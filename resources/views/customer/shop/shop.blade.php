<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Joaz Hair</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Combine both fonts in ONE config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        rustler: ['RustlerBarter', 'sans-serif'],
                        bricolage: ['"Bricolage Grotesque"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- Load RustlerBarter font from public/fonts -->
    <style>
        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .animate-scroll {
            animation: scroll 40s linear infinite;
        }

        .hover\:pause:hover {
            animation-play-state: paused;
        }

        @font-face {
            font-family: 'RustlerBarter';
            src: url('/fonts/RustlerBarter.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <!-- Load Bricolage Grotesque from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="flex bg-[#FCFCFC] flex-col">
        <!-- Header Section -->
        @include('components.header')
        @include('components.cart-notification')

        <!-- Main Product Display Section -->
        <main class="flex flex-row w-full px-16 py-12">
            <!-- Left Column - Product Image -->
            <div class="w-1/2 pr-8">
                @if ($product->images->isNotEmpty())
                    <div class="w-full h-full bg-gray-800 rounded-l-2xl overflow-hidden">
                        <img src="{{ asset("storage/" . $product->images->first()->image) }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover object-bottom">
                    </div>
                @else
                    <div class="w-full h-full bg-gray-200 rounded-l-2xl overflow-hidden">
                        <div class="flex items-center justify-center h-full">
                            <span class="text-center">No Image</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Product Details -->
            <div class="w-1/2 pl-5">
                <div class="flex flex-col py-10 pr-4 gap-6">
                    <!-- Product Title -->
                    <h1 class="text-4xl font-rustler">{{ $product->name }}</h1>

                    <!-- Availability and Ratings -->
                    <div class="flex flex-row items-center font-bricolage justify-between">
                        <div class="flex flex-row items-center gap-2">
                            <span class="text-sm font-medium">In stock</span>
                            <div class="w-3 h-3 bg-[#85BB3F] rounded-xl"></div>
                            <span class="text-sm font-medium">{{ $product->quantity }} available</span>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <span class="text-sm font-medium">{{ $product->reviews->count() }} ratings</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col gap-2">
                        <h3 class="text-4xl pt-2 font-light font-rustler leading-[20px]">DESCRIPTION</h3>
                        <p class="text-md font-normal font-bricolage leading-[18px] pr-16">
                            {{ $product->description }}
                        </p>
                    </div>

                    <!-- Color -->
                    <div class="flex flex-col items-start">
                        <h3 class="text-4xl font-light font-rustler">COLOR</h3>
                        <div class="flex flex-row items-center justify-center">
                            @if (count($product->variants) > 0)
                                @if (count($product->variants) > 1)
                                    <select name="variant" id="variant" class="text-base font-bricolage">
                                        @foreach ($product->variants as $variant)
                                            <option value="{{ $variant->id }}" {{ $variant->id == $product->variants->first()->id ? 'selected' : '' }}>
                                                {{ $variant->color }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-base font-bricolage">{{ $product->variants->first()->color }}</span>
                                @endif
                            @else
                                <span class="text-base font-bricolage"></span>
                            @endif
                        </div>

                        <h3 class="text-4xl font-light font-rustler mt-4">Length</h3>
                        <div class="flex flex-row items-center justify-center">
                            @if (count($product->variants) > 0)
                                @if (count($product->variants) > 1)
                                    <select name="variant" id="variant" class="text-base font-bricolage">
                                        @foreach ($product->variants as $variant)
                                            <option value="{{ $variant->id }}" {{ $variant->id == $product->variants->first()->id ? 'selected' : '' }}>
                                                {{ $variant->length }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-base font-bricolage">{{ $product->variants->first()->length }}</span>
                                @endif
                            @else
                                <span class="text-base font-bricolage"></span>
                            @endif
                        </div>

                    </div>

                    <!-- Price -->
                    <div class="flex flex-col items-start">
                        <h3 class="text-4xl pt-2 font-light font-rustler">PRICE</h3>
                        <div class="flex flex-row items-center justify-center">
                            <span class="text-4xl font-semibold font-bricolage leading-[1.2]" id="product-price">
                                <!-- Price will be dynamically inserted here by JS -->
                            </span>
                        </div>
                    </div>

                    <!-- Add to Cart and Quantity Section -->
                    <div class="pt-8">


                        <form action="{{ route('cart.add') }}" method="POST" class="flex flex-row gap-4 w-full">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="form-quantity" value="1">
                            @if($product->variants->isNotEmpty())
                                <input type="hidden" name="variant_id" id="form-variant-id" value="{{ $product->variants->first()->id }}">
                            @endif

                            <button type="submit" class="px-12 py-4 text-white font-semibold rounded-lg text-base whitespace-nowrap"
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);">
                                ADD TO CART
                            </button>

                            <!-- Quantity Selector -->
                            <div class="flex flex-row items-center justify-center">
                                <button type="button"
                                    class="w-10 h-10 bg-[#E7E4E1] text-[#212121] rounded-sm flex flex-row items-center justify-center font-bold text-xl"
                                    id="decrement-btn">
                                    -
                                </button>
                                <span
                                    class="w-10 h-10 text-[#FCFCFC] flex flex-row items-center justify-center bg-[#85BB3F] text-center font-semibold"
                                    id="quantity-display">1</span>
                                <button type="button"
                                    class="w-10 h-10 bg-[#E7E4E1] text-[#212121] rounded-sm flex flex-row items-center justify-center font-bold text-xl"
                                    id="increment-btn">
                                    +
                                </button>
                            </div>
                        </form>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Data from Blade
                            const variants = @json($product->variants->keyBy('id'));

                            // Detect currency preference from Blade (Nigeria or not)
                            const isNaira = @json(
                                (Auth::check() && Auth::user()->country->name == "Nigeria") ||
                                (isset($location) && $location->country == "Nigeria")
                            );

                            // Pick correct initial price
                            const initialPrice = parseFloat(isNaira
                                ? '{{ $product->variants->first()->price_ngn ?? $product->price_ngn }}'
                                : '{{ $product->variants->first()->price_usd ?? $product->price_usd }}'
                            );

                            // DOM Elements
                            const priceElement = document.getElementById('product-price');
                            const variantSelect = document.getElementById('variant');
                            const quantityDisplay = document.getElementById('quantity-display');
                            const formQuantityInput = document.getElementById('form-quantity');
                            const formVariantIdInput = document.getElementById('form-variant-id');
                            const incrementBtn = document.getElementById('increment-btn');
                            const decrementBtn = document.getElementById('decrement-btn');

                            // State
                            let currentQuantity = 1;
                            let currentPrice = initialPrice;

                            // Function to update the displayed price
                            function updatePriceDisplay() {
                                const total = currentPrice * currentQuantity;
                                if (isNaira) {
                                    priceElement.textContent = '₦' + total.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                } else {
                                    priceElement.textContent = '$' + total.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }

                            // Event Listener for variant dropdown
                            if (variantSelect) {
                                variantSelect.addEventListener('change', function() {
                                    const selectedVariantId = this.value;
                                    if (variants[selectedVariantId]) {
                                        currentPrice = parseFloat(isNaira
                                            ? variants[selectedVariantId].price_ngn
                                            : variants[selectedVariantId].price_usd
                                        );
                                        if (formVariantIdInput) {
                                            formVariantIdInput.value = selectedVariantId; // Update hidden variant ID
                                        }
                                        updatePriceDisplay();
                                    }
                                });
                            }

                            // Event Listener for increment button
                            if (incrementBtn) {
                                incrementBtn.addEventListener('click', function() {
                                    currentQuantity++;
                                    quantityDisplay.textContent = currentQuantity;
                                    formQuantityInput.value = currentQuantity;
                                    updatePriceDisplay();
                                });
                            }

                            // Event Listener for decrement button
                            if (decrementBtn) {
                                decrementBtn.addEventListener('click', function() {
                                    if (currentQuantity > 1) {
                                        currentQuantity--;
                                        quantityDisplay.textContent = currentQuantity;
                                        formQuantityInput.value = currentQuantity;
                                        updatePriceDisplay();
                                    }
                                });
                            }

                            // Initialize price on page load
                            updatePriceDisplay();
                        });
                    </script>

                </div>
            </div>
        </main>

        <!-- Reviews Section -->
        <section class="py-12 bg-[#FCFCFC]">
            <div class="flex flex-col items-center">
                <h2 class="text-3xl font-rustler pb-8">REVIEWS</h2>

                <!-- Customer Image Gallery -->
                @if($reviewImages->isNotEmpty())
                <div class="w-full overflow-hidden relative mb-8">
                    <div class="flex w-max animate-scroll hover:pause">
                        <!-- Original Images -->
                        <div class="flex flex-row gap-4 pr-4">
                            @foreach ($reviewImages as $image)
                                <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $image->image) }}" alt="Customer review image">
                                </div>
                            @endforeach
                        </div>

                        <!-- Duplicated Images for seamless loop -->
                        <div class="flex flex-row gap-4 pr-4">
                            @foreach ($reviewImages as $image)
                                <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $image->image) }}" alt="Customer review image">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Individual Reviews -->
            <div class="flex flex-col bg-[#FCFCFC] gap-8 w-full px-16">

                <h1 class="text-2xl font-semibold font-bricolage text-[#212121]">Top Reviews</h1>

                @forelse ($product->reviews as $review)
                @php
    $avatar = $review->user->profile->avatar ?? null;
    $avatarUrl = $avatar && file_exists(public_path('storage/' . $avatar))
        ? asset('storage/' . $avatar)
        : asset('images/user-icon.png');
