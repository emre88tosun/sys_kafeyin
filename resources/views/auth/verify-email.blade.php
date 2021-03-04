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
                                    <h6 class="h5 mb-0 mt-4 mb-3">Merhaba, {{\Illuminate\Support\Facades\Auth::user()->name}} {{\Illuminate\Support\Facades\Auth::user()->surname}}!</h6>
                                    <p class="text-muted mt-1 mb-4">Kafeyin platformuna katıldığınız için size minnettarız ancak e-posta adresinize gönderdiğimiz doğrulama bağlantısı üzerinden gerekli işlemi gerçekleştirdikten sonra devam edebilirsiniz.</p>
                                    @if (session('reSent'))
                                        <div class="mb-4 font-medium text-sm text-success">
                                            {{ __('Yeni bir doğrulama bağlantısı gönderilmiştir.') }}
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-xl-9">
                                            <form action="{{ route('resend.verif') }}" method="post" class="authentication-form">
                                                @csrf
                                                <input type="hidden" name="email" value="{{\Illuminate\Support\Facades\Auth::user()->email}}">
                                                <div class="form-group mb-0 text-center">
                                                    <button class="btn btn-primary btn-block" type="submit">Yeni doğrulama bağlantısı gönder</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-xl-3">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button class="btn btn-light btn-block" type="submit">Çıkış yap</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
