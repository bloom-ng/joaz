@extends("layouts.admin-layout")

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Product Reviews</h1>
    </div>

    <!-- Search Form -->
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="flex items-center gap-4">
            <div class="flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Reviews</label>
                <input type="text"
                       id="search"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by product name, user name, or review..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div class="flex gap-2 mt-6">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.reviews.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-lg font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                        <i class="fas fa-times mr-2"></i>
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($reviews as $review)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap items-center gap-1">
                                    <a href="{{ route('admin.reviews.show', $review->id) }}"
                                        class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200"
                                        title="View Review">
                                        <i class="fas fa-eye text-gray-700"></i>
                                    </a>
                                    <a href="{{ route('admin.reviews.edit', $review->id) }}"
                                        class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200"
                                        title="Edit Review">
                                        <i class="fas fa-edit text-blue-600"></i>
                                    </a>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline-block m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                            onclick="if(confirm('Are you sure you want to delete this review?')) { this.form.submit(); }"
                                            class="inline-flex items-center justify-center w-6 h-6 cursor-pointer hover:scale-110 transition-all duration-200"
                                            title="Delete Review">
                                            <i class="fas fa-trash text-red-600"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                <a href="{{ route('admin.products.edit', $review->product->id) }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $review->product->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ $review->user->name }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <div class="flex text-yellow-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas {{ $i <= $review->rating ? 'fa-star' : 'fa-star-o' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <div class="line-clamp-2">{{ $review->review }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ $review->created_at->format('d M, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
            
            @if($reviews->hasPages())
                <div class="mt-6 px-4 py-3 border-t border-gray-200">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Script -->
<script>
    // This script handles the delete confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('button[onclick*="confirm("]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this review?')) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            });
        });
    });
</script>
@endsection
