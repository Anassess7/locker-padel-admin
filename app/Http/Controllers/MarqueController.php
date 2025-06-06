<?php

namespace App\Http\Controllers;

use App\Models\Marque;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marques = Marque::all();
        return view('marque.index', compact('marques'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marque.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'marque' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('marques', 'public');
        }
        Marque::create([
            'marque' => $validated['marque'],
            'image' => $imagePath,
        ]);
        return redirect()->route('marques.index')->with('success', 'Marque added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Marque $marque)
    {
        return view('marque.show', compact('marque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marque $marque)
    {
        return view('marque.edit', compact('marque'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marque $marque)
    {
        $validated = $request->validate([
            'marque' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('marques', 'public');
            $marque->image = $imagePath;
        }
        $marque->marque = $validated['marque'];
        $marque->save();
        return redirect()->route('marques.index')->with('success', 'Marque updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marque $marque)
    {
        $marque->delete();
        return redirect()->route('marques.index')->with('success', 'Marque deleted successfully.');
    }
}
