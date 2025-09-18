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

    <!-- Load RustlerBarter font -->
    <style>
        @font-face {
            font-family: 'RustlerBarter';
            src: url('/fonts/RustlerBarter.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap"
        rel="stylesheet">

    <title>Cart - JOAZ</title>
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    @php
        $deliveryMethod = session("checkout.delivery_method");
    @endphp

    <div class="min-h-screen flex flex-col">
        @include("components.header")

        <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-24 py-12">
            DELIVERY DETAILS
        </div>

        <div class="flex justify-center px-16 pb-20">
            <div
                class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-3/5 rounded-2xl px-24 p-8 items-center gap-3">

                <h2 class="font-bold pb-2 pt-2 text-2xl">2/2</h2>
                <h2 class="font-bold text-2xl">SELECT PICKUP LOCATION</h2>


                @if (!$defaultAddress)
                    <div class="flex flex-col items-center mt-4 text-center">
                        <p class="text-gray-500 text-sm mb-3">
                            Please add a default address first before selecting a pickup location.
                        </p>
                        <a href="{{ route("account-center") }}#address"
                            class="px-6 py-3 rounded-lg text-white font-medium"
                            style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);">
                            Manage Addresses
                        </a>
                    </div>
                @elseif ($pickupAddresses->isNotEmpty())
                    <form action="{{ route("checkout.setPickup") }}" method="POST" class="w-full">
                        @csrf
                        @foreach ($pickupAddresses as $pickup)
                            <div
                                class="w-full border border-[#21212199]/30 rounded-lg p-4 flex items-center gap-3 mb-3">
                                <input type="radio" name="pickup_address_id" id="pickup{{ $pickup->id }}"
                                    value="{{ $pickup->id }}" class="w-4 h-4 text-[#85BB3F] focus:ring-[#85BB3F]">

                                <label for="pickup{{ $pickup->id }}" class="cursor-pointer w-full flex flex-col">
                                    <span class="text-sm text-gray-600">
                                        {{ $pickup->address }}, {{ $pickup->city }}, {{ $pickup->state }},
                                        {{ $pickup->country }}.
                                    </span>
                                </label>
                            </div>
                        @endforeach

                        <button type="submit"
                            style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            class="text-[#FCFCFC] text-sm px-10 py-4 rounded-lg w-full mt-6">
                            PROCEED
                        </button>
                    </form>
                @else
                    <p class="text-gray-500 text-sm mt-3">
                        Sorry, no pickup locations are available in your country.
                    </p>
                    @if ($allAddresses->isNotEmpty())
                        <form action="{{ route("checkout.setPickup") }}" method="POST" class="w-full mt-4">
                            @csrf
                            <label for="fallbackPickup" class="block text-sm font-medium text-gray-700 mb-2">
                                Select available pickup locations:
                            </label>
                            <select name="pickup_address_id" id="fallbackPickup"
                                class="w-full border border-[#21212199]/30 rounded-lg px-4 py-3 text-sm focus:ring-[#85BB3F] focus:border-[#85BB3F]">
                                @foreach ($allAddresses as $pickup)
                                    <option value="{{ $pickup->id }}">
                                        {{ $pickup->address }}, {{ $pickup->city }}, {{ $pickup->state }},
                                        {{ $pickup->country }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                                class="text-[#FCFCFC] text-sm px-10 py-4 rounded-lg w-full mt-6">
                                PROCEED
                            </button>
                        </form>
                    @endif
                @endif

            </div>
        </div>

        @include("components.footer")
    </div>
</body>

</html>
