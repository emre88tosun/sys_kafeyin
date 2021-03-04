@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
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
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="btn-group float-right">
                                <button type="button"
                                        class="btn btn-light btn-sm dropdown-toggle"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                                       data-target="#ppChange"
                                       class="dropdown-item">Profil fotoğrafını güncelle</a>
                                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                                       data-target="#gsmChange"
                                       class="dropdown-item">GSM güncelle</a>
                                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                                       data-target="#passChange"
                                       class="dropdown-item">Şifre güncelle</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-0">
                        <div class="popup-gallery" data-source="{{$user->avatar}}">
                            <a href="{{$user->avatar}}" title="">
                                <img src="{{$user->avatar}}" alt="img" class="avatar-xxl rounded-circle">
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 pt-2">
                        <h4 class="mb-3 font-size-15">Bilgiler <a href="javascript:void(0);" data-toggle="modal" data-target="#contactInfoDialog" class="card-title header-title border-bottom mb-0 mt-0"><i class="uil-info-circle"></i></a></h4>
                        <div class="table-responsive">
                            <table class="table table-borderless m-0 text-muted">
                                <tbody>
                                <tr>
                                    <th scope="row">Ad</th>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Soyad</th>
                                    <td>{{$user->surname}}</td>
                                </tr>
                                @if($hasBrand && $hasMagaza)
                                    <tr>
                                        <th scope="row">Yetki</th>
                                        <td>Marka & Mağaza Yöneticisi</td>
                                    </tr>
                                @elseif(!$hasBrand && $hasMagaza)
                                    <tr>
                                        <th scope="row">Yetki</th>
                                        <td>Mağaza Yöneticisi</td>
                                    </tr>
                                @elseif($hasBrand && !$hasMagaza)
                                    <tr>
                                        <th scope="row">Yetki</th>
                                        <td>Marka Yöneticisi</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="row">E-posta</th>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">GSM</th>
                                    <td>+90{{$user->gsmNumber}}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="log-tab" data-toggle="pill" href="#log"
                               role="tab" aria-controls="pills-activity" aria-selected="true">
                                Hesap hareketleri
                            </a>
                        </li>
                        @if($hasMagaza)
                            <li class="nav-item">
                                <a class="nav-link" id="store-tab" data-toggle="pill" href="#store"
                                   role="tab" aria-controls="pills-activity" aria-selected="false">
                                    Mağaza işlemleri
                                </a>
                            </li>
                        @endif
                        @if($hasBrand)
                            <li class="nav-item">
                                <a class="nav-link" id="brand-tab" data-toggle="pill" href="#brand"
                                   role="tab" aria-controls="pills-activity" aria-selected="false">
                                    Marka işlemleri
                                </a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="log" role="tabpanel" aria-labelledby="log-tab">
                            <table id="tblUserLogs" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Detay</th>
                                    <th>IP</th>
                                    <th>İşlem Tarihi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $log)
                                    <tr>
                                        <td>{{$log->desc}}</td>
                                        @if(json_decode($log->detail,true)['ip']??false)
                                            <td>{{json_decode($log->detail,true)['ip']}}</td>
                                        @else
                                            <td>Sistem</td>
                                        @endif
                                        <td>{{\Carbon\Carbon::createFromTimeString($log->created_at)->format('d/m/Y H:i')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        </div>
                        @if($hasMagaza)
                            <div class="tab-pane fade" id="store" role="tabpanel" aria-labelledby="store-tab">
                                <table id="tblStoreLogs" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Detay</th>
                                        <th>IP</th>
                                        <th>İşlem Tarihi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($storeLogs as $log)
                                        <tr>
                                            <td>{{$log->desc}}</td>
                                            @if(json_decode($log->detail,true)['ip']??false)
                                                <td>{{json_decode($log->detail,true)['ip']}}</td>
                                            @else
                                                <td>Sistem</td>
                                            @endif
                                            <td>{{\Carbon\Carbon::createFromTimeString($log->created_at)->format('d/m/Y H:i')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        @endif
                        @if($hasBrand)
                            <div class="tab-pane fade" id="brand" role="tabpanel" aria-labelledby="brand-tab">
                                <table id="tblBrandLogs" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Detay</th>
                                        <th>IP</th>
                                        <th>İşlem Tarihi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($brandLogs as $log)
                                        <tr>
                                            <td>{{$log->desc}}</td>
                                            @if(json_decode($log->detail,true)['ip']??false)
                                                <td>{{json_decode($log->detail,true)['ip']}}</td>
                                            @else
                                                <td>Sistem</td>
                                            @endif
                                            <td>{{\Carbon\Carbon::createFromTimeString($log->created_at)->format('d/m/Y H:i')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>


                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="contactInfoDialog" tabindex="-1" role="dialog"
         aria-labelledby="contactInfoDialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactInfoDialog">Bilgi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12">
                        @if($hasBrand)
                            @if(count($user->brand->stores) > 1)
                                <p>Bilgileriniz, sadece markanıza bağlı mağazaların yöneticileri ile paylaşılmaktadır.</p>
                            @else
                                @if($hasMagaza)
                                    <p>Bilgileriniz hiçbir kullanıcı ile paylaşılmamaktadır.</p>
                                @else
                                    <p>Bilgileriniz, sadece mağaza yöneticiniz ile paylaşılmaktadır.</p>
                                @endif
                            @endif
                        @else
                            <p>Bilgileriniz, sadece marka yöneticiniz ile paylaşılmaktadır.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ppChange" tabindex="-1" role="dialog"
         aria-labelledby="ppChange" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ppChange">Profil Fotoğrafını Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="/yoneticipaneli/ppchange">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">Yeni profil fotoğrafı</label>
                                <div class="col-md-8">
                                    <input type="file" id="image" name="image" data-max-file-size="1M" required
                                           data-show-loader="true"
                                           data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                            </div>
                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Devam">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="passChange" tabindex="-1" role="dialog"
         aria-labelledby="passChange" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passChange">Şifre Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/passchange">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="curpass" class="col-md-4 col-form-label">Güncel şifre</label>
                                <div class="col-md-8">
                                    <input type="password" name="curpass" required class="form-control" id="curpass"
                                           placeholder="Güncel şifre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">Yeni şifre</label>
                                <div class="col-md-8">
                                    <input type="password" name="password" required class="form-control" id="password"
                                           placeholder="Yeni şifre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label">Yeni şifre doğrulama</label>
                                <div class="col-md-8">
                                    <input type="password" name="password_confirmation" required class="form-control" id="password_confirmation"
                                           placeholder="Yeni şifre doğrulama">
                                </div>
                            </div>
                            <div class="offset-md-4">
                                <div class="alert bg-soft-primary-light w-100 ml-2">
                                    <p class="m-0 text-primary font-weight-bold small">*Şifreniz en az 8 karakterden oluşmalı.<br>*En az 1 adet küçük harf (a-z), en az 1 adet büyük harf (A-Z), en az 1 adet rakam (0-9) içermelidir.</p>
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Devam">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="gsmChange" tabindex="-1" role="dialog"
         aria-labelledby="gsmChange" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gsmChange">GSM Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/gsmchange">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="gsm" class="col-md-4 col-form-label">Yeni GSM</label>
                                <div class="col-md-8">
                                    <input type="text" name="gsm" required class="form-control" id="gsm" data-inputmask-alias="599 999 99 99"
                                           placeholder="Yeni GSM">
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Devam">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm');
        });
    </script>
    <script>
        @if($errors->any())
            @if($errors->first('hata'))
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('hata')}}",
                type: "error",
            });
            @else
            swal.fire({
                title: 'Hata!',
                html: "@foreach($errors->all() as $err) {{$err}} <br> @endforeach",
                type: "error",
            });
            @endif

        @elseif(session('ppUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Profil fotoğrafınız başarıyla güncellenmiştir.",
                type: "success",
            });
        @elseif(session('passUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Şifreniz başarıyla güncellenmiştir.",
                type: "success",
            });
        @elseif(session('gsmUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "GSM numaranız başarıyla güncellenmiştir.",
                type: "success",
            });
        @elseif(session('addrUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Adresiniz başarıyla güncellenmiştir.",
                type: "success",
            });
        @endif
    </script>
    <script>
        $('[data-plugin="citySelect"]').select2();
        $('[data-plugin="citySelect"]').on("select2:selecting", function() {
            $(".countySelect").empty();
            $(".districtSelect").empty();
            $(".neighborhoodSelect").empty();
        });
    </script>
    <script type="text/javascript">
        $('.countySelect').select2({
            minimumResultsForSearch: Infinity,
            ajax: {
                url: '/yoneticipaneli/getcounties',
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $('[data-plugin="citySelect"]').val(),
                        search: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
        $('.countySelect').on("select2:selecting", function() {
            $(".districtSelect").empty();
            $(".neighborhoodSelect").empty();
        });
        $('.districtSelect').select2({
            minimumResultsForSearch: Infinity,
            ajax: {
                url: '/yoneticipaneli/getdistricts',
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $('.countySelect').val(),
                        search: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
        $('.districtSelect').on("select2:selecting", function() {
            $(".neighborhoodSelect").empty();
        });
        $('.neighborhoodSelect').select2({
            minimumResultsForSearch: Infinity,
            ajax: {
                url: '/yoneticipaneli/getneighborhoods',
                type: 'GET',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $('.districtSelect').val(),
                        search: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        })
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
