@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Modifier Client</h1>
<form action="{{ route('clients.update', $client) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Nom</label>
        <input type="text" name="nom_client" value="{{ old('nom_client', $client->nom_client) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Telephone</label>
        <input type="text" name="telephone" value="{{ old('telephone', $client->telephone) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Adresse</label>
        <input type="text" name="adresse" value="{{ old('adresse', $client->adresse) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Email</label>
        <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full border rounded px-3 py-2">
    </div>
    <div class="flex justify-end">
        <a href="{{ route('clients.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
    </div>
</form>
@endsection 