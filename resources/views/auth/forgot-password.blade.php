<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Joaz Hair</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
            extend: {
                fontFamily: {
                bricolage: ['"Bricolage Grotesque"', 'sans-serif'],
                }
            }
            }
        }
    </script>
</head>
<body class="h-screen font-bricolage md:overflow-hidden">
    <div class="flex flex-col md:flex-row">
        <!-- Mobile Promotional Image (hidden on md and above) -->
        <div class="w-full h-[40vh] md:hidden">
            <img src="/images/models-left.png" alt="" class="w-full h-full hidden md:block object-cover">
            <img src="/images/models-left-mobile.png" alt="" class="w-full h-full block md:hidden object-cover">
        </div>
        <!-- Mobile Forgot Password Form (hidden on md and above) -->
        <div class="flex flex-col h-[60vh] w-full  items-center bg-white pt-10 p-4 md:hidden">
            <div class="flex flex-col gap-4 w-full max-w-sm justify-center items-center">
                <div><img class="w-10 h-12" src="/images/logo-2.png" alt=""></div>
                <h1 class="text-lg font-bold pb-2 text-center">Forgot your password?</h1>
                <p class="text-black font-light text-center mb-4 leading-5 text-sm">
                    Enter your email address and a password reset link will be sent to your email address
                </p>
                <div class="flex flex-col gap-3 w-full justify-center">
                    @if (session('status'))
                        <div class="text-green-600 text-sm text-center mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="text-red-600 text-sm text-center mb-4">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    <form class="flex flex-col justify-between h-full gap-4 w-full" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="flex flex-col gap-3 w-full">
                            <input 
                                type="email" 
                                name="email" 
                                id="email-mobile" 
                                class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                placeholder="Email address"
                                value="{{ old('email') }}"
                                required
                            >
                        </div>
                        <div class="flex flex-row mt-[10%] pb-8 justify-center pt-2 items-center">
                            <button 
                                type="submit" 
                                class="w-full text-md py-3 text-white rounded-lg" 
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            >
                                SEND ME LINK
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Desktop Forgot Password Form (hidden on mobile) -->
        <div class="hidden md:flex min-h-screen font-bricolage bg-[#FCFCFC] items-center justify-center p-4 w-full">
            <div class="w-full max-w-lg">
                <div class="flex flex-col gap-3 w-full justify-center items-center border border-[#21212199/70] px-16 rounded-xl p-8">
                    <div><img class="w-12 h-14" src="/images/logo-2.png" alt=""></div>
                    <h1 class="text-xl font-bold pb-3 text-center">Forgot your password?</h1>
                    <p class="text-black font-light text-center mb-6 leading-5">
                        Enter your email address and a password reset link will be sent to your email address
                    </p>
                    <div class="flex flex-col gap-2 w-full justify-center">
                        @if (session('status'))
                            <div class="text-green-600 text-sm text-center mb-4">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="text-red-600 text-sm text-center mb-4">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form class="flex flex-col justify-center gap-2 w-full" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="flex flex-col gap-2 w-full">
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email-desktop" 
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                    placeholder="Email address"
                                    value="{{ old('email') }}"
                                    required
                                >
                                <div class="flex flex-row justify-center pt-4 items-center">
                                    <button 
                                        type="submit" 
                                        class="w-full text-md py-4 text-white rounded-lg p-2" 
                                        style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                                    >
                                        SEND ME LINK
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
