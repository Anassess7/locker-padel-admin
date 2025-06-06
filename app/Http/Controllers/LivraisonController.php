<?php

namespace App\Http\Controllers;

use App\Models\Livraison;
use App\Models\Client;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LivraisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livraisons = Livraison::with(['client', 'articles'])->orderBy('date_livraison', 'desc')->get();
        return view('livraison.index', compact('livraisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        $articles = Article::all();
        return view('livraison.create', compact('clients', 'articles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_livraison' => 'required|date',
            'company' => 'required|string|max:255',
            'reference' => 'required|string|unique:livraisons,reference',
            'prix_livraison' => 'required|numeric|min:0',
            'articles' => 'required|array|min:1',
            'articles.*.id' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
            'articles.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $livraison = Livraison::create([
                'client_id' => $validated['client_id'],
                'date_livraison' => $validated['date_livraison'],
                'company' => $validated['company'],
                'reference' => $validated['reference'],
                'prix_livraison' => $validated['prix_livraison'],
                'status' => Livraison::STATUS_PENDING,
                'prix_total' => 0, // Will be calculated after adding articles
            ]);

            $total = 0;
            foreach ($validated['articles'] as $article) {
                $prixTotal = $article['quantite'] * $article['prix_unitaire'];
                $total += $prixTotal;

                $livraison->articles()->attach($article['id'], [
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'prix_total' => $prixTotal
                ]);
            }

            $livraison->prix_total = $total + $validated['prix_livraison'];
            $livraison->save();

            DB::commit();
            return redirect()->route('livraisons.index')->with('success', 'Livraison créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error creating Livraison: ' . $e->getMessage());
            return back()->withInput()->with('error', "Une erreur est survenue lors de la création de la livraison.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Livraison $livraison)
    {
        $livraison->load(['client', 'articles']);
        return view('livraison.show', compact('livraison'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livraison $livraison)
    {
        if ($livraison->status === Livraison::STATUS_DELIVERED) {
            return redirect()->route('livraisons.index')
                ->with('error', 'Impossible de modifier une livraison déjà livrée.');
        }

        $clients = Client::all();
        $articles = Article::all();
        $livraison->load('articles');
        return view('livraison.edit', compact('livraison', 'clients', 'articles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livraison $livraison)
    {
        if ($livraison->status === Livraison::STATUS_DELIVERED) {
            return redirect()->route('livraisons.index')
                ->with('error', 'Impossible de modifier une livraison déjà livrée.');
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date_livraison' => 'required|date',
            'company' => 'required|string|max:255',
            'reference' => 'required|string|unique:livraisons,reference,' . $livraison->id,
            'prix_livraison' => 'required|numeric|min:0',
            'articles' => 'required|array|min:1',
            'articles.*.id' => 'required|exists:articles,id',
            'articles.*.quantite' => 'required|integer|min:1',
            'articles.*.prix_unitaire' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $livraison->update([
                'client_id' => $validated['client_id'],
                'date_livraison' => $validated['date_livraison'],
                'company' => $validated['company'],
                'reference' => $validated['reference'],
                'prix_livraison' => $validated['prix_livraison'],
            ]);

            // Remove all existing articles
            $livraison->articles()->detach();

            // Add new articles
            $total = 0;
            foreach ($validated['articles'] as $article) {
                $prixTotal = $article['quantite'] * $article['prix_unitaire'];
                $total += $prixTotal;

                $livraison->articles()->attach($article['id'], [
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'prix_total' => $prixTotal
                ]);
            }

            $livraison->prix_total = $total + $validated['prix_livraison'];
            $livraison->save();

            DB::commit();
            return redirect()->route('livraisons.index')->with('success', 'Livraison modifiée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating Livraison: ' . $e->getMessage());
            return back()->withInput()->with('error', "Une erreur est survenue lors de la modification de la livraison.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livraison $livraison)
    {
        if ($livraison->status === Livraison::STATUS_DELIVERED) {
            return redirect()->route('livraisons.index')
                ->with('error', 'Impossible de supprimer une livraison déjà livrée.');
        }

        DB::beginTransaction();
        try {
            $livraison->articles()->detach();
            $livraison->delete();
            DB::commit();
            return redirect()->route('livraisons.index')->with('success', 'Livraison supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error deleting Livraison: ' . $e->getMessage());
            return back()->with('error', "Une erreur est survenue lors de la suppression de la livraison.");
        }
    }

    public function updateStatus(Request $request, Livraison $livraison)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Livraison::STATUS_PENDING,
                Livraison::STATUS_IN_TRANSIT,
                Livraison::STATUS_DELIVERED,
                Livraison::STATUS_CANCELLED
            ])
        ]);

        $livraison->update([
            'status' => $request->status
        ]);

        return redirect()->route('livraisons.index')
            ->with('success', 'Statut de la livraison mis à jour avec succès.');
    }
}
