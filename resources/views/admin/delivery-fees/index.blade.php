@extends('layouts.admin-layout')

@push('scripts')
<script>
    function showDeleteModal(id) {
        document.getElementById('delete-fee-id').value = id;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function hideDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
</script>
@endpush

@section('content')

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="hidden fixed inset-0 bg-opacity-50 overflow-y-auto h-full w-full mt-8">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Delivery Fee</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Are you sure you want to delete this delivery fee? This action cannot be undone.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form id="delete-form" action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete
                    </button>
                </form>
                <button onclick="hideDeleteModal()" class="ml-3 px-4 py-2 bg-gray-200 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<div class="w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Delivery Fees</h2>
        <a href="{{ route('admin.delivery-fees.create') }}"
           class="px-4 py-2 bg-[#85BB3F] text-white rounded-lg hover:bg-[#6e9e33] transition-colors">
            Add New Fee
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($deliveryFees as $fee)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $fee->country }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                            {{ number_format($fee->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.delivery-fees.edit', $fee->id) }}"
                                   class="text-blue-600 hover:text-blue-900 mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                        onclick="document.getElementById('delete-fee-id').value = '{{ $fee->id }}'; document.getElementById('delete-form').action = '{{ route('admin.delivery-fees.destroy', $fee->id) }}'; document.getElementById('delete-modal').classList.remove('hidden')"
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                            No delivery fees found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $deliveryFees->links() }}
        </div>
    </div>
</div>

<input type="hidden" id="delete-fee-id" value="">

@endsection
