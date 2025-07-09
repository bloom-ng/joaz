<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Hair Products E-commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center font-[bricolage]">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Logo and Title -->
            <div class="text-center mb-8">
                <div class="mx-auto h-16 w-16 bg-[#85BB3F] rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-cut text-white text-2xl"></i>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Admin Login</h2>
                <p class="text-gray-600">Hair Products E-commerce Platform</p>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                            placeholder="Enter your email">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-[#85BB3F] focus:border-[#85BB3F]"
                            placeholder="Enter your password">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-[#85BB3F] focus:ring-[#85BB3F] border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[#85BB3F] hover:bg-[#85BB3F]/70 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#85BB3F] transition duration-150 ease-in-out">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-[#85BB3F] group-hover:text-[#85BB3F]/60"></i>
                        </span>
                        Sign In
                    </button>
                </div>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('home') }}" class="font-medium text-[#85BB3F] hover:text-[#85BB3F]">
                        ← Back to Home
                    </a>
                </p>
            </div>
        </div>

        <!-- Demo Credentials -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <h3 class="text-sm font-medium text-blue-800 mb-2">Demo Credentials:</h3>
            <div class="text-xs text-blue-700 space-y-1">
                <p><strong>Email:</strong> admin@example.com</p>
                <p><strong>Password:</strong> password</p>
            </div>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('ring-2', 'ring-[#85BB3F]');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('ring-2', 'ring-[#85BB3F]');
                });
            });
        });
    </script>
</body>

</html>
