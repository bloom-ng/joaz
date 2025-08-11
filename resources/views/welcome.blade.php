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
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="flex flex-col">
        @include('components.header')
        <div class="text-center flex flex-col">
            <h1
                class="text-[110px] font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                JOAZ HAIR EXTENSION
            </h1>
            <div class="flex flex-row justify-center px-16">
                <img src="/images/models.png" alt="">
            </div>
        </div>
        <div class="text-center flex flex-col pt-16 pb-10 px-16">
            <h1 class="font-rustler text-4xl">BEST SELLER</h1>
            <p class="text-2xl font-bricolage py-6">Slay effortlessly when you Shop from our best seller collection</p>
            <div class="flex flex-row justify-center gap-4">
                @forelse($mostOrderedProducts as $product)
                    <div class="flex text-left flex-col gap-2 w-1/4">
                        @if ($product->images->isNotEmpty())
                            <img src="{{ asset("storage/" . $product->images->first()->image) }}"
                                alt="{{ $product->name }}" class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                <span>No Image</span>
                            </div>
                        @endif
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">{{ $product->name }}</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage">
                                <img class="w-4 h-4" src="{{ asset("images/naira.png") }}" alt="">
                                {{ number_format($product->price_ngn) }}
                            </p>
                            <a href="{{ route('shop.productDetails', $product->id) }}"
                                class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] hover:text-[#85BB3F] transition-colors">
                                SHOP
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-8">No products found.</p>
                @endforelse
            </div>
        </div>
        <div
        class="flex flex-row gap-10 justify-center items-center w-full h-[90vh] bg-[url('/images/reviews-bg.png')] bg-cover bg-center"
        id="review-section"
    >
        <!-- Prev Button -->
        <div class="flex flex-col p-1.5 rounded-full bg-[#FCFCFC]/70 cursor-pointer" onclick="changeReview(-1)">
            <img class="w-10 h-10 z-10" src="/images/navigate-before.png" alt="Previous">
        </div>

        <!-- Review Content -->
        <div class="flex flex-col w-[40vw] bg-[#FCFCFC]/65 p-8 rounded-md items-center justify-center text-center">
            <h1 class="text-3xl font-rustler pb-8">CUSTOMER REVIEWS</h1>
            <img id="review-img" class="w-10 h-10 rounded-full" src="/images/pfp.png" alt="Profile Picture">
            <p id="review-name" class="font-semibold py-1">JANE COOPER</p>
            <div id="review-stars" class="flex flex-row gap-2">
                <!-- Stars will be rendered here -->
            </div>
            <p id="review-text" class="text-md font-bricolage pt-3 px-8 text-center">
                “ I really loved the extensions, it doesn’t tangle and it’s so easy to use.”
            </p>
        </div>

        <!-- Next Button -->
        <div class="flex flex-col p-1.5 rounded-full bg-[#FCFCFC]/70 cursor-pointer" onclick="changeReview(1)">
            <img class="w-10 h-10 z-10" src="/images/navigate-next.png" alt="Next">
        </div>
    </div>

            <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">FRENCH CURL BRAIDS</h1>
                <p class="text-xl w-[45vw] font-bricolage text-center">French Curl Hair is soft, lightweight, and easy to
                    maintain, giving you a classy, bouncy look perfect for knotless or boho braids.</p>
                <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] pt-5">LEARN HAIR TIPS</p>
            </div>

            <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">OUR COLLECTION</h1>
                <div class="flex flex-row justify-center gap-4">
                    @foreach($randomCategoryProducts as $product)
                        <div class="flex text-left flex-col gap-2">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset("storage/" . $product->images->first()->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                    <span>No Image</span>
                                </div>
                            @endif
                            <h1 class="text-md leading-[2px] pt-2 font-bricolage">{{ strtoupper($product->name) }}</h1>
                            <p class="text-md font-bricolage">{{ $product->description ?: 'Premium quality product' }}</p>
                            <div class="-mt-3 flex flex-row justify-between">
                                <p class="flex flex-row gap-1 items-center text-md font-bricolage">
                                    <img class="w-4 h-4" src="{{ asset('images/naira.png') }}" alt="">
                                    {{ number_format($product->price_ngn) }}
                                </p>
                                                                <a href="{{ route('shop.productDetails', $product->id) }}" class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] hover:text-gray-600">
                                    SHOP
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-row justify-center pt-10 items-center gap-2">
                    <h1 class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">VIEW ALL</h1>
                </div>
            </div>

            @include('components.subscribe')
        </div>

        @include('components.footer')
    </div>
</body>

</html>
<script>
    const reviews = [
        {
            name: 'JANE COOPER',
            image: '/images/pfp.png',
            rating: 4,
            text: '“ I really loved the extensions, it doesn’t tangle and it’s so easy to use.”'
        },
        {
            name: 'JOHN DOE',
            image: '/images/pfp.png',
            rating: 5,
            text: '“ Amazing product! Soft texture and long-lasting quality. Highly recommend.”'
        },
        {
            name: 'SARAH K.',
            image: '/images/pfp.png',
            rating: 3,
            text: '“ Decent quality for the price. Delivery was also fast and smooth.”'
        }
    ];

    let currentReviewIndex = 0;

    function renderReview() {
        const review = reviews[currentReviewIndex];
        document.getElementById('review-name').textContent = review.name;
        document.getElementById('review-img').src = review.image;
        document.getElementById('review-text').textContent = review.text;

        const starsContainer = document.getElementById('review-stars');
        starsContainer.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
            const star = document.createElement('img');
            star.src = i <= review.rating ? '/images/star.png' : '/images/star-outline.png';
            star.className = 'w-4 h-4';
            starsContainer.appendChild(star);
        }
    }

    function changeReview(direction) {
        currentReviewIndex = (currentReviewIndex + direction + reviews.length) % reviews.length;
        renderReview();
    }

    // Load first review on page load
    renderReview();
</script>
