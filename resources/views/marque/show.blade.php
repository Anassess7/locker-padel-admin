@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Marque Details</h1>
<div class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-4">
        <span class="font-semibold">ID:</span> {{ $marque->id }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Name:</span> {{ $marque->marque }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Image:</span>
        @if($marque->image)
            <img src="{{ asset('storage/' . $marque->image) }}" alt="{{ $marque->marque }}" class="h-16 inline">
        @else
            <span class="text-gray-400">No image</span>
        @endif
    </div>
    <div class="flex justify-end">
        <a href="{{ route('marques.edit', $marque) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Edit</a>
        <a href="{{ route('marques.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>
</div>
@endsection 