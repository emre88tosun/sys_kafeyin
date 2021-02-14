@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Kullanıcılar</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/admin">Admin Kullanıcılar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{$user->id}} - {{$user->name}} {{$user->surname}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">#{{$user->id}} - {{$user->name}} {{$user->surname}}</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Kullanıcıya ait bilgiler</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#detay" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-info-circle"></i></span>
                                <span class="d-none d-sm-block">Detay</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#duzenle" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-edit"></i></span>
                                <span class="d-none d-sm-block">Düzenle</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="detay">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="table-responsive table-hover">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">ID</th>
                                                <td>{{$user->id}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ad</th>
                                                <td>{{$user->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Soyad</th>
                                                <td>{{$user->surname}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-posta</th>
                                                <td>{{$user->email}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">TCKN</th>
                                                <td>{{$user->identityNumber}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">GSM</th>
                                                <td>{{$user->gsmNumber}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Üyelik tarihi</th>
                                                <td>{{\Carbon\Carbon::createFromTimeString($user->created_at)->format('d/m/Y H:i')}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-posta onaylama tarihi</th>
                                                @if($user->email_verified_at)
                                                    <td>{{\Carbon\Carbon::createFromTimeString($user->email_verified_at)->format('d/m/Y H:i')}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Son giriş tarihi</th>
                                                @if($user->lastLogin)
                                                    <td>{{\Carbon\Carbon::createFromTimeString($user->lastLogin)->format('d/m/Y H:i')}}</td>
                                                @else
                                                    <td></td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="duzenle">
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
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Profil fotoğrafı</h6>
                    <div class="media pt-0">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <div class="popup-gallery" data-source="{{$user->avatar}}">
                                    <a href="{{$user->avatar}}" title="">
                                        <img src="{{$user->avatar}}" alt="img" class="avatar-xxl rounded-circle">
                                    </a>
                                </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->email == 'admin@kafeyinapp.com')
                @if($user->email != 'admin@kafeyinapp.com')
                    <div class="card">
                        <div class="card-body pt-2">
                            <h6 class="header-title mb-4">Kullanıcıyı sil</h6>
                            <div class="media pt-0">
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <tr>
                                            <td><a href="javascript:void(0);" type="button" data-id="{{$user->id}}" class="card-link text-danger sa-aKullaniciSil">Kullanıcıyı sil</a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
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
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script>
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        } );
        $('[data-plugin="customselects1"]').select2();
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
        @elseif(session('brUsUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Kullanıcı bilgileri güncellendi',
            type: "success",
        });
        @elseif(session('usBrUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Kullanıcı bilgileri güncellenmiştir.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
