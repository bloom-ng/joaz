<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Joaz Hair Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-[bricolage]">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-[#85BB3F] rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 01-8 0m8 0a4 4 0 00-8 0m8 0V5a4 4 0 00-8 0v2m8 0v2a4 4 0 01-8 0V7"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                <p class="text-gray-600">Register to start shopping</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                        class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                        placeholder="Enter your name">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                        class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                        placeholder="Enter your email">
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input id="phone" name="phone" type="text" required value="{{ old('phone') }}"
                        class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                        placeholder="Enter your phone number">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required
                        class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                        placeholder="Enter your password">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="block w-full px-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                        placeholder="Confirm your password">
                </div>
                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#85BB3F] hover:bg-[#85BB3F]/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#85BB3F] transition duration-150 ease-in-out">
                        Register
                    </button>
                </div>
            </form>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('admin.login') }}" class="font-medium text-[#85BB3F] hover:text-[#85BB3F]">Sign In</a>
                </p>
                <p class="text-sm text-gray-600 mt-2">
                    <a href="{{ route('home') }}" class="font-medium text-[#85BB3F] hover:text-[#85BB3F]">← Back to Home</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
