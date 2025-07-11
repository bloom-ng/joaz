@extends('layouts.admin-layout')

@section('content')
<div class="w-full">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center px-4 py-2 border-2 border-blue-600 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 hover:scale-105 transition-all duration-200">
            <i class="fas fa-plus mr-2"></i>
            Add Category
        </a>
    </div>
    <div class="bg-white shadow-lg rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent Category</th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.categories.show', $category) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="View Details">
                                    <i class="fas fa-eye text-[#222222]"></i>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center justify-center w-6 h-6 hover:scale-110 transition-all duration-200" title="Edit">
                                    <i class="fas fa-edit text-green-800"></i>
                                </a>
                                <button type="button"
                                    class="inline-flex items-center justify-center w-6 h-6 cursor-pointer hover:scale-110 transition-all duration-200 open-delete-category-modal"
                                    title="Delete Category" data-category-name="{{ $category->name }}" data-category-id="{{ $category->id }}">
                                    <i class="fas fa-trash text-[#B22234]"></i>
                                </button>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $category->parent?->name ?? '-' }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</div>

{{-- Delete Category Modal --}}
<div id="deleteCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Delete Category</h2>
        <p class="text-gray-700 mb-6">Are you sure you want to delete the category <span id="deleteCategoryName" class="font-semibold text-red-600"></span>? This action cannot be undone.</p>
        <form id="deleteCategoryForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-4">
                <button type="button" id="cancelDeleteCategory" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('deleteCategoryModal');
    const deleteButtons = document.querySelectorAll('.open-delete-category-modal');
    const cancelBtn = document.getElementById('cancelDeleteCategory');
    const deleteCategoryName = document.getElementById('deleteCategoryName');
    const deleteCategoryForm = document.getElementById('deleteCategoryForm');

    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const categoryName = this.getAttribute('data-category-name');
            const categoryId = this.getAttribute('data-category-id');
            deleteCategoryName.textContent = categoryName;
            deleteCategoryForm.action = `/admin/categories/${categoryId}`;
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
