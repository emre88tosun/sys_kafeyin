@extends('layouts.non-auth')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.css') }}" type="text/css"/>
@endsection

@section('content')

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="col-md-12 p-5">
                                <div class="mb-4">
                                    <a href="#">
                                        <img src="/assets/images/logo.png" alt="logo" height="36"/>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h4 class="">Yönetici Hesabı Oluşturma</h4>
                                        <p class="text-muted text-justify mb-2">
                                            Merhaba, {{$preUser->name}} {{$preUser->surname}}. Aşağıda bulunan formu
                                            gönderdikten sonra yönetici hesabınız tanımlanacak ve e-posta adresinize bir
                                            doğrulama e-postası göndereceğiz.
                                            E-posta adresinizi doğruladıktan sonra yönetici hesabınıza giriş yapabilir
                                            ve Kafeyin'in hizmetlerini kullanabilirsiniz.</p>
                                        @if($preUser->marka)
                                            <p class="text-blackish mb-2">Yöneticisi olduğunuz marka:
                                                <text class="text-primary font-weight-bold">{{$preUser->marka->name}}
                                                    (ID:MRK88{{$preUser->marka->id}})
                                                </text>
                                            </p>
                                        @endif
                                        @if($preUser->magaza)
                                            <p class="text-blackish mb-2">Yöneticisi olduğunuz mağaza:
                                                <text class="text-primary font-weight-bold">{{$preUser->magaza->name}}
                                                    (ID:KFYN{{$preUser->magaza->id}})
                                                </text>
                                            </p>
                                        @endif
                                        <hr>
                                        @if($errors->any())
                                            <div class="alert alert-danger w-100">
                                                <p><strong>Bir şeyler ters gitti.</strong></p>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form id="yoneticiHesabiOlusturForm" class="mt-3" method="post"
                                              action="/yoneticihesabigonder">
                                            @csrf
                                            <fieldset>
                                                <input type="hidden" name="pUID" value="{{$preUser->id}}">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"
                                                                   class="col-md-12 col-form-label">Ad</label>
                                                            <div class="col-md-12">
                                                                <input id="name"
                                                                       class="form-control"
                                                                       readonly
                                                                       name="name"
                                                                       type="text"
                                                                       value="{{$preUser->name}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="surname"
                                                                   class="col-md-12 col-form-label">Soyad</label>
                                                            <div class="col-md-12">
                                                                <input id="surname"
                                                                       class="form-control"
                                                                       readonly
                                                                       name="surname"
                                                                       type="text"
                                                                       value="{{$preUser->surname}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email"
                                                                   class="col-md-12 col-form-label">E-posta
                                                                adresi</label>
                                                            <div class="col-md-12">
                                                                <input id="email"
                                                                       class="form-control"
                                                                       readonly
                                                                       name="email"
                                                                       type="text"
                                                                       value="{{$preUser->email}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="gsmNumber"
                                                                   class="col-md-12 col-form-label">GSM</label>
                                                            <div class="col-md-12">
                                                                <input id="gsmNumber"
                                                                       class="form-control"
                                                                       readonly
                                                                       name="gsmNumber"
                                                                       type="text"
                                                                       value="+90{{$preUser->gsmNumber}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="password"
                                                                   class="col-md-12 col-form-label">Şifre</label>
                                                            <div class="col-md-12 input-group">
                                                                <input id="password"
                                                                       class="form-control"
                                                                       required
                                                                       name="password"
                                                                       type="password">
                                                                <span class="input-group-append">
                                                                  <a href="javascript:void(0);" id="togglePass" class="btn btn-outline-primary" type="button">
                                                                        <i class="uil uil-eye"></i>
                                                                  </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="password_confirmation"
                                                                   class="col-md-12 col-form-label">Şifre
                                                                doğrulama</label>
                                                            <div class="col-md-12 input-group">
                                                                <input id="password_confirmation"
                                                                       class="form-control"
                                                                       required
                                                                       name="password_confirmation"
                                                                       type="password">
                                                                <span class="input-group-append">
                                                                  <a href="javascript:void(0);" id="togglePassConfirm" class="btn btn-outline-primary" type="button">
                                                                        <i class="uil uil-eye"></i>
                                                                  </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert ml-4 mr-4 bg-soft-primary-light w-100 m-0">
                                                        <p class="m-0 text-primary font-weight-bold small">*Şifreniz en az 8 karakterden oluşmalı.<br>*En az 1 adet küçük harf (a-z), en az 1 adet büyük harf (A-Z), en az 1 adet rakam (0-9) içermelidir.</p>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary btn-sm w-100 ml-4 mr-4 mt-3" value="Gönder">
                                                </div>
                                            </fieldset>
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
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.js') }}"></script>
    <script type="text/javascript">
        $('#togglePassConfirm').click(function (){
           if(document.getElementById('password_confirmation').type === "password"){
               document.getElementById('password_confirmation').type = "text";
           }else if(document.getElementById('password_confirmation').type === "text"){
               document.getElementById('password_confirmation').type = "password";
           }

        });
        $('#togglePass').click(function (){
            if(document.getElementById('password').type === "password"){
                document.getElementById('password').type = "text";
            }else if(document.getElementById('password').type === "text"){
                document.getElementById('password').type = "password";
            }

        });
        $('#yoneticiHesabiOlusturForm').submit(function(e){
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
