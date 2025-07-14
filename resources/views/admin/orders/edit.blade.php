@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Order Status</h1>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="bg-white shadow-lg rounded-xl p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Order Number</label>
            <div class="px-4 py-2 bg-gray-100 rounded"># {{ $order->tracking_number }}</div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Customer</label>
            <div class="px-4 py-2 bg-gray-100 rounded">{{ $order->user->name ?? '-' }}</div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Total</label>
            <div class="px-4 py-2 bg-gray-100 rounded">{{ $order->payment_currency }} {{ number_format($order->total_amount, 2) }}</div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold mb-2">Date</label>
            <div class="px-4 py-2 bg-gray-100 rounded">{{ $order->created_at->format('Y-m-d') }}</div>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
            <select name="order_status" id="order_status" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                    <option value="{{ $status }}" {{ $order->order_status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            @error('status')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update Status</button>
        </div>
    </form>
</div>
@endsection
