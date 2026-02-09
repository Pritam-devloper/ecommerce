@extends('layouts.dashboard')
@section('title', 'Order Detail')
@section('page-title', 'Order #' . $order->order_number)

@section('sidebar')
<a href="{{ route('seller.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-tachometer-alt w-8"></i><span x-show="sidebarOpen">Dashboard</span></a>
<a href="{{ route('seller.products') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-box w-8"></i><span x-show="sidebarOpen">Products</span></a>
<a href="{{ route('seller.orders') }}" class="flex items-center px-4 py-3 rounded-lg text-white bg-flipblue"><i class="fas fa-shopping-bag w-8"></i><span x-show="sidebarOpen">Orders</span></a>
<a href="{{ route('seller.coupons') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-ticket-alt w-8"></i><span x-show="sidebarOpen">Coupons</span></a>
<a href="{{ route('seller.wallet') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-wallet w-8"></i><span x-show="sidebarOpen">Wallet</span></a>
<a href="{{ route('seller.profile') }}" class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-white/10"><i class="fas fa-cog w-8"></i><span x-show="sidebarOpen">Settings</span></a>
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <!-- Order Items -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Your Items in This Order</h3>
            @php $myItems = $order->items->where('seller_id', auth()->user()->seller->id); @endphp
            <div class="space-y-3">
                @foreach($myItems as $item)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-gray-200 rounded shrink-0 overflow-hidden">
                        @if($item->product && $item->product->thumbnail)<img src="{{ asset('storage/'.$item->product->thumbnail) }}" class="w-full h-full object-cover">@endif
                    </div>
                    <div class="flex-1">
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 0) }}</p>
                    </div>
                    <p class="font-semibold">₹{{ number_format($item->total, 0) }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t flex justify-between font-semibold text-lg">
                <span>Your Total</span>
                <span>₹{{ number_format($myItems->sum('total'), 0) }}</span>
            </div>
        </div>

        <!-- Update Status -->
        @if(!in_array($order->status, ['delivered','cancelled','refunded']))
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Update Order Status</h3>
            <form method="POST" action="{{ route('seller.orders.status', $order) }}" class="flex gap-3">
                @csrf @method('PATCH')
                <select name="status" class="border rounded-lg px-4 py-2 flex-1">
                    @foreach(['confirmed','processing','shipped','delivered'] as $s)
                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button class="bg-flipblue text-white px-6 py-2 rounded-lg hover:bg-blue-700">Update</button>
            </form>
        </div>
        @endif
    </div>

    <!-- Order Info Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Order Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Status</span>
                    @php $colors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red','refunded'=>'gray']; @endphp
                    <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="flex justify-between"><span class="text-gray-500">Payment</span><span>{{ ucfirst($order->payment_method) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Payment Status</span><span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($order->payment_status) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Date</span><span>{{ $order->created_at->format('d M Y, h:i A') }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Customer</h3>
            <div class="space-y-2 text-sm">
                <p class="font-medium">{{ $order->user->name }}</p>
                <p class="text-gray-500">{{ $order->user->email }}</p>
                @if($order->user->phone)<p class="text-gray-500">{{ $order->user->phone }}</p>@endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Shipping Address</h3>
            <div class="text-sm text-gray-600">
                <p class="font-medium text-gray-800">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_phone }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_zip }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
