<html>

<head>
    <title>Joaz Hair</title>

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
</head>

<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="flex flex-col bg-[#FCFCFC]">
        @include('components.header')
        
        <div class="text-center flex flex-col">
            <h1
                class="text-[110px] font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                CONTACT US
            </h1>
            
            <div
                class="flex flex-row gap-10 justify-center items-center w-full h-[90vh] bg-[url('/images/reviews-bg.png')] bg-cover bg-center"
                id="review-section"
            >
                <div class="flex flex-col font-bricolage px-16 w-[40vw] bg-[#FCFCFC] p-8 rounded-md items-center justify-center text-center">
                    <h1 class="text-xl font-semibold leading-[22px] font-bricolage pb-8">We’d love to attend to you. Call any of our office line or visit us in person.</h1>
                    <img class="w-6 h-6 rounded-full" src="/images/location.png" alt="Profile Picture">
                    <p class="font-semibold py-1">Office Address</p>
                    <p class="px-16 leading-[20px]">Shop No BPF14, First Floor. Old Banex Plaza Wuse 2, Abuja, Nigeria. </p>
                    <div class="flex flex-row pt-8 justify-between gap-20">
                        <div class="flex flex-col items-center justify-center">
                            <img class="w-7 h-7" src="/images/phone.png" alt="">
                            <p class="font-semibold pt-3">Wuse 2 Call Line</p>
                            <p>09020112040  <br>
                            09055550592</p>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <img class="w-7 h-7" src="/images/phone.png" alt="">
                            <p class="font-semibold pt-3">Gwarimpa Call Line</p>
                            <p>07070042009 <br>
                            09072222678</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('components.subscribe')

        @include('components.footer')
    </div>
</body>

</html>
