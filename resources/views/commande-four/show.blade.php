@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Détail Commande Fournisseur</h1>

<div class="bg-white p-6 rounded shadow mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <span class="font-semibold">Fournisseur:</span> {{ $commandeFour->fournisseur->nom_fournisseur ?? 'N/A' }}
        </div>
        <div>
            <span class="font-semibold">Date Commande:</span> {{ $commandeFour->date_commande->format('d/m/Y') }}
        </div>
        @if($commandeFour->date_arrive)
            <div>
                <span class="font-semibold">Date Arrivée:</span> {{ $commandeFour->date_arrive->format('d/m/Y') }}
            </div>
        @endif
        <div>
            <span class="font-semibold">Montant Commande:</span> {{ number_format($commandeFour->montant_commande, 2, ',', ' ') }} Dhs
        </div>
        <div>
            <span class="font-semibold">Montant Livraison:</span> {{ number_format($commandeFour->montant_livraison, 2, ',', ' ') }} Dhs
        </div>
        <div>
            <span class="font-semibold">Montant Total:</span> <span class="font-bold">{{ number_format($commandeFour->montant_total, 2, ',', ' ') }} Dhs</span>
        </div>
         <div>
            <span class="font-semibold">Validation:</span>
            <span class="px-2 py-1 text-sm rounded {{ $commandeFour->validation ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $commandeFour->validation ? 'Validée' : 'En attente' }}
            </span>
        </div>
    </div>
    @if($commandeFour->observation)
        <div class="mt-4">
            <span class="font-semibold">Observation:</span> {{ $commandeFour->observation }}
        </div>
    @endif
</div>

<h2 class="text-xl font-bold mb-4">Articles Commandés</h2>

@if($commandeFour->ligneCommandeFours->count() > 0)
    <div class="overflow-x-auto mb-6">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Description</th>
                    <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Quantité</th>
                    <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Prix Unitaire</th>
                    <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Prix Total Ligne</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($commandeFour->ligneCommandeFours as $ligne)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4">{{ $ligne->description }}</td>
                    <td class="py-3 px-4 text-right">{{ $ligne->qte }}</td>
                    <td class="py-3 px-4 text-right">{{ number_format($ligne->prix_unitaire, 2, ',', ' ') }} Dhs</td>
                    <td class="py-3 px-4 text-right font-semibold">{{ number_format($ligne->prix_tot, 2, ',', ' ') }} Dhs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="mb-6 p-4 bg-yellow-100 text-yellow-800 rounded">
        Aucun article dans cette commande.
    </div>
@endif

<div class="flex justify-between items-center">
    <div>
        <a href="{{ route('commande-fours.edit', $commandeFour) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Editer</a>
        <a href="{{ route('commande-fours.index') }}" class="text-gray-600 hover:underline">Retour à la liste</a>
    </div>
    @if(!$commandeFour->validation)
        <form action="{{ route('commande-fours.update', $commandeFour) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <input type="hidden" name="validation" value="1">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Valider la Commande
            </button>
        </form>
    @endif
</div>
@endsection 