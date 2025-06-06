@extends('layouts.dashboard')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Marques</h1>
    <a href="{{ route('marques.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Marque</a>
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
                <th class="py-3 px-4 border-b text-left font-medium text-gray-500">Name</th>
                <th class="py-3 px-4 border-b text-center font-medium text-gray-500">Image</th>
                <th class="py-3 px-4 border-b text-right font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($marques as $marque)
            <tr class="hover:bg-gray-50">
                <td class="py-3 px-4 whitespace-nowrap">{{ $marque->id }}</td>
                <td class="py-3 px-4">{{ $marque->marque }}</td>
                <td class="py-3 px-4 text-center">
                    @if($marque->image)
                        <img src="{{ asset('storage/' . $marque->image) }}" alt="{{ $marque->marque }}" class="h-8 object-contain mx-auto">
                    @else
                        <span class="text-gray-400">No image</span>
                    @endif
                </td>
                <td class="py-3 px-4 text-right whitespace-nowrap">
                    <a href="{{ route('marques.edit', $marque) }}" class="text-blue-600 hover:text-blue-800 mr-3">Edit</a>
                    <form action="{{ route('marques.destroy', $marque) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Delete this marque?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-500">No marques found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection