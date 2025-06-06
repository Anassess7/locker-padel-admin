@extends('layouts.dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')
    <main class="flex-1 p-8">
        <h1 class="text-2xl font-bold mb-6">Détail Utilisateur</h1>
        <div class="bg-white p-6 rounded shadow max-w-lg">
            <div class="mb-4">
                <span class="font-semibold">ID:</span> {{ $utilisateur->id }}
            </div>
            <div class="mb-4">
                <span class="font-semibold">Nom d'utilisateur:</span> {{ $utilisateur->nom_utilisateur }}
            </div>
            <div class="mb-4">
                <span class="font-semibold">Admin:</span> {{ $utilisateur->admin ? 'Oui' : 'Non' }}
            </div>
            <div class="flex justify-end">
                <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Editer</a>
                <a href="{{ route('utilisateurs.index') }}" class="text-gray-600 hover:underline">Retour</a>
            </div>
        </div>
    </main>
</div>
@endsection 