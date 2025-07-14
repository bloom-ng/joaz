@extends('layouts.admin-layout')

@section('content')
<div class="w-full ">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
        <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700"><i class="fas fa-edit mr-2"></i>Edit Status</a>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Order Number</p>
                <p class="font-semibold text-gray-900"># {{ $order->tracking_number }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Order Date</p>
                <p class="font-semibold text-gray-900">{{ $order->created_at->format('Y-m-d') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Customer</p>
                <p class="font-semibold text-gray-900">{{ $order->user->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Status</p>
                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs capitalize">{{ $order->order_status }}</span>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Payment Status</p>
                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs capitalize">{{ $order->payment_status }}</span>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Delivery Method</p>
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs capitalize">{{ $order->delivery_method }}</span>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Tracking Number</p>
                <p class="font-semibold text-gray-900">{{ $order->tracking_number ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total</p>
                <p class="font-semibold text-gray-900">{{ $order->payment_currency }} {{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Order Items</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->product->name ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->payment_currency }} {{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->payment_currency }} {{ number_format($item->unit_price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Delivery Information</h2>
        @if($order->delivery)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Address</p>
                    <p class="font-semibold text-gray-900">{{ $order->delivery->address ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Status</p>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs capitalize">{{ $order->delivery->status ?? '-' }}</span>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Delivered At</p>
                    <p class="font-semibold text-gray-900">{{ $order->delivery->delivered_at ? $order->delivery->delivered_at->format('Y-m-d H:i') : '-' }}</p>
                </div>
            </div>
        @else
            <p class="text-gray-500">No delivery information available.</p>
        @endif
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Transactions</h2>
        @if($order->transactions && $order->transactions->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction #</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->transactions as $transaction)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">#{{ $transaction->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->payment_currency }} {{ number_format($transaction->amount, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 capitalize">{{ $transaction->status }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500">No transactions found for this order.</p>
        @endif
    </div>
</div>
@endsection
