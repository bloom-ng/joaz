@extends('layouts.admin-layout')

@section('content')
<div class="w-full ">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Category</h1>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $category->name) }}"
                    class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter category name">
                @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="parent_category_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Category</label>
                <select id="parent_category_id" name="parent_category_id" class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">None (Top-level)</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @if(old('parent_category_id', $category->parent_category_id) == $cat->id) selected @endif>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('parent_category_id') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">Cancel</a>
                <button type="submit" class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 hover:border-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-sm">Update Category</button>
            </div>
        </form>
    </div>
</div>
@endsection
