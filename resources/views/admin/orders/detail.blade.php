@extends('layouts.dashboard')
@section('title', 'Order Detail')
@section('page-title', 'Order #' . $order->order_number)

@section('sidebar')
@include('admin.partials.sidebar')
@endsection

@section('content')
<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Order Items</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                    <div class="w-14 h-14 bg-gray-200 rounded shrink-0 overflow-hidden">
                        @if($item->product && $item->product->thumbnail)<img src="{{ asset('storage/'.$item->product->thumbnail) }}" class="w-full h-full object-cover">@endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-500">Seller: {{ $item->seller->shop_name ?? 'N/A' }} | Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 0) }}</p>
                    </div>
                    <p class="font-semibold shrink-0">₹{{ number_format($item->total, 0) }}</p>
                </div>
                @endforeach
            </div>
            <div class="mt-4 pt-4 border-t space-y-2 text-sm">
                <div class="flex justify-between"><span>Subtotal</span><span>₹{{ number_format($order->subtotal, 0) }}</span></div>
                <div class="flex justify-between"><span>Shipping</span><span>₹{{ number_format($order->shipping, 0) }}</span></div>
                @if($order->discount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>-₹{{ number_format($order->discount, 0) }}</span></div>@endif
                <div class="flex justify-between font-bold text-lg border-t pt-2"><span>Total</span><span>₹{{ number_format($order->total, 0) }}</span></div>
            </div>
        </div>

        <!-- Update Status / Refund -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Actions</h3>
            <div class="flex gap-3 flex-wrap">
                @if(!in_array($order->status, ['refunded']))
                <form method="POST" action="{{ route('admin.orders.refund', $order) }}" onsubmit="return confirm('Process refund for this order?')">
                    @csrf @method('PATCH')
                    <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm"><i class="fas fa-undo mr-1"></i>Process Refund</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Order Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Status</span>
                    @php $colors = ['pending'=>'yellow','confirmed'=>'blue','processing'=>'purple','shipped'=>'indigo','delivered'=>'green','cancelled'=>'red','refunded'=>'gray']; @endphp
                    <span class="px-2 py-1 rounded text-xs font-semibold bg-{{ $colors[$order->status] ?? 'gray' }}-100 text-{{ $colors[$order->status] ?? 'gray' }}-700">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="flex justify-between"><span class="text-gray-500">Payment</span><span>{{ ucfirst($order->payment_method) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Pay Status</span><span class="{{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }} font-medium">{{ ucfirst($order->payment_status) }}</span></div>
                @if($order->coupon_code)<div class="flex justify-between"><span class="text-gray-500">Coupon</span><span class="font-mono">{{ $order->coupon_code }}</span></div>@endif
                <div class="flex justify-between"><span class="text-gray-500">Date</span><span>{{ $order->created_at->format('d M Y, h:i A') }}</span></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Customer</h3>
            <p class="font-medium">{{ $order->user->name }}</p>
            <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold mb-4">Shipping</h3>
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
