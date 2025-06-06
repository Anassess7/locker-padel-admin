<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Marque;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with('marque')->get();
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marques = Marque::all();
        return view('article.create', compact('marques'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:255',
            'ref_local' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'marque_id' => 'required|exists:marques,id',
            'prix_ach' => 'required|numeric',
            'prix_vente' => 'required|numeric',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Article ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $marques = Marque::all();
        return view('article.edit', compact('article', 'marques'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'reference' => 'required|string|max:255',
            'ref_local' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'marque_id' => 'required|exists:marques,id',
            'prix_ach' => 'required|numeric',
            'prix_vente' => 'required|numeric',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Article modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }
}
