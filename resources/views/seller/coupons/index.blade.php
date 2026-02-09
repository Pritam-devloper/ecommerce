@extends('layouts.dashboard')
@section('title', 'Coupons')
@section('page-title', 'Manage Coupons')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<!-- Create Coupon -->
<div x-data="{ open: false }" class="mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Your Coupons</h2>
        <button @click="open = !open" class="bg-flipblue text-white px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-plus mr-2"></i>Create Coupon</button>
    </div>

    <div x-show="open" x-transition class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <form method="POST" action="{{ route('seller.coupons.store') }}" class="grid md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1">Coupon Code *</label>
                <input type="text" name="code" value="{{ old('code') }}" required class="w-full border rounded-lg px-4 py-2 uppercase" placeholder="e.g. SALE20">
                @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Type *</label>
                <select name="type" class="w-full border rounded-lg px-4 py-2">
                    <option value="fixed">Fixed Amount (₹)</option>
                    <option value="percent">Percentage (%)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Value *</label>
                <input type="number" name="value" value="{{ old('value') }}" step="0.01" min="0" required class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Min Order Amount</label>
                <input type="number" name="min_order" value="{{ old('min_order', 0) }}" step="0.01" min="0" class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Max Uses</label>
                <input type="number" name="max_uses" value="{{ old('max_uses') }}" min="1" class="w-full border rounded-lg px-4 py-2" placeholder="Unlimited">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Expires At</label>
                <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="w-full border rounded-lg px-4 py-2">
            </div>
            <div class="md:col-span-2">
                <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-save mr-2"></i>Create Coupon</button>
            </div>
        </form>
    </div>
</div>

<!-- Coupons List -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Code</th><th class="p-4">Type</th><th class="p-4">Value</th><th class="p-4">Min Order</th><th class="p-4">Used</th><th class="p-4">Expires</th><th class="p-4">Status</th><th class="p-4">Actions</th></tr></thead>
        <tbody>
        @forelse($coupons as $coupon)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-mono font-bold">{{ $coupon->code }}</td>
            <td class="p-4">{{ ucfirst($coupon->type) }}</td>
            <td class="p-4 font-semibold">{{ $coupon->type === 'fixed' ? '₹' : '' }}{{ $coupon->value }}{{ $coupon->type === 'percent' ? '%' : '' }}</td>
            <td class="p-4">₹{{ number_format($coupon->min_order, 0) }}</td>
            <td class="p-4">{{ $coupon->used }}{{ $coupon->max_uses ? '/'.$coupon->max_uses : '' }}</td>
            <td class="p-4">{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d M Y') : 'Never' }}</td>
            <td class="p-4">
                @if($coupon->isValid())
                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-700">Active</span>
                @else
                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-100 text-red-700">Expired</span>
                @endif
            </td>
            <td class="p-4">
                <form method="POST" action="{{ route('seller.coupons.delete', $coupon) }}" onsubmit="return confirm('Delete this coupon?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" class="p-8 text-center text-gray-500">No coupons yet. Create your first coupon above!</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
