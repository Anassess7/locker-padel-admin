@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Détails de la Livraison</h1>
        <div class="flex space-x-4">
            <a href="{{ route('livraisons.index') }}" class="text-gray-600 hover:text-gray-800">Retour à la liste</a>
            @if($livraison->status !== \App\Models\Livraison::STATUS_DELIVERED)
                <a href="{{ route('livraisons.edit', $livraison) }}" class="text-blue-600 hover:text-blue-800">Modifier</a>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Informations Générales</h2>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Référence</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $livraison->reference }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Client</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $livraison->client->nom_client }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date de Livraison</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $livraison->date_livraison->format('d/m/Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Société de Livraison</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $livraison->company }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Statut</dt>
                        <dd class="mt-1">
                            <span class="px-2 py-1 text-sm rounded bg-{{ $livraison->status_color }}-100 text-{{ $livraison->status_color }}-800">
                                {{ $livraison->status_label }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <div>
                <h2 class="text-lg font-medium text-gray-900 mb-4">Détails Financiers</h2>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Prix de Livraison</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ number_format($livraison->prix_livraison, 2, ',', ' ') }} Dhs</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Prix Total</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ number_format($livraison->prix_total, 2, ',', ' ') }} Dhs</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Articles</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($livraison->articles as $article)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $article->nom }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                {{ $article->pivot->quantite }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                {{ number_format($article->pivot->prix_unitaire, 2, ',', ' ') }} Dhs
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                {{ number_format($article->pivot->prix_total, 2, ',', ' ') }} Dhs
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($livraison->status !== \App\Models\Livraison::STATUS_DELIVERED)
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Mettre à jour le statut</h2>
            <form action="{{ route('livraisons.update-status', $livraison) }}" method="POST" class="flex items-center space-x-4">
                @csrf
                <select name="status" class="rounded-md border-gray-300">
                    <option value="{{ \App\Models\Livraison::STATUS_PENDING }}" {{ $livraison->status === \App\Models\Livraison::STATUS_PENDING ? 'selected' : '' }}>En attente</option>
                    <option value="{{ \App\Models\Livraison::STATUS_IN_TRANSIT }}" {{ $livraison->status === \App\Models\Livraison::STATUS_IN_TRANSIT ? 'selected' : '' }}>En transit</option>
                    <option value="{{ \App\Models\Livraison::STATUS_DELIVERED }}" {{ $livraison->status === \App\Models\Livraison::STATUS_DELIVERED ? 'selected' : '' }}>Livrée</option>
                    <option value="{{ \App\Models\Livraison::STATUS_CANCELLED }}" {{ $livraison->status === \App\Models\Livraison::STATUS_CANCELLED ? 'selected' : '' }}>Annulée</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Mettre à jour
                </button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection 