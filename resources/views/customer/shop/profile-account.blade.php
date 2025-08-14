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

        <div class="flex font-bricolage font-semibold px-16 pt-12 text-[#212121]/60 flex-row text-xl gap-10">
            <h1 class="text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">ACCOUNT</h1>
            <h1>ADDRESS BOOK</h1>
            <h1>MY CART</h1>
            <h1>MY ORDERS</h1>
        </div>

        <div class="flex flex-row font-rustler text-4xl items-center justify-center py-12">PROFILE DETAILS</div>

        <div class="flex justify-center pb-36 px-16">
            <div class="flex flex-col border border-[1px] border-[#21212199]/30 font-bricolage w-full lg:w-3/5 rounded-2xl px-5 pt-6 pb-9 gap-6">
                <!-- My Profile Section -->
                <div class="flex justify-between items-center pb-4">
                    <h2 class="font-bold text-xl">My profile</h2>
                    <button class="font-semibold text-xl font-bricolage border-b-[1px] border-[#212121]">EDIT</button>
                </div>

                <!-- Name -->
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">Name</span>
                    <span class="">Shantel Glory</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">

                <!-- Email Address -->
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">Email address</span>
                    <span class="">shantelglory@gmail.com</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">

                <!-- Phone Number -->
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">Phone number</span>
                    <span class="">0203-241-3120</span>
                </div>
                <hr class="border-[0.5px] border-[#212121]/20 -mt-2 -mx-5">

                <!-- Gender -->
                <div class="flex justify-between items-center">
                    <span class="text-[#212121] font-bold">Gender</span>
                    <span class="">Female</span>
                </div>
            </div>
        </div>

        
        @include('components.footer')
    </div>
</body>
</html>
