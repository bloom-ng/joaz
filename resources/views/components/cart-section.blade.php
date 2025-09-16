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
@php
    $cart = $cart ?? \App\Models\Cart::with('items.product')
                ->firstOrCreate(['user_id' => auth()->id()]);

    // Calculate NGN total
    $total_ngn = $cart->items->sum(function($item) {
        return $item->product->price_ngn * $item->quantity;
    });

    // Calculate USD total
    $total_usd = $cart->items->sum(function($item) {
        return $item->product->price_usd * $item->quantity;
    });
@endphp

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="min-h-screen flex flex-col">

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
                        @forelse ($cart->items as $item)
                            @php
                                $product = $item->product;
                                $images = $product->images->first()->image ?? null;
                                $quantity = $item->quantity;
                                $unitPrice = $item->unit_price;
                                $totalItems = $cart->items->sum('quantity');
                                $itemId =    $item->id;

                            @endphp

                            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-0">
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
                                    <div class="flex flex-row items-center justify-center">
                                        <button type="button"
                                        onclick="updateQuantity({{ $item->id }}, 'decrement')"
                                        class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">
                                    -
                                </button>

                                        <span id="quantity-{{ $item->id }}" class="w-6 h-6 text-[#FCFCFC] flex items-center justify-center bg-[#85BB3F] text-center font-semibold">
                                        {{ $item->quantity }}
                                    </span>

                                        <button type="button"
                                        onclick="updateQuantity({{ $item->id }}, 'increment')"
                                        class="w-6 h-6 bg-[#E7E4E1] text-[#212121] rounded-sm flex items-center justify-center font-bold text-xl">
                                    +
                                </button>

                                    </div>
                                </td>
                                <td class="px-6 py-4 align-middle whitespace-nowrap">
                                    <span class="flex flex-row gap-1 items-center">
                                        @if (Auth::check() && Auth::user()->country->name == "Nigeria")
                                        <p class="flex items-center text-md font-bricolage">
                                            <img class="w-4 h-4 mr-1" src="{{ asset('images/naira.png') }}" alt="">
                                            {{ number_format($item->product->price_ngn * $item->quantity, 2) }}
                                        </p>
                                    @elseif(isset($location) && $location->country == "Nigeria")
                                        <p class="flex items-center text-md font-bricolage">
                                            <img class="w-4 h-4 mr-1" src="{{ asset('images/naira.png') }}" alt="">
                                            {{ number_format($item->product->price_ngn * $item->quantity, 2) }}
                                        </p>
                                    @else
                                        <p class="flex items-center text-md font-bricolage">
                                            <img class="w-4 h-4" src="{{ asset('images/mdi_dollar.png') }}" alt="">
                                            {{ number_format($item->product->price_usd * $item->quantity, 2) }}
                                        </p>
                                    @endif

                                    </span>
                                </td>
                                <td class="px-6 py-4 align-middle">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="event.preventDefault(); removeFromCart({{ $item->id }}, event);">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <img class="w-4 h-4 cursor-pointer" src="{{ asset('images/trash.png') }}" alt="Remove">
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8">
                                    <p class="font-rustler text-4xl">Your cart is empty</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            <div class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[30%] rounded-2xl">
                <div class="font-semibold flex flex-row items-start pt-7 pb-4 items-center px-4 border-b-[1px] border-[#212121]/20 justify-start">Cart Summary</div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Total Items</p>
                    <p class="total-items">{{ $cart->items->sum('quantity') }}</p>
                </div>
                <div class="flex flex-row font-semibold py-4 px-4 border-b-[1px] border-[#212121]/20 justify-between items-center">
                    <p>Price</p>
                    <span class="flex flex-row gap-1 items-center">
                        @if (Auth::check() && Auth::user()->country->name == "Nigeria")
    <p class="flex items-center text-md font-bricolage">
        <img class="w-4 h-4 mr-1" src="{{ asset('images/naira.png') }}" alt="">
        {{ number_format($total_ngn, 2) }}
    </p>
@elseif(isset($location) && $location->country == "Nigeria")
    <p class="flex items-center text-md font-bricolage">
        <img class="w-4 h-4 mr-1" src="{{ asset('images/naira.png') }}" alt="">
        {{ number_format($total_ngn, 2) }}
    </p>
@else
    <p class="flex items-center text-md font-bricolage">
        <img class="w-4 h-4" src="{{ asset('images/mdi_dollar.png') }}" alt="">
        {{ number_format($total_usd, 2) }}
    </p>
@endif

                    </span>
                </div>
                <div class="flex flex-row justify-between py-4 px-4 border-b-[1px] border-[#212121]/20 items-center">
                    <p class="font-semibold">Delivery</p>
                    <p>Not Included</p>
                </div>
                <div class="flex flex-col justify-between gap-4 p-4 pb-7 mt-auto">
                    <p class="text-xs pb-8">*Please confirm your order to add your delivery/pickup details.</p>
                    <div class="flex flex-row font-bold justify-between">
                        <p>Total</p>
                        <span class="flex flex-row gap-1 items-center">
                            @if (Auth::check() && Auth::user()->country->name == "Nigeria")
                            <p class="flex items-center text-md font-bricolage cart-total">
                                <img class="w-4 h-4 mr-1" src="{{ asset('images/naira.png') }}" alt="">
                                {{ number_format($cart->total_ngn, 2) }}
                            </p>
                        @elseif(isset($location) && $location->country == "Nigeria")
                            <p class="flex items-center text-md font-bricolage cart-total">
                                <img class="w-4 h-4 mr-1" src="{{ asset('images/naira.png') }}" alt="">
                                {{ number_format($cart->total_ngn, 2) }}
                            </p>
                        @else
                            <p class="flex items-center text-md font-bricolage cart-total">
                                <img class="w-4 h-4" src="{{ asset('images/mdi_dollar.png') }}" alt="">
                                {{ number_format($cart->total_usd, 2) }}
                            </p>
                        @endif

                        </span>
                    </div>
                    <a href="{{ route('confirm-delivery') }}"><button style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg">
                        CONFIRM ORDER
                    </button></a>
                </div>
            </div>


        </div>

        <div class="flex flex-row justify-start px-16 pb-10 pt-10 items-center gap-2">
            <a href="{{ route('shop.category') }}">
                <h1 class="text-xl font-semibold font-bricolage border-b-[1px] border-[#212121]">CONTINUE SHOPPING</h1>
            </a>
        </div>

        @include('components.footer')
    </div>
</body>
</html>


<script>
    async function updateQuantity(itemId, action) {
        try {
            const response = await fetch(`/cart/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ action })
            });

            const data = await response.json();

            if (data.success) {
                // Refresh the page to update all cart data
                window.location.reload();
            } else if (data.error) {
                alert(data.error);
            }
        } catch (err) {
            console.error('Error updating cart:', err);
            alert('Something went wrong while updating the cart. Please try again.');
        }
    }

    async function removeFromCart(itemId, event) {
        event.preventDefault();


        const form = event.target.closest('form');

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ _method: 'DELETE' })
            });

            const data = await response.json();

            if (data.success) {
                // Refresh the page to update all cart data
                window.location.reload();
            } else {
                alert(data.message || 'Failed to remove item');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            alert('An error occurred while removing the item. Please try again.');
        }
    }
    </script>
