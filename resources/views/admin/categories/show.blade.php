@extends('layouts.admin-layout')

@section('content')
<div class="w-full ">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Category Details</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategories</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $category->parent?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            @if($category->children->count() > 0)
                                {{ $category->children->pluck('name')->join(', ') }}
                            @else
                                None
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $category->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $category->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">Back to List</a>
            <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">Edit Category</a>
        </div>
    </div>
</div>
@endsection
