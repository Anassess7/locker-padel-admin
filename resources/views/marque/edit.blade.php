@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Edit Marque</h1>
<form action="{{ route('marques.update', $marque) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Name</label>
        <input type="text" name="marque" value="{{ old('marque', $marque->marque) }}" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Image</label>
        <input type="file" name="image" class="w-full border rounded px-3 py-2">
        @if($marque->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $marque->image) }}" alt="{{ $marque->marque }}" class="h-12 inline">
            </div>
        @endif
    </div>
    <div class="flex justify-end">
        <a href="{{ route('marques.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
    </div>
</form>
@endsection 