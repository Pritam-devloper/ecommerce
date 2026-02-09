@extends('layouts.dashboard')
@section('title', 'Wallet')
@section('page-title', 'My Wallet')

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<!-- Balance Cards -->
<div class="grid md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-gray-500 text-sm">Total Earnings</p>
        <p class="text-2xl font-bold text-green-600 mt-1">₹{{ number_format($totalEarnings, 0) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-gray-500 text-sm">Commission Paid</p>
        <p class="text-2xl font-bold text-red-600 mt-1">₹{{ number_format($commission, 0) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-gray-500 text-sm">Available Balance</p>
        <p class="text-2xl font-bold text-flipblue mt-1">₹{{ number_format($balance, 0) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-gray-500 text-sm">Withdrawn</p>
        <p class="text-2xl font-bold text-gray-600 mt-1">₹{{ number_format($withdrawn, 0) }}</p>
    </div>
</div>

<!-- Withdraw Request -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6">
    <h3 class="font-semibold mb-4">Request Withdrawal</h3>
    <form method="POST" action="{{ route('seller.wallet.withdraw') }}" class="flex gap-3 items-end">
        @csrf
        <div class="flex-1">
            <label class="block text-sm font-medium mb-1">Amount (₹)</label>
            <input type="number" name="amount" min="100" max="{{ $balance }}" step="0.01" required class="w-full border rounded-lg px-4 py-2" placeholder="Min ₹100">
            @error('amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <button class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700 h-[42px]"><i class="fas fa-paper-plane mr-2"></i>Request</button>
    </form>
</div>

<!-- Withdrawal History -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b"><h3 class="font-semibold">Withdrawal History</h3></div>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Date</th><th class="p-4">Amount</th><th class="p-4">Status</th><th class="p-4">Processed At</th></tr></thead>
        <tbody>
        @forelse($withdrawRequests as $req)
        <tr class="border-t">
            <td class="p-4">{{ $req->created_at->format('d M Y') }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($req->amount, 0) }}</td>
            <td class="p-4">
                @php $c = ['pending'=>'yellow','approved'=>'green','rejected'=>'red','paid'=>'blue']; @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $c[$req->status] ?? 'gray' }}-100 text-{{ $c[$req->status] ?? 'gray' }}-700">{{ ucfirst($req->status) }}</span>
            </td>
            <td class="p-4 text-gray-500">{{ $req->processed_at ? \Carbon\Carbon::parse($req->processed_at)->format('d M Y') : '-' }}</td>
        </tr>
        @empty
        <tr><td colspan="4" class="p-8 text-center text-gray-500">No withdrawal requests yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
