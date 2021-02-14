@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <p>
                <a href="https://www.facebook.com/kafeyinapp" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;"><img src="{{asset('assets/images/facebook.png')}}" width="17" alt="Facebook" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-right: 12px;"></a>
                &bull;
                <a href="https://twitter.com/kafeyinapp" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;"><img src="{{asset('assets/images/twitter.png')}}" width="17" alt="Twitter" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;margin-left: 12px; margin-right: 12px;"></a>
                &bull;
                <a href="https://www.instagram.com/kafeyinapp" style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;"><img src="{{asset('assets/images/instagram.png')}}" width="17" alt="Instagram" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle; margin-left: 12px;"></a>
            </p>
            <p>
                Kahve aşkına!
            </p>
            <p style="--text-opacity: 1; color: #263238; color: rgba(38, 50, 56, var(--text-opacity)); text-decoration: none;">
                Bu e-postayı neden aldığınızı bilmiyorsanız destek@kafeyinapp.com e-posta adresi üzerinden bize bildirebilirsiniz.
            </p>
        @endcomponent
    @endslot
@endcomponent
