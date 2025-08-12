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
                <div class="flex flex-col justify-center items-center gap-2">
                    <img class="w-16 h-16" src="/images/wigs.png" alt="">
                    <p class="text-3xl z-20 font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">WIGS</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-2">
                    <img class="w-16 h-16" src="/images/bundles.png" alt="">
                    <p class="text-3xl font-rustler font-light text-[#212121]">BUNDLES</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-2">
                    <img class="w-16 h-16" src="/images/extension.png" alt="">
                    <p class="text-3xl font-rustler font-light text-[#212121]">EXTENSIONS</p>
                </div>
                <div class="flex flex-col justify-center items-center gap-2">
                    <img class="w-16 h-16" src="/images/frontals.png" alt="">
                    <p class="text-3xl font-rustler font-light text-[#212121]">FRONTALS</p>
                </div>
            </div>

            <form action="" class="flex flex-row items-start justify-center pt-16 gap-20">
                <div class="rounded-3xl flex flex-row items-center gap-2 border border-[1px] px-4 border-[#212121] py-2 w-[45vw]">
                    <div>
                        <img class="w-4 h-4" src="/images/search.png" alt="">
                    </div>
                    <input type="text" name="search" placeholder="Search wig" class="w-full placeholder:text-sm placeholder:font-bricolage">
                </div>
            </form>

            <div class="text-center flex flex-col pt-16 pb-10 px-16">
                <div class="flex flex-row justify-between items-center">
                    <div class="relative">
                        <div class="flex flex-row items-center gap-3 cursor-pointer" onclick="toggleDropdown()">
                            <h1 class="text-2xl font-bold font-bricolage" id="selected-option">SYNTHETIC HAIR</h1>
                            <img class="w-3 h-2 transition-transform duration-200" id="dropdown-arrow" src="/images/dropdown.png" alt="">
                        </div>
                        <div class="absolute top-full left-0 mt-2 bg-white border border-[#212121]/20 rounded-lg shadow-lg z-50 hidden" id="dropdown-menu">
                            <div class="py-2">
                                <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer font-bricolage" onclick="selectOption('SYNTHETIC HAIR')">SYNTHETIC HAIR</div>
                                <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer font-bricolage" onclick="selectOption('HUMAN HAIR')">HUMAN HAIR</div>
                                <div class="px-4 py-2 hover:bg-gray-50 cursor-pointer font-bricolage" onclick="selectOption('BRANDING EXTENSION')">BRANDING EXTENSION</div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row text-xl font-bricolage items-center gap-4">
                        <p>All</p>
                        <p class="text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">Straight</p>
                        <p>Curly</p>
                        <p>Wavy</p>
                    </div>
                </div>
                <div class="grid grid-cols-3 justify-center gap-4 pt-10">
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product1.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product3.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product4.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>

                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product3.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product4.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product1.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>

                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product1.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product3.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product4.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center flex flex-col pt-16 pb-10 px-16">
                <h1 class="font-rustler text-4xl">BEST SELLER</h1>
                <p class="text-2xl font-bricolage py-6">Slay effortlessly when you Shop from our best seller collection</p>
                <div class="flex flex-row justify-center gap-4">
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product1.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product2.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product3.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">12” FRENCH CURLS BRAIDS</h1>
                        <div class="flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                </div>
            </div>
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

            <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">FRENCH CURL BRAIDS</h1>
                <p class="text-xl w-[45vw] font-bricolage text-center">French Curl Hair is soft, lightweight, and easy to maintain, giving you a classy, bouncy look perfect for knotless or boho braids.</p>
                <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] pt-5">LEARN HAIR TIPS</p>
            </div>

            <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">CUSTOMERS ALSO VIEW</h1>
                <div class="flex flex-row justify-center gap-4">
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product1.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">FRENCH CURLS BRAIDS</h1>
                        <p class="text-md font-bricolage">12” ( 4 to 5 packs recommended)</p>
                        <div class="-mt-3 flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product3.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">FRENCH CURLS BRAIDS</h1>
                        <p class="text-md font-bricolage">12” ( 4 to 5 packs recommended)</p>
                        <div class="-mt-3 flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                    <div class="flex text-left flex-col gap-2">
                        <img src="/images/product4.png" alt="">
                        <h1 class="text-md leading-[2px] pt-2 font-bricolage">FRENCH CURLS BRAIDS</h1>
                        <p class="text-md font-bricolage">12” ( 4 to 5 packs recommended)</p>
                        <div class="-mt-3 flex flex-row justify-between">
                            <p class="flex flex-row gap-1 items-center text-md font-bricolage"><img class="w-4 h-4" src="/images/naira.png" alt="">7,000/pack</p>
                           <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">SHOP</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row justify-center pt-10 items-center gap-2">
                    <h1 class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">VIEW ALL</h1>
                    <img class="w-4 h-4" src="/images/arrow-right.png" alt="">
                </div>
            </div>

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

    function selectOption(option) {
        document.getElementById('selected-option').textContent = option;
        toggleDropdown();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.relative');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');
        
        if (!dropdown.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });
</script>