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
        <div class="flex flex-row font-rustler text-4xl items-center justify-center pb-8 pt-12">ORDER SUMMARY</div>
        <div class="flex flex-row items-stretch gap-6 px-16 rounded-2xl">
            {{-- RIGHT: Guest Checkout Form --}}
            <div
                class="flex flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[40%] rounded-2xl p-6">
                <h2 class="font-semibold text-lg mb-4 border-b-[1px] border-[#212121]/20">Address Details</h2>

                @if (session()->has("guest_details"))
                    @php
                        $details = session("guest_details");
                    @endphp

                    <div class="flex flex-col gap-2">
                        <p><strong>Name:</strong> {{ $details["guest_name"] }}</p>
                        <br>
                        <p><strong>Email:</strong> {{ $details["guest_email"] }}</p>
                        <br>
                        <p><strong>Phone:</strong> {{ $details["guest_phone"] }}</p>
                        <br>
                        <p><strong>Country:</strong> {{ $details["country"] }}</p>
                        <br>
                        <p><strong>Ship to :</strong> {{ $details["guest_address"] }}</p>
                        <br>
                    </div>

                      {{-- Edit button --}}
    <form method="POST" action="{{ route('orders.guest.editDetails') }}" class="mb-4">
        @csrf
        <button type="submit" class="text-sm px-4 py-2 bg-yellow-500 text-white rounded-lg">
            Edit Details
        </button>
    </form>

                    {{-- Proceed button --}}
                    <form method="POST" action="{{ route("orders.guest.place") }}">
                        @csrf
                        @if (isset($location) && $location->country == "Nigeria")
                            <input type="hidden" name="total_amount" value="{{ $total_ngn }}">
                        @else
                            <input type="hidden" name="total_amount" value="{{ $total_usd }}">
                        @endif
                        @if (isset($location) && $location->country == "Nigeria")
                            <input type="hidden" name="payment_currency" value="NGN">
                        @else
                            <input type="hidden" name="payment_currency" value="USD">
                        @endif
                        <input type="hidden" name="delivery_method" value="delivery">
                        <button type="submit"
                            style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="w-full text-[#FCFCFC] text-sm px-10 py-4 rounded-lg">
                            PROCEED TO CHECKOUT
                        </button>
                    </form>
                @else
                @php
                     $countries = DB::table('countries')->orderBy('name')->get();
                @endphp
                    {{-- Show form if no details saved --}}
                    <form method="POST" action="{{ route("orders.saveDetails") }}" class="flex flex-col gap-4">
                        @csrf
                        <input type="text" name="guest_name" placeholder="Full Name"
                            class="border border-gray-300 rounded-lg px-4 py-2" required>

                        <input type="email" name="guest_email" placeholder="Email"
                            class="border border-gray-300 rounded-lg px-4 py-2" required>

                        <input type="text" name="guest_phone" placeholder="Phone"
                            class="border border-gray-300 rounded-lg px-4 py-2" required>

                        <select name="country_id" id="country-mobile"
                            class="bg-white w-full border border-[#212121/80] rounded-md p-3" required>
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ old("country_id") == $country->id ? "selected" : "" }}>{{ $country->name }}
                                </option>
                            @endforeach
                        </select>

                        <textarea name="guest_address" placeholder="Delivery Address" rows="3"
                            class="border border-gray-300 rounded-lg px-4 py-2" required>
                        </textarea>

                        <button type="submit"
                            style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="text-[#FCFCFC] text-sm px-10 py-4 rounded-lg mt-4">
                            ADD DETAILS
                        </button>
                    </form>
                @endif
            </div>

            {{-- LEFT: Order Items --}}
            <div
                class="flex relative flex-col h-full border border-[1px] border-[#21212199]/30 font-bricolage w-[60%] rounded-2xl">
                <table class="table-auto w-full">
                    <thead class="w-full border-b-[1px] border-[#212121]/20">
                        <tr>
                            <th class="text-left px-6 py-4">S/N</th>
                            <th class="text-left px-6 py-4">Products</th>
                            <th class="text-left px-6 py-4">Qty</th>
                            <th class="text-left px-6 py-4">Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cartItems as $index => $item)
                            @php
                                $product = $item["product"];
                                $images = $product->images->first()->image ?? null;
                            @endphp

                            <tr class="border-b-[1px] border-[#212121]/20 last:border-b-[1px]">
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-row gap-3 items-center">
                                        @if ($images)
                                            <img class="w-[80px] h-[90px] object-cover rounded-xl"
                                                src="{{ asset("storage/" . $images) }}" alt="{{ $product->name }}">
                                        @else
                                            <div
                                                class="w-[80px] h-[90px] bg-gray-200 rounded-xl flex items-center justify-center">
                                                <span>No Image</span>
                                            </div>
                                        @endif
                                        <div class="flex flex-col gap-1">
                                            <h1 class="font-semibold">{{ $product->name }}</h1>
                                            <p class="text-sm">{{ Str::limit($product->description, 40) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold">{{ $item["quantity"] }}</td>
                                <td class="px-6 py-4">
                                    @if (isset($location) && $location->country == "Nigeria")
                                        ₦{{ number_format($product->price_ngn * $item["quantity"], 2) }}
                                    @else
                                        ${{ number_format($product->price_usd * $item["quantity"], 2) }}
                                    @endif
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

                <div class="flex px-12 py-4 flex-col font-bold gap-2">

                    {{-- Cart Total --}}
                    <div class="flex flex-row justify-between">
                        <p>Total</p>
                        @if (isset($location) && $location->country == "Nigeria")
                            <span>₦{{ number_format($total_ngn, 2) }}</span>
                        @else
                            <span>${{ number_format($total_usd, 2) }}</span>
                        @endif
                    </div>

                    {{-- Delivery Fee --}}
                    <div class="flex flex-row justify-between">
                        <p>Delivery Fee</p>
                        @if (isset($location) && $location->country == "Nigeria")
                            <span>₦{{ number_format($deliveryFeeAmount, 2) }}</span>
                        @else
                            <span>${{ number_format($deliveryFeeAmount, 2) }}</span>
                        @endif
                    </div>

                    {{-- VAT --}}
                    <div class="flex flex-row justify-between">
                        <p>VAT ({{ $VAT }}%)</p>
                        @if (isset($location) && $location->country == "Nigeria")
                            <span>₦{{ number_format($vat_ngn, 2) }}</span>
                        @else
                            <span>${{ number_format($vat_usd, 2) }}</span>
                        @endif
                    </div>

                    {{-- Final Payable --}}
                    <div class="flex flex-row justify-between border-t pt-2">
                        <p>Grand Total</p>
                        @if (isset($location) && $location->country == "Nigeria")
                            <span>₦{{ number_format($total_ngn + $deliveryFeeAmount + $vat_ngn, 2) }}</span>
                        @else
                            <span>${{ number_format($total_usd + $deliveryFeeAmount + $vat_usd, 2) }}</span>
                        @endif
                    </div>

                </div>

            </div>


        </div>
    </div>

</body>

</html>
