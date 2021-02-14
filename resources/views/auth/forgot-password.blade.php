{{--
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
--}}
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
                                            <img src="assets/images/logo.png" alt="logo" height="36" />
                                        </a>
                                    </div>
                                    <h6 class="h5 mb-0 mt-4">Şifremi unuttum</h6>
                                    <p class="text-muted mt-1 mb-4">Kayıtlı e-posta adresinizi girerek şifre yenileme bağlantısı talep edebilirsiniz.</p>

                                    @if(session('status'))
                                        <div class="alert alert-primary">{{ session('status') }}</div>
                                        <br>
                                    @endif

                                    <form action="{{ route('password.email') }}" method="post" class="authentication-form">
                                        @csrf

                                        <div class="form-group">
                                            <label class="form-control-label">E-posta adresi</label>
                                            <a href="{{ route('login') }}"
                                               class="float-right text-muted text-unline-dashed ml-1">Giriş sayfasına dön</a>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="mail"></i>
                                                </span>
                                                </div>
                                                <input type="email"
                                                       class="form-control @if($errors->has('email')) is-invalid @endif" id="
                                                email" name="email" value="{{ old('email')}}" />

                                                @if($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn-primary btn-block" type="submit"> Devam
                                            </button>
                                        </div>
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


