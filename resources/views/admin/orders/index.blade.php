@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Orders</h1>
    </div>
    
    <!-- Search Form -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Orders</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by tracking number, customer, status..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.orders.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tracking Number</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="View Details">
                                    <i class="fas fa-eye text-[#222222]"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200 ml-2" title="Edit Status">
                                    <i class="fas fa-edit text-green-800"></i>
                                </a>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">  {{ $order->tracking_number }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->user->name ?? '-' }}</td>

                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 capitalize">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'shipped' => 'bg-purple-100 text-purple-800',
                                        'delivered' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                    $badgeClass = $statusColors[$order->order_status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs {{ $badgeClass }}">{{ $order->order_status }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->payment_currency }} {{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-center text-gray-500">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
