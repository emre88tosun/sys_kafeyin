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
                    <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal">Normal Kullanıcılar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">#{{$user->id}}
                        - {{$user->name}} {{$user->surname}}</li>
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
                            <a href="#loglar" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-list-ul"></i></span>
                                <span class="d-none d-sm-block">Loglar</span>
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
                                                <th scope="row">Şehir</th>
                                                <td>{{$user->city}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Favori kahve</th>
                                                <td>{{$user->favDrink}}</td>
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
                                            <tr>
                                                <th scope="row">Son enlem</th>
                                                <td>{{$user->lastLatitude}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Son boylam</th>
                                                <td>{{$user->lastLongitude}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="table-responsive table-hover">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Kullanıcı puanı</th>
                                                <td>{{$user->userPoint}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Çekirdek sayısı</th>
                                                <td>{{$user->beansCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Makina kullanım sayısı</th>
                                                <td>{{count($user->makina_searches)}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Sadakat kartı sayısı</th>
                                                <td>{{count($user->loyalty_cards)}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Yorum sayısı</th>
                                                <td>{{count($user->comments)}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Fotoğraf sayısı</th>
                                                <td>{{count($user->photos)}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Takipçi sayısı</th>
                                                <td>{{count($user->followers)}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Takip sayısı</th>
                                                <td>{{count($user->followings)}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Konum görünürlüğü</th>
                                                @if($user->locationVisibility)
                                                    <td><span class="badge badge-soft-success">Görünür</span></td>
                                                @else
                                                    <td><span class="badge badge-soft-danger">Gizli</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Anlık bildirim izni</th>
                                                @if($user->canPushNotif)
                                                    <td><span class="badge badge-soft-success">Olumlu</span></td>
                                                @else
                                                    <td><span class="badge badge-soft-danger">Olumsuz</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">E-posta bildirim izni</th>
                                                @if($user->canEmailNotif)
                                                    <td><span class="badge badge-soft-success">Olumlu</span></td>
                                                @else
                                                    <td><span class="badge badge-soft-danger">Olumsuz</span></td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <h5 class="header-title mt-3">Cihaz bilgileri</h5>
                            <div class="col-6">
                                @if($user->device_info)
                                    <div class="table-responsive table-hover">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Marka</th>
                                                <td>{{$user->device_info->brand}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Cihaz</th>
                                                <td>{{$user->device_info->device}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Sistem</th>
                                                <td>{{$user->device_info->systemVersion}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Bağlantı</th>
                                                <td>{{$user->device_info->connType}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="pt-2 text-danger">Cihaz bilgisi bulunamadı.</p>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane" id="loglar">
                            <div class="col-xl-12">
                                <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Detay</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->user_logs as $log)
                                        <tr>
                                            <td>{{$log->id}}</td>
                                            <td>{{$log->desc}}</td>
                                            <td>{{\Carbon\Carbon::createFromTimeString($log->created_at)->format('H:i d/m/Y')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
                                                        <input type="text" name="gsmNumber" class="form-control" maxlength="16" minlength="16" data-inputmask-alias="5999999999" id="gsmNumber" placeholder="GSM" value="{{$user->gsmNumber}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="beansCount" class="col-md-4 col-form-label">Çekirdek sayısı</label>
                                                <div class="col-md-8">
                                                    <input type="number" name="beansCount" required class="form-control" id="beansCount"
                                                           placeholder="Çekirdek sayısı" value="{{$user->beansCount}}">
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
                                                <label for="image" class="col-md-3 col-form-label">Profil fotoğrafı</label>
                                                <div class="col-md-9">
                                                    <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                                </div>
                                            </div>
                                            <div class="offset-md-3">
                                                <input type="submit" class="btn btn-primary ml-1" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col-xl-6">
                                    <form method="post" action="/adminpanel/kullaniciguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="userID" value="{{$user->id}}">
                                            <div class="form-group row">
                                                <label for="locationVisibility" class="col-md-4 ml-2 col-form-label">Konum görünürlüğü</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="locationVisibility" name="locationVisibility" value="1" class="custom-control-input" @if($user->locationVisibility) checked @endif>
                                                    <label class="custom-control-label" for="locationVisibility">Görünür</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="locationVisibility2" name="locationVisibility" value="0" class="custom-control-input" @if(!$user->locationVisibility) checked @endif>
                                                    <label class="custom-control-label" for="locationVisibility2">Gizli</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="canPushNotif" class="col-md-4 ml-2 col-form-label">Anlık bildirim izni</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="canPushNotif" name="canPushNotif" value="1" class="custom-control-input" @if($user->canPushNotif) checked @endif>
                                                    <label class="custom-control-label" for="canPushNotif">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="canPushNotif2" name="canPushNotif" value="0" class="custom-control-input" @if(!$user->canPushNotif) checked @endif>
                                                    <label class="custom-control-label" for="canPushNotif2">Olumsuz</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="canEmailNotif" class="col-md-4 ml-2 col-form-label">E-posta bildirim izni</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="canEmailNotif" name="canEmailNotif" value="1" class="custom-control-input" @if($user->canEmailNotif) checked @endif>
                                                    <label class="custom-control-label" for="canEmailNotif">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="canEmailNotif2" name="canEmailNotif" value="0" class="custom-control-input" @if(!$user->canEmailNotif) checked @endif>
                                                    <label class="custom-control-label" for="canEmailNotif2">Olumsuz</label>
                                                </div>
                                            </div>
                                            <div class="offset-md-4">
                                                <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
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

            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Bağlantılar</h6>
                    <div class="media pt-0">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    <td><a href="/adminpanel/kullanicilar/normal/{{$user->id}}/yorumlar">Yorumlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/kullanicilar/normal/{{$user->id}}/fotograflar">Fotoğraflar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/kullanicilar/normal/{{$user->id}}/favoriler">Favoriler</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/kullanicilar/normal/{{$user->id}}/takipler">Takipler & Takipçiler</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/kullanicilar/normal/{{$user->id}}/sadakatkartlari">Sadakat kartları</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->email == 'admin@kafeyinapp.com')
                <div class="card">
                    <div class="card-body pt-2">
                        <h6 class="header-title mb-4">Kullanıcıyı sil</h6>
                        <div class="media pt-0">
                            <div class="table-responsive table-hover">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <td><a href="javascript:void(0);" type="button" data-id="{{$user->id}}" class="card-link text-danger sa-kKullaniciSil">Kullanıcıyı sil</a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
        @elseif(session('tcknExists'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Bu TCKN ile kayıtlı başka bir kullanıcı bulunmaktadır.',
            type: "warning",
        });
        @elseif(session('gsmExists'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Bu GSM numarası ile kayıtlı başka bir kullanıcı bulunmaktadır.',
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
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
