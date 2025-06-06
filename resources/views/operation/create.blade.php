@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Ajouter Opération</h1>
<form action="{{ route('operations.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Date</label>
        <input type="date" name="date_operation" value="{{ old('date_operation', date('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Type</label>
        <select name="type" class="w-full border rounded px-3 py-2" required>
            <option value="">Sélectionner un type</option>
            <option value="credit" {{ old('type') === 'credit' ? 'selected' : '' }}>Crédit</option>
            <option value="debit" {{ old('type') === 'debit' ? 'selected' : '' }}>Débit</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Catégorie</label>
        <select name="categorie" class="w-full border rounded px-3 py-2" required>
            <option value="">Sélectionner une catégorie</option>
            <option value="achat" {{ old('categorie') === 'achat' ? 'selected' : '' }}>Achat</option>
            <option value="vente" {{ old('categorie') === 'vente' ? 'selected' : '' }}>Vente</option>
            <option value="transport" {{ old('categorie') === 'transport' ? 'selected' : '' }}>Transport</option>
            <option value="salaire" {{ old('categorie') === 'salaire' ? 'selected' : '' }}>Salaire</option>
            <option value="autre" {{ old('categorie') === 'autre' ? 'selected' : '' }}>Autre</option>
        </select>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Libelle</label>
        <input type="text" name="description" value="{{ old('description') }}" class="w-full border rounded px-3 py-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-2 font-semibold">Montant</label>
        <input type="number" step="0.01" name="montant" value="{{ old('montant') }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('operations.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    </div>
</form>
@endsection 