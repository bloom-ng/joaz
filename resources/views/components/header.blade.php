<div class="flex flex-row text-[#212121] items-center font-bricolage px-16 py-8 justify-between">
    <a href="/">
        <div>
            <img class="w-12 h-12" src="/images/logo.png" alt="">
        </div>
    </a>
    <div class="flex flex-row items-center gap-11 text-md font-semibold">
        @auth
            <div>
                <img class="h-4" src="/images/profile.png" alt="">
            </div>
        @endauth
        <div>
            <a href="/">HOME</a>
        </div>
        <div>
            <a href="{{ route('shop.categories') }}">SHOP</a>
        </div>
        <div>
            <a href="">LEARN</a>
        </div>
        <div>
            <a href="">CONTACT US</a>
        </div>
        <div>
            <img class="h-5" src="/images/cart.png" alt="">
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
