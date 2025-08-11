<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style></style>
    @endif
    <title>Joaz Hair Products Admin Panel</title>
</head>

<body class="bg-gray-100 flex w-full">
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "green",
                stopOnFocus: true,
                ariaLive: "polite",
                onClick: function() {}
            }).showToast();
        </script>
    @endif
    @if (session('error'))
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        <script>
            Toastify({
                text: "{{ session('error') }}",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "red",
                stopOnFocus: true,
                ariaLive: "polite",
                onClick: function() {}
            }).showToast();
        </script>
    @endif
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
        @foreach ($errors->all() as $error)
            <script>
                Toastify({
                    text: "{{ $error }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "red",
                    stopOnFocus: true,
                    ariaLive: "polite",
                    onClick: function() {}
                }).showToast();
            </script>
        @endforeach
    @endif

    <!-- side bar -->
    <aside class="relative bg-[#ffffff] h-screen w-[20%] hidden lg:block">
        <div class="p-6">
            <img src="/images/logo.png" alt="logo" class="h-14 w-42">
        </div>
        <nav class="text-white text-xs font-semibold">
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.dashboard'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="mr-3">
                        <mask id="mask0_38_1068" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                            width="25" height="25">
                            <rect x="0.5" y="0.25" width="24" height="24" fill="white" />
                        </mask>
                        <g mask="url(#mask0_38_1068)">
                            <path
                                d="M10.7529 6.13434L11.0313 10.2743L11.1695 12.3551C11.171 12.5691 11.2045 12.7817 11.2692 12.986C11.4361 13.3826 11.8377 13.6346 12.2746 13.617L18.9318 13.1815C19.2201 13.1768 19.4985 13.2846 19.7057 13.4813C19.8784 13.6452 19.9899 13.8596 20.0251 14.0902L20.0369 14.2302C19.7614 18.0449 16.9597 21.2267 13.1529 22.048C9.34604 22.8693 5.44235 21.1343 3.5612 17.7849C3.01888 16.8118 2.68014 15.7423 2.56487 14.639C2.51672 14.3124 2.49552 13.9825 2.50147 13.6525C2.49552 9.56273 5.40796 6.02696 9.48482 5.17457C9.9755 5.09816 10.4565 5.35792 10.6533 5.80553C10.7042 5.90919 10.7378 6.02021 10.7529 6.13434Z"
                                fill="white" />
                            <path opacity="0.4"
                                d="M22.5 10.0622L22.493 10.0948L22.4728 10.1422L22.4756 10.2723C22.4652 10.4446 22.3986 10.6104 22.284 10.7444C22.1645 10.8839 22.0013 10.9789 21.8216 11.0158L21.712 11.0308L14.0312 11.5285C13.7757 11.5537 13.5213 11.4713 13.3314 11.3019C13.173 11.1606 13.0718 10.97 13.0432 10.7646L12.5277 3.095C12.5187 3.06907 12.5187 3.04096 12.5277 3.01502C12.5347 2.80361 12.6278 2.60378 12.7861 2.46017C12.9443 2.31656 13.1547 2.24114 13.37 2.25076C17.9299 2.36677 21.7623 5.64573 22.5 10.0622Z"
                                fill="white" />
                        </g>
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <mask id="mask0_58_4494" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                            width="25" height="25">
                            <rect x="0.5" y="0.25" width="24" height="24" fill="white" />
                        </mask>
                        <g mask="url(#mask0_58_4494)">
                            <path
                                d="M10.7524 6.13434L11.0308 10.2743L11.169 12.3551C11.1705 12.5691 11.204 12.7817 11.2687 12.986C11.4356 13.3826 11.8372 13.6346 12.2741 13.617L18.9313 13.1815C19.2196 13.1768 19.498 13.2846 19.7052 13.4813C19.8779 13.6452 19.9894 13.8596 20.0246 14.0902L20.0364 14.2302C19.7609 18.0449 16.9592 21.2267 13.1524 22.048C9.34555 22.8693 5.44186 21.1343 3.56071 17.7849C3.01839 16.8118 2.67965 15.7423 2.56438 14.639C2.51623 14.3124 2.49503 13.9825 2.50098 13.6525C2.49503 9.56273 5.40747 6.02696 9.48433 5.17457C9.97501 5.09816 10.456 5.35792 10.6528 5.80553C10.7037 5.90919 10.7373 6.02021 10.7524 6.13434Z"
                                fill="#222222" fill-opacity="0.7" />
                            <path opacity="0.4"
                                d="M22.5005 10.0622L22.4935 10.0948L22.4733 10.1422L22.4761 10.2723C22.4657 10.4446 22.3991 10.6104 22.2845 10.7444C22.165 10.8839 22.0018 10.9789 21.8221 11.0158L21.7125 11.0308L14.0317 11.5285C13.7762 11.5537 13.5218 11.4713 13.3319 11.3019C13.1735 11.1606 13.0723 10.97 13.0437 10.7646L12.5282 3.095C12.5192 3.06907 12.5192 3.04096 12.5282 3.01502C12.5352 2.80361 12.6283 2.60378 12.7866 2.46017C12.9448 2.31656 13.1552 2.24114 13.3705 2.25076C17.9304 2.36677 21.7628 5.64573 22.5005 10.0622Z"
                                fill="#222222" fill-opacity="0.7" />
                        </g>
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.dashboard') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Dashboard</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
                class="{{ request()->routeIs('admin.products.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.products.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white" />
                        <path d="M2 17L12 22L22 17" fill="white" />
                        <path d="M2 12L12 17L22 12" fill="white" />
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#222222" fill-opacity="0.7" />
                        <path d="M2 17L12 22L22 17" fill="#222222" fill-opacity="0.7" />
                        <path d="M2 12L12 17L22 12" fill="#222222" fill-opacity="0.7" />
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.products.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Products</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.categories.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3H10V10H3V3Z" fill="white" />
                        <path d="M15 3H22V10H15V3Z" fill="white" />
                        <path d="M3 15H10V22H3V15Z" fill="white" />
                        <path d="M15 15H22V22H15V15Z" fill="white" />
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 3H10V10H3V3Z" fill="#222222" fill-opacity="0.7" />
                        <path d="M15 3H22V10H15V3Z" fill="#222222" fill-opacity="0.7" />
                        <path d="M3 15H10V22H3V15Z" fill="#222222" fill-opacity="0.7" />
                        <path d="M15 15H22V22H15V15Z" fill="#222222" fill-opacity="0.7" />
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.categories.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Categories</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
                class="{{ request()->routeIs('admin.orders.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.orders.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                            stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            stroke-opacity="0.7" />
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.orders.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Orders</span>
            </a>

            <a href="{{ route('admin.customers.index') }}"
                class="{{ request()->routeIs('admin.customers.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.customers.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9ZM19 21H5V3H13V9H19V21Z"
                            fill="white" />
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9ZM19 21H5V3H13V9H19V21Z"
                            fill="#222222" fill-opacity="0.7" />
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.customers.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Customers</span>
            </a>

            <a href="{{ route('admin.transactions.index') }}"
                class="{{ request()->routeIs('admin.transactions.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.transactions.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white" />
                        <path d="M2 17L12 22L22 17" fill="white" />
                        <path d="M2 12L12 17L22 12" fill="white" />
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#222222" fill-opacity="0.7" />
                        <path d="M2 17L12 22L22 17" fill="#222222" fill-opacity="0.7" />
                        <path d="M2 12L12 17L22 12" fill="#222222" fill-opacity="0.7" />
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.transactions.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Transactions</span>
            </a>

            <a href="{{ route('admin.vouchers.index') }}"
                class="{{ request()->routeIs('admin.vouchers.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.vouchers.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 5H3C1.9 5 1 5.9 1 7V17C1 18.1 1.9 19 3 19H21C22.1 19 23 18.1 23 17V7C23 5.9 22.1 5 21 5ZM21 17H3V7H21V17Z"
                            fill="white" />
                        <path d="M7 9H17V11H7V9Z" fill="white" />
                        <path d="M7 13H17V15H7V13Z" fill="white" />
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21 5H3C1.9 5 1 5.9 1 7V17C1 18.1 1.9 19 3 19H21C22.1 19 23 18.1 23 17V7C23 5.9 22.1 5 21 5ZM21 17H3V7H21V17Z"
                            fill="#222222" fill-opacity="0.7" />
                        <path d="M7 9H17V11H7V9Z" fill="#222222" fill-opacity="0.7" />
                        <path d="M7 13H17V15H7V13Z" fill="#222222" fill-opacity="0.7" />
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.vouchers.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Vouchers</span>
            </a>

            <a href="{{ route('admin.reviews.index') }}"
                class="{{ request()->routeIs('admin.reviews.*') ? 'flex items-center py-[12px] px-5 bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl ml-8 shadow-md mt-7 mr-4 font-[bricolage]' : 'flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]' }}">
                @if (request()->routeIs('admin.reviews.*'))
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="white"/>
                    </svg>
                @else
                    <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z" fill="#222222" fill-opacity="0.7"/>
                    </svg>
                @endif
                <span
                    class="pl-5 text-[13.5px] {{ request()->routeIs('admin.reviews.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Reviews</span>
            </a>

            <form method="POST" action="{{ route('admin.logout') }}"
                class="flex items-center py-2 px-8 text-gray-600 mt-7 font-[bricolage]">
                @csrf
                <button type="submit" class="flex items-start">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.8308 14.9008L18.2526 10.9083C18.416 10.7219 18.4996 10.4866 18.4998 10.25C18.4998 10.0882 18.4608 9.92571 18.3816 9.77797C18.3464 9.71213 18.3033 9.64958 18.2526 9.59173L14.8308 5.59921C14.4714 5.17986 13.8401 5.13127 13.4208 5.49066C13.0015 5.85006 12.9529 6.48136 13.3123 6.90071L15.3257 9.24995L7.58103 9.24995C7.02875 9.24995 6.58103 9.69767 6.58103 10.25C6.58103 10.8022 7.02875 11.25 7.58103 11.25L15.3258 11.25L13.3123 13.5993C12.9529 14.0187 13.0015 14.65 13.4208 15.0094C13.8401 15.3688 14.4714 15.3202 14.8308 14.9008ZM8.49976 4.24994C9.05204 4.24994 9.49976 4.69765 9.49976 5.24994L9.49976 6.74994C9.49976 7.30222 9.94747 7.74994 10.4998 7.74994C11.052 7.74994 11.4998 7.30222 11.4998 6.74994L11.4998 5.24994C11.4998 3.59308 10.1566 2.24994 8.49976 2.24994L5.49976 2.24994C3.8429 2.24994 2.49976 3.59308 2.49976 5.24994L2.49976 15.2499C2.49976 16.9068 3.8429 18.2499 5.49976 18.2499L8.49976 18.2499C10.1566 18.2499 11.4998 16.9068 11.4998 15.2499L11.4998 13.7499C11.4998 13.1977 11.052 12.7499 10.4998 12.7499C9.94747 12.7499 9.49976 13.1977 9.49976 13.7499L9.49976 15.2499C9.49976 15.8022 9.05204 16.2499 8.49976 16.2499L5.49976 16.2499C4.94747 16.2499 4.49976 15.8022 4.49976 15.2499L4.49976 5.24994C4.49976 4.69765 4.94747 4.24994 5.49976 4.24994L8.49976 4.24994Z"
                            fill="#B22234" />
                    </svg>
                    <span class="pl-5 text-[13.5px] text-[#B22234]">Sign Out</span>
                </button>
            </form>
        </nav>
    </aside>
    <!-- /side bar -->

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden lg:flex justify-between">
            <div class="w-full flex flex-row justify-between">
                <p class=" text-[#222222] text-[30px] ml-4"></p>
                <div class="flex">
                    <img src="https://ui-avatars.com/api/?color=fff&background=85BB3F&name={{ auth()->user()->name }}"
                        alt="User" class="w-[45px] h-[45px] rounded-full font-[RustlerBarter]">
                    <div class="ml-2">
                        <p class="text-[12px] text-[#222222] font-[bricolage]">{{ auth()->user()->name }}</p>
                        <p class="text-[10.5px] text-[#22222280] font-[bricolage]">Account</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- /desktop header -->

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-[#ffffff] py-5 px-6 lg:hidden">
            <div class="flex items-center justify-between">
                <a href="/">
                    <img class="w-[110px] lg:w-16" src="/images/logo.png" alt="logo" /></a>

                <button @click="isOpen = !isOpen" class="text-black text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex' : 'hidden'" class="w-full flex flex-col pt-4">

                <a href="{{ route('admin.dashboard') }}"
                    class="{{ request()->routeIs('admin.dashboard') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.dashboard'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="mr-3">
                            <mask id="mask0_38_1068" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0"
                                y="0" width="25" height="25">
                                <rect x="0.5" y="0.25" width="24" height="24" fill="white" />
                            </mask>
                            <g mask="url(#mask0_38_1068)">
                                <path
                                    d="M10.7529 6.13434L11.0313 10.2743L11.1695 12.3551C11.171 12.5691 11.2045 12.7817 11.2692 12.986C11.4361 13.3826 11.8377 13.6346 12.2746 13.617L18.9318 13.1815C19.2201 13.1768 19.4985 13.2846 19.7057 13.4813C19.8784 13.6452 19.9899 13.8596 20.0251 14.0902L20.0369 14.2302C19.7614 18.0449 16.9597 21.2267 13.1529 22.048C9.34604 22.8693 5.44235 21.1343 3.5612 17.7849C3.01888 16.8118 2.68014 15.7423 2.56487 14.639C2.51672 14.3124 2.49552 13.9825 2.50147 13.6525C2.49552 9.56273 5.40796 6.02696 9.48482 5.17457C9.9755 5.09816 10.4565 5.35792 10.6533 5.80553C10.7042 5.90919 10.7378 6.02021 10.7529 6.13434Z"
                                    fill="white" />
                                <path opacity="0.4"
                                    d="M22.5 10.0622L22.493 10.0948L22.4728 10.1422L22.4756 10.2723C22.4652 10.4446 22.3986 10.6104 22.284 10.7444C22.1645 10.8839 22.0013 10.9789 21.8216 11.0158L21.712 11.0308L14.0312 11.5285C13.7757 11.5537 13.5213 11.4713 13.3314 11.3019C13.173 11.1606 13.0718 10.97 13.0432 10.7646L12.5277 3.095C12.5187 3.06907 12.5187 3.04096 12.5277 3.01502C12.5347 2.80361 12.6278 2.60378 12.7861 2.46017C12.9443 2.31656 13.1547 2.24114 13.37 2.25076C17.9299 2.36677 21.7623 5.64573 22.5 10.0622Z"
                                    fill="white" />
                            </g>
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <mask id="mask0_58_4494" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0"
                                y="0" width="25" height="25">
                                <rect x="0.5" y="0.25" width="24" height="24" fill="white" />
                            </mask>
                            <g mask="url(#mask0_58_4494)">
                                <path
                                    d="M10.7524 6.13434L11.0308 10.2743L11.169 12.3551C11.1705 12.5691 11.204 12.7817 11.2687 12.986C11.4356 13.3826 11.8372 13.6346 12.2741 13.617L18.9313 13.1815C19.2196 13.1768 19.498 13.2846 19.7052 13.4813C19.8779 13.6452 19.9894 13.8596 20.0246 14.0902L20.0364 14.2302C19.7609 18.0449 16.9592 21.2267 13.1524 22.048C9.34555 22.8693 5.44186 21.1343 3.56071 17.7849C3.01839 16.8118 2.67965 15.7423 2.56438 14.639C2.51623 14.3124 2.49503 13.9825 2.50098 13.6525C2.49503 9.56273 5.40747 6.02696 9.48433 5.17457C9.97501 5.09816 10.456 5.35792 10.6528 5.80553C10.7037 5.90919 10.7373 6.02021 10.7524 6.13434Z"
                                    fill="#222222" fill-opacity="0.7" />
                                <path opacity="0.4"
                                    d="M22.5005 10.0622L22.4935 10.0948L22.4733 10.1422L22.4761 10.2723C22.4657 10.4446 22.3991 10.6104 22.2845 10.7444C22.165 10.8839 22.0018 10.9789 21.8221 11.0158L21.7125 11.0308L14.0317 11.5285C13.7762 11.5537 13.5218 11.4713 13.3319 11.3019C13.1735 11.1606 13.0723 10.97 13.0437 10.7646L12.5282 3.095C12.5192 3.06907 12.5192 3.04096 12.5282 3.01502C12.5352 2.80361 12.6283 2.60378 12.7866 2.46017C12.9448 2.31656 13.1552 2.24114 13.3705 2.25076C17.9304 2.36677 21.7628 5.64573 22.5005 10.0622Z"
                                    fill="#222222" fill-opacity="0.7" />
                            </g>
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.dashboard') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="{{ request()->routeIs('admin.products.*') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.products.*'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white" />
                            <path d="M2 17L12 22L22 17" fill="white" />
                            <path d="M2 12L12 17L22 12" fill="white" />
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#222222" fill-opacity="0.7" />
                            <path d="M2 17L12 22L22 17" fill="#222222" fill-opacity="0.7" />
                            <path d="M2 12L12 17L22 12" fill="#222222" fill-opacity="0.7" />
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.products.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Products</span>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories.*') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.categories.*'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3H10V10H3V3Z" fill="white" />
                            <path d="M15 3H22V10H15V3Z" fill="white" />
                            <path d="M3 15H10V22H3V15Z" fill="white" />
                            <path d="M15 15H22V22H15V15Z" fill="white" />
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3H10V10H3V3Z" fill="#222222" fill-opacity="0.7" />
                            <path d="M15 3H22V10H15V3Z" fill="#222222" fill-opacity="0.7" />
                            <path d="M3 15H10V22H3V15Z" fill="#222222" fill-opacity="0.7" />
                            <path d="M15 15H22V22H15V15Z" fill="#222222" fill-opacity="0.7" />
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.categories.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Categories</span>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->routeIs('admin.orders.*') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.orders.*'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                stroke="#222222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                stroke-opacity="0.7" />
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.orders.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Orders</span>
                </a>

                <a href="{{ route('admin.customers.index') }}"
                    class="{{ request()->routeIs('admin.customers.*') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.customers.*'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9ZM19 21H5V3H13V9H19V21Z"
                                fill="white" />
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.9 1 3 1.9 3 3V21C3 22.1 3.9 23 5 23H19C20.1 23 21 22.1 21 21V9ZM19 21H5V3H13V9H19V21Z"
                                fill="#222222" fill-opacity="0.7" />
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.customers.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Customers</span>
                </a>

                <a href="{{ route('admin.transactions.index') }}"
                    class="{{ request()->routeIs('admin.transactions.*') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.transactions.*'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="white" />
                            <path d="M2 17L12 22L22 17" fill="white" />
                            <path d="M2 12L12 17L22 12" fill="white" />
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" fill="#222222" fill-opacity="0.7" />
                            <path d="M2 17L12 22L22 17" fill="#222222" fill-opacity="0.7" />
                            <path d="M2 12L12 17L22 12" fill="#222222" fill-opacity="0.7" />
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.transactions.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Transactions</span>
                </a>

                <a href="{{ route('admin.vouchers.index') }}"
                    class="{{ request()->routeIs('admin.vouchers.*') ? 'flex items-center py-2 pl-4 nav-item bg-gradient-to-r from-[#85BB3F] to-[#2B2B2B] text-white rounded-xl shadow-md font-[bricolage]' : 'flex items-center py-2 pl-4 nav-item text-gray-600 font-[bricolage]' }}">
                    @if (request()->routeIs('admin.vouchers.*'))
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 5H3C1.9 5 1 5.9 1 7V17C1 18.1 1.9 19 3 19H21C22.1 19 23 18.1 23 17V7C23 5.9 22.1 5 21 5ZM21 17H3V7H21V17Z"
                                fill="white" />
                            <path d="M7 9H17V11H7V9Z" fill="white" />
                            <path d="M7 13H17V15H7V13Z" fill="white" />
                        </svg>
                    @else
                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 5H3C1.9 5 1 5.9 1 7V17C1 18.1 1.9 19 3 19H21C22.1 19 23 18.1 23 17V7C23 5.9 22.1 5 21 5ZM21 17H3V7H21V17Z"
                                fill="#222222" fill-opacity="0.7" />
                            <path d="M7 9H17V11H7V9Z" fill="#222222" fill-opacity="0.7" />
                            <path d="M7 13H17V15H7V13Z" fill="#222222" fill-opacity="0.7" />
                        </svg>
                    @endif
                    <span
                        class="pl-5 text-[13.5px] {{ request()->routeIs('admin.vouchers.*') ? 'text-[#ffffff]' : 'text-[#222222B2]' }}">Vouchers</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}"
                    class="flex items-center py-2 pl-4 nav-item text-[#B22234]">
                    @csrf
                    <button type="submit" class="flex items-center">
                        <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="mr-3">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.8308 14.9008L18.2526 10.9083C18.416 10.7219 18.4996 10.4866 18.4998 10.25C18.4998 10.0882 18.4608 9.92571 18.3816 9.77797C18.3464 9.71213 18.3033 9.64958 18.2526 9.59173L14.8308 5.59921C14.4714 5.17986 13.8401 5.13127 13.4208 5.49066C13.0015 5.85006 12.9529 6.48136 13.3123 6.90071L15.3257 9.24995L7.58103 9.24995C7.02875 9.24995 6.58103 9.69767 6.58103 10.25C6.58103 10.8022 7.02875 11.25 7.58103 11.25L15.3258 11.25L13.3123 13.5993C12.9529 14.0187 13.0015 14.65 13.4208 15.0094C13.8401 15.3688 14.4714 15.3202 14.8308 14.9008ZM8.49976 4.24994C9.05204 4.24994 9.49976 4.69765 9.49976 5.24994L9.49976 6.74994C9.49976 7.30222 9.94747 7.74994 10.4998 7.74994C11.052 7.74994 11.4998 7.30222 11.4998 6.74994L11.4998 5.24994C11.4998 3.59308 10.1566 2.24994 8.49976 2.24994L5.49976 2.24994C3.8429 2.24994 2.49976 3.59308 2.49976 5.24994L2.49976 15.2499C2.49976 16.9068 3.8429 18.2499 5.49976 18.2499L8.49976 18.2499C10.1566 18.2499 11.4998 16.9068 11.4998 15.2499L11.4998 13.7499C11.4998 13.1977 11.052 12.7499 10.4998 12.7499C9.94747 12.7499 9.49976 13.1977 9.49976 13.7499L9.49976 15.2499C9.49976 15.8022 9.05204 16.2499 8.49976 16.2499L5.49976 16.2499C4.94747 16.2499 4.49976 15.8022 4.49976 15.2499L4.49976 5.24994C4.49976 4.69765 4.94747 4.24994 5.49976 4.24994L8.49976 4.24994Z"
                                fill="#B22234" />
                        </svg>
                        <span class="pl-5 text-[13.5px] text-[#B22234]">Sign Out</span>
                    </button>
                </form>

            </nav>
        </header>
        <!-- /mobile header -->

        <!-- content -->
        <div class="w-full flex flex-col overflow-y-scroll p-7">
            @yield('content')
        </div>
        <!-- /content -->
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    @stack('scripts')
</body>

</html>
