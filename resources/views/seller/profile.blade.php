@extends('layouts.dashboard')
@section('title', 'Shop Settings')
@section('page-title', 'Shop Profile')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">Shop Information</h3>
            <div>
                <label class="block text-sm font-medium mb-1">Shop Name *</label>
                <input type="text" name="shop_name" value="{{ old('shop_name', $seller->shop_name) }}" required class="w-full border rounded-lg px-4 py-2">
                @error('shop_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Shop Description</label>
                <textarea name="description" rows="4" class="w-full border rounded-lg px-4 py-2">{{ old('description', $seller->description) }}</textarea>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $seller->phone) }}" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $seller->address) }}" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">Shop Images</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Shop Logo</label>
                    @if($seller->logo)<img src="{{ asset('storage/'.$seller->logo) }}" class="w-20 h-20 object-cover rounded-full border mb-2">@endif
                    <input type="file" name="logo" accept="image/*" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Shop Banner</label>
                    @if($seller->banner)<img src="{{ asset('storage/'.$seller->banner) }}" class="w-full h-20 object-cover rounded border mb-2">@endif
                    <input type="file" name="banner" accept="image/*" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
        </div>

        <button type="submit" class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-save mr-2"></i>Save Changes</button>
    </form>
</div>
@endsection
