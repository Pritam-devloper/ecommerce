@extends('layouts.dashboard')
@section('title', 'My Products')
@section('page-title', 'Manage Products')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-lg font-semibold">All Products ({{ $products->total() }})</h2>
    <a href="{{ route('seller.products.create') }}" class="bg-flipblue text-white px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-plus mr-2"></i>Add Product</a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Product</th><th class="p-4">Category</th><th class="p-4">Price</th><th class="p-4">Stock</th><th class="p-4">Status</th><th class="p-4">Actions</th></tr></thead>
        <tbody>
        @forelse($products as $product)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gray-100 rounded overflow-hidden shrink-0">
                        @if($product->thumbnail)<img src="{{ asset('storage/'.$product->thumbnail) }}" class="w-full h-full object-cover">@endif
                    </div>
                    <span class="font-medium">{{ Str::limit($product->name, 30) }}</span>
                </div>
            </td>
            <td class="p-4">{{ $product->category->name ?? '-' }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($product->final_price, 0) }}</td>
            <td class="p-4"><span class="{{ $product->stock < 5 ? 'text-red-600 font-bold' : '' }}">{{ $product->stock }}</span></td>
            <td class="p-4">
                <span class="px-2 py-1 rounded text-xs font-semibold
                    {{ $product->status === 'approved' ? 'bg-green-100 text-green-700' : ($product->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($product->status) }}
                </span>
            </td>
            <td class="p-4">
                <div class="flex gap-2">
                    <a href="{{ route('seller.products.edit', $product) }}" class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{ route('seller.products.delete', $product) }}" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="p-8 text-center text-gray-500">No products yet. <a href="{{ route('seller.products.create') }}" class="text-flipblue">Add your first product</a></td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $products->links() }}</div>
@endsection
