@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Customers</h1>
    </div>
    
    <!-- Search Form -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('admin.customers.index') }}" class="flex items-center gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Customers</label>
                <input type="text" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, or phone..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.customers.index') }}"
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
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orders</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="View Details">
                                    <i class="fas fa-eye text-[#222222]"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="Edit">
                                    <i class="fas fa-edit text-green-800"></i>
                                </a>
                                <button type="button"
                                    class="inline-flex items-center justify-center w-6 h-6 cursor-pointer hover:scale-110 transition-all duration-200 open-delete-customer-modal"
                                    title="Delete Customer" data-customer-name="{{ $customer->name }}" data-customer-id="{{ $customer->id }}">
                                    <i class="fas fa-trash text-[#B22234]"></i>
                                </button>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $customer->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $customer->email }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $customer->phone ?? '-' }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $customer->orders_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $customers->links() }}
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
