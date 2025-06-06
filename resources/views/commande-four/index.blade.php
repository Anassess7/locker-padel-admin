@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Liste des Commandes Fournisseur</h1>
    <a href="{{ route('commande-fours.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter Commande</a>
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
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Fournisseur</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Date Commande</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Date Arrivée</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Montant Commande</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Montant Total</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Validation</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($commandeFours as $commandeFour)
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4">{{ $commandeFour->fournisseur->nom_fournisseur ?? 'N/A' }}</td>
                <td class="py-3 px-4">{{ $commandeFour->date_commande->format('d/m/Y') }}</td>
                <td class="py-3 px-4">{{ $commandeFour->date_arrive ? $commandeFour->date_arrive->format('d/m/Y') : 'N/A' }}</td>
                <td class="py-3 px-4 text-right">{{ number_format($commandeFour->montant_commande, 2, ',', ' ') }} Dhs</td>
            
                <td class="py-3 px-4 text-right font-semibold">{{ number_format($commandeFour->montant_total, 2, ',', ' ') }} Dhs</td>
                <td class="py-3 px-4">
                    <span class="px-2 py-1 text-sm rounded {{ $commandeFour->validation ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $commandeFour->validation ? 'Validée' : 'En attente' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right whitespace-nowrap">
                @if(!$commandeFour->validation)
                        <form action="{{ route('commande-fours.validate', $commandeFour) }}" method="POST" class="inline mr-3">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800">Valider</button>
                        </form>
                    @endif
                    <a href="{{ route('commande-fours.show', $commandeFour) }}" class="text-gray-600 hover:text-gray-800 mr-3">Voir</a>
                    @if(!$commandeFour->validation)
                        <a href="{{ route('commande-fours.edit', $commandeFour) }}" class="text-blue-600 hover:text-blue-800 mr-3">Editer</a>
                        <form action="{{ route('commande-fours.destroy', $commandeFour) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette commande ?')">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="py-4 text-center text-gray-500">Aucune commande fournisseur trouvée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 