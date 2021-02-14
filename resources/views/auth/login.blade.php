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
                                    <h6 class="h5 mb-0 mt-4">Hoşgeldiniz!</h6>
                                    <p class="text-muted mt-1 mb-4">Devam etmek için lütfen giriş yapınız.</p>

                                    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>
                                    <br>@endif
                                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>
                                    <br>@endif

                                    <form action="{{ route('login') }}" method="post" class="authentication-form">
                                        @csrf

                                        <div class="form-group">
                                            <label class="form-control-label">E-posta adresi</label>
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

                                        <div class="form-group mt-4">
                                            <label class="form-control-label">Şifre</label>
                                            <a href="{{ route('password.request') }}"
                                               class="float-right text-muted text-unline-dashed ml-1">Şifremi unuttum</a>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                                </div>
                                                <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password"
                                                       name="password" />

                                                @if($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group mb-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="remember_me"
                                                    {{ old('remember_me') ? 'checked' : '' }} />
                                                <label class="custom-control-label" for="remember_me">Beni hatırla</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 text-center">
                                            <button class="btn btn-primary btn-block" type="submit"> Giriş yap
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
