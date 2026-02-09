@extends('layouts.app')
@section('title', 'My Addresses')
@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-map-marker-alt text-flipblue mr-2"></i>Saved Addresses</h1>

    {{-- Add Address Form --}}
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center text-flipblue font-semibold">
            <i class="fas fa-plus mr-2"></i>Add New Address
        </button>
        <form method="POST" action="{{ route('buyer.addresses.store') }}" x-show="open" x-cloak class="mt-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-1">Full Name</label><input type="text" name="name" required class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="block text-sm font-medium mb-1">Phone</label><input type="text" name="phone" required class="w-full border rounded-lg px-3 py-2"></div>
                <div class="md:col-span-2"><label class="block text-sm font-medium mb-1">Address</label><input type="text" name="address_line" required class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="block text-sm font-medium mb-1">City</label><input type="text" name="city" required class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="block text-sm font-medium mb-1">State</label><input type="text" name="state" required class="w-full border rounded-lg px-3 py-2"></div>
                <div><label class="block text-sm font-medium mb-1">ZIP Code</label><input type="text" name="zip_code" required class="w-full border rounded-lg px-3 py-2"></div>
                <div class="flex items-end"><label class="flex items-center"><input type="checkbox" name="is_default" value="1" class="mr-2">Set as default address</label></div>
            </div>
            <button type="submit" class="mt-4 bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Address</button>
        </form>
    </div>

    {{-- Address Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($addresses as $address)
        <div class="bg-white rounded-xl shadow-sm p-6 {{ $address->is_default ? 'border-2 border-flipblue' : '' }}">
            @if($address->is_default)<span class="text-xs bg-blue-50 text-blue-700 px-2 py-1 rounded font-medium">Default</span>@endif
            <h3 class="font-semibold mt-2">{{ $address->name }}</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $address->full_address }}</p>
            <p class="text-sm text-gray-500 mt-1"><i class="fas fa-phone mr-1"></i>{{ $address->phone }}</p>
            <form method="POST" action="{{ route('buyer.addresses.delete', $address) }}" class="mt-3">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 text-sm hover:underline"><i class="fas fa-trash mr-1"></i>Delete</button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
