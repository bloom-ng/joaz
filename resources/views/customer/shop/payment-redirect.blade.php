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

        /* Loading dots animation */
        .dot {
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .dot-1 {
            animation-delay: -0.32s;
        }
        .dot-2 {
            animation-delay: -0.16s;
        }
        @keyframes bounce {
            0%, 80%, 100% {
                transform: scale(0);
            }
            40% {
                transform: scale(1.0);
            }
        }
    </style>

    <!-- Load Bricolage Grotesque from Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap" rel="stylesheet">

    <title>Redirecting - JOAZ</title>
</head>
<body class="bg-[#FCFCFC] text-[#212121]">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        <main class="flex-grow flex flex-col items-center h-[80vh] justify-center text-center">
            <div class="flex justify-center items-center space-x-2 mb-8">
                <div class="dot dot-1 w-4 h-4 bg-[#212121] rounded-full"></div>
                <div class="dot dot-2 w-4 h-4 bg-[#546D32] rounded-full"></div>
                <div class="dot dot-3 w-4 h-4 bg-[#85BB3F] rounded-full"></div>
            </div>
            <h1 class="font-bricolage text-4xl font-bold">You will be redirected shortly to our</h1>
            <h1 class="font-bricolage text-4xl font-bold">payment platform ...</h1>
        </main>
        <form id="paystackForm" action="{{ route('payment.initialize') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
        </form>

        @include('components.footer')
    </div>
</body>
</html>
<script>
    setTimeout(function(){
        document.getElementById('paystackForm').submit();
    }, 5000);
</script>

