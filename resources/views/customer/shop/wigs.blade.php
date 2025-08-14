<html>
    <head>
        <title>Joaz Hair</title>

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
            @font-face {
            font-family: 'RustlerBarter';
            src: url('/fonts/RustlerBarter.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
            }
        </style>

        <!-- Load Bricolage Grotesque from Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap" rel="stylesheet">
    </head>

    <body class="bg-[#FCFCFC] text-[#212121]">
        <div class="flex flex-col">
            @include('components.header')
            <div class="text-center flex flex-col">
                <h1 class="text-[110px] font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                    SHOP NOW
                </h1>
                <div class="flex flex-row justify-center px-16">
                    <img src="/images/wigs_shop.png" alt="">
                </div>
            </div>
            <div class="flex flex-row justify-center pt-16 gap-20">
                @foreach($parentCategories as $parentCategory)
                    <div class="flex flex-col justify-center items-center gap-2">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)] text-[#fff] text-4xl font-rustler font-light">
                            {{ ucfirst(substr($parentCategory->name, 0, 1)) }}
                        </div>
                        <p class="text-3xl z-20 font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">{{ $parentCategory->name }}</p>
                    </div>
                @endforeach
            </div>

            <form action="" method="GET" class="flex flex-row items-start justify-center pt-16 gap-20">
                <div class="rounded-3xl flex flex-row items-center gap-2 border border-[1px] px-4 border-[#212121] py-2 w-[45vw]">
                    <div>
                        <img class="w-4 h-4" src="/images/search.png" alt="">
                    </div>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search in {{ $selectedCategory ? $selectedCategory->name : 'all categories' }}"
                        class="w-full placeholder:text-sm placeholder:font-bricolage"
                    >
                    @if(request('search'))
                        <a href="{{ $selectedCategory ? route('shop.category', ['category' => $selectedCategory->slug]) : route('shop.index') }}" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            <div class="text-center flex flex-col pt-16 pb-10 px-16">
                <div class="flex flex-row justify-between items-center">
                    <div class="relative">
                        <div class="flex flex-row items-center gap-3 cursor-pointer" onclick="toggleDropdown()">
                            <h1 class="text-2xl font-bold font-bricolage" id="selected-category">
                                {{ $selectedCategory ? $selectedCategory->name : 'SELECT CATEGORY' }}
                            </h1>
                            <img class="w-3 h-2 transition-transform duration-200" id="dropdown-arrow" src="/images/dropdown.png" alt="">
                        </div>
                        <div class="absolute top-full left-0 mt-2 bg-white border border-[#212121]/20 rounded-lg shadow-lg z-50 hidden" id="dropdown-menu">
                            <div class="py-2">
                                @foreach($parentCategories as $parent)
                                    <a href=""
                                       class="block px-4 py-2 hover:bg-gray-50 cursor-pointer font-bricolage {{ $selectedCategory && $selectedCategory->id === $parent->id ? 'bg-gray-100' : '' }}">
                                        {{ $parent->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if($selectedCategory && $selectedCategory->children->isNotEmpty())
                        <div class="flex flex-row text-xl font-bricolage items-center gap-4" id="child-categories">
                            <a href=""
                               class="{{ !request('subcategory') ? 'text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]' : '' }}">
                                All
                            </a>
                            @foreach($selectedCategory->children as $child)
                                <a href=""
                                   class="{{ request('subcategory') === $child->slug ? 'text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]' : '' }}">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
                @if($products && $products->count() > 0)
                <div class="grid grid-cols-3 justify-center gap-4 pt-10">
                    @foreach($products as $product)
                        @php
                            $mainImage = $product->images->first()->image ?? null;
                            $imageUrl = $mainImage ? asset('storage/' . $mainImage) : '/images/placeholder-product.png';
                        @endphp
                        <div class="flex text-left flex-col gap-2">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                            <h1 class="text-md leading-[2px] pt-2 font-bricolage">{{ strtoupper($product->name) }}</h1>
                            <div class="flex flex-row justify-between">
                                <p class="flex flex-row gap-1 items-center text-md font-bricolage">
                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                    {{ number_format($product->price_ngn, 2) }}
                                </p>
                                <a href="{{ route('shop.productDetails', $product->id) }}" class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] hover:border-transparent">
                                    SHOP
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <p class="text-xl font-bricolage">No products found in this category.</p>
                </div>
            @endif
            </div>


            @if(isset($bestSellers) && $bestSellers->isNotEmpty())
            <div class="text-center flex flex-col pt-16 pb-10 px-16">
                <h1 class="font-rustler text-4xl">BEST SELLER</h1>
                <p class="text-2xl font-bricolage py-6">Slay effortlessly when you Shop from our best seller collection</p>
                <div class="flex flex-row justify-center gap-4">
                    @foreach($bestSellers as $product)
                    <div class="flex text-left flex-col gap-2 flex-1 max-w-[300px]">
                        <a href="{{ route('shop.productDetails', $product->id) }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400">No image</span>
                                </div>
                            @endif
                        </a>
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">{{ strtoupper($product->name) }}</h1>
                        <div class="flex flex-row justify-between items-center">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage">
                                <img class="w-4 h-4" src="{{ asset('images/naira.png') }}" alt="">
                                {{ number_format($product->price_ngn, 2) }}
                            </p>
                            <a href="{{ route('shop.productDetails', $product->id) }}"
                               class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] hover:text-green-600 transition-colors">
                                SHOP
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- <div class="flex flex-row gap-10 justify-center items-center w-full h-[90vh] bg-[url('/images/reviews-bg.png')] bg-cover bg-center">
                <div class="flex flex-col p-1.5 rounded-full bg-[#FCFCFC]/70">
                    <img class="w-10 h-10 z-10" src="/images/navigate-before.png" alt="">
                </div>
                <div class="flex flex-col w-[40vw] bg-[#FCFCFC] p-8 rounded-md items-center justify-center">
                    <h1 class="text-3xl font-rustler pb-8">CUSTOMER REVIEWS</h1>
                    <img class="w-10 h-10 rounded-full" src="/images/pfp.png" alt="Profile Picture">
                    <p class="font-semibold py-1">JANE COOPER</p>
                    <div class="flex flex-row gap-2">
                        <img class="w-4 h-4" src="/images/star.png" alt="">
                        <img class="w-4 h-4" src="/images/star.png" alt="">
                        <img class="w-4 h-4" src="/images/star.png" alt="">
                        <img class="w-4 h-4" src="/images/star.png" alt="">
                        <img class="w-4 h-4" src="/images/star-outline.png" alt="">
                    </div>
                    <p class="text-md font-bricolage pt-3 px-8 text-center">“ I really loved the extensions, it doesn’t tangle and it’s so easy to use.”</p>
                </div>
                <div class="flex flex-col p-1.5 rounded-full bg-[#FCFCFC]/70">
                    <img class="w-10 h-10 z-10" src="/images/navigate-next.png" alt="">
                </div>
            </div> -->

            {{-- <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">FRENCH CURL BRAIDS</h1>
                <p class="text-xl w-[45vw] font-bricolage text-center">French Curl Hair is soft, lightweight, and easy to maintain, giving you a classy, bouncy look perfect for knotless or boho braids.</p>
                <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] pt-5">LEARN HAIR TIPS</p>
            </div> --}}

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
                                    <p class="flex flex-row gap-1 items-center text-md font-bricolage">
                                        <img class="w-4 h-4" src="/images/naira.png" alt="">{{ number_format($relatedProduct->price_ngn, 2) }}
                                    </p>
                                    <a href="{{ route('shop.productDetails', $relatedProduct->id) }}" class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($product->category)
                    <div class="flex flex-row justify-center pt-10 items-center gap-2">
                        <a href="{{ route('shop.categories') }}" class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">VIEW ALL IN {{ strtoupper($product->category->name) }}</a>
                    </div>
                    @endif
                </div>
            </section>
            @endif

            @if(isset($bestSellers) && $bestSellers->isNotEmpty())
            <div class="text-center flex flex-col pt-16 pb-10 px-16">
                <h1 class="font-rustler text-4xl">BEST SELLER</h1>
                <p class="text-2xl font-bricolage py-6">Slay effortlessly when you Shop from our best seller collection</p>
                <div class="flex flex-row justify-center gap-4">
                    @foreach($bestSellers as $product)
                    <div class="flex text-left flex-col gap-2 flex-1 max-w-[300px]">
                        <a href="{{ route('shop.productDetails', $product->id) }}">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-100 flex items-center justify-center">
                                    <span class="text-gray-400">No image</span>
                                </div>
                            @endif
                        </a>
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">{{ strtoupper($product->name) }}</h1>
                        <div class="flex flex-row justify-between items-center">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage">
                                <img class="w-4 h-4" src="{{ asset('images/naira.png') }}" alt="">
                                {{ number_format($product->price_ngn, 2) }}
                            </p>
                            <a href="{{ route('shop.productDetails', $product->id) }}"
                               class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] hover:text-green-600 transition-colors">
                                SHOP
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @include('components.subscribe')

            @include('components.footer')
        </div>
    </body>
</html>


<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');

        if (dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.remove('hidden');
            dropdownArrow.style.transform = 'rotate(180deg)';
        } else {
            dropdownMenu.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.relative');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');
        const target = event.target;

        // Check if click is outside the dropdown menu and not on a child category link
        if (!dropdown.contains(target) && !target.closest('#child-categories')) {
            dropdownMenu.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });
</script>
