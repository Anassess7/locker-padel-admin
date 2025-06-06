@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Détail Client</h1>
<div class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-4">
        <span class="font-semibold">ID:</span> {{ $client->id }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Nom:</span> {{ $client->nom_client }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Telephone:</span> {{ $client->telephone ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Adresse:</span> {{ $client->adresse ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Email:</span> {{ $client->email ?? 'N/A' }}
    </div>
    <div class="flex justify-end">
        <a href="{{ route('clients.edit', $client) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Editer</a>
        <a href="{{ route('clients.index') }}" class="text-gray-600 hover:underline">Retour</a>
    </div>
</div>
@endsection 