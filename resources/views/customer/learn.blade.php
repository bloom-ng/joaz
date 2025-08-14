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
    <div class="flex flex-col">
        @include('components.header')
        <div class="text-center flex flex-col">
            <h1
                class="text-[110px] font-rustler font-light text-transparent bg-clip-text bg-[linear-gradient(89.8deg,#212121_-12.04%,#85BB3F_104.11%)]">
                HAIR CARE TIPS
            </h1>
            <div class="flex flex-row justify-center px-16">
                <img src="/images/haircare.png" alt="">
            </div>
        </div>
        <div class="text-center flex flex-col pt-16 pb-10 px-16">
            <h1 class="font-rustler text-4xl pb-10">RECENT POSTS</h1>
            <div class="flex flex-row justify-center gap-4">
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/product1.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">Shiny french curls extension after 3 weeks? Here’s how...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/curly.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">The secret to having a bouncy spring twist...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/product4.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">Shiny french curls extension after 3 weeks? Here’s how...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center flex flex-col pt-16 pb-10 px-16">
            <h1 class="font-rustler text-4xl pb-10">MORE POSTS</h1>
            <div class="grid grid-cols-3 justify-center gap-x-4 gap-y-8">
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/product1.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">Shiny french curls extension after 3 weeks? Here’s how...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/curly.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">The secret to having a bouncy spring twist...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/product4.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">Shiny french curls extension after 3 weeks? Here’s how...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/curly.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">The secret to having a bouncy spring twist...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/product1.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">Shiny french curls extension after 3 weeks? Here’s how...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
                <div class="flex text-left flex-col gap-2">
                    <img src="/images/product4.png" alt="">
                    <h1 class="text-md leading-[18px] pt-2 pr-20 font-bricolage">Shiny french curls extension after 3 weeks? Here’s how...</h1>
                    <div class="flex flex-row items-start">
                        <a href="#">
                            <p class="text-md font-semibold font-bricolage border-b-[1px] border-[#212121]">READ MORE</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @include('components.subscribe')

        @include('components.footer')
    </div>
</body>

</html>
