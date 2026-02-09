@extends('layouts.app')
@section('title', 'Search: ' . ($q ?? '') . ' - AbhiShop')
@section('content')
<div class="max-w-[1440px] mx-auto px-4 py-4">
    <div class="bg-white rounded-sm shadow-sm p-4 mb-3 flex items-center justify-between">
        <h1 class="text-sm text-gray-600">
            @if($q) Showing results for "<span class="font-bold text-gray-900">{{ $q }}</span>" @else All Products @endif
        </h1>
        <span class="text-xs text-gray-400">{{ $products->total() }} products found</span>
    </div>

    @if($products->count())
        <div class="bg-white rounded-sm shadow-sm p-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3">
                @foreach($products as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-6">{{ $products->links() }}</div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-sm shadow-sm">
            <i class="fas fa-search text-gray-200 text-6xl mb-4"></i>
            <h2 class="text-lg text-gray-500 mb-1">Sorry, no results found!</h2>
            <p class="text-gray-400 text-sm">Please check the spelling or try searching for something else</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-flipblue text-white px-8 py-2 rounded-sm text-sm font-bold hover:bg-blue-700">Back to Home</a>
        </div>
    @endif
</div>
@endsection
