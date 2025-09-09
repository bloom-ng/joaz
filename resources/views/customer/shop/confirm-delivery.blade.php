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

        <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-24 py-12">DELIVERY DETAILS</div>

        <div class="flex justify-center px-16 pb-20">
            <div
                class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-3/5 rounded-2xl px-24 p-8 items-center gap-3">
                <h2 class="font-bold pb-4 pt-2 text-2xl">1/2</h2>
                <form action="{{ route("process-delivery") }}" method="POST" class="w-full">
                    @csrf
                    <div class="relative w-full mb-4">
                        <select name="delivery_method" id="delivery-method"
                            class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-transparent appearance-none cursor-pointer"
                            required>
                            <option value="" disabled {{ old("delivery_method") ? "" : "selected" }}>Select
                                delivery method</option>
                            <option value="delivery" {{ old("delivery_method") == "delivery" ? "selected" : "" }}>
                                Delivery</option>
                            <option value="pickup" {{ old("delivery_method") == "pickup" ? "selected" : "" }}>Pickup
                            </option>
                        </select>
                        @error("delivery_method")
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Display user details (readonly, no editing) --}}
                    <input type="text" value="{{ auth()->user()->name }}"
                        class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-gray-100 placeholder:text-black mb-4"
                        readonly>

                    <input type="email" value="{{ auth()->user()->email }}"
                        class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-gray-100 placeholder:text-black mb-4"
                        readonly>

                    <input type="tel" value="{{ auth()->user()->phone }}"
                        class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-gray-100 placeholder:text-black mb-4"
                        readonly>

                    <button type="submit" style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                        class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg w-full mt-8 mb-3">
                        PROCEED
                    </button>
                </form>


            </div>
        </div>



        @include("components.footer")
    </div>
</body>

</html>

<style>
    /* Custom styling for the select dropdown */
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;utf8,<svg fill='%23212121' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/><path d='M0 0h24v24H0z' fill='none'/></svg>");
        background-repeat: no-repeat;
        background-position-x: 98%;
        background-position-y: 50%;
    }

    /* Remove default arrow in IE */
    select::-ms-expand {
        display: none;
    }
</style>
