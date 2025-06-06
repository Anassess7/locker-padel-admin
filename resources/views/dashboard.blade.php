@extends('layouts.dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-8">Dashboard</h1>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Articles</div>
        <div class="text-2xl font-bold">{{ $stats['articles'] }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Marques</div>
        <div class="text-2xl font-bold">{{ $stats['marques'] }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Clients</div>
        <div class="text-2xl font-bold">{{ $stats['clients'] }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Fournisseurs</div>
        <div class="text-2xl font-bold">{{ $stats['fournisseurs'] }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Commandes</div>
        <div class="text-2xl font-bold">{{ $stats['commandes'] }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Opérations (Total Dhs)</div>
        <div class="text-2xl font-bold">{{ number_format($stats['operations'], 2, ',', ' ') }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Utilisateurs</div>
        <div class="text-2xl font-bold">{{ $stats['utilisateurs'] }}</div>
    </div>
    <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Livraisons</div>
        <div class="text-2xl font-bold">{{ $stats['livraisons'] }}</div>
    </div>
</div>
@endsection
