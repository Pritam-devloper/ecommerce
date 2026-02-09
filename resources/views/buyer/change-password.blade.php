@extends('layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="max-w-lg mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-lock text-flipblue mr-2"></i>Change Password</h1>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('buyer.change-password.update') }}">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 border rounded-lg">
            </div>
            <button type="submit" class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update Password</button>
        </form>
    </div>
</div>
@endsection
