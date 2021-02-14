@extends('layouts.non-auth')

@section('content')
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12 p-5">
                                    <div class="mx-auto mb-1">
                                        <a href="/">
                                            <img src="/assets/images/logo.png" alt="logo" height="36" />
                                        </a>
                                    </div>
                                    <h6 class="h5 mb-0 mt-4 mb-3">Merhaba, {{$user->name}} {{$user->surname}}!</h6>
                                    @if($user->isBrandManager)
                                        <p class="text-muted mt-1 mb-0">Hesabınız, sistemlerimizde "Marka Yöneticisi" olarak kayıtlı olmasına rağmen hesabınıza tanımlı herhangi bir marka veya mağaza bulunmamaktadır.</p>
                                    @else
                                        <p class="text-muted mt-1 mb-0">Hesabınız, sistemlerimizde "Mağaza Yöneticisi" olarak kayıtlı olmasına rağmen hesabınıza tanımlı herhangi bir mağaza bulunmamaktadır.</p>
                                    @endif
                                    <p class="text-muted mt-2">Bir sorun olduğunu düşünüyorsanız <a href="mailto:destek@kafeyinapp.com" class="text-muted font-weight-semibold">destek@kafeyinapp.com</a> e-posta adresi üzerinden iletişime geçebilirsiniz.</p>
                                    <form method="GET" action="{{ route('cikis.yap') }}">
                                        @csrf
                                        <button class="btn btn-primary btn-sm" type="submit">Çıkış yap</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
