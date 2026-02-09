@extends('layouts.app')
@section('title', 'My Profile - AbhiShop')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-user text-flipblue mr-2"></i>My Profile</h1>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('buyer.profile.update') }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-2 border rounded-lg bg-gray-50">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ $user->phone }}" class="w-full px-4 py-2 border rounded-lg">
                </div>
            </div>
            <button type="submit" class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Changes</button>
        </form>
    </div>
</div>
@endsection
