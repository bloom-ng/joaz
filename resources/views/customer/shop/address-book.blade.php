






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    
    <title>Cart - JOAZ</title>
</head>
<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        <div class="flex font-bricolage font-semibold px-16 pt-12 text-[#212121]/60 flex-row text-xl gap-10">
            <h1>ACCOUNT</h1>
            <div class="pb-[1.5px] bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                <h1 class="text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">ADDRESS BOOK</h1>
            </div>
            <h1>MY CART</h1>
            <h1>MY ORDERS</h1>
        </div>

        <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">ADDRESS DETAILS</div>

        <div class="flex flex-row justify-center gap-8 pb-40 px-16">
            <!-- Address Card 1 -->
            <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-full lg:w-1/2 rounded-2xl p-6 gap-5">
                <div class="flex justify-between items-center pb-4">
                    <h2 class="font-bold text-lg">Address 1 <span class="text-base text-[#212121]">( default address )</span></h2>
                    <button class="font-semibold text-lg font-bricolage border-b-[1px] border-[#212121]">EDIT</button>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] text-lg font-bold">Address</span>
                    <span class="text-right">House 304, Fancy global estate.</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">City</span>
                    <span class="">Abuja, Nigeria</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">Name</span>
                    <span class="">Shantel Glory</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between pb-3 items-center">
                    <span class="text-[#212121] font-bold">Phone number</span>
                    <span class="">0203-241-3120</span>
                </div>
            </div>

            <!-- Address Card 2 -->
            <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-full lg:w-1/2 rounded-2xl p-6 gap-5">
                <div class="flex justify-between items-center pb-4">
                    <h2 class="font-bold text-lg">Address 1 <span class="text-base text-[#212121]">( default address )</span></h2>
                    <button class="font-semibold text-lg font-bricolage border-b-[1px] border-[#212121]">EDIT</button>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] text-lg font-bold">Address</span>
                    <span class="text-right">House 304, Fancy global estate.</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">City</span>
                    <span class="">Abuja, Nigeria</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">Name</span>
                    <span class="">Shantel Glory</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-[0.5px] -mx-6">

                <div class="flex justify-between pb-3 items-center">
                    <span class="text-[#212121] font-bold">Phone number</span>
                    <span class="">0203-241-3120</span>
                </div>
            </div>
        </div>

        
        @include('components.footer')
    </div>
</body>
</html>

