@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Hesabım</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">{{$user->name}} {{$user->surname}}</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <form method="post" action="/adminpanel/kullaniciguncelle">
                                @csrf
                                <fieldset>
                                    <input type="hidden" name="userID" value="{{$user->id}}">
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label">Ad</label>
                                        <div class="col-md-8">
                                            <input type="text" name="name" required class="form-control" id="name"
                                                   placeholder="Ad" value="{{$user->name}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="surname" class="col-md-4 col-form-label">Soyad</label>
                                        <div class="col-md-8">
                                            <input type="text" name="surname" required class="form-control" id="surname"
                                                   placeholder="Soyad" value="{{$user->surname}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="favDrink" class="col-md-4 col-form-label">Favori kahve</label>
                                        <div class="col-md-8">
                                            <input type="text" name="favDrink" required class="form-control" id="favDrink"
                                                   placeholder="Favori kahve" value="{{$user->favDrink}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="identityNumber" class="col-md-4 col-form-label">TCKN</label>
                                        <div class="col-md-8">
                                            <input type="text" name="identityNumber" class="form-control" data-inputmask-alias="99999999999" id="identityNumber" placeholder="TCKN" value="{{$user->identityNumber}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="gsmNumber"
                                               class="col-md-4 col-form-label">GSM</label>
                                        <div class="col-md-8">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">+90</div>
                                                </div>
                                                <input type="text" name="gsmNumber" class="form-control" maxlength="12" minlength="10" data-inputmask-alias="5999999999" id="gsmNumber" placeholder="GSM" value="{{$user->gsmNumber}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="offset-md-4">
                                        <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="col-xl-6">
                            <form enctype="multipart/form-data" method="post" action="/adminpanel/kullaniciavatarguncelle">
                                @csrf
                                <fieldset>
                                    <input type="hidden" name="userID" value="{{$user->id}}">
                                    <div class="form-group row">
                                        <label for="image" class="col-md-4 col-form-label">Profil fotoğrafı</label>
                                        <div class="col-md-8">
                                            <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                        </div>
                                    </div>
                                    <div class="offset-md-4">
                                        <input type="submit" class="btn btn-primary ml-1" value="Güncelle">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3"><div class="card">
                <div class="card-body pb-2">
                    <div class="text-center mt-3">
                        <img src="{{$user->avatar}}" alt="avatar" class="avatar-xl rounded-circle" />
                        <h5 class="mt-2 mb-0">{{$user->name}} {{$user->surname}}</h5>
                        <h6 class="text-muted font-weight-normal mt-2 mb-4">{{$user->email}}</h6>
                        <h6 class="text-muted font-weight-normal mt-2 mb-4">Admin</h6>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Şifre değiştir</h5>
                    <form method="post" action="/adminpanel/sifredegistir">
                        @csrf
                        <fieldset>
                            <div class="form-group">
                                <label for="pass1" class="col-form-label">Güncel şifre</label>
                                <input type="password" name="pass1" class="form-control" required id="pass1">
                            </div>
                            <div class="form-group">
                                <label for="pass2" class="col-form-label">Yeni şifre</label>
                                <input type="password" name="pass2" class="form-control" required id="pass2">
                            </div>
                            <div class="form-group">
                                <label for="pass3" class="col-form-label">Yeni şifre doğrulama</label>
                                <input type="password" name="pass3" class="form-control" required id="pass3">
                            </div>


                            <div class="offset-md-0">
                                <input type="submit" class="btn btn-primary" value="Güncelle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script>
        @if (session('userUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Kullanıcı bilgileri güncellenmiştir.',
            type: "success",
        });
        @elseif(session('fileErr'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Seçtiğiniz dosya yüklenirken bir problem oluştu.',
            type: "warning",
        });
        @elseif(session('hashErr'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Girdiğiniz değer ile şifreniz uyuşmuyor.',
            type: "warning",
        });
        @elseif(session('avatarUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Kullanıcının profil fotoğrafı güncellendi.',
            type: "success",
        });
        @elseif(session('gsmExists'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Bu GSM numarası ile kayıtlı başka bir kullanıcı bulunmaktadır.',
            type: "warning",
        });
        @elseif(session('tcknExists'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Bu TCKN ile kayıtlı başka bir kullanıcı bulunmaktadır.',
            type: "warning",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
