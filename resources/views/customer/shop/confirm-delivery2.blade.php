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
    @php
        $deliveryMethod = session("checkout.delivery_method");
        $user = auth()->user();
        $defaultAddress = $user->addresses()->where("is_default", true)->first();

    @endphp
    <div class="min-h-screen flex flex-col">
        @include("components.header")

        <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-24 py-12">DELIVERY DETAILS</div>

        <div class="flex justify-center px-16 pb-20">
            <div
                class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-3/5 rounded-2xl px-24 p-8 items-center gap-3">
                <h2 class="font-bold pb-2 pt-2 text-2xl">2/2</h2>
                <h2 class="font-bold text-2xl">SELECT DELIVERY ADDRESS</h2>
                <!-- Address Options -->
                @foreach ($user->addresses as $address)
    <div class="w-full border border-[#21212199]/30 rounded-lg p-4 flex items-center gap-3">
        <input type="radio"
               name="address"
               id="address{{ $address->id }}"
               value="{{ $address->id }}"
               @if ($address->is_default) checked @endif
               class="w-4 h-4 text-[#85BB3F] focus:ring-[#85BB3F] address-radio">

        <label for="address{{ $address->id }}" class="cursor-pointer w-full flex flex-col">
            <span class="text-sm text-gray-600">
                {{ $address->address }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country }}
                (<span class="font-bold">{{ $address->label }}</span>)
            </span>
        </label>
    </div>
@endforeach



                <!-- Add New Address -->
                <button id="toggleForm"
                    class="w-full border border-dashed border-[#85BB3F] text-[#85BB3F] rounded-lg py-3 mt-5 hover:bg-[#85BB3F]/10 transition">
                    + Add New Address
                </button>



                <!-- Inline Form (Hidden by default) -->
                <form action="{{ route('checkout.addAddress') }}" method="POST" class="w-full">
                    @csrf
                    <div id="addressForm"
                        class="hidden w-full border border-[#212121]/30 rounded-lg p-6 mt-4 space-y-4">

                        <div class="flex justify-between items-center">
                            <span class="text-[#212121] text-sm font-bold">Address Type</span>
                            <input type="text" name="label" placeholder="House, Office"
                                class="border border-[#212121]/20 rounded-md px-3 py-2 text-sm w-2/3 focus:ring-[#85BB3F] focus:border-[#85BB3F]" required>
                        </div>
                        <hr class="border-[0.5px] border-[#212121]/20">

                        <div class="flex justify-between items-center">
                            <span class="text-[#212121] text-sm font-bold">Address</span>
                            <input type="text" name="address" placeholder="House 304, Fancy global estate."
                                class="border border-[#212121]/20 rounded-md px-3 py-2 text-sm w-2/3 focus:ring-[#85BB3F] focus:border-[#85BB3F]" required>
                        </div>
                        <hr class="border-[0.5px] border-[#212121]/20">

                        <div class="flex justify-between items-center">
                            <span class="text-[#212121] text-sm font-bold">Country</span>
                            <input type="text" name="country" placeholder="Nigeria"
                                class="border border-[#212121]/20 rounded-md px-3 py-2 text-sm w-2/3 focus:ring-[#85BB3F] focus:border-[#85BB3F]" required>
                        </div>
                        <hr class="border-[0.5px] border-[#212121]/20">

                        <div class="flex justify-between items-center">
                            <span class="text-[#212121] text-sm font-bold">State</span>
                            <input type="text" name="state" placeholder="FCT Abuja"
                                class="border border-[#212121]/20 rounded-md px-3 py-2 text-sm w-2/3 focus:ring-[#85BB3F] focus:border-[#85BB3F]" required>
                        </div>
                        <hr class="border-[0.5px] border-[#212121]/20">

                        <div class="flex justify-between items-center">
                            <span class="text-[#212121] text-sm font-bold">City</span>
                            <input type="text" name="city" placeholder="Abuja"
                                class="border border-[#212121]/20 rounded-md px-3 py-2 text-sm w-2/3 focus:ring-[#85BB3F] focus:border-[#85BB3F]" required>
                        </div>
                        <hr class="border-[0.5px] border-[#212121]/20">

                        <div class="flex justify-between items-center">
                            <span class="text-[#212121] text-sm font-bold">Postal Code</span>
                            <input type="text" name="postal_code" placeholder="023120"
                                class="border border-[#212121]/20 rounded-md px-3 py-2 text-sm w-2/3 focus:ring-[#85BB3F] focus:border-[#85BB3F]">
                        </div>

                        <button type="submit"
                            class="mt-4 w-full bg-[#85BB3F] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#6ca233] transition">
                            Save Address
                        </button>
                    </div>
                </form>


                  <!-- Proceed Button -->
                 <a href="{{ route('order-summary2') }}" style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                 class="text-[#FCFCFC] text-sm px-10 py-4 rounded-lg w-full mt-6 text-center"><button >
                  PROCEED
              </button></a>

            </div>

        </div>



        @include("components.footer")
    </div>
</body>

</html>

<script>
    const toggleBtn = document.getElementById("toggleForm");
    const form = document.getElementById("addressForm");

    toggleBtn.addEventListener("click", () => {
        form.classList.toggle("hidden");
    });

    document.querySelectorAll('.address-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            let addressId = this.value;

            fetch("{{ route('checkout.setDefaultAddress') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    address_id: addressId
                })
            })
            .catch(error => console.error("Error:", error));
        });
    });
    </script>

