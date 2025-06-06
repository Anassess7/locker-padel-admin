@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Détail Fournisseur</h1>
<div class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-4">
        <span class="font-semibold">ID:</span> {{ $fournisseur->id }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Nom:</span> {{ $fournisseur->nom_fournisseur }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Telephone:</span> {{ $fournisseur->telephone ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Adresse:</span> {{ $fournisseur->adresse ?? 'N/A' }}
    </div>
    <div class="flex justify-end">
        <a href="{{ route('fournisseurs.edit', $fournisseur) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Editer</a>
        <a href="{{ route('fournisseurs.index') }}" class="text-gray-600 hover:underline">Retour</a>
    </div>
</div>
@endsection 