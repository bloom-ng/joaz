@extends('layouts.admin-layout')

@section('content')
<div class="w-full max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:space-x-8">
        <!-- Category Filter -->
        <aside class="w-full md:w-1/4 mb-6 md:mb-0">
            <div class="bg-white shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold mb-4">Categories</h2>
                <ul>
                    @foreach($categories as $category)
                        <li>
                            <a href="?category={{ $category->id }}" class="block py-2 px-3 rounded hover:bg-blue-50 {{ request('category') == $category->id ? 'bg-blue-100 font-bold' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        <!-- Product Table -->
        <main class="w-full md:w-3/4">
            <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (NGN)</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/80' }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded border border-gray-200">
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 max-w-xs truncate">{{ $product->description }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-blue-600 font-bold">₦{{ number_format($product->price_ngn, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('customer.products.show', $product) }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-12">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
