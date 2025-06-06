@extends('layouts.dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Modifier Utilisateur</h1>
        <form action="{{ route('utilisateurs.update', $utilisateur) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Nom d'utilisateur</label>
                <input type="text" name="nom_utilisateur" value="{{ old('nom_utilisateur', $utilisateur->nom_utilisateur) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block mb-2 font-semibold">Mot de passe <span class="text-gray-500">(laisser vide pour ne pas changer)</span></label>
                <input type="password" name="mdp" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="admin" value="1" class="form-checkbox" {{ $utilisateur->admin ? 'checked' : '' }}>
                    <span class="ml-2">Admin</span>
                </label>
            </div>
            <div class="flex justify-end">
                <a href="{{ route('utilisateurs.index') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Enregistrer</button>
            </div>
        </form>
    </main>
</div>
@endsection 