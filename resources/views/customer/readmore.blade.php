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
        <div class="flex flex-row bg-[#212121] h-[85vh] mb-10 mx-16">
            <div class="flex flex-col w-[51%] items-center font-rustler text-[#FCFCFC] justify-center">
                <h1 class="text-[65px] leading-[60px] px-8 text-center">The secret to having a bouncy spring twist...</h1>
            </div>
            <div class="w-[49%] rounded-l-xl" style="background-image: url('/images/curly.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                
            </div>
        </div>

        <div class="flex flex-row py-5 font-bricolage text-lg text-[#FCFCFC] justify-between w-full px-16" style="background: linear-gradient(89.8deg, #212121 -12.04%, #85BB3F 104.11%);">
            <div>
                <h1 class=""> <span class="font-semibold">Posted:</span> 31/06/2025</h1>
            </div>
            <div>
                <p>152 reads</p>
            </div>
        </div>

        <div class="flex flex-col px-16 py-10 bg-[#FCFCFC]">
            <div class="font-bricolage text-2xl text-[#212121]">
                <p>
                Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. Shiny french curls extension after 3 weeks? Here’s how. 
                </p>
            </div>
            <div class="flex flex-row items-center pt-14 justify-center gap-4">
                <img class="w-6 h-6" src="/images/share.png" alt="">
                <img class="w-6 h-6" src="/images/link-variant.png" alt="">
                <img class="w-6 h-6" src="/images/twitter.png" alt="">
                <img class="w-6 h-6" src="/images/whatsapp.png" alt="">
            </div>
        </div>

        @include('components.subscribe')

        @include('components.footer')
    </div>
</body>

</html>
