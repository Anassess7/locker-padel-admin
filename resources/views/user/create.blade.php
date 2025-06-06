@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">Add User</h1>
<form action="{{ route('users.store') }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
    @csrf
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Name</label>
        <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Email</label>
        <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="mb-4">
        <label class="block mb-2 font-semibold">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('users.index') }}" class="mr-4 text-gray-600 hover:underline">Cancel</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add</button>
    </div>
</form>
@endsection 