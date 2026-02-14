@extends('layouts.dashboard')
@section('title', 'Settings')
@section('page-title', 'Website Settings')

@section('sidebar')
@include('admin.partials.sidebar')
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
