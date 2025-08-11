@extends('layouts.customer')

@section('title')
    {{ $category->name }} - Joaz
@endsection

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-rustler text-gray-800">{{ strtoupper($category->name) }}</h1>
        <p class="text-lg text-gray-600 mt-2 font-bricolage">{{ $category->description }}</p>
    </div>

    @if($products->isEmpty())
        <div class="text-center py-16">
            <p class="text-xl text-gray-500">There are no products in this category yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <div class="flex text-left flex-col gap-2 group">
                    <div class="overflow-hidden rounded-lg">
                        <a href="{{ route('shop.productDetails', $product->id) }}">
                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image_path) : '/images/product-placeholder.png' }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-300">
                        </a>
                    </div>
                    <h2 class="text-lg leading-tight pt-2 font-bricolage font-semibold">{{ $product->name }}</h2>
                    <div class="flex flex-row justify-between items-center mt-auto">
                        <p class="flex flex-row gap-1 items-center text-md font-bricolage font-bold">
                            <img class="w-4 h-4" src="/images/naira.png" alt="">{{ number_format($product->price_ngn, 2) }}
                        </p>
                        <a href="{{ route('shop.productDetails', $product->id) }}" class="text-md font-semibold font-bricolage border-b-2 border-transparent group-hover:border-[#212121] transition-colors duration-300">SHOP</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