@endphp
                    <div class="flex flex-col gap-4 py-6 bg-[#FCFCFC] rounded-lg">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-row gap-2">
                                <div>
                                    <img src="{{ $avatarUrl }}" alt="User avatar" class="w-10 h-10 rounded-full object-cover"><!-- Placeholder for user avatar -->
                                </div>
                                <div class="flex flex-col -mt-2 justify-center text-lg font-semibold">
                                    <p>{{ $review->user->name }}</p>
                                    <div class="flex flex-row gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <img class="w-4 h-4" src="{{ $i <= $review->rating ? '/images/star.png' : '/images/star-outline.png' }}" alt="Star">
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col -mt-2">
                                <p class="font-semibold font-bricolage">Date posted</p>
                                <p>{{ $review->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                        <p>{{ $review->review }}</p>
                    </div>

                    @if (!$loop->last)
                        <div class="flex flex-col ">
                            <hr>
                        </div>
                    @endif
                @empty
                    <div class="py-6">
                        <p class="text-center text-gray-500">No reviews yet. Be the first to review this product!</p>
                    </div>
                @endforelse
            </div>
            </div>
    </div>
    </section>

    <!-- Customers Also View Section -->
     @if($relatedProducts->isNotEmpty())
    <section class="px-16 py-12">
        <div class="flex flex-col items-center">
            <h2 class="text-3xl font-rustler pb-8">CUSTOMERS ALSO VIEW</h2>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($relatedProducts as $relatedProduct)
                    <div class="flex text-left flex-col gap-2">
                        <a href="{{ route('shop.productDetails', $relatedProduct->id) }}">
                            <img src="{{ $relatedProduct->images->first() ? asset('storage/' . $relatedProduct->images->first()->image) : '/images/product-placeholder.png' }}" alt="{{ $relatedProduct->name }}" class="w-full h-auto object-cover">
                        </a>
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">{{ $relatedProduct->name }}</h1>
                        <p class="text-md font-bricolage">{{ $relatedProduct->description }}</p>
                        <div class="-mt-3 flex flex-row justify-between items-center">

                            @if (Auth::check() && Auth::user()->country->name == "Nigeria")
                            <p class="flex items-center text-md font-bricolage">
                                <img class="w-4 h-4 mr-1" src="{{ asset("images/naira.png") }}"
                                    alt="">
                                {{ number_format($product->price_ngn, 2) }}
                            </p>
                        @elseif(isset($location) && $location->country == "Nigeria")
                            <p class="flex items-center text-md font-bricolage">
                                <img class="w-4 h-4 mr-1" src="{{ asset("images/naira.png") }}"
                                    alt="">
                                {{ number_format($product->price_ngn, 2) }}
                            </p>
                        @else
                            <p class="flex items-center text-md font-bricolage">
                                <img class="w-4 h-4" src="{{ asset("images/mdi_dollar.png") }}"
                                    alt="">
                                {{ number_format($product->price_usd, 2) }}
                            </p>
                        @endif
                            <a href="{{ route('shop.productDetails', $relatedProduct->id) }}" class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($product->category)
            <div class="flex flex-row justify-center pt-10 items-center gap-2">
                <a href="{{ route('shop.category') }}" class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">VIEW ALL IN {{ strtoupper($product->category->name) }}</a>
            </div>
            @endif
        </div>
    </section>
    @endif

        @include('components.subscribe')

        @include('components.footer')


    </div>
</body>

</html>
