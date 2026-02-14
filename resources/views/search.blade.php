@extends('layouts.app')
@section('title', ($q ? 'Search: ' . $q : 'Shop All') . ' - Shiivaraa')
@section('content')

<div class="bg-stone-50 min-h-screen">
    {{-- Page Header --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
            <h1 class="jewelry-serif text-3xl md:text-4xl font-light text-gray-900 mb-2">
                @if($q) Search Results @else Shop All Jewelry @endif
            </h1>
            <p class="text-gray-600">
                @if($q) 
                    Showing results for "<span class="font-medium">{{ $q }}</span>"
                @else 
                    Discover our complete collection of handcrafted jewelry
                @endif
                <span class="text-gray-400 ml-2">({{ $products->total() }} {{ Str::plural('piece', $products->total()) }})</span>
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-12 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- Sidebar Filters --}}
            <aside class="lg:w-64 shrink-0">
                <div class="bg-white p-6 sticky top-24">
                    <h3 class="text-sm uppercase tracking-wider text-gray-900 font-medium mb-4">Filter By</h3>
                    
                    {{-- Categories --}}
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h4 class="text-sm text-gray-700 mb-3 font-medium">Category</h4>
                        <div class="space-y-2">
                            @foreach($categories as $cat)
                            <a href="{{ route('category', $cat) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                {{ $cat->name }} <span class="text-gray-400">({{ $cat->products_count }})</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="mb-6 pb-6 border-b border-gray-200">
                        <h4 class="text-sm text-gray-700 mb-3 font-medium">Price Range</h4>
                        <div class="space-y-2">
                            <a href="{{ route('search', ['q' => $q, 'price' => 'under-25000']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                Under ₹25,000
                            </a>
                            <a href="{{ route('search', ['q' => $q, 'price' => '25000-50000']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                ₹25,000 - ₹50,000
                            </a>
                            <a href="{{ route('search', ['q' => $q, 'price' => '50000-100000']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                ₹50,000 - ₹1,00,000
                            </a>
                            <a href="{{ route('search', ['q' => $q, 'price' => 'above-100000']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                Above ₹1,00,000
                            </a>
                        </div>
                    </div>

                    {{-- Sort By --}}
                    <div class="mb-6">
                        <h4 class="text-sm text-gray-700 mb-3 font-medium">Sort By</h4>
                        <div class="space-y-2">
                            <a href="{{ route('search', ['q' => $q, 'sort' => 'newest']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                Newest First
                            </a>
                            <a href="{{ route('search', ['q' => $q, 'sort' => 'price_low']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                Price: Low to High
                            </a>
                            <a href="{{ route('search', ['q' => $q, 'sort' => 'price_high']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                Price: High to Low
                            </a>
                            <a href="{{ route('search', ['q' => $q, 'sort' => 'popular']) }}" 
                                class="block text-sm text-gray-600 hover:text-amber-700 transition">
                                Most Popular
                            </a>
                        </div>
                    </div>

                    {{-- Clear Filters --}}
                    <a href="{{ route('search') }}" 
                        class="block w-full text-center border border-gray-300 text-gray-700 py-2 text-sm hover:border-gray-400 transition">
                        Clear All Filters
                    </a>
                </div>
            </aside>

            {{-- Products Grid --}}
            <main class="flex-1">
                @if($products->count())
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="bg-white p-12 text-center">
                        <i class="fas fa-search text-gray-300 text-6xl mb-6"></i>
                        <h2 class="jewelry-serif text-2xl font-light text-gray-900 mb-3">No Results Found</h2>
                        <p class="text-gray-600 mb-6">
                            We couldn't find any products matching your search. Please try different keywords or browse our collections.
                        </p>
                        <a href="{{ route('home') }}" 
                            class="inline-block bg-gray-900 text-white px-8 py-3 text-sm tracking-wider uppercase hover:bg-gray-800 transition">
                            Back to Home
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

@endsection
