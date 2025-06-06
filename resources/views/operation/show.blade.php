@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Détail Opération</h1>
<div class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-4">
        <span class="font-semibold">ID:</span> {{ $operation->id }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Date:</span> {{ $operation->date_operation->format('d/m/Y') }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Type:</span>
        <span class="px-2 py-1 rounded text-sm {{ $operation->type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
            {{ $operation->type === 'credit' ? 'Crédit' : 'Débit' }}
        </span>
    </div>
    <div class="mb-4">
        <span class="font-semibold">Catégorie:</span> {{ ucfirst($operation->categorie) }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Description:</span> {{ $operation->description }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Fournisseur:</span> {{ $operation->fournisseur->nom_fournisseur ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Montant:</span>
        <span class="font-medium {{ $operation->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
            {{ number_format($operation->montant, 2, ',', ' ') }} Dhs
        </span>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('operations.edit', $operation) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Editer</a>
        <a href="{{ route('operations.index') }}" class="text-gray-600 hover:underline">Retour</a>
    </div>
</div>
@endsection 