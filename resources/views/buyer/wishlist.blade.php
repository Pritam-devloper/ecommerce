@extends('layouts.app')
@section('title', 'My Wishlist')
@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-heart text-red-500 mr-2"></i>My Wishlist</h1>
    @if($items->count())
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($items as $item)
            @include('components.product-card', ['product' => $item->product])
        @endforeach
    </div>
    {{ $items->links() }}
    @else
    <div class="text-center py-16 bg-white rounded-xl">
        <i class="fas fa-heart text-gray-300 text-5xl mb-4"></i>
        <p class="text-gray-500">Your wishlist is empty</p>
    </div>
    @endif
</div>
@endsection
