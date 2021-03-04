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
                                    <h6 class="h5 mb-0 mt-4">Şifre yenileme</h6>
                                    <p class="text-muted mt-1 mb-4">Formu doldurarak şifrenizi yenileyebilirsiniz.</p>

                                    @if(session('errors'))
                                        @foreach(session('errors')->all() as $err)
                                            <div class="alert alert-danger">{{ $err }}</div>
                                        @endforeach
                                    @endif
                                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>
                                    <br>@endif

                                    <form id="frmResPass" action="{{ route('password.update') }}" method="post" class="authentication-form">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                        <div class="form-group">
                                            <label for="email" class="form-control-label">E-posta adresi</label>
                                            <a href="{{ route('login') }}"
                                               class="float-right text-muted text-unline-dashed ml-1">Giriş sayfasına dön</a>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="mail"></i>
                                                </span>
                                                </div>
                                                <input type="email"
                                                       class="form-control" id="
                                                email" required name="email" value="{{ old('email',$request->email)}}" />

                                            </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="form-control-label">Şifre</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                                </div>
                                                <input type="password" required class="form-control" id="password"
                                                       name="password" />

                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <label for="password_confirmation" class="form-control-label">Şifre doğrulama</label>
                                            <div class="input-group input-group-merge">
                                                <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                                </div>
                                                <input type="password" required class="form-control" id="password_confirmation"
                                                       name="password_confirmation" />

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

