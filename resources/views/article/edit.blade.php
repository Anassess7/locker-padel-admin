@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifier Article</h1>
<form action="{{ route('articles.update', $article) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Référence</label>
        <input type="text" name="reference" value="{{ old('reference', $article->reference) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Réf. Local</label>
        <input type="text" name="ref_local" value="{{ old('ref_local', $article->ref_local) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Nom</label>
        <input type="text" name="nom" value="{{ old('nom', $article->nom) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Marque</label>
        <select name="marque_id" class="w-full border rounded px-3 py-2" required>
            <option value="">Sélectionner une marque</option>
            @foreach($marques as $marque)
                <option value="{{ $marque->id }}" {{ old('marque_id', $article->marque_id) == $marque->id ? 'selected' : '' }}>{{ $marque->marque }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Prix Achat</label>
        <input type="number" step="0.01" name="prix_ach" value="{{ old('prix_ach', $article->prix_ach) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Prix Vente</label>
        <input type="number" step="0.01" name="prix_vente" value="{{ old('prix_vente', $article->prix_vente) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('articles.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </div>
</form>
@endsection 