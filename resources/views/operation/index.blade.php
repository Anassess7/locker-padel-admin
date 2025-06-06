@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Opérations</h1>
    <a href="{{ route('operations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ajouter Opération</a>
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

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-gray-600">Total Crédit</h3>
        <p class="text-2xl font-bold text-green-600">{{ number_format($totalCredit, 2, ',', ' ') }} Dhs</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-gray-600">Total Débit</h3>
        <p class="text-2xl font-bold text-red-600">{{ number_format($totalDebit, 2, ',', ' ') }} Dhs</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-gray-600">Solde</h3>
        <p class="text-2xl font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ number_format($balance, 2, ',', ' ') }} Dhs
        </p>
    </div>
</div>

<div class="overflow-x-auto">
    <table class="w-full bg-white rounded-lg shadow">
        <thead class="bg-gray-50">
            <tr>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Date</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Type</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Catégorie</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Description</th>
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Fournisseur</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Montant</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($operations as $operation)
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4">{{ $operation->date->format('d/m/Y') }}</td>
                <td class="py-3 px-4">
                    <span class="px-2 py-1 rounded text-sm {{ $operation->type_transaction === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $operation->type_transaction === 'credit' ? 'Crédit' : 'Débit' }}
                    </span>
                </td>
                <td class="py-3 px-4">{{ $operation->libelle }}</td>
                <td class="py-3 px-4">{{ $operation->libelle }}</td>
                <td class="py-3 px-4">{{ $operation->fournisseur->nom_fournisseur ?? 'N/A' }}</td>
                <td class="py-3 px-4 text-right font-medium {{ $operation->type_transaction === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($operation->montant_transaction, 2, ',', ' ') }} Dhs
                </td>
                <td class="py-3 px-4 text-right whitespace-nowrap">
                    <a href="{{ route('operations.edit', $operation) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                    <form action="{{ route('operations.destroy', $operation) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette opération ?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="py-4 text-center text-gray-500">Aucune opération trouvée.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection 