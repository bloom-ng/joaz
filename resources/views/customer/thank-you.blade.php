<html>

<head>
    <title>Joaz Hair - Thank You</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

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

    <style>
        @font-face {
            font-family: 'RustlerBarter';
            src: url('/fonts/RustlerBarter.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap"
        rel="stylesheet">
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="flex flex-col bg-[#FCFCFC] min-h-screen">
        @include('components.header')

        <div class="flex flex-col items-center text-center flex-1 py-12">
            <h1
                class="text-[90px] md:text-[110px] font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                THANK YOU
            </h1>

            <div
                class="flex flex-col font-bricolage px-10 py-10 w-[90%] md:w-[50vw] bg-[#FCFCFC] rounded-2xl shadow-lg items-center justify-center text-center mt-6">
                <img src="{{ asset('images/check-bg.png') }}" class="w-23 h-16 mb-6" alt="Success Icon">

                <h2 class="text-2xl font-semibold pb-4">Your order has been placed successfully!</h2>
                <p class="text-base leading-[22px] text-gray-700">Thank you,
                    <span class="font-bold">
                        {{ strtoupper($order->guest_name ?? $order->user->name) }}
                    </span>.
                    Your order, with tracking number <span class="font-bold">#{{ $order->tracking_number }}</span> has been received.
                </p>

                <div class="mt-6 text-left w-full">
                    <h3 class="font-semibold mb-2">Order Summary</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <li class="py-2 flex justify-between">
                                <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                @if (isset($location) && $location->country == "Nigeria")
                                    <span>{{ $order->payment_currency }} {{ number_format($item->product->price_ngn * $item->quantity, 2) }}</span>
                                @else
                                    <span>{{ $order->payment_currency }} {{ number_format($item->product->price_usd * $item->quantity, 2) }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 flex justify-between font-semibold">
                        <span>Total:</span>
                        <span>{{ $order->payment_currency }} {{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div class="mt-10 flex gap-6">
                    <a href="{{ route("shop.category") }}"
                       class="px-6 py-3 rounded-lg bg-[#85BB3F] text-white font-medium hover:bg-[#6ea634] transition">
                       Continue Shopping
                    </a>
                    <a href=""
                       class="px-6 py-3 rounded-lg border border-[#212121] text-[#212121] font-medium hover:bg-gray-100 transition">
                       Track Your Order
                    </a>
                </div>
            </div>
        </div>

        @include('components.footer')
    </div>
</body>
</html>
