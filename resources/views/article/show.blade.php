@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Détail Article</h1>
<div class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-4">
        <span class="font-semibold">ID:</span> {{ $article->id }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Référence:</span> {{ $article->reference }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Réf. Local:</span> {{ $article->ref_local }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Nom:</span> {{ $article->nom }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Marque:</span> {{ $article->marque->marque ?? 'N/A' }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Prix Achat:</span> {{ number_format($article->prix_ach, 2, ',', ' ') }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Prix Vente:</span> {{ number_format($article->prix_vente, 2, ',', ' ') }}
    </div>
    <div class="flex justify-end">
        <a href="{{ route('articles.edit', $article) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Editer</a>
        <a href="{{ route('articles.index') }}" class="text-gray-600 hover:underline">Retour</a>
    </div>
</div>
@endsection 