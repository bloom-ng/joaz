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

        <div class="flex font-bricolage font-semibold px-16 py-12 text-[#212121]/60 flex-row text-xl gap-10">
            <h1>ACCOUNT</h1>
            <h1>ADDRESS BOOK</h1>
            <h1 class="text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">MY CART</h1>
            <h1>MY ORDERS</h1>
        </div>

        <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">MY CART</div>

        <div class="flex flex-row items-stretch gap-4 px-16 rounded-2xl">
            <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-[70%] rounded-2xl">
                <table class="table-auto">
                    <thead class="w-full border-b-[1px] border-[#212121]/20">
                        <tr>
                            <th class="text-left px-6 py-4">Product Name</th>
                            <th class="text-left px-6 py-4">Quantity</th>
                            <th class="text-left px-6 py-4">Total</th>
                            <th class="text-left px-6 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-row gap-3 items-center">
                                    <img class="w-[120px] h-[132px] object-cover rounded-xl" src="{{ asset('images/product1.png') }}" alt="">
                                    <div class="flex flex-col gap-1">
                                        <h1 class="font-semibold">French curls braid</h1>
                                        <p>12” (12 Inches) <br> Metallic Grey, 037</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-row items-center justify-center">
                                    <button class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">-</button>
                                    <span class="w-6 h-6 text-[#FCFCFC] flex items-center justify-center bg-[#85BB3F] text-center font-semibold">1</span>
                                    <button class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">+</button>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                <span class="flex flex-row gap-1 items-center">
                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                    <p>164,000.00</p>
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <img class="w-4 h-4" src="/images/trash.png" alt="">
                            </td>
                        </tr>
                        <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-row gap-3 items-center">
                                    <img class="w-[120px] h-[132px] object-cover rounded-xl" src="{{ asset('images/product1.png') }}" alt="">
                                    <div class="flex flex-col gap-1">
                                        <h1 class="font-semibold">French curls braid</h1>
                                        <p>12” (12 Inches) <br> Metallic Grey, 037</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-row items-center justify-center">
                                    <button class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">-</button>
                                    <span class="w-6 h-6 text-[#FCFCFC] flex items-center justify-center bg-[#85BB3F] text-center font-semibold">1</span>
                                    <button class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">+</button>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                <span class="flex flex-row gap-1 items-center">
                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                    <p>164,000.00</p>
                                </span>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <img class="w-4 h-4" src="/images/trash.png" alt="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[30%] rounded-2xl">
                <div class="font-semibold flex flex-row items-start pt-7 pb-4 items-center px-4 border-b-[1px] border-[#212121]/20 justify-start">Cart Summary</div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Total Items</p>
                    <p>3</p>
                </div>
                <div class="flex flex-row font-semibold py-4 px-4 border-b-[1px] border-[#212121]/20 justify-between items-center">
                    <p>Price</p>
                    <span class="flex flex-row gap-1 items-center">
                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                        <p>164,000.00</p>
                    </span>
                </div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Delivery</p>
                    <p>Not Included</p>
                </div>
                <div class="flex flex-col justify-between gap-4 p-4 pb-7 mt-auto">
                    <p class="text-xs pb-8">*Please confirm your order to add your delivery/pickup details.</p>
                    <div class="flex pb-5 flex-row font-bold justify-between">
                        <p>Total</p>
                        <span class="flex flex-row gap-1 items-center">
                            <img class="w-4 h-4" src="/images/naira.png" alt="">
                            <p>164,000.00</p>
                        </span>
                    </div>
                    <button style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg">
                        CONFIRM ORDER
                    </button>
                </div>
            </div>

            
        </div>
        
        <div class="flex flex-row justify-start px-16 pb-10 pt-10 items-center gap-2">
            <h1 class="text-xl font-semibold font-bricolage border-b-[1px] border-[#212121]">CONTINUE SHOPPING</h1>
        </div>
        
        @include('components.footer')
    </div>
</body>
</html>
