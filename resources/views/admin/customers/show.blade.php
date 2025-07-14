@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Customer Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded hover:bg-green-700"><i class="fas fa-edit mr-2"></i>Edit</a>
            <button type="button" class="inline-flex items-center px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 open-delete-customer-modal" data-customer-name="{{ $customer->name }}" data-customer-id="{{ $customer->id }}"><i class="fas fa-trash mr-2"></i>Delete</button>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Name</p>
                <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-semibold text-gray-900">{{ $customer->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Phone</p>
                <p class="font-semibold text-gray-900">{{ $customer->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Avatar</p>
                @if($customer->profile && $customer->profile->avatar)
                    <img src="{{ asset('storage/' . $customer->profile->avatar) }}" alt="Avatar" class="w-16 h-16 mt-2 rounded-full object-cover border">
                @else
                    <span class="text-gray-500">-</span>
                @endif
            </div>
            <div>
                <p class="text-gray-600 text-sm">Gender</p>
                <p class="font-semibold text-gray-900">{{ ucfirst($customer->profile->gender ?? '-') }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Date of Birth</p>
                <p class="font-semibold text-gray-900">{{ $customer->profile && $customer->profile->date_of_birth ? $customer->profile->date_of_birth->format('Y-m-d') : '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-600 text-sm">Bio</p>
                <p class="font-semibold text-gray-900">{{ $customer->profile->bio ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-600 text-sm">Social Links</p>
                @if($customer->profile && !empty($customer->profile->social_links))
                    <ul class="list-disc ml-5">
                        @foreach($customer->profile->social_links as $link)
                            <li><a href="{{ $link }}" class="text-blue-600 underline" target="_blank">{{ $link }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <span class="text-gray-500">-</span>
                @endif
            </div>
        </div>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Orders</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($customer->orders as $order)
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">${{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($order->status) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="View Order">
                                    <i class="fas fa-eye text-[#222222]"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Delete Customer Modal --}}
<div id="deleteCustomerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Delete Customer</h2>
        <p class="text-gray-700 mb-6">Are you sure you want to delete the customer <span id="deleteCustomerName" class="font-semibold text-red-600"></span>? This action cannot be undone.</p>
        <form id="deleteCustomerForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-4">
                <button type="button" id="cancelDeleteCustomer" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('deleteCustomerModal');
    const deleteButtons = document.querySelectorAll('.open-delete-customer-modal');
    const cancelBtn = document.getElementById('cancelDeleteCustomer');
    const deleteCustomerName = document.getElementById('deleteCustomerName');
    const deleteCustomerForm = document.getElementById('deleteCustomerForm');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const customerName = this.getAttribute('data-customer-name');
            const customerId = this.getAttribute('data-customer-id');
            deleteCustomerName.textContent = customerName;
            deleteCustomerForm.action = `/admin/customers/${customerId}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    cancelBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Optional: close modal on background click
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});
</script>
@endsection
