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

        <div class="flex flex-row font-rustler text-4xl items-center justify-center pb-8 pt-12">ORDER SUMMARY</div>

        <div class="flex flex-row items-stretch gap-4 px-16 rounded-2xl">
            <div class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[70%] rounded-2xl">
                <table class="table-auto">
                    <thead class="w-full border-b-[1px] border-[#212121]/20">
                        <tr>
                            <th class="text-left px-6 py-4">S/N</th>
                            <th class="text-left px-6 py-4">Product Name</th>
                            <th class="text-left px-6 py-4">Qty</th>
                            <th class="text-left px-6 py-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
                            <td class="px-6 py-4 align-middle">1</td>
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
                                <p class="font-semibold">4</p>
                            </td>
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                <span class="flex flex-row gap-1 items-center">
                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                    <p>164,000.00</p>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[30%] rounded-2xl">
                <div class="font-semibold flex flex-row items-start pt-7 pb-4 items-center px-4 border-b-[1px] border-[#212121]/20 justify-start">Order Summary</div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Total Items</p>
                    <p>4</p>
                </div>
                <div class="flex flex-row font-semibold py-4 px-4 border-b-[1px] border-[#212121]/20 justify-between items-center">
                    <p>Price</p>
                    <span class="flex flex-row gap-1 items-center">
                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                        <p>48,000.00</p>
                    </span>
                </div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Delivery</p>
                    <span class="flex flex-row gap-1 items-center">
                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                        <p class="font-semibold">0.00</p>
                    </span>
                </div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Vat</p>
                    <span class="flex flex-row gap-1 items-center">
                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                        <p class="font-semibold">500.00</p>
                    </span>
                </div>
                <div class="flex flex-col justify-between gap-4 p-4 pb-7 mt-auto">
                    <div class="flex flex-row justify-between pb-8 items-center">
                        <p class="font-semibold">Pickup address</p>
                        <span class="flex flex-row gap-1 items-center">
                            Banex Plaza, Wuse 2
                        </span>
                    </div>
                    <div class="flex pb-5 flex-row font-bold justify-between">
                        <p>Total</p>
                        <span class="flex flex-row gap-1 items-center">
                            <img class="w-4 h-4" src="/images/naira.png" alt="">
                            <p>48,500.00</p>
                        </span>
                    </div>
                    <button style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg">
                            PROCEED TO PAY
                    </button>
                </div>
            </div>
        </div>
        
        @include('components.footer')
    </div>
</body>
</html>
