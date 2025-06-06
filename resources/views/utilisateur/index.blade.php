@extends('layouts.dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Utilisateurs</h1>
            <a href="{{ route('utilisateurs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter Utilisateur</a>
        </div>
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        <table class="min-w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Nom d'utilisateur</th>
                    <th class="py-2 px-4 border-b">Admin</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($utilisateurs as $utilisateur)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $utilisateur->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $utilisateur->nom_utilisateur }}</td>
                    <td class="py-2 px-4 border-b">{{ $utilisateur->admin ? 'Oui' : 'Non' }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('utilisateurs.destroy', $utilisateur) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2" onclick="return confirm('Supprimer cet utilisateur ?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</div>
@endsection 