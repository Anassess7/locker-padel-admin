@extends('layouts.dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-6">User Details</h1>
<div class="bg-white p-6 rounded shadow max-w-lg">
    <div class="mb-4">
        <span class="font-semibold">ID:</span> {{ $user->id }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Name:</span> {{ $user->name }}
    </div>
    <div class="mb-4">
        <span class="font-semibold">Email:</span> {{ $user->email }}
    </div>
    <div class="flex justify-end">
        <a href="{{ route('users.edit', $user) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-2">Edit</a>
        <a href="{{ route('users.index') }}" class="text-gray-600 hover:underline">Back</a>
    </div>
</div>
@endsection 