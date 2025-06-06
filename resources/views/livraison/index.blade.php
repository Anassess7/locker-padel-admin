@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Liste des Livraisons</h1>
    <a href="{{ route('livraisons.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Nouvelle Livraison</a>
</div>

@if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Référence</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Client</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Date Livraison</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Société</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Prix Livraison</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Prix Total</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Statut</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($livraisons as $livraison)
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4">{{ $livraison->reference }}</td>
                <td class="py-3 px-4">{{ $livraison->client->nom_client ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $livraison->date_livraison->format('d/m/Y') }}</td>
                <td class="py-3 px-4">{{ $livraison->company }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($livraison->prix_livraison, 2, ',', ' ') }} Dhs</td>
                <td class="py-3 px-4 text-right font-semibold">{{ number_format($livraison->prix_total, 2, ',', ' ') }} Dhs</td>
                <td class="py-3 px-4">
                    <div class="flex flex-col space-y-2">
                        <span class="px-3 py-1 text-sm rounded-full font-medium
                            @if($livraison->status === \App\Models\Livraison::STATUS_DELIVERED)
                                bg-green-100 text-green-800
                            @elseif($livraison->status === \App\Models\Livraison::STATUS_CANCELLED)
                                bg-red-100 text-red-800
                            @elseif($livraison->status === \App\Models\Livraison::STATUS_PENDING)
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-blue-100 text-blue-800
                            @endif
                        ">
                            @if($livraison->status === \App\Models\Livraison::STATUS_DELIVERED)
                                Livrée
                            @elseif($livraison->status === \App\Models\Livraison::STATUS_CANCELLED)
                                Annulée
                            @elseif($livraison->status === \App\Models\Livraison::STATUS_PENDING)
                                En attente
                            @else
                                En transit
                            @endif
                        </span>
                        @if($livraison->status !== \App\Models\Livraison::STATUS_DELIVERED)
                            <div class="flex space-x-2">
                                <form action="{{ route('livraisons.update-status', $livraison) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="{{ \App\Models\Livraison::STATUS_DELIVERED }}">
                                    <button type="submit" class="text-xs bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">
                                        Marquer comme livrée
                                    </button>
                                </form>
                                @if($livraison->status !== \App\Models\Livraison::STATUS_CANCELLED)
                                    <form action="{{ route('livraisons.update-status', $livraison) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="status" value="{{ \App\Models\Livraison::STATUS_CANCELLED }}">
                                        <button type="submit" class="text-xs bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                            Annuler
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </td>
                <td class="py-3 px-4 text-right whitespace-nowrap">
                    <a href="{{ route('livraisons.show', $livraison) }}" class="text-gray-600 hover:text-gray-800 mr-3">Voir</a>
                    @if($livraison->status === \App\Models\Livraison::STATUS_PENDING)
                        <a href="{{ route('livraisons.edit', $livraison) }}" class="text-blue-600 hover:text-blue-800 mr-3">Editer</a>
                        <form action="{{ route('livraisons.destroy', $livraison) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette livraison ?')">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="py-4 text-center text-gray-500">Aucune livraison trouvée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 