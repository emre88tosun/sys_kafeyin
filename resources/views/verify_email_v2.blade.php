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
                                    @if($nonUser)
                                        <h6 class="h5 mb-0 mt-4 mb-3">Hata!</h6>
                                        <div class="alert alert-danger">Böyle bir kullanıcı bulunamamıştır.</div>
                                        <h6 class="h5 mb-0 mt-4">Yeniden gönder</h6>
                                        <p class="text-muted mt-1 mb-4">E-posta adresinizi girerek yeni bir doğrulama bağlantısı talebinde bulunabilirsiniz.</p>
                                        <form action="{{ route('resend.verif') }}" method="post" class="authentication-form">
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
                                                email" name="email" required value="{{ session('email')}}" />

                                                    @if($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (session('reSent'))
                                                <div class="mb-4 font-medium text-sm text-success">
                                                    {{ __('Yeni bir doğrulama bağlantısı gönderilmiştir.') }}
                                                </div>
                                            @endif
                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit">Gönder</button>
                                            </div>
                                        </form>
                                    @elseif($hashErr)
                                        <h6 class="h5 mb-0 mt-4 mb-3">Hata!</h6>
                                        <div class="alert alert-danger">Bir hata oluştu.</div>
                                        <h6 class="h5 mb-0 mt-4">Yeniden gönder</h6>
                                        <p class="text-muted mt-1 mb-4">E-posta adresinizi girerek yeni bir doğrulama bağlantısı talebinde bulunabilirsiniz.</p>
                                        <form action="{{ route('resend.verif') }}" method="post" class="authentication-form">
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
                                                email" name="email" required value="{{ session('email')}}" />

                                                    @if($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (session('reSent'))
                                                <div class="mb-4 font-medium text-sm text-success">
                                                    {{ __('Yeni bir doğrulama bağlantısı gönderilmiştir.') }}
                                                </div>
                                            @endif
                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit">Gönder</button>
                                            </div>
                                        </form>
                                    @elseif($invalidSign)
                                        <h6 class="h5 mb-0 mt-4 mb-3">Hata!</h6>
                                        <div class="alert alert-danger">Geçersiz imzalı bir bağlantıya tıkladınız. Lütfen yeni bir doğrulama bağlantısı talep ediniz.</div>
                                        <h6 class="h5 mb-0 mt-4">Yeniden gönder</h6>
                                        <p class="text-muted mt-1 mb-4">E-posta adresinizi girerek yeni bir doğrulama bağlantısı talebinde bulunabilirsiniz.</p>
                                        <form action="{{ route('resend.verif') }}" method="post" class="authentication-form">
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
                                                email" name="email" required value="{{ session('email')}}" />

                                                    @if($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (session('reSent'))
                                                <div class="mb-4 font-medium text-sm text-success">
                                                    {{ __('Yeni bir doğrulama bağlantısı gönderilmiştir.') }}
                                                </div>
                                            @endif
                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit">Gönder</button>
                                            </div>
                                        </form>
                                    @elseif($verified)
                                        <h6 class="h5 mb-0 mt-4 mb-3">Başarılı!</h6>
                                        <div class="alert alert-success">E-posta adresiniz onaylanmıştır.</div>
                                    @elseif($expired)
                                        <h6 class="h5 mb-0 mt-4 mb-3">Hata!</h6>
                                        <div class="alert alert-danger">E-posta onaylama bağlantısının süresi doldu.</div>
                                        <h6 class="h5 mb-0 mt-4">Yeniden gönder</h6>
                                        <p class="text-muted mt-1 mb-4">E-posta adresinizi girerek yeni bir doğrulama bağlantısı talebinde bulunabilirsiniz.</p>
                                        <form action="{{ route('resend.verif') }}" method="post" class="authentication-form">
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
                                                email" name="email" required value="{{ session('email')}}" />

                                                    @if($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (session('reSent'))
                                                <div class="mb-4 font-medium text-sm text-success">
                                                    {{ __('Yeni bir doğrulama bağlantısı gönderilmiştir.') }}
                                                </div>
                                            @endif
                                            <div class="form-group mb-0 text-center">
                                                <button class="btn btn-primary btn-block" type="submit">Gönder</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
