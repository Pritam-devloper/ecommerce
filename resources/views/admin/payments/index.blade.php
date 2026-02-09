@extends('layouts.dashboard')
@section('title', 'Payments')
@section('page-title', 'Payments & Withdrawals')

@section('sidebar')
<a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-users w-8"></i><span x-show="sidebarOpen">Users</span></a>
<a href="{{ route('admin.sellers') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-store w-8"></i><span x-show="sidebarOpen">Sellers</span></a>
<a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('admin.categories') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tags w-8"></i><span x-show="sidebarOpen">Categories</span></a>
<a href="{{ route('admin.banners') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-image w-8"></i><span x-show="sidebarOpen">Banners</span></a>
<a href="{{ route('admin.payments') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-credit-card w-8"></i><span x-show="sidebarOpen">Payments</span></a>
<a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
<a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-chart-bar w-8"></i><span x-show="sidebarOpen">Reports</span></a>
@endsection

@section('content')
<!-- Stats -->
<div class="grid md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-5 text-center">
        <p class="text-gray-500 text-sm">Total Commission Earned</p>
        <p class="text-2xl font-bold text-green-600">₹{{ number_format($totalCommission, 0) }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 text-center">
        <p class="text-gray-500 text-sm">Pending Withdrawals</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $pendingWithdrawals }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-5 text-center">
        <p class="text-gray-500 text-sm">Total Paid Out</p>
        <p class="text-2xl font-bold text-blue-600">₹{{ number_format($totalPaidOut, 0) }}</p>
    </div>
</div>

<!-- Withdrawal Requests -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-4 border-b"><h3 class="font-semibold">Withdrawal Requests</h3></div>
    <table class="w-full text-sm">
        <thead><tr class="bg-gray-50 text-left text-gray-500"><th class="p-4">Seller</th><th class="p-4">Amount</th><th class="p-4">Status</th><th class="p-4">Requested</th><th class="p-4">Actions</th></tr></thead>
        <tbody>
        @forelse($withdrawals as $w)
        <tr class="border-t hover:bg-gray-50">
            <td class="p-4 font-medium">{{ $w->seller->shop_name }}</td>
            <td class="p-4 font-semibold">₹{{ number_format($w->amount, 0) }}</td>
            <td class="p-4">
                @php $c = ['pending'=>'yellow','approved'=>'green','rejected'=>'red','paid'=>'blue']; @endphp
                <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $c[$w->status] ?? 'gray' }}-100 text-{{ $c[$w->status] ?? 'gray' }}-700">{{ ucfirst($w->status) }}</span>
            </td>
            <td class="p-4 text-gray-500">{{ $w->created_at->format('d M Y') }}</td>
            <td class="p-4">
                @if($w->status === 'pending')
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('admin.withdrawals.approve', $w) }}">@csrf @method('PATCH')<button class="text-green-600 hover:underline text-sm">Approve</button></form>
                    <form method="POST" action="{{ route('admin.withdrawals.reject', $w) }}">@csrf @method('PATCH')<button class="text-red-600 hover:underline text-sm">Reject</button></form>
                </div>
                @else
                <span class="text-gray-400">-</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-8 text-center text-gray-500">No withdrawal requests.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $withdrawals->links() }}</div>
@endsection
