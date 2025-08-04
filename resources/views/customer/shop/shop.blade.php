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
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
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
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="flex bg-[#FCFCFC] flex-col">
        <!-- Header Section -->
        <div class="flex flex-row text-[#212121] items-center font-bricolage px-16 py-8 justify-between">
            <div>
                <img class="w-12 h-12" src="/images/logo.png" alt="">
            </div>
            <div class="flex flex-row items-center gap-11 text-md font-semibold">
                @auth
                    <div>
                        <img class="h-4" src="/images/profile.png" alt="">
                    </div>
                @endauth
                <div>
                    <a href="">HOME</a>
                </div>
                <div>
                    <a href="">SHOP</a>
                </div>
                <div>
                    <a href="">LEARN</a>
                </div>
                <div>
                    <a href="">CONTACT US</a>
                </div>
                <div>
                    <img class="h-5" src="/images/cart.png" alt="">
                </div>
                @guest
                    <a href="/signin">
                        <div style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="text-[#FCFCFC] px-10 py-3 rounded-lg">
                            LOGIN
                        </div>
                    </a>
                @endguest


            </div>
        </div>

        <!-- Main Product Display Section -->
        <main class="flex flex-row w-full px-16 py-12">
            <!-- Left Column - Product Image -->
            <div class="w-1/2 pr-8">
                <div class="w-full h-full bg-gray-800 rounded-l-2xl overflow-hidden">
                    <img src="/images/product-main.png" alt="French Curls Braids" class="w-full h-full object-cover object-bottom">
                </div>
            </div>

            <!-- Right Column - Product Details -->
            <div class="w-1/2 pl-5">
                <div class="flex flex-col py-10 pr-4 gap-6">
                    <!-- Product Title -->
                    <h1 class="text-4xl font-rustler">FRENCH CURLS BRAIDS</h1>
                    
                    <!-- Availability and Ratings -->
                    <div class="flex flex-row items-center font-bricolage justify-between">
                        <div class="flex flex-row items-center gap-2">
                            <span class="text-sm font-medium">In stock</span>
                            <div class="w-3 h-3 bg-[#85BB3F] rounded-xl"></div>
                            <span class="text-sm font-medium">50 available</span>
                        </div>
                        <div class="flex flex-row items-center gap-2">
                            <span class="text-sm font-medium">150 ratings</span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col gap-2">
                        <h3 class="text-4xl pt-2 font-light font-rustler leading-[20px]">DESCRIPTION</h3>
                        <p class="text-md font-normal font-bricolage leading-[18px] pr-16">
                            Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks?
                        </p>
                    </div>

                    <!-- Color -->
                    <div class="flex flex-col items-start">
                        <h3 class="text-4xl font-light font-rustler">COLOR</h3>
                        <div class="flex flex-row items-center justify-center">
                            <span class="text-base font-bricolage">Metallic Grey, 037</span>
                            <img class="pl-5 w-7 h-1.5" src="/images/dropdown.png" alt="">
                        </div>
                        
                    </div>

                    <!-- Length -->
                    <div class="flex flex-col items-start">
                        <h3 class="text-4xl pt-2 font-light font-rustler">LENGTH</h3>
                        <div class="flex flex-row items-center justify-center">
                            <span class="text-base font-bricolage">12" 28 inches</span>
                            <img class="pl-5 w-7 h-1.5" src="/images/dropdown.png" alt="">
                        </div>
                    </div>

                    <!-- Suitable For -->
                    <div class="flex flex-col items-start">
                        <h3 class="text-4xl pt-2 font-light font-rustler">SUITABLE FOR</h3>
                        <div class="flex flex-row items-center justify-center">
                            <span class="text-base font-bricolage">Knotless Braids</span>
                        </div>
                    </div>
                    

                    <div class="flex pt-8 flex-row justify-between">
                        <!-- Add to Cart Button -->
                        <button class="px-16 py-4 text-white font-semibold rounded-lg text-base" 
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);">
                            ADD TO CART
                        </button>
                        <!-- Quantity Selector -->
                        <div class="flex flex-row items-center justify-center">
                            <button class="w-10 h-10 bg-[#E7E4E1] text-[#212121] rounded-sm flex flex-row items-center justify-center font-bold text-xl">-</button>
                            <span class="w-10 h-10  text-[#FCFCFC] flex flex-row items-center justify-center bg-[#85BB3F] text-center font-semibold">1</span>
                            <button class="w-10 h-10 bg-[#E7E4E1] text-[#212121] rounded-sm flex flex-row items-center justify-center font-bold text-xl">+</button>
                        </div>
                    </div>
                    

                    
                </div>
            </div>
        </main>

        <!-- Reviews Section -->
        <section class="py-12 bg-[#FCFCFC]">
            <div class="flex flex-col items-center">
                <h2 class="text-3xl font-rustler pb-8">REVIEWS</h2>
                
                <!-- Customer Image Gallery -->
                                                <div class="w-full overflow-hidden relative mb-8">
                    <div class="flex w-max animate-scroll hover:pause">
                                            <!-- Original Images -->
                        <div class="flex flex-row gap-4 pr-4">
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_60.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_60.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                            </div>
                        </div>

                        <!-- Duplicated Images for seamless loop -->
                        <div class="flex flex-row gap-4 pr-4">
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_60.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_60.png" alt="">
                            </div>
                            <div class="w-[370px] flex-shrink-0 aspect-[370/320]">
                                <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                <!-- Individual Reviews -->
                <div class="flex flex-col bg-[#FCFCFC] gap-8 w-full px-16">

                    <h1 class="text-2xl font-semibold font-bricolage text-[#212121]">Top Reviews</h1>

                    <!-- Review 1 -->
                    <div class="flex flex-col gap-4 py-6 bg-[#FCFCFC] rounded-lg">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-row gap-2">
                                <div>
                                    <img class="w-16 h-16 rounded-full" src="/images/pfp.png" alt="">
                                </div>
                                <div class="flex flex-col -mt-2 justify-center text-lg font-semibold">
                                    <p>Jane Hopper</p>
                                    <div class="flex flex-row gap-1">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star-outline.png" alt="Star">
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col -mt-2">
                                <p class="font-semibold font-bricolage">Date posted</p>
                                <p>31/05/2025</p>
                            </div>
                        </div>
                        <p>Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks?</p>
                        <div class="flex flex-row gap-2.5 justify-end">
                            <div class="flex flex-row gap-2">
                                <div>
                                    <img class="w-6 h-6" src="/images/thumbs-down.png" alt="">
                                </div>
                                <div>
                                    <img class="w-6 h-6" src="/images/thumbs-up.png" alt="">
                                </div>
                            </div>
                            <p class="font-bricolage">Was this review helpful?</p>
                        </div>
                    </div>

                    <div class="flex flex-col ">
                        <hr>
                    </div>

                    <!-- Review 2 -->
                    <div class="flex flex-col gap-4 py-6 bg-[#FCFCFC] rounded-lg">
                        <div class="flex flex-row items-center justify-between">
                            <div class="flex flex-row gap-2">
                                <div>
                                    <img class="w-16 h-16 rounded-full" src="/images/pfp.png" alt="">
                                </div>
                                <div class="flex flex-col -mt-2 justify-center text-lg font-semibold">
                                    <p>Jane Hopper</p>
                                    <div class="flex flex-row gap-1">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star.png" alt="Star">
                                        <img class="w-4 h-4" src="/images/star-outline.png" alt="Star">
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col -mt-2">
                                <p class="font-semibold font-bricolage">Date posted</p>
                                <p>31/05/2025</p>
                            </div>
                        </div>
                        <p>Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks? Here's how: Shiny french curls extension after 3 weeks?</p>
                        <div class="w-[200px] aspect-[370/320]">
                            <img class="w-full h-full object-cover" src="/images/frame_59.png" alt="">
                        </div>
                        <div class="flex flex-row gap-2.5 justify-end">
                            <div class="flex flex-row gap-2">
                                <div>
                                    <img class="w-6 h-6" src="/images/thumbs-down.png" alt="">
                                </div>
                                <div>
                                    <img class="w-6 h-6" src="/images/thumbs-up.png" alt="">
                                </div>
                            </div>
                            <p class="font-bricolage">Was this review helpful?</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Customers Also View Section -->
        <section class="px-16 py-12">
            <div class="flex flex-col items-center">
                <h2 class="text-3xl font-rustler pb-8">CUSTOMERS ALSO VIEW</h2>
                
                <!-- Product Grid -->
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
        </section>

        <!-- Subscribe Section -->
        <div class="bg-[#212121] flex flex-col justify-center items-center">
            <div class="flex flex-row w-full h-[85vh] p-16 justify-center items-center">
                <div class="w-1/2 h-full">
                    <img src="/images/models2.png" alt="" class="w-full h-full object-cover">
                </div>
                <div class="flex -ml-[1%] flex-col items-center justify-center h-full w-1/2 bg-[#FCFCFC] px-16">
                    <div class="flex flex-col gap-2 w-full max-w-md justify-center items-center">
                        <div><img class="w-12 h-14" src="/images/logo-2.png" alt=""></div>
                        <h1 class="text-3xl font-meduim text-center font-rustler">MAINTAIN YOUR HAIR EXTENSIONS</h1>
                        <p class="text-black font-bricolage pb-5 text-center px-2 leading-5">
                            Learn how to maintain your hair extensions by subscribing to our newsletter.
                        </p>
                        <div class="flex flex-col gap-4 w-full justify-center">
                            <form class="flex flex-col gap-4 w-full" action="">
                                <div class="flex flex-col pb-5 gap-4 w-full">
                                    <input 
                                        type="email" 
                                        name="email" 
                                        class="bg-[#FCFCFC] w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] py-2.5 p-3"
                                        placeholder="Email address"
                                    >
                                </div>
                                <div class="flex flex-row justify-center pt-2 items-center">
                                    <button 
                                        type="submit" 
                                        class="w-full text-md py-3 text-white rounded-lg" 
                                        style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                                    >
                                        SUBSCRIBE
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="flex flex-col px-16 py-10 bg-[#FCFCFC]">
            <div class="flex flex-row justify-between items-center">
                <div class="flex flex-col font-bricolage">
                    <img class="w-12 h-14" src="/images/logo.png" alt="">
                    <p class="leading-5 pt-2 text-[16px] font-semibold">SHOP NO BPF14,FIRST FLOOR.OLD <br> BANEX PLAZA
                        WUSE 2, Abuja, Nigeria</p>
                </div>
                <div class="flex flex-row gap-4">
                    <img class="w-4 h-4" src="/images/instagram.png" alt="">
                    <img class="w-4 h-4" src="/images/tiktok.png" alt="">
                </div>
                <div class="flex flex-row gap-36 justify-between items-center">
                    <div class="flex flex-row text-[20px] font-semibold font-bricolage gap-10">
                        <p>HOME</p>
                        <p>SHOP</p>
                        <p>LEARN</p>
                        <p>CONTACT US</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-[#212121] px-16 py-12 flex flex-row justify-center items-center">
            <div>
                <p class="text-[#FCFCFC] font-bricolage">JOAZ HAIR EXTENSION © 2025</p>
            </div>
        </div>
    </div>
</body>
</html> 