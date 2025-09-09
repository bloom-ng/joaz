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
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap"
        rel="stylesheet">

    <title>Cart - JOAZ</title>
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="min-h-screen flex flex-col">
        @include("components.header")
        @php
            $deliveryMethod = session("checkout.delivery_method");
            $user = auth()->user();
            $defaultAddress = $user->addresses()->where("is_default", true)->first();

        @endphp

        <div class="flex flex-row font-rustler text-4xl items-center justify-center pb-8 pt-12">ORDER SUMMARY</div>

        <div class="flex flex-row items-stretch gap-4 px-16 rounded-2xl">
            <div
                class="flex relative flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[70%] rounded-2xl">
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
                        @forelse($cartItems as $index => $item)
                        @php
                        $product = $item->product;
                        $images = $product->images->first()->image ?? null;
                        $quantity = $item->quantity;
                        $subTotal = $cartItems->sum(fn($item) => $item->unit_price * $item->quantity);

                    @endphp

                        <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
                            <td class="px-6 py-4 align-middle">{{ $index +1 }}</td>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex flex-row gap-3 items-center">
                                    @if($images)
                                            <img class="w-[120px] h-[132px] object-cover rounded-xl"
                                                 src="{{ asset('storage/' . $images) }}"
                                                 alt="{{ $product->name }}">
                                        @else
                                            <div class="w-[140px] h-[132px] bg-gray-200 rounded-xl flex items-center justify-center">
                                                <span class="w-[100px] h-[112px] object-cover rounded-xl text-center mt-7">No Image</span>
                                            </div>
                                        @endif
                                    <div class="flex flex-col gap-1">
                                        <h1 class="font-semibold">{{ $product->name }}</h1>
                                        <p>{{ $product->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <p class="font-semibold">{{ $item->quantity }}</p>
                            </td>
                            <td class="px-6 py-4 align-middle whitespace-nowrap">
                                <span class="flex flex-row gap-1 items-center">
                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                    <p>{{ number_format($item->unit_price * $item->quantity, 2) }}</p>
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                Your cart is empty.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="flex flex-col absolute -bottom-16">
                    @if($defaultAddress)
                    <p>* Delivery to <span class="font-semibold">{{ $defaultAddress->address }}, {{ $defaultAddress->city }}, {{ $defaultAddress->state }} {{ $defaultAddress->country }}.</span></p>
                    @else
                    <p>No default address selected</p>
                    @endif
                </div>
            </div>

            <div
                class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[30%] rounded-2xl">
                <div
                    class="font-semibold flex flex-row items-start pt-7 pb-4 items-center px-4 border-b-[1px] border-[#212121]/20 justify-start">
                    Order Summary</div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Total Items</p>
                    <p>{{ $cartItems->sum('quantity') }}</p>
                </div>
                <div
                    class="flex flex-row font-semibold py-4 px-4 border-b-[1px] border-[#212121]/20 justify-between items-center">
                    <p>Price</p>
                    <span class="flex flex-row gap-1 items-center">
                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                        <p class="font-semibold">{{ number_format($subTotal, 2) }}</p>
                    </span>
                </div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Delivery Fee</p>
                    <span class="flex flex-row gap-1 items-center">
                        <img class="w-4 h-4" src="/images/naira.png" alt="">
                        <p class="font-semibold">5000.00</p>
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
                        <p class="font-semibold">Address</p>
                        <span class="flex flex-col text-right">
                            @if($defaultAddress)
                                <p class="font-semibold">
                                    {{ $defaultAddress->city }}, {{ $defaultAddress->state }}, {{ $defaultAddress->country }}
                                </p>
                            @else
                                <p class="text-red-500 text-sm">No Address</p>
                            @endif
                        </span>
                    </div>

                    <div class="flex pb-5 flex-row font-bold justify-between">
                        <p>Total</p>
                        <span class="flex flex-row gap-1 items-center">
                            <img class="w-4 h-4" src="/images/naira.png" alt="">
                            <p>184,000.00</p>
                        </span>
                    </div>
                    <button style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                        class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg">
                        PROCEED TO PAY
                    </button>
                </div>
            </div>
        </div>

        @include("components.footer")
    </div>
</body>

</html>
