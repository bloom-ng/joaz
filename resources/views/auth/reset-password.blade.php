<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Joaz Hair</title>
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
        <!-- Mobile Reset Password Form (hidden on md and above) -->
        <div class="flex flex-col h-[60vh] w-full  items-center bg-white pt-10 p-4 md:hidden">
            <div class="flex flex-col gap-4 w-full max-w-sm justify-center items-center">
                <div><img class="w-10 h-12" src="/images/logo-2.png" alt=""></div>
                <h1 class="text-lg font-bold pb-2 text-center">Reset your password</h1>
                <div class="flex flex-col gap-3 w-full justify-center">
                    <form class="flex flex-col justify-between h-full gap-4 w-full" action="">
                        <div class="flex flex-col gap-3 w-full">
                            <!-- Old Password Field -->
                            <div class="flex flex-row justify-between relative">
                                <input 
                                    type="password" 
                                    name="old_password" 
                                    id="old_password-mobile" 
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                    placeholder="Old password"
                                >
                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer" src="/images/eye.png" alt="" onclick="togglePassword('old_password-mobile')">
                            </div>

                            <!-- New Password Field -->
                            <div class="flex flex-row justify-between relative">
                                <input 
                                    type="password" 
                                    name="new_password" 
                                    id="new_password-mobile" 
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                    placeholder="New password"
                                >
                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer" src="/images/eye.png" alt="" onclick="togglePassword('new_password-mobile')">
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="flex flex-row justify-between relative">
                                <input 
                                    type="password" 
                                    name="confirm_password" 
                                    id="confirm_password-mobile" 
                                    class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-3"
                                    placeholder="Confirm password"
                                >
                                <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer" src="/images/eye.png" alt="" onclick="togglePassword('confirm_password-mobile')">
                            </div>
                        </div>
                        <div class="flex flex-row mt-[10%] pb-8 justify-center pt-2 items-center">
                            <button 
                                type="submit" 
                                class="w-full text-md py-3 text-white rounded-lg" 
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            >
                                RESET PASSWORD
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Desktop Reset Password Form (hidden on mobile) -->
        <div class="hidden md:flex min-h-screen font-bricolage bg-[#FCFCFC] items-center justify-center p-4 w-full">
            <div class="w-full max-w-lg">
                <div class="flex flex-col gap-3 w-full justify-center items-center border border-[#21212199/70] px-16 rounded-xl p-8">
                    <div><img class="w-12 h-14" src="/images/logo-2.png" alt=""></div>
                    <h1 class="text-xl font-bold pb-3 text-center">Reset your password</h1>
                    <div class="flex flex-col gap-2 w-full justify-center">
                        <form class="flex flex-col justify-center gap-2 w-full" action="">
                            <div class="flex flex-col gap-2 w-full">
                                <!-- Old Password Field -->
                                <div class="flex flex-row justify-between relative">
                                    <input 
                                        type="password" 
                                        name="old_password" 
                                        id="old_password-desktop" 
                                        class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                        placeholder="Old password"
                                    >
                                    <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer" src="/images/eye.png" alt="" onclick="togglePassword('old_password-desktop')">
                                </div>

                                <!-- New Password Field -->
                                <div class="flex flex-row justify-between relative">
                                    <input 
                                        type="password" 
                                        name="new_password" 
                                        id="new_password-desktop" 
                                        class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                        placeholder="New password"
                                    >
                                    <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer" src="/images/eye.png" alt="" onclick="togglePassword('new_password-desktop')">
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="flex flex-row justify-between relative">
                                    <input 
                                        type="password" 
                                        name="confirm_password" 
                                        id="confirm_password-desktop" 
                                        class="bg-white w-full border border-[#212121/80] rounded-md placeholder-[#212121/60] p-2 py-2.5"
                                        placeholder="Confirm password"
                                    >
                                    <img class="absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer" src="/images/eye.png" alt="" onclick="togglePassword('confirm_password-desktop')">
                                </div>

                                <!-- Submit Button -->
                                <div class="flex flex-row justify-center pt-4 items-center">
                                    <button 
                                        type="submit" 
                                        class="w-full text-md py-4 text-white rounded-lg p-2" 
                                        style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                                    >
                                        RESET PASSWORD
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html> 