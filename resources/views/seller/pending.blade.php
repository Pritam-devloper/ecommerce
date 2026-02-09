@extends('layouts.app')
@section('title', 'Seller Approval Pending')
@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="text-center bg-white rounded-2xl shadow p-10 max-w-md">
        <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-clock text-yellow-500 text-4xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Approval Pending</h1>
        <p class="text-gray-500 mb-6">Your seller account is under review. You'll be notified once admin approves your account.</p>
        <a href="{{ route('home') }}" class="bg-flipblue text-white px-6 py-3 rounded-lg hover:bg-blue-700 inline-block">Go to Homepage</a>
    </div>
</div>
@endsection
