<div class="flex flex-row text-[#212121] items-center font-bricolage px-16 py-8 justify-between">
    <a href="/">
        <div>
            <img class="w-12 h-12" src="/images/logo.png" alt="">
        </div>
    </a>
    <div class="flex flex-row items-center gap-11 text-md font-semibold">
        @auth
            <div>
                <a href="{{ route('account-center') }}">
                <img class="h-4" src="/images/profile.png" alt="">
                </a>
            </div>
        @endauth
        <div>
            <a href="/">HOME</a>
        </div>
        <div>
            <a href="{{ route('shop.category') }}">SHOP</a>
        </div>
        <div>
            <a href="{{ route('learn') }}">LEARN</a>
        </div>
        <div>
            <a href="{{ route('contact-us') }}">CONTACT US</a>
        </div>
        <div>
            @auth
                <a href="{{ route('cart.index') }}#cart" class="relative">
                    <img class="h-5" src="/images/cart.png" alt="Cart">
                    @php
                        $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                        $itemCount = $cart ? $cart->items->sum('quantity') : 0;
                    @endphp
                    @if($itemCount > 0)
                        <span class="absolute -top-2 -right-2 bg-[#85BB3F] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $itemCount }}
                        </span>
                    @endif
                </a>    
            @else
                <a href="{{ route('login') }}" class="relative">
                    <img class="h-5" src="/images/cart.png" alt="Cart">
                    @if(session()->has('cart') && !empty(session('cart')['items']))
                        <span class="absolute -top-2 -right-2 bg-[#85BB3F] text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ collect(session('cart')['items'])->sum('quantity') }}
                        </span>
                    @endif
                </a>
            @endauth
        </div>
        @guest
            <a href="/signin">
                <div style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                    class="text-[#FCFCFC] px-10 py-3 rounded-lg">
                    LOGIN
                </div>
            </a>
        @endguest
    </div>
</div>
