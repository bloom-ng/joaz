@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Transactions</h1>
    </div>

    <!-- Search Form -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex items-center gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Transactions</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by reference, gateway, status..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.transactions.index') }}"
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction Ref #</th>

                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gateway</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="View Details">
                                <i class="fas fa-eye text-gray-700"></i>
                            </a>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $transaction->transaction_reference }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 capitalize">
                            {{ $transaction->gateway }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                            {{ strtoupper($transaction->currency) }} {{ number_format($transaction->amount, 2) }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
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
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                            {{ $transaction->paid_at ? $transaction->paid_at->format('Y-m-d H:i') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-3 text-center text-gray-500">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
