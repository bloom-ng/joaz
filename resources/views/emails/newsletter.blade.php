@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    # {{ $subject ?? 'Newsletter Update' }}

    {!! nl2br(e($content)) !!}

    @component('mail::button', ['url' => $unsubscribeUrl, 'color' => 'red'])
        Unsubscribe from Newsletter
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            
            @slot('subcopy')
                If you're having trouble clicking the "Unsubscribe" button, copy and paste the URL below into your web browser:
                <span class="break-all">{{ $unsubscribeUrl }}</span>
            @endsubcopy
        @endcomponent
    @endslot
@endcomponent
