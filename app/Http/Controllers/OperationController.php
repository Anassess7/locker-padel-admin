<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operations = Operation::with(['fournisseur'])
            ->orderBy('date', 'desc')
            ->get();
        
        // Calculate totals
        $totalCredit = $operations->where('type_transaction', 'credit')->sum('montant_transaction');
        $totalDebit = $operations->where('type_transaction', 'debit')->sum('montant_transaction');
        $balance = $totalCredit - $totalDebit;

        return view('operation.index', compact('operations', 'totalCredit', 'totalDebit', 'balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fournisseurs = Fournisseur::all();
        return view('operation.create', compact('fournisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type_transaction' => 'required|in:credit,debit',
            'montant_transaction' => 'required|numeric|min:0',
            'libelle' => 'required|string|max:255',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'date_ech' => 'nullable|date',
            'num_chq' => 'nullable|string|max:255',
            'tireur' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'banque' => 'nullable|string|max:255',
            'agence' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'validation' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            Operation::create([
                'date' => $validated['date'],
                'type_transaction' => $validated['type_transaction'],
                'montant_transaction' => $validated['montant_transaction'],
                'libelle' => $validated['libelle'],
                'fournisseur_id' => $validated['fournisseur_id'] ?? null,
                'date_ech' => $validated['date_ech'] ?? null,
                'num_chq' => $validated['num_chq'] ?? null,
                'tireur' => $validated['tireur'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
                'banque' => $validated['banque'] ?? null,
                'agence' => $validated['agence'] ?? null,
                'ville' => $validated['ville'] ?? null,
                'observation' => $validated['observation'] ?? null,
                'validation' => $validated['validation'] ?? false,
            ]);
            DB::commit();
            return redirect()->route('operations.index')->with('success', 'Opération ajoutée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'ajout de l\'opération.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Operation $operation)
    {
        return view('operation.show', compact('operation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Operation $operation)
    {
        $fournisseurs = Fournisseur::all();
        return view('operation.edit', compact('operation', 'fournisseurs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Operation $operation)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'type_transaction' => 'required|in:credit,debit',
            'montant_transaction' => 'required|numeric|min:0',
            'libelle' => 'required|string|max:255',
            'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            'date_ech' => 'nullable|date',
            'num_chq' => 'nullable|string|max:255',
            'tireur' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'banque' => 'nullable|string|max:255',
            'agence' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
            'validation' => 'boolean',
        ]);

        DB::beginTransaction();
        try {
            $operation->update([
                'date' => $validated['date'],
                'type_transaction' => $validated['type_transaction'],
                'montant_transaction' => $validated['montant_transaction'],
                'libelle' => $validated['libelle'],
                'fournisseur_id' => $validated['fournisseur_id'] ?? null,
                'date_ech' => $validated['date_ech'] ?? null,
                'num_chq' => $validated['num_chq'] ?? null,
                'tireur' => $validated['tireur'] ?? null,
                'telephone' => $validated['telephone'] ?? null,
                'banque' => $validated['banque'] ?? null,
                'agence' => $validated['agence'] ?? null,
                'ville' => $validated['ville'] ?? null,
                'observation' => $validated['observation'] ?? null,
                'validation' => $validated['validation'] ?? $operation->validation,
            ]);
            DB::commit();
            return redirect()->route('operations.index')->with('success', 'Opération modifiée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la modification de l\'opération.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Operation $operation)
    {
        DB::beginTransaction();
        try {
            $operation->delete();
            DB::commit();
            return redirect()->route('operations.index')->with('success', 'Opération supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la suppression de l\'opération.');
        }
    }
}
