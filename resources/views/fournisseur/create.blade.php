@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Ajouter Fournisseur</h1>
<form action="{{ route('fournisseurs.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Nom</label>
        <input type="text" name="nom_fournisseur" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Telephone</label>
        <input type="text" name="telephone" class="w-full border rounded px-3 py-2">
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Adresse</label>
        <input type="text" name="adresse" class="w-full border rounded px-3 py-2">
    </div>
    <div class="flex justify-end">
        <a href="{{ route('fournisseurs.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter</button>
    </div>
</form>
@endsection 