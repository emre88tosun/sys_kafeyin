@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
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
                                       data-target="#addressChange"
                                       class="dropdown-item">Adres güncelle</a>
                                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                                       data-target="#passChange"
                                       class="dropdown-item">Şifre güncelle</a>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <div class="popup-gallery" data-source="{{$user->avatar}}">
                            <a href="{{$user->avatar}}" title="">
                                <img src="{{$user->avatar}}" alt="img" class="avatar-lg rounded-circle">
                            </a>
                        </div>
                        <h5 class="mt-2 mb-0">{{$user->name}} {{$user->surname}}</h5>
                        @if($hasBrand && $hasMagaza)
                            <h6 class="text-muted font-weight-normal mt-2 mb-0">Marka & Mağaza Yöneticisi</h6>
                        @elseif(!$hasBrand && $hasMagaza)
                            <h6 class="text-muted font-weight-normal mt-2 mb-0">Mağaza Yöneticisi</h6>
                        @elseif($hasBrand && !$hasMagaza)
                            <h6 class="text-muted font-weight-normal mt-2 mb-0">Marka Yöneticisi</h6>
                        @endif
                        @if($user->addresses->first())
                            <h6 class="text-muted font-weight-normal mt-1 mb-4">{{$user->addresses->first()->city->name}}</h6>
                        @endif
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <h4 class="mb-3 font-size-15">İletişim Bilgileri <a href="javascript:void(0);" data-toggle="modal" data-target="#contactInfoDialog" class="card-title header-title border-bottom mb-0 mt-0"><i class="uil-info-circle"></i></a></h4>
                        <div class="table-responsive">
                            <table class="table table-borderless m-0 text-muted">
                                <tbody>
                                <tr>
                                    <th scope="row">E-posta</th>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">GSM</th>
                                    <td>+90{{$user->gsmNumber}}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Adres</th>
                                    @if($user->addresses->first())
                                    <td>{{$user->addresses->first()->neighborhood->name}}. {{$user->addresses->first()->avenueStreet}} No: {{$user->addresses->first()->buildingApartmentNo}} {{$user->addresses->first()->district->name}} {{$user->addresses->first()->county->name}}/{{$user->addresses->first()->city->name}} </td>
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
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="log-tab" data-toggle="pill" href="#log"
                               role="tab" aria-controls="pills-activity" aria-selected="true">
                                Hesap hareketleriniz
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="log" role="tabpanel" aria-labelledby="log-tab">
                            <h5 class="mt-3">Son 1 ay</h5>
                            @if(count($logs))
                                <div class="left-timeline mt-3 mb-3 pl-4">
                                    <ul class="list-unstyled events mb-0">
                                        @foreach($logs as $log)
                                            <li class="event-list">
                                                <div class="pb-4">
                                                    <div class="media">
                                                        <div class="event-date text-center mr-4">
                                                            <div class="bg-soft-primary-light p-1 rounded text-primary font-size-14">{{\Carbon\Carbon::createFromTimeString($log->created_at)->format('d/m/Y H:i')}}</div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="font-size-15 mt-0 mb-1">{{$log->desc}}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            @else
                                <p>Burası tertemiz!</p>
                            @endif


                        </div>

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
                                <p>Mağaza Yöneticileriniz ile sadece e-posta adresi bilginiz paylaşılmaktadır. Bunun yanı sıra hiçbir iletişim bilginiz, hiçbir kullanıcı ile paylaşılmamaktadır.</p>
                            @else
                                @if($hasMagaza)
                                    <p>İletişim bilgileriniz hiçbir kullanıcı ile paylaşılmamaktadır.</p>
                                @else
                                    <p>Mağaza Yöneticiniz ile sadece e-posta adresi bilginiz paylaşılmaktadır. Bunun yanı sıra hiçbir iletişim bilginiz, hiçbir kullanıcı ile paylaşılmamaktadır.</p>
                                @endif
                            @endif
                        @else
                            <p>Marka Yöneticiniz ile sadece e-posta adresi bilginiz paylaşılmaktadır. Bunun yanı sıra hiçbir iletişim bilginiz, hiçbir kullanıcı ile paylaşılmamaktadır.</p>
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
                                <label for="newpass" class="col-md-4 col-form-label">Yeni şifre</label>
                                <div class="col-md-8">
                                    <input type="password" name="newpass" required class="form-control" id="newpass"
                                           placeholder="Yeni şifre">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newpassconfirm" class="col-md-4 col-form-label">Yeni şifre doğrulama</label>
                                <div class="col-md-8">
                                    <input type="password" name="newpassconfirm" required class="form-control" id="newpassconfirm"
                                           placeholder="Yeni şifre doğrulama">
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
    <div class="modal fade" id="addressChange" tabindex="-1" role="dialog"
         aria-labelledby="addressChange" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressChange">Adres Güncelle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/addresschange">
                        @csrf
                        <fieldset>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label for="city" class="col-md-3 col-form-label">İl</label>
                                        <div class="col-md-9">
                                            <select data-plugin="citySelect" required class="form-control"  name="cityID" >
                                                <option></option>
                                                @foreach($aCities as $city)
                                                    <option value="{{$city->id}}" >{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label for="county" class="col-md-3 col-form-label">İlçe</label>
                                        <div class="col-md-9">
                                            <select data-plugin="countySelect" required class="countySelect form-control"  name="countyID" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label for="district" class="col-md-3 col-form-label">Semt</label>
                                        <div class="col-md-9">
                                            <select data-plugin="districtSelect" required class="districtSelect form-control"  name="districtID" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label for="neighborhood" class="col-md-3 col-form-label">Mahalle</label>
                                        <div class="col-md-9">
                                            <select data-plugin="neighborhoodSelect" required class="neighborhoodSelect form-control"  name="neighborhoodID" >
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group row">
                                        <label for="avenueStreet" class="col-md-2 col-form-label">Cadde / Sokak</label>
                                        <div class="col-md-10">
                                            <input type="text" name="avenueStreet" required class="form-control" id="avenueStreet"
                                                   placeholder="Cadde / Sokak">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label for="buildingNo" class="col-md-3 col-form-label">Apt. No</label>
                                        <div class="col-md-9">
                                            <input type="number" name="buildingNo" required class="form-control" id="buildingNo"
                                                   placeholder="Apt. No">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label for="apartmentNo" class="col-md-3 col-form-label">Daire No</label>
                                        <div class="col-md-9">
                                            <input type="number" name="apartmentNo" required class="form-control" id="apartmentNo"
                                                   placeholder="Daire No">
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="offset-md-1">
                                <input type="submit" class="btn btn-primary float-right" value="Devam">
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
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('hata')}}",
                type: "error",
            });
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
@endsection
