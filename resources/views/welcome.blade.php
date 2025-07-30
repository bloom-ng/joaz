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
            <div class="flex flex-row text-[#212121] items-center font-bricolage px-16 py-8 justify-between">
                <div>
                    <img class="w-12 h-12" src="/images/logo.png" alt="">
                </div>
                <div class="flex flex-row items-center gap-11 text-md font-semibold">
                    <div>
                        <img class="h-4" src="/images/profile.png" alt="">
                    </div>
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
                </div>
            </div>
            <div class="text-center flex flex-col">
                <h1 class="text-[110px] font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
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
            <div class="flex flex-row gap-10 justify-center items-center w-full h-[90vh] bg-[url('/images/reviews-bg.png')] bg-cover bg-center">
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
            </div>

            <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">FRENCH CURL BRAIDS</h1>
                <p class="text-xl w-[45vw] font-bricolage text-center">French Curl Hair is soft, lightweight, and easy to maintain, giving you a classy, bouncy look perfect for knotless or boho braids.</p>
                <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121] pt-5">LEARN HAIR TIPS</p>
            </div>

            <div class="flex flex-col items-center justify-center px-16 py-10">
                <h1 class="text-3xl font-rustler pb-4">OUR COLLECTION</h1>
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

            <div class="bg-[#212121] flex flex-col justify-center items-center">
                <div class="flex flex-row w-full h-[85vh] p-16 justify-center items-center">
                    <div class="w-1/2 h-full">
                        <img src="/images/models2.png" alt="" class="w-full h-full object-cover">
                    </div>
                    <div class="flex -ml-1 flex-col items-center justify-center h-full w-1/2 bg-[#FCFCFC] px-16">
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

            <div class="flex flex-col px-16 py-10 bg-[#FCFCFC]">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-col font-bricolage">
                        <img class="w-12 h-14" src="/images/logo.png" alt="">
                        <p class="leading-5 pt-2 text-[16px] font-semibold">SHOP NO BPF14,FIRST FLOOR.OLD <br> BANEX PLAZA WUSE 2, Abuja, Nigeria</p>
                    </div>
                    <div class="flex flex-row gap-36 justify-between items-center">
                        <div class="flex flex-row gap-4">
                            <img class="w-4 h-4" src="/images/instagram.png" alt="">
                            <img class="w-4 h-4" src="/images/tiktok.png" alt="">
                        </div>
                        <div class="flex flex-row text-[20px] font-semibold font-bricolage gap-10">
                            <p>HOME</p>
                            <p>SHOP</p>
                            <p>LEARN</p>
                            <p>CONTACT US</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
