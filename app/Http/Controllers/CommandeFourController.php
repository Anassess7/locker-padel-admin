<?php

namespace App\Http\Controllers;

use App\Models\CommandeFour;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\LigneCommandeFour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeFourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandeFours = CommandeFour::with('fournisseur')->orderBy('date_commande', 'desc')->get();
        return view('commande-four.index', compact('commandeFours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fournisseurs = Fournisseur::all();
        $articles = Article::all();
        return view('commande-four.create', compact('fournisseurs', 'articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedCommande = $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_commande' => 'required|date',
            'date_arrive' => 'nullable|date|after_or_equal:date_commande',
            'observation' => 'nullable|string',
        ]);

        // Validate ligne_commande_fours (array of items)
        $request->validate([
            'ligne_commande_fours' => 'required|array|min:1',
            'ligne_commande_fours.*.article_id' => 'nullable|exists:articles,id',
            'ligne_commande_fours.*.description' => 'required_without:ligne_commande_fours.*.article_id|string|max:255',
            'ligne_commande_fours.*.qte' => 'required|integer|min:1',
            'ligne_commande_fours.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        $ligneCommandeFoursData = $request->input('ligne_commande_fours');

        // Calculate total amounts
        $montantCommande = 0;
        foreach ($ligneCommandeFoursData as $item) {
            $montantCommande += $item['qte'] * $item['prix_unitaire'];
        }

        $montantLivraison = $request->input('montant_livraison', 0);
        $montantTotal = $montantCommande + $montantLivraison;

        DB::beginTransaction();
        try {
            $commandeFour = CommandeFour::create([
                'fournisseur_id' => $validatedCommande['fournisseur_id'],
                'date_commande' => $validatedCommande['date_commande'],
                'date_arrive' => $validatedCommande['date_arrive'] ?? null,
                'montant_commande' => $montantCommande,
                'montant_livraison' => $montantLivraison,
                'montant_total' => $montantTotal,
                'observation' => $validatedCommande['observation'] ?? null,
                'validation' => false, // Default to false on creation
            ]);

            foreach ($ligneCommandeFoursData as $item) {
                $commandeFour->ligneCommandeFours()->create([
                    'article_id' => $item['article_id'] ?? null,
                    'description' => $item['description'] ?? '',
                    'prix_unitaire' => $item['prix_unitaire'],
                    'qte' => $item['qte'],
                    'prix_tot' => $item['qte'] * $item['prix_unitaire'],
                ]);
            }

            DB::commit();
            return redirect()->route('commande-fours.index')->with('success', 'Commande fournisseur ajoutée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating Commande Four:' . $e->getMessage());
            return back()->withInput()->with('error', "Une erreur est survenue lors de l'ajout de la commande fournisseur.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CommandeFour $commandeFour)
    {
        $commandeFour->load('ligneCommandeFours.article');
        return view('commande-four.show', compact('commandeFour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CommandeFour $commandeFour)
    {
        $fournisseurs = Fournisseur::all();
        $articles = Article::all();
        $commandeFour->load('ligneCommandeFours');
        return view('commande-four.edit', compact('commandeFour', 'fournisseurs', 'articles'));
    }

    /**
     * Validate the specified command.
     */
    public function validate(CommandeFour $commandeFour)
    {
        DB::beginTransaction();
        try {
            $commandeFour->update([
                'validation' => true,
                'date_arrive' => now()->toDateString()
            ]);

            DB::commit();
            return redirect()->route('commande-fours.index')->with('success', 'Commande fournisseur validée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error validating Commande Four:' . $e->getMessage());
            return back()->with('error', "Une erreur est survenue lors de la validation de la commande fournisseur.");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CommandeFour $commandeFour)
    {
        // If this is just a validation request
        if ($request->has('validation') && $request->input('validation') == 1) {
            return $this->validate($commandeFour);
        }

        $validatedCommande = $request->validate([
            'fournisseur_id' => 'required|exists:fournisseurs,id',
            'date_commande' => 'required|date',
            'date_arrive' => 'nullable|date|after_or_equal:date_commande',
            'observation' => 'nullable|string',
        ]);

        // Validate ligne_commande_fours (array of items)
        $request->validate([
            'ligne_commande_fours' => 'required|array|min:1',
            'ligne_commande_fours.*.id' => 'nullable|exists:ligne_commande_fours,id',
            'ligne_commande_fours.*.article_id' => 'nullable|exists:articles,id',
            'ligne_commande_fours.*.description' => 'required_without:ligne_commande_fours.*.article_id|string|max:255',
            'ligne_commande_fours.*.qte' => 'required|integer|min:1',
            'ligne_commande_fours.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        $ligneCommandeFoursData = $request->input('ligne_commande_fours');

        // Calculate total amounts
        $montantCommande = 0;
        foreach ($ligneCommandeFoursData as $item) {
            $montantCommande += $item['qte'] * $item['prix_unitaire'];
        }

        $montantLivraison = $request->input('montant_livraison', 0);
        $montantTotal = $montantCommande + $montantLivraison;

        DB::beginTransaction();
        try {
            // Check if validation is being set to true and date_arrive is not set
            if ($request->input('validation') && !$commandeFour->validation && empty($request->input('date_arrive'))) {
                 $validatedCommande['date_arrive'] = now()->toDateString();
            }

            $commandeFour->update([
                'fournisseur_id' => $validatedCommande['fournisseur_id'],
                'date_commande' => $validatedCommande['date_commande'],
                'date_arrive' => $validatedCommande['date_arrive'] ?? null,
                'montant_commande' => $montantCommande,
                'montant_livraison' => $montantLivraison,
                'montant_total' => $montantTotal,
                'observation' => $validatedCommande['observation'] ?? null,
                'validation' => $validatedCommande['validation'] ?? $commandeFour->validation,
            ]);

            // Sync ligne_commande_fours
            $existingItemIds = $commandeFour->ligneCommandeFours->pluck('id')->toArray();
            $updatedItemIds = [];

            foreach ($ligneCommandeFoursData as $item) {
                if (isset($item['id']) && $item['id'] !== null) {
                    // Update existing item
                    $ligneCommandeFour = $commandeFour->ligneCommandeFours()->where('id', $item['id'])->first();
                    if ($ligneCommandeFour) {
                        $ligneCommandeFour->update([
                            'article_id' => $item['article_id'] ?? null,
                            'description' => $item['description'] ?? null,
                            'prix_unitaire' => $item['prix_unitaire'],
                            'qte' => $item['qte'],
                            'prix_tot' => $item['qte'] * $item['prix_unitaire'],
                        ]);
                        $updatedItemIds[] = $item['id'];
                    }
                } else {
                    // Create new item
                    $newItem = $commandeFour->ligneCommandeFours()->create([
                        'article_id' => $item['article_id'] ?? null,
                        'description' => $item['description'] ?? null,
                        'prix_unitaire' => $item['prix_unitaire'],
                        'qte' => $item['qte'],
                        'prix_tot' => $item['qte'] * $item['prix_unitaire'],
                    ]);
                     $updatedItemIds[] = $newItem->id;
                }
            }

            // Delete items that were removed in the form
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            if (!empty($itemsToDelete)) {
                $commandeFour->ligneCommandeFours()->whereIn('id', $itemsToDelete)->delete();
            }

            DB::commit();
            return redirect()->route('commande-fours.index')->with('success', 'Commande fournisseur modifiée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating Commande Four:' . $e->getMessage());
            return back()->withInput()->with('error', "Une erreur est survenue lors de la modification de la commande fournisseur.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommandeFour $commandeFour)
    {
        DB::beginTransaction();
        try {
            // Delete associated ligne_commande_fours first
            $commandeFour->ligneCommandeFours()->delete();
            $commandeFour->delete();

            DB::commit();
            return redirect()->route('commande-fours.index')->with('success', 'Commande fournisseur supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting Commande Four:' . $e->getMessage());
            return back()->with('error', "Une erreur est survenue lors de la suppression de la commande fournisseur.");
        }
    }
}
