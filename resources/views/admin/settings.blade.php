@extends('layouts.dashboard')
@section('title', 'Settings')
@section('page-title', 'Website Settings')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<div class="max-w-3xl">
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">General Settings</h3>
            <div>
                <label class="block text-sm font-medium mb-1">Site Name</label>
                <input type="text" name="settings[site_name]" value="{{ $settings['site_name'] ?? 'ShopZone' }}" class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Site Description</label>
                <textarea name="settings[site_description]" rows="3" class="w-full border rounded-lg px-4 py-2">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Contact Email</label>
                <input type="email" name="settings[contact_email]" value="{{ $settings['contact_email'] ?? '' }}" class="w-full border rounded-lg px-4 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Contact Phone</label>
                <input type="text" name="settings[contact_phone]" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full border rounded-lg px-4 py-2">
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 space-y-4">
            <h3 class="text-lg font-semibold border-b pb-2">Business Settings</h3>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Default Commission Rate (%)</label>
                    <input type="number" name="settings[default_commission]" value="{{ $settings['default_commission'] ?? 10 }}" min="0" max="100" step="0.1" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Shipping Charge (₹)</label>
                    <input type="number" name="settings[shipping_charge]" value="{{ $settings['shipping_charge'] ?? 50 }}" min="0" step="0.01" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Free Shipping Above (₹)</label>
                    <input type="number" name="settings[free_shipping_above]" value="{{ $settings['free_shipping_above'] ?? 500 }}" min="0" step="0.01" class="w-full border rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Min Withdrawal Amount (₹)</label>
                    <input type="number" name="settings[min_withdrawal]" value="{{ $settings['min_withdrawal'] ?? 100 }}" min="0" class="w-full border rounded-lg px-4 py-2">
                </div>
            </div>
        </div>

        <button type="submit" class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-save mr-2"></i>Save Settings</button>
    </form>
</div>
@endsection
