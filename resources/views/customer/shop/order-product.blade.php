<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts config to match project -->
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

      /* Custom scrollbar styles (from My Orders) */
      .custom-scrollbar::-webkit-scrollbar {
        width: 14px;
      }
      .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
      }
      .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E7E4E1;
        border-radius: 10px;
        border: 4px solid transparent;
        background-clip: content-box;
      }
    </style>

    <!-- Load Bricolage Grotesque from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <title>My Orders - JOAZ</title>
</head>
<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="min-h-screen flex flex-col">
      @include('components.header')
            <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-8 pb-4">MY ORDERS</div>

            <main>
            <div class="flex flex-col items-stretch gap-8 px-16 rounded-2xl ">
                <div class="flex font-bricolage font-semibold text-[#212121]/60 flex-row gap-10">
                </div>

                <div class="border border-[1px] border-[#21212199]/30 font-bricolage w-full rounded-2xl overflow-hidden">
                    <div class="overflow-y-auto max-h-[574px] custom-scrollbar">
                        <table class="table-auto w-full">
                            <thead class="sticky top-0 bg-[#FCFCFC] z-10 w-full border-b-[1px] border-[#212121]/20">
                                <tr>
                                    <th class="text-left px-6 py-4">Products</th>
                                    <th class="text-left px-6 py-4">Quantity</th>
                                    <th class="text-left px-6 py-4">Product Amount</th>
                                    <th class="text-left px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-[#FFFFFF]">
                                @forelse ($order->items as $item)
                                @php
                                    $images = $item->product->images->first()->image ?? null;
                                    $product = $item->product;

                                @endphp
                                    <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">

                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex flex-row gap-3 items-center">
                                                @if ($images)
                                                    <img class="w-[120px] h-[132px] object-cover rounded-xl"
                                                        src="{{ asset("storage/" . $images) }}" alt="{{ $product->name }}">
                                                @else
                                                    <div
                                                        class="w-[140px] h-[132px] bg-gray-200 rounded-xl flex items-center justify-center">
                                                        <span
                                                            class="w-[100px] h-[112px] object-cover rounded-xl text-center mt-7">No
                                                            Image</span>
                                                    </div>
                                                @endif
                                                <div class="flex flex-col gap-1">
                                                    <h1 class="font-semibold">{{ $product->name }}</h1>
                                                    <p>{{ $product->description }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 align-middle">{{ $item->quantity}}</td>
                                        <td class="px-6 py-4 align-middle whitespace-nowrap">
                                            @if (Auth::check() && Auth::user()->country->name == "Nigeria")
                                                <span class="flex flex-row gap-1 items-center">
                                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                                    <p>{{ number_format(($item->quantity * $item->product->price_ngn), 2) }}</p>
                                                </span>
                                            @elseif(isset($location) && $location->country == "Nigeria")
                                                <span class="flex flex-row gap-1 items-center">
                                                    <img class="w-4 h-4" src="/images/naira.png" alt="">
                                                    <p>{{ number_format(($item->quantity * $item->product->price_ngn), 2) }}</p>
                                                </span>
                                            @else
                                                <span class="flex flex-row gap-1 items-center">
                                                    <img class="w-4 h-4" src="/images/mdi_dollar.png" alt="">
                                                    <p>{{ number_format(($item->quantity * $item->product->price_usd), 2) }}</p>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            @php
                                                $statusClass = match ($order->order_status) {
                                                    "delivered" => "bg-green-100 text-green-800",
                                                    "pending" => "bg-yellow-100 text-yellow-800",
                                                    "cancelled" => "bg-red-100 text-red-800",
                                                    "processing" => "bg-blue-100 text-blue-800",
                                                    "shipped" => "bg-purple-100 text-purple-800",
                                                };
                                            @endphp

                                            <p
                                                class="w-full text-sm text-center rounded-3xl px-5 py-2 {{ $statusClass }}">
                                                {{ ucfirst($order->order_status) }}
                                            </p>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-500">No orders found.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination inside the card -->

                </div>
            </div>
        </main>
            @include("components.footer")
        </div>
</body>

</html>
