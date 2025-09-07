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

        <div class="flex flex-row font-rustler text-4xl items-center justify-center pt-24 py-12">DELIVERY DETAILS</div>

        <div class="flex justify-center px-16 pb-20">
            <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-3/5 rounded-2xl px-24 p-8 items-center gap-3">
                <h2 class="font-bold pb-4 pt-2 text-2xl">1/2</h2>
                <div class="relative w-full">
                    <div class="flex flex-row items-center justify-between w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-transparent cursor-pointer" onclick="toggleDropdown()">
                        <span id="selected-option">Select pickup mode</span>
                        <img id="dropdown-arrow" class="w-3 h-2 transition-transform duration-200" src="/images/dropdown.png" alt="Dropdown arrow">
                    </div>
                    <div id="dropdown-menu" class="hidden absolute w-full mt-1 bg-white border border-[#21212199]/30 rounded-lg shadow-lg z-10">
                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100" onclick="selectOption('Home delivery'); event.preventDefault();">Home delivery</a>
                        <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100" onclick="selectOption('Pickup'); event.preventDefault();">Pickup</a>
                    </div>
                </div>
                <input type="text" placeholder="Name" class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-transparent placeholder:text-black">
                <input type="email" placeholder="Email address" class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-transparent placeholder:text-black">
                <input type="tel" placeholder="Phone number" class="w-full font-bricolage border border-[#21212199]/30 rounded-lg p-4 bg-transparent placeholder:text-black">
               <button style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                        class="text-[#FCFCFC] text-sm px-10 py-5 rounded-lg w-full mt-8 mb-3"> <a href="{{ route('confirm-delivery2') }}">
                    PROCEED
                </a></button>
            </div>
        </div>



        @include('components.footer')
    </div>
</body>
</html>

<script>
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');

        if (dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.remove('hidden');
            dropdownArrow.style.transform = 'rotate(180deg)';
        } else {
            dropdownMenu.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    }

    function selectOption(option) {
        document.getElementById('selected-option').textContent = option;
        toggleDropdown();
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.querySelector('.relative');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');

        if (!dropdown.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
            dropdownArrow.style.transform = 'rotate(0deg)';
        }
    });
</script>
