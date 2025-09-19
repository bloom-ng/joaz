@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Transaction Details</h1>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Transaction Information -->
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Transaction Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Transaction ID</p>
                    <p class="font-semibold text-gray-900">#{{ $transaction->id }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Order ID</p>
                    @if($transaction->order)
                        <a href="{{ route('admin.orders.show', $transaction->order) }}" class="font-semibold text-blue-600 hover:underline">
                            #{{ $transaction->order_id }}
                        </a>
                    @else
                        <p class="font-semibold text-gray-900">#{{ $transaction->order_id }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Gateway</p>
                    <p class="font-semibold text-gray-900 capitalize">{{ $transaction->gateway }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Reference</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->transaction_reference }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Amount</p>
                    <p class="font-semibold text-gray-900">{{ strtoupper($transaction->currency) }} {{ number_format($transaction->amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Status</p>
                    @php
                        $statusColors = [
                            'successful' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'failed' => 'bg-red-100 text-red-800',
                            'cancelled' => 'bg-gray-100 text-gray-800',
                        ];
                        $badgeClass = $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs {{ $badgeClass }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Paid At</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->paid_at ? $transaction->paid_at->format('Y-m-d H:i:s') : '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Created At</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        @if($transaction->order)
        <div class="bg-white shadow-lg rounded-xl p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Order Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Order ID</p>
                    <a href="{{ route('admin.orders.show', $transaction->order) }}" class="font-semibold text-blue-600 hover:underline">
                        #{{ $transaction->order->id }}
                    </a>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Customer</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->order->user->name ?? '' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Customer Email</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->order->user->email ?? '' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Order Total</p>
                    <p class="font-semibold text-gray-900">
                        {{ strtoupper($transaction->order->currency) }} {{ number_format($transaction->order->total_amount, 2) }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Order Status</p>
                    @php
                        $orderStatusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'shipped' => 'bg-purple-100 text-purple-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $orderBadgeClass = $orderStatusColors[$transaction->order->order_status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-2 py-1 rounded-full text-xs {{ $orderBadgeClass }} capitalize">
                        {{ $transaction->order->order_status }}
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="flex justify-end">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Back to Transactions
        </a>
    </div>
</div>

@endsection
