<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Signup - Joaz Hair</title>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;500;700&display=swap"
        rel="stylesheet">
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="h-screen font-bricolage md:overflow-hidden">
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-[45%] h-[40vh] md:h-screen">
            <img src="/images/models-left.png" alt="" class="w-full h-full hidden md:block object-cover">
            <img src="/images/models-left-mobile.png" alt="" class="w-full h-full block md:hidden object-cover">
        </div>

        <!-- Mobile Signup Form (hidden on md and above) -->
        <div class="flex flex-col h-[60vh] w-full items-center bg-white pt-10 p-4 md:hidden">
            <div class="flex flex-col gap-4 w-full max-w-sm justify-center items-center">
                <div><img class="w-10 h-12" src="/images/logo-2.png" alt=""></div>
                <p class="text-xl font-bold pb-2 text-center">Signup to access your account</p>
                <div class="flex flex-col gap-3 w-full justify-center">
                    <form class="flex flex-col justify-between h-full gap-4 w-full" method="POST"
                        action="{{ route("register.post") }}">
                        @csrf
                        <div class="flex flex-col gap-3 w-full">
                            <input placeholder="Name" type="text" name="name" id="name-mobile"
                                value="{{ old("name") }}"
                                class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                required>
                            @error("name")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <input placeholder="Email address" type="email" name="email" id="email-mobile"
                                value="{{ old("email") }}"
                                class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                required>
                            @error("email")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <input placeholder="Phone number" type="text" name="phone" id="phone-mobile"
                                value="{{ old("phone") }}"
                                class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                required>
                            @error("phone")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <select name="country_id" id="country-mobile"
                                class="bg-white w-full border border-[#212121/80] rounded-md p-3" required>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ old("country_id") == $country->id ? "selected" : "" }}>{{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error("country_id")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex flex-row justify-between relative">
                                <input placeholder="Password" type="password" name="password" id="password-mobile"
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                    required>
                                                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                                    src="/images/eye.png" alt="" onclick="togglePassword('password-mobile', this)">
                            </div>
                            @error("password")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex flex-row justify-between relative">
                                <input placeholder="Confirm password" type="password" name="password_confirmation"
                                    id="password_confirmation-mobile"
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                    required>
                                                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                                    src="/images/eye.png" alt=""
                                    onclick="togglePassword('password_confirmation-mobile', this)">
                            </div>
                        </div>
                        <div class="flex flex-row mt-[10%] pb-8 justify-center pt-2 items-center">
                            <button type="submit" class="w-full text-md py-3 text-white rounded-lg"
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);">
                                SIGNUP
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Desktop Signup Form (hidden on mobile) -->
        <div class="hidden md:flex flex-col h-screen w-[55%] justify-center items-center bg-white pr-10">
            <div
                class="flex flex-col gap-3 w-[90%] justify-center items-center border border-[#21212199/70] rounded-xl p-8">
                <div><img class="w-12 h-14" src="/images/logo-2.png" alt=""></div>
                <p class="text-xl font-bold pb-3">Signup to access your account</p>
                <div class="flex flex-col gap-2 w-full justify-center">
                    <form class="flex flex-col justify-center gap-2 w-full" method="POST"
                        action="{{ route("register.post") }}">
                        @csrf
                        <div class="flex flex-col gap-2 w-full px-16">
                            <input placeholder="Name" type="text" name="name" id="name-desktop"
                                value="{{ old("name") }}"
                                class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                required>
                            @error("name")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <input placeholder="Email address" type="email" name="email" id="email-desktop"
                                value="{{ old("email") }}"
                                class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                required>
                            @error("email")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex flex-row justify-between relative">
                                <select name="country_id" id="country-desktop"
                                    class="bg-white w-full border border-[#212121/80] rounded-md p-3" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old("country_id") == $country->id ? "selected" : "" }}>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                @error("country_id")
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-row justify-between relative">
                                <input placeholder="Phone number" type="text" name="phone" id="phone-desktop"
                                    value="{{ old("phone") }}"
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                    required>
                                @error("phone")
                                    <p class="text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex flex-row justify-between relative">
                                <input placeholder="Password" type="password" name="password" id="password-desktop"
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                    required>
                                                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                                    src="/images/eye.png" alt=""
                                    onclick="togglePassword('password-desktop', this)">
                            </div>
                            @error("password")
                                <p class="text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="flex flex-row justify-between relative">
                                <input placeholder="Confirm password" type="password" name="password_confirmation"
                                    id="password_confirmation-desktop"
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                    required>
                                                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                                    src="/images/eye.png" alt=""
                                    onclick="togglePassword('password_confirmation-desktop', this)">
                            </div>

                            <div class="flex flex-row justify-center pt-4 items-center">
                                <button type="submit" class="w-full text-md py-4 text-white rounded-lg p-2"
                                    style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);">
                                    SIGNUP
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function togglePassword(inputId, eyeIcon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.src = '/images/open-eye.png';
            } else {
                passwordInput.type = 'password';
                eyeIcon.src = '/images/eye.png';
            }
        }
    </script>
</body  >

</html>
