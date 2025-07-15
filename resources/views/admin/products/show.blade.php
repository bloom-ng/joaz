@extends('layouts.admin-layout')

@section('content')
<div class="w-full ">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Product Details</h1>
            <p class="text-gray-600 mt-1">View complete product information</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border-2 border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Products
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-3">{{ $product->name }}</h2>
            <p class="text-gray-600 mb-4 text-lg">{{ $product->description }}</p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 text-center">
                    <div class="text-blue-600 font-semibold text-lg">${{ number_format($product->price_usd, 2) }}</div>
                    <div class="text-blue-700 text-sm">USD Price</div>
                </div>
                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4 text-center">
                    <div class="text-green-600 font-semibold text-lg">₦{{ number_format($product->price_ngn, 2) }}</div>
                    <div class="text-green-700 text-sm">NGN Price</div>
                </div>
                @if($product->sale_price)
                    <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4 text-center">
                        <div class="text-yellow-600 font-semibold text-lg">₦{{ number_format($product->sale_price, 2) }}</div>
                        <div class="text-yellow-700 text-sm">Sale Price</div>
                    </div>
                @endif
                <div class="bg-purple-50 border-2 border-purple-200 rounded-lg p-4 text-center">
                    <div class="text-purple-600 font-semibold text-lg">{{ $product->quantity }}</div>
                    <div class="text-purple-700 text-sm">Quantity</div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-gray-50 border-2 border-gray-200 rounded-lg p-4 text-center">
                    <div class="text-gray-600 font-semibold text-lg">{{ $product->category?->name ?? 'No Category' }}</div>
                    <div class="text-gray-700 text-sm">Category</div>
                </div>
                <!-- Removed is_active status display -->
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Product Images
            </h3>
            @if($product->images->count() > 0)
                <div class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2">
                    @foreach($product->images as $image)
                        <div class="relative group">
                                                            <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-16 object-cover rounded border-2 border-gray-200" alt="Product Image">
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm">No images available</p>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-6 py-3 border-2 border-yellow-600 text-sm font-medium rounded-lg text-yellow-600 bg-white hover:bg-yellow-50 hover:border-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Product
            </a>
        </div>
    </div>

</div>
@endsection
