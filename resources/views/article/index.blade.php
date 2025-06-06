@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Articles</h1>
    <a href="{{ route('articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter Article</a>
</div>
@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif
<div class="overflow-x-auto">
    <table class="w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">ID</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Référence</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Réf. Local</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Nom</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Marque</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Prix Achat</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Prix Vente</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($articles as $article)
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4 whitespace-nowrap">{{ $article->id }}</td>
                <td class="py-3 px-4">{{ $article->reference }}</td>
                <td class="py-3 px-4">{{ $article->ref_local }}</td>
                <td class="py-3 px-4">{{ $article->nom }}</td>
                <td class="py-3 px-4">{{ $article->marque->marque ?? 'N/A' }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($article->prix_ach, 2, ',', ' ') }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($article->prix_vente, 2, ',', ' ') }}</td>
                <td class="py-3 px-4 text-right whitespace-nowrap">
                    <a href="{{ route('articles.edit', $article) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cet article ?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="py-4 text-center text-gray-500">Aucun article trouvé.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 