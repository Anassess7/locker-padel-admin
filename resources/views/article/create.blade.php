@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Ajouter Article</h1>
<form action="{{ route('articles.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Référence</label>
        <input type="text" name="reference" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Réf. Local</label>
        <input type="text" name="ref_local" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Nom</label>
        <input type="text" name="nom" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Marque</label>
        <select name="marque_id" class="w-full border rounded px-3 py-2" required>
            <option value="">Sélectionner une marque</option>
            @foreach($marques as $marque)
                <option value="{{ $marque->id }}">{{ $marque->marque }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Prix Achat</label>
        <input type="number" step="0.01" name="prix_ach" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Prix Vente</label>
        <input type="number" step="0.01" name="prix_vente" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('articles.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    </div>
</form>
@endsection 