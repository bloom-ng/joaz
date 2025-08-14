<!-- subscribe section -->
<div class="bg-[#212121] flex flex-col justify-center items-center">
    <div class="flex flex-row w-full h-[85vh] p-16 justify-center items-center">
        <div class="w-1/2 h-full">
            <img src="/images/models2.png" alt="" class="w-full h-full object-cover">
        </div>
        <div class="flex -ml-[1%] flex-col items-center justify-center h-full w-1/2 bg-[#FCFCFC] px-16">
            <div class="flex flex-col gap-2 w-full max-w-md justify-center items-center">
                <div><img class="w-12 h-14" src="/images/logo-2.png" alt=""></div>
                <h1 class="text-3xl font-meduim text-center font-rustler">MAINTAIN YOUR HAIR EXTENSIONS</h1>
                <p class="text-black font-bricolage pb-5 text-center px-2 leading-5">
                    Learn how to maintain your hair extensions by subscribing to our newsletter.
                </p>
                <div class="flex flex-col gap-4 w-full justify-center">
                    <form class="flex flex-col gap-4 w-full" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ $errors->first() }}</span>
                            </div>
                        @endif
                        <div class="flex flex-col pb-5 gap-4 w-full">
                            <input 
                                type="email" 
                                name="email" 
                                value="{{ old('email', auth()->user()->email ?? '') }}"
                                class="bg-[#FCFCFC] w-full border border-[#212121]/80 rounded-md placeholder-[#212121]/60 py-2.5 p-3"
                                placeholder="Email address"
                                required
                            >
                        </div>
                        <div class="flex flex-row justify-center pt-2 items-center">
                            <button 
                                type="submit" 
                                class="w-full text-md py-3 text-white rounded-lg hover:opacity-90 transition-opacity" 
                                style="background: linear-gradient(91.36deg, #85BB3F 0%, #212121 162.21%);"
                            >
                                SUBSCRIBE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
