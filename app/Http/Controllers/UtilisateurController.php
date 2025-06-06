<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $utilisateurs = Utilisateur::all();
        return view('utilisateur.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('utilisateur.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_utilisateur' => 'required|unique:utilisateurs,nom_utilisateur',
            'mdp' => 'required|min:4',
        ]);
        Utilisateur::create([
            'nom_utilisateur' => $validated['nom_utilisateur'],
            'mdp' => Hash::make($validated['mdp']),
            'admin' => $request->has('admin'),
        ]);
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Utilisateur $utilisateur)
    {
        return view('utilisateur.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Utilisateur $utilisateur)
    {
        return view('utilisateur.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Utilisateur $utilisateur)
    {
        $validated = $request->validate([
            'nom_utilisateur' => 'required|unique:utilisateurs,nom_utilisateur,' . $utilisateur->id,
            'mdp' => 'nullable|min:4',
        ]);
        $utilisateur->nom_utilisateur = $validated['nom_utilisateur'];
        if ($request->filled('mdp')) {
            $utilisateur->mdp = Hash::make($validated['mdp']);
        }
        $utilisateur->admin = $request->has('admin');
        $utilisateur->save();
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Utilisateur $utilisateur)
    {
        $utilisateur->delete();
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
