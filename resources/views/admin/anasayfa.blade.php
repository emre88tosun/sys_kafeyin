@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')

@endsection

@section('content')


    <div class="col-xl-12 mt-2 mb-3 ">
        <div class="row">
            <a type="button" href="javascript:void(0);" class="btn btn-primary btn-sm " data-toggle="modal"
               data-target="#markaEkleModal">Marka Ekle</a>
            <a type="button" href="javascript:void(0);" class="btn btn-primary btn-sm ml-2" data-toggle="modal"
               data-target="#magazaEkleModal">Mağaza Ekle</a>
            <div class="btn-group ml-2">
                <button type="button"
                        class="btn btn-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">Kullanıcı Ekle <i
                        class="icon"><span
                            data-feather="chevron-down"></span></i>
                </button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                       data-target="#adminKullaniciEkle"
                       class="dropdown-item">Admin Kullanıcısı Ekle</a>
                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                       data-target="#magazaKullaniciEkle"
                       class="dropdown-item">Mağaza Kullanıcısı Ekle</a>
                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                       data-target="#normalKullaniciEkle"
                       class="dropdown-item">Normal Kullanıcı Ekle</a>

                </div>
            </div>
            <div class="btn-group ml-2">
                <button type="button"
                        class="btn btn-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">Önbellek Temizleme <i
                        class="icon"><span
                            data-feather="chevron-down"></span></i>
                </button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" type="button" class="dropdown-item sa-configClear">Config:Clear</a>
                    <a href="javascript:void(0);" type="button" class="dropdown-item sa-cacheClear">Cache:Clear</a>
                    <a href="javascript:void(0);" type="button" class="dropdown-item sa-configCache">Config:Cache</a>
                    <a href="javascript:void(0);" type="button" class="dropdown-item sa-optimizeClear">Optimize:Clear</a>

                </div>
            </div>

            <div class="btn-group ml-2">
                <button type="button"
                        class="btn btn-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">Sunucu Aç / Kapat <i
                        class="icon"><span
                            data-feather="chevron-down"></span></i>
                </button>
                <div class="dropdown-menu">
                    <a href="javascript:void(0);" type="button" class="dropdown-item sa-serverUp">Sunucuyu aç</a>
                    <a href="javascript:void(0);" type="button" class="dropdown-item sa-serverDown">Sunucuyu kapat</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <span
                                class="text-muted text-uppercase font-size-12 font-weight-bold">Kullanıcı sayısı</span>
                            <h2 class="mb-0">{{$tuc}}</h2>
                        </div>
                        <div class="align-self-center">
                            <div id="tuchart" class="apex-charts mb-2"></div>
                            @if($l7du[0] == 0)
                                @if($l7du[1] == 0)
                                    <span class="text-muted font-weight-bold font-size-13"><i class='uil uil-minus'></i>0.0%</span>
                                @else
                                    <span class="text-danger font-weight-bold font-size-13"><i
                                            class='uil uil-arrow-down'></i>100.0%</span>
                                @endif
                            @else
                                @if($l7du[1] == 0)
                                    <span class="text-success font-weight-bold font-size-13"><i
                                            class='uil uil-arrow-up'></i>100.0%</span>
                                @else
                                    @if($l7du[1] > $l7du[0])
                                        <span class="text-danger font-weight-bold font-size-13"><i
                                                class='uil uil-arrow-down'></i>{{number_format(($l7du[1]-$l7du[0])/$l7du[1]*100,2,'.',',')}}%</span>
                                    @elseif($l7du[1] < $l7du[0])
                                        <span class="text-success font-weight-bold font-size-13"><i
                                                class='uil uil-arrow-up'></i>{{number_format(($l7du[0]-$l7du[1])/$l7du[1]*100,2,'.',',')}}%</span>
                                    @elseif($l7du[1] == $l7du[0])
                                        <span class="text-muted font-weight-bold font-size-13"><i
                                                class='uil uil-minus'></i>0.0%</span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <span class="text-muted text-uppercase font-size-12 font-weight-bold">Yorum sayısı</span>
                            <h2 class="mb-0">{{$tcc}}</h2>
                        </div>
                        <div class="align-self-center">
                            <div id="tcchart" class="apex-charts mb-2"></div>
                            @if($l7dc[0] == 0)
                                @if($l7dc[1] == 0)
                                    <span class="text-muted font-weight-bold font-size-13"><i class='uil uil-minus'></i>0.0%</span>
                                @else
                                    <span class="text-danger font-weight-bold font-size-13"><i
                                            class='uil uil-arrow-down'></i>100.0%</span>
                                @endif
                            @else
                                @if($l7dc[1] == 0)
                                    <span class="text-success font-weight-bold font-size-13"><i
                                            class='uil uil-arrow-up'></i>100.0%</span>
                                @else
                                    @if($l7dc[1] > $l7dc[0])
                                        <span class="text-danger font-weight-bold font-size-13"><i
                                                class='uil uil-arrow-down'></i>{{number_format(($l7dc[1]-$l7dc[0])/$l7dc[1]*100,2,'.',',')}}%</span>
                                    @elseif($l7dc[1] < $l7dc[0])
                                        <span class="text-success font-weight-bold font-size-13"><i
                                                class='uil uil-arrow-up'></i>{{number_format(($l7dc[0]-$l7dc[1])/$l7dc[1]*100,2,'.',',')}}%</span>
                                    @elseif($l7dc[1] == $l7dc[0])
                                        <span class="text-muted font-weight-bold font-size-13"><i
                                                class='uil uil-minus'></i>0.0%</span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <span class="text-muted text-uppercase font-size-12 font-weight-bold">Fotoğraf sayısı</span>
                            <h2 class="mb-0">{{$tpc}}</h2>
                        </div>
                        <div class="align-self-center">
                            <div id="tpchart" class="apex-charts mb-2"></div>
                            @if($l7dp[0] == 0)
                                @if($l7dp[1] == 0)
                                    <span class="text-muted font-weight-bold font-size-13"><i class='uil uil-minus'></i>0.0%</span>
                                @else
                                    <span class="text-danger font-weight-bold font-size-13"><i
                                            class='uil uil-arrow-down'></i>100.0%</span>
                                @endif
                            @else
                                @if($l7dp[1] == 0)
                                    <span class="text-success font-weight-bold font-size-13"><i
                                            class='uil uil-arrow-up'></i>100.0%</span>
                                @else
                                    @if($l7dp[1] > $l7dp[0])
                                        <span class="text-danger font-weight-bold font-size-13"><i
                                                class='uil uil-arrow-down'></i>{{number_format(($l7dp[1]-$l7dp[0])/$l7dp[1]*100,2,'.',',')}}%</span>
                                    @elseif($l7dp[1] < $l7dp[0])
                                        <span class="text-success font-weight-bold font-size-13"><i
                                                class='uil uil-arrow-up'></i>{{number_format(($l7dp[0]-$l7dp[1])/$l7dp[1]*100,2,'.',',')}}%</span>
                                    @elseif($l7dp[1] == $l7dp[0])
                                        <span class="text-muted font-weight-bold font-size-13"><i
                                                class='uil uil-minus'></i>0.0%</span>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body p-0">
                    <div class="media p-3">
                        <div class="media-body">
                            <div class="row mb-2">
                                <div class="col-xl-6">
                            <span
                                class="text-muted text-uppercase font-size-12 font-weight-bold">Aktif Mağaza Sayısı</span>
                                    <h2 class="mb-0">{{$tsc}}</h2>
                                </div>
                                <div class="col-xl-6">
                            <span
                                class="text-muted text-uppercase font-size-12 font-weight-bold">Marka Sayısı</span>
                                    <h2 class="mb-0">{{$tbc}}</h2>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xl-6">
            <h4>Kullanıcı</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body p-0">
                    <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan itibaren</h5>
                    <div class="media px-3 py-4 border-bottom">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$nuc}}</h4>
                            <span class="text-muted">Yeni kullanıcı</span>
                        </div>
                        <i data-feather="users" class="align-self-center icon-dual icon-lg"></i>
                    </div>

                    <div class="media px-3 py-4 border-bottom">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$ulc}}</h4>
                            <span class="text-muted">Uygulamaya giriş yapan kullanıcı sayısı</span>
                        </div>
                        <i data-feather="log-in" class="align-self-center icon-dual icon-lg"></i>
                    </div>

                    <div class="media px-3 py-4">
                        <div class="media-body">
                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$muc}}</h4>
                            <span class="text-muted">Makina kullanım sayısı</span>
                        </div>
                        <i data-feather="search" class="align-self-center icon-dual icon-lg"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mt-0 mb-0 header-title">En son üye olan kullanıcılar</h5>
                    <div class="table-responsive mt-3">
                        <table class="table table-hover table-nowrap mb-0">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Ad-Soyad</th>
                                <th scope="col">E-posta</th>
                                <th scope="col">Şehir</th>
                                <th scope="col">Durum</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lru as $lu)
                                <tr>
                                    <td>{{$lu->id}}</td>
                                    <td><a class="text-muted"
                                           href="/adminpanel/kullanicilar/normal/{{$lu->id}}">{{$lu->name}} {{$lu->surname}}</a>
                                    </td>
                                    <td>{{$lu->email}}</td>
                                    <td>{{$lu->city}}</td>
                                    @if($lu->email_verified_at)
                                        <td><span class="badge badge-soft-success py-1">Onaylandı</span></td>
                                    @else
                                        <td><span class="badge badge-soft-danger py-1">Onaylanmadı</span></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mt-0 mb-0 header-title">En fazla kullanıcısı olan şehirler</h5>
                    <div id="cuchart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-fill">
                        <li class="nav-item">
                            <a href="#yazilar" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-pen"></i></span>
                                <span class="d-none d-sm-block">Yazılar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#etkinlikler" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-calendar-alt"></i></span>
                                <span class="d-none d-sm-block">Etkinlikler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#paylasimlar" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-images"></i></span>
                                <span class="d-none d-sm-block">Paylaşımlar</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content text-muted">
                        <div class="tab-pane show active" id="yazilar">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <h5 class="card-title header-title border-bottom p-3 mb-0">Tüm zamanlar</h5>
                                            <div class="media px-3 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tarc}}</h4>
                                                    <span class="text-muted">Toplam yazı sayısı</span>
                                                </div>
                                                <i data-feather="file-text"
                                                   class="align-self-center icon-dual icon-lg"></i>
                                            </div>
                                            <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan
                                                itibaren</h5>
                                            <div class="media px-3 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$toarc}}</h4>
                                                    <span class="text-muted">Yeni eklenen yazı sayısı</span>
                                                </div>
                                                <i data-feather="plus" class="align-self-center icon-dual icon-lg"></i>
                                            </div>


                                            <div class="media px-3 py-4">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$toarfc}}</h4>
                                                    <span class="text-muted">Favoriye eklenen yazı sayısı</span>
                                                </div>
                                                <i data-feather="heart" class="align-self-center icon-dual icon-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mt-0 mb-0 header-title">En popüler yazılar</h5>
                                            <div class="table-responsive mt-3 mb-0">
                                                <table class="table table-hover mt-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Mağaza</th>
                                                        <th scope="col">Başlık</th>
                                                        <th scope="col">Favori sayısı</th>
                                                        <th scope="col">Görüntülenme sayısı</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mfarts as $lu)
                                                        <tr>
                                                            <td>{{$lu->id}}</td>
                                                            <td><a class="text-muted"
                                                                   href="/adminpanel/magazalar/{{$lu->store->id}}">#{{$lu->store->id}}
                                                                    - {{$lu->store->name}}</a>
                                                            </td>
                                                            <td>{{$lu->title}}</td>
                                                            <td>{{$lu->favorites_count}}</td>
                                                            <td>{{$lu->viewCount}}</td>
                                                            <td><a type="button" data-toggle="modal"
                                                                   data-target="#yaziModal{{$lu->id}}"
                                                                   class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                                   href="javascript:void(0);">Detay
                                                                </a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                @foreach($mfarts as $yazi)
                                                    <div class="modal fade" id="yaziModal{{$yazi->id}}" tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="yaziModal{{$yazi->id}}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="yaziModal{{$yazi->id}}">
                                                                        Yazı detay</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Kapat">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h6>{{$yazi->title}}</h6>
                                                                    <hr>
                                                                    <p>{{$yazi->desc}}</p>
                                                                    <p class="font-weight-bold">Eklenme
                                                                        tarihi: {{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</p>
                                                                    <div class="popup-gallery"
                                                                         data-source="{{$yazi->imageLink}}">
                                                                        <a href="{{$yazi->imageLink}}" title="">
                                                                            <img src="{{$yazi->imageLink}}" alt="img"
                                                                                 class="avatar-md rounded">
                                                                        </a>
                                                                    </div>
                                                                    @if($yazi->hasVideo)
                                                                        <hr>
                                                                        <td>Video bağlantısı: {{$yazi->videoLink}}</td>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="etkinlikler">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <h5 class="card-title header-title border-bottom p-3 mb-0">Tüm zamanlar</h5>
                                            <div class="media px-3 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tactc}}</h4>
                                                    <span class="text-muted">Toplam etkinlik sayısı</span>
                                                </div>
                                                <i data-feather="calendar"
                                                   class="align-self-center icon-dual icon-lg"></i>
                                            </div>
                                            <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan
                                                itibaren</h5>
                                            <div class="media px-3 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$toactc}}</h4>
                                                    <span class="text-muted">Yeni eklenen etkinlik sayısı</span>
                                                </div>
                                                <i data-feather="plus" class="align-self-center icon-dual icon-lg"></i>
                                            </div>


                                            <div class="media px-3 py-4">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$toactfc}}</h4>
                                                    <span class="text-muted">Favoriye eklenen etkinlik sayısı</span>
                                                </div>
                                                <i data-feather="heart" class="align-self-center icon-dual icon-lg"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mt-0 mb-0 header-title">En popüler etkinlikler</h5>
                                            <div class="table-responsive mt-3 mb-0">
                                                <table class="table table-hover mt-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Mağaza</th>
                                                        <th scope="col">Başlık</th>
                                                        <th scope="col">Favori sayısı</th>
                                                        <th scope="col">Görüntülenme sayısı</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mfacsts as $lu)
                                                        <tr>
                                                            <td>{{$lu->id}}</td>
                                                            <td><a class="text-muted"
                                                                   href="/adminpanel/magazalar/{{$lu->store->id}}">#{{$lu->store->id}}
                                                                    - {{$lu->store->name}}</a>
                                                            </td>
                                                            <td>{{$lu->title}}</td>
                                                            <td>{{$lu->favorites_count}}</td>
                                                            <td>{{$lu->viewCount}}</td>
                                                            <td><a type="button" data-toggle="modal"
                                                                   data-target="#etkModal{{$lu->id}}"
                                                                   class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                                   href="javascript:void(0);">Detay
                                                                </a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                @foreach($mfacsts as $etk)
                                                    <div class="modal fade" id="etkModal{{$etk->id}}" tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="etkModal{{$etk->id}}" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="etkModal{{$etk->id}}">
                                                                        Etkinlik detay</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Kapat">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <h6>{{$etk->title}}</h6>
                                                                    <hr>
                                                                    <p>{{$etk->desc}}</p>
                                                                    <p class="font-weight-bold">Eklenme
                                                                        tarihi: {{\Carbon\Carbon::createFromTimeString($etk->created_at)->format('d/m/Y H:i')}}</p>
                                                                    <div class="popup-gallery"
                                                                         data-source="{{$etk->imageLink}}">
                                                                        <a href="{{$etk->imageLink}}" title="">
                                                                            <img src="{{$etk->imageLink}}" alt="img"
                                                                                 class="avatar-md rounded">
                                                                        </a>
                                                                    </div>
                                                                    @if($etk->canTicketing)
                                                                        <hr>
                                                                        <p>Bilet fiyatı: {{$etk->ticketFee}}TL</p>
                                                                        <p>Kalan bilet
                                                                            sayısı: {{$etk->availableTicketCount}}</p>
                                                                        <a class="card-link" target="_blank"
                                                                           href="/adminpanel/etkinlikler/{{$etk->id}}/biletler">Biletler</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="paylasimlar">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <h5 class="card-title header-title border-bottom p-3 mb-0">Tüm zamanlar</h5>
                                            <div class="media px-3 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tstoc}}</h4>
                                                    <span class="text-muted">Toplam paylaşım sayısı</span>
                                                </div>
                                                <i data-feather="image" class="align-self-center icon-dual icon-lg"></i>
                                            </div>
                                            <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan
                                                itibaren</h5>
                                            <div class="media px-3 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tostoc}}</h4>
                                                    <span class="text-muted">Yeni eklenen paylaşım sayısı</span>
                                                </div>
                                                <i data-feather="plus" class="align-self-center icon-dual icon-lg"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title mt-0 mb-0 header-title">En çok görüntülenen
                                                paylaşımlar</h5>
                                            <div class="table-responsive mt-3 mb-0">
                                                <table class="table table-hover mt-0">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Mağaza</th>
                                                        <th scope="col">Görsel</th>
                                                        <th scope="col">Görüntülenme sayısı</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mvstos as $sto)
                                                        <tr>
                                                            <td>{{$sto->id}}</td>
                                                            <td><a class="text-muted"
                                                                   href="/adminpanel/magazalar/{{$sto->store->id}}">#{{$sto->store->id}}
                                                                    - {{$sto->store->name}}</a>
                                                            </td>
                                                            <td>
                                                                <div class="popup-gallery"
                                                                     data-source="{{$sto->imageLink}}">
                                                                    <a href="{{$sto->imageLink}}" title="">
                                                                        <img src="{{$sto->imageLink}}" alt="img"
                                                                             class="avatar-md rounded">
                                                                    </a>
                                                                </div>
                                                            </td>
                                                            <td>{{$sto->viewCount}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xl-6">
            <h4>Marka & Mağaza</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">En son eklenen markalar</h6>
                    @foreach($lbrs as $br)
                        <div class="media border-top pt-3">
                            <img src="{{$br->logo}}" class="avatar rounded mr-3" alt="logo">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15"><a
                                        href="/adminpanel/markalar/{{$br->id}}">{{$br->name}} ({{$br->stores_count}}
                                        mağaza)</a></h6>
                                <h6 class="text-muted font-weight-normal mt-1 mb-3">Eklenme
                                    tarihi: {{\Carbon\Carbon::createFromTimeString($br->created_at)->format('d/m/Y')}}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">En son eklenen mağazalar</h6>
                    @foreach($lstores as $lsto)
                        <div class="media border-top pt-3">
                            <img src="{{$lsto->brand->logo}}" class="avatar rounded mr-3" alt="logo">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15"><a
                                        href="/adminpanel/magazalar/{{$lsto->id}}">{{$lsto->name}}
                                        ({{$lsto->location->name}}, {{$lsto->city->name}})</a></h6>
                                <h6 class="text-muted font-weight-normal mt-1 mb-3">Eklenme
                                    tarihi: {{\Carbon\Carbon::createFromTimeString($lsto->created_at)->format('d/m/Y')}}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Mağaza sayısı değişimi</h6>
                    <div class="align-self-center">
                        <div id="sto-change-chart" class="apex-charts" dir="ltr"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 col-xl-6">
            <h4>Sadakat Kartları</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title header-title border-bottom p-3 mb-0">Tüm zamanlar</h5>
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="media px-3 py-4 border-right">
                                        <div class="media-body">
                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atclc}}</h4>
                                            <span class="text-muted">Aktif kart sayısı</span>
                                        </div>
                                        <i data-feather="credit-card" class="align-self-center icon-dual icon-lg"></i>
                                    </div>
                                </div>
                                <div class="col-xl-3">

                                    <div class="media px-3 py-4 border-right">
                                        <div class="media-body">
                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atavlc}}</h4>
                                            <span class="text-muted">Kullanılabilir kart sayısı</span>
                                        </div>
                                        <i data-feather="plus" class="align-self-center icon-dual icon-lg"></i>
                                    </div>
                                </div>
                                <div class="col-xl-3">

                                    <div class="media px-3 py-4 border-right">
                                        <div class="media-body">
                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atudlc}}</h4>
                                            <span class="text-muted">Kullanılan kart sayısı</span>
                                        </div>
                                        <i data-feather="check" class="align-self-center icon-dual icon-lg"></i>
                                    </div>
                                </div>
                                <div class="col-xl-3">

                                    <div class="media px-3 py-4">
                                        <div class="media-body">
                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atdellc}}</h4>
                                            <span class="text-muted">Silinen kart sayısı</span>
                                        </div>
                                        <i data-feather="trash-2" class="align-self-center icon-dual icon-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-2">
                    <div class="card">
                        <div class="card-body p-0">
                            <h5 class="card-title header-title border-bottom p-3 mb-3">00.00'dan itibaren</h5>
                            <div class="media px-3 py-4">
                                <div class="media-body">
                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tdclc}}</h4>
                                    <span class="text-muted">Yeni kart sayısı</span>
                                </div>
                                <i data-feather="credit-card" class="align-self-center icon-dual icon-lg"></i>
                            </div>

                            <div class="media px-3 py-4">
                                <div class="media-body">
                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tdavlc}}</h4>
                                    <span class="text-muted">Yeni kullanılabilir kart sayısı</span>
                                </div>
                                <i data-feather="plus" class="align-self-center icon-dual icon-lg"></i>
                            </div>

                            <div class="media px-3 py-4">
                                <div class="media-body">
                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tdudlc}}</h4>
                                    <span class="text-muted">Kullanılan kart sayısı</span>
                                </div>
                                <i data-feather="check" class="align-self-center icon-dual icon-lg"></i>
                            </div>
                            <div class="media px-3 py-4">
                                <div class="media-body">
                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tddellc}}</h4>
                                    <span class="text-muted">Silinen kart sayısı</span>
                                </div>
                                <i data-feather="trash-2" class="align-self-center icon-dual icon-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mt-0 mb-0 header-title">00.00'dan itibaren en fazla kart oluşturulan
                                markalar</h5>
                            <div class="table-responsive mt-3 mb-3">
                                <table class="table table-hover table-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Ad</th>
                                        <th scope="col">Bugün Oluşturulan Kart Sayısı</th>
                                        <th scope="col">Aktif Kart Sayısı</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($locbs as $locb)
                                        <tr>
                                            <td>{{$locb->id}}</td>
                                            <td><a class="text-muted"
                                                   href="/adminpanel/markalar/{{$locb->id}}">{{$locb->name}}</a>
                                            </td>
                                            <td>{{$locb->today_created_cards_count}}</td>
                                            <td>{{$locb->activeLoyaltyCardCount}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mt-0 mb-0 header-title">00.00'dan itibaren en fazla kart onaylayan
                                markalar</h5>
                            <div class="table-responsive mt-3 mb-3">
                                <table class="table table-hover table-nowrap mb-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Ad</th>
                                        <th scope="col">Bugün Onaylanan Kart Sayısı</th>
                                        <th scope="col">Kullanılan Kart Sayısı</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($locusedbs as $locb)
                                        <tr>
                                            <td>{{$locb->id}}</td>
                                            <td><a class="text-muted"
                                                   href="/adminpanel/markalar/{{$locb->id}}">{{$locb->name}}</a>
                                            </td>
                                            <td>{{$locb->today_approved_cards_count}}</td>
                                            <td>{{$locb->usedLoyaltyCardCount}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-fill">
                        <li class="nav-item">
                            <a href="#qr" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-code"></i></span>
                                <span class="d-none d-sm-block">QR Kodlar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#menuurunler" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-coffee"></i></span>
                                <span class="d-none d-sm-block">Menü Ürünleri</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content text-muted">
                        <div class="tab-pane show active" id="qr">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body p-0">
                                                    <h5 class="card-title header-title border-bottom p-3 mb-0">Tüm
                                                        zamanlar</h5>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="media px-3 py-4 border-right">
                                                                <div class="media-body">
                                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atkqrCount}}</h4>
                                                                    <span
                                                                        class="text-muted">Oluşturulan QR kod sayısı</span>
                                                                </div>
                                                                <i data-feather="plus"
                                                                   class="align-self-center icon-dual icon-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">

                                                            <div class="media px-3 py-4 border-right">
                                                                <div class="media-body">
                                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atUsedkqrCount}}</h4>
                                                                    <span
                                                                        class="text-muted">Kullanılan QR kod sayısı</span>
                                                                </div>
                                                                <i data-feather="check"
                                                                   class="align-self-center icon-dual icon-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">

                                                            <div class="media px-3 py-4">
                                                                <div class="media-body">
                                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$atDeletedkqrCount}}</h4>
                                                                    <span
                                                                        class="text-muted">Silinen QR kod sayısı</span>
                                                                </div>
                                                                <i data-feather="trash-2"
                                                                   class="align-self-center icon-dual icon-lg"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mt-0 mb-0 header-title">Tüm zamanlar en fazla
                                                        QR kod oluşturulan
                                                        ürünler</h5>
                                                    <div class="table-responsive mt-3 mb-0">
                                                        <table class="table table-hover table-nowrap mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Ürün</th>
                                                                <th scope="col">Mağaza</th>
                                                                <th scope="col">Toplam Kod Sayısı</th>
                                                                <th scope="col">Aktif Kod Sayısı</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($items3 as $item1)
                                                                <tr>
                                                                    <td>{{$item1->id}}</td>
                                                                    <td>{{$item1->title}}</td>
                                                                    <td><a class="text-muted"
                                                                           href="/adminpanel/magazalar/{{$item1->store->id}}">#{{$item1->store->id}}
                                                                            - {{$item1->store->name}}</a>
                                                                    </td>
                                                                    <td>{{$item1->qrcodes_count}}</td>
                                                                    <td>{{$item1->active_qrcodes_count}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mt-0 mb-0 header-title">Tüm zamanlar en fazla
                                                        QR kod kullanılan
                                                        ürünler</h5>
                                                    <div class="table-responsive mt-3 mb-0">
                                                        <table class="table table-hover table-nowrap mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Ürün</th>
                                                                <th scope="col">Mağaza</th>
                                                                <th scope="col">Toplam Kod Sayısı</th>
                                                                <th scope="col">Kullanılan Kod Sayısı</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($items4 as $item1)
                                                                <tr>
                                                                    <td>{{$item1->id}}</td>
                                                                    <td>{{$item1->title}}</td>
                                                                    <td><a class="text-muted"
                                                                           href="/adminpanel/magazalar/{{$item1->store->id}}">#{{$item1->store->id}}
                                                                            - {{$item1->store->name}}</a>
                                                                    </td>
                                                                    <td>{{$item1->qrcodes_count}}</td>
                                                                    <td>{{$item1->used_qrcodes_count}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="card">
                                                <div class="card-body p-0">
                                                    <h5 class="card-title header-title border-bottom p-3 mb-3">00.00'dan
                                                        itibaren</h5>
                                                    <div class="media px-3 py-4">
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tdCdkqrCount}}</h4>
                                                            <span class="text-muted">Yeni QR kod sayısı</span>
                                                        </div>
                                                        <i data-feather="plus"
                                                           class="align-self-center icon-dual icon-lg"></i>
                                                    </div>

                                                    <div class="media px-3 py-4">
                                                        <div class="media-body mt-3">
                                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tdUsedkqrCount}}</h4>
                                                            <span class="text-muted">Kullanılan QR kod sayısı</span>
                                                        </div>
                                                        <i data-feather="check"
                                                           class="align-self-center icon-dual icon-lg"></i>
                                                    </div>
                                                    <div class="media px-3 py-4">
                                                        <div class="media-body mt-3">
                                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$tdDeletedkqrCount}}</h4>
                                                            <span class="text-muted">Silinen QR kod sayısı</span>
                                                        </div>
                                                        <i data-feather="trash-2"
                                                           class="align-self-center icon-dual icon-lg"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-9">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mt-0 mb-0 header-title">00.00'dan itibaren en
                                                        fazla QR kod oluşturulan
                                                        ürünler</h5>
                                                    <div class="table-responsive mt-3 mb-0">
                                                        <table class="table table-hover table-nowrap mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Ürün</th>
                                                                <th scope="col">Mağaza</th>
                                                                <th scope="col">Bugün Oluşturulan Kod Sayısı</th>
                                                                <th scope="col">Aktif Kod Sayısı</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($items1 as $item1)
                                                                <tr>
                                                                    <td>{{$item1->id}}</td>
                                                                    <td>{{$item1->title}}</td>
                                                                    <td><a class="text-muted"
                                                                           href="/adminpanel/magazalar/{{$item1->store->id}}">#{{$item1->store->id}}
                                                                            - {{$item1->store->name}}</a>
                                                                    </td>
                                                                    <td>{{$item1->today_created_qrcodes_count}}</td>
                                                                    <td>{{$item1->active_qrcodes_count}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mt-0 mb-0 header-title">00.00'dan itibaren en
                                                        fazla QR kod kullanılan
                                                        ürünler</h5>
                                                    <div class="table-responsive mt-3 mb-0">
                                                        <table class="table table-hover table-nowrap mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Ürün</th>
                                                                <th scope="col">Mağaza</th>
                                                                <th scope="col">Bugün Kullanılan Kod Sayısı</th>
                                                                <th scope="col">Kullanılan Kod Sayısı</th>
                                                                <th scope="col">Aktif Kod Sayısı</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($items2 as $item1)
                                                                <tr>
                                                                    <td>{{$item1->id}}</td>
                                                                    <td>{{$item1->title}}</td>
                                                                    <td><a class="text-muted"
                                                                           href="/adminpanel/magazalar/{{$item1->store->id}}">#{{$item1->store->id}}
                                                                            - {{$item1->store->name}}</a>
                                                                    </td>
                                                                    <td>{{$item1->today_used_qrcodes_count}}</td>
                                                                    <td>{{$item1->used_qrcodes_count}}</td>
                                                                    <td>{{$item1->active_qrcodes_count}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane" id="menuurunler">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body p-0">
                                                    <h5 class="card-title header-title border-bottom p-3 mb-0">
                                                        Sayılar</h5>
                                                    <div class="row">
                                                        <div class="col-xl-4">
                                                            <div class="media px-3 py-4 border-right">
                                                                <div class="media-body">
                                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$itemC}}</h4>
                                                                    <span class="text-muted">Toplam ürün sayısı</span>
                                                                </div>
                                                                <i data-feather="coffee"
                                                                   class="align-self-center icon-dual icon-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">

                                                            <div class="media px-3 py-4 border-right">
                                                                <div class="media-body">
                                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$itemAcC}}</h4>
                                                                    <span class="text-muted">Aktif ürün sayısı</span>
                                                                </div>
                                                                <i data-feather="check"
                                                                   class="align-self-center icon-dual icon-lg"></i>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">

                                                            <div class="media px-3 py-4">
                                                                <div class="media-body">
                                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$itemTdC}}</h4>
                                                                    <span
                                                                        class="text-muted">Bugün eklenen ürün sayısı</span>
                                                                </div>
                                                                <i data-feather="plus"
                                                                   class="align-self-center icon-dual icon-lg"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title mt-0 mb-0 header-title">En çok görüntülenen
                                                        ürünler</h5>
                                                    <div class="table-responsive mt-3 mb-0">
                                                        <table class="table table-hover table-nowrap mb-0">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col">ID</th>
                                                                <th scope="col">Ürün</th>
                                                                <th scope="col">Mağaza</th>
                                                                <th scope="col">Görüntülenme Sayısı</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($mvItems as $item1)
                                                                <tr>
                                                                    <td>{{$item1->id}}</td>
                                                                    <td>{{$item1->title}}</td>
                                                                    <td><a class="text-muted"
                                                                           href="/adminpanel/magazalar/{{$item1->store->id}}">#{{$item1->store->id}}
                                                                            - {{$item1->store->name}}</a>
                                                                    </td>
                                                                    <td>{{$item1->views_count}}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body pt-2">
                                                    <h6 class="header-title mb-4">Ürün sayısı değişimi</h6>
                                                    <div class="align-self-center">
                                                        <div id="item-change-chart" class="apex-charts" dir="ltr"></div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body p-0">
                                                    <h5 class="card-title header-title border-bottom p-3 mb-0">
                                                        Kategoriler</h5>
                                                    <div class="row">
                                                        @foreach($itemCats as $itemcat)
                                                            <div class="col-xl-4">
                                                                <div class="media px-3 py-4 border-right">
                                                                    <div class="media-body">
                                                                        <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$itemcat->items_count}}</h4>
                                                                        <span class="text-muted">{{$itemcat->desc}} ürün sayısı</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="markaEkleModal" tabindex="-1" role="dialog"
         aria-labelledby="markaEkleModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markaEkleModal">Marka Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="/adminpanel/markaekle">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" required class="form-control" id="name"
                                           placeholder="Ad">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="needStampCount" class="col-md-4 col-form-label">Gereken damga sayısı</label>
                                <div class="col-md-8">
                                    <input type="number" name="needStampCount" required class="form-control"
                                           id="needStampCount"
                                           placeholder="Gereken damga sayısı" value="6">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isEnabledLoyaltyCard" class="col-md-4 col-form-label">QR & Sadakat
                                    kartı</label>
                                <div class="custom-control custom-radio mt-2 ml-3">
                                    <input type="radio" id="isEnabledLoyaltyCard" name="isEnabledLoyaltyCard" value="1"
                                           class="custom-control-input" checked>
                                    <label class="custom-control-label" for="isEnabledLoyaltyCard">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio ml-4 mt-2">
                                    <input type="radio" id="isEnabledLoyaltyCard2" name="isEnabledLoyaltyCard" value="0"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="isEnabledLoyaltyCard2">Pasif</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="adminNote" class="col-md-4 col-form-label">Admin notu</label>
                                <div class="col-md-8">
                        <textarea type="text" rows="2" name="adminNote" class="form-control" id="adminNote"
                                  placeholder="Admin notu"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label">Logo</label>
                                <div class="col-md-8">
                                    <input type="file" id="image" name="image" data-max-file-size="1M" required
                                           data-show-loader="true" data-allowed-formats="square"
                                           data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                            </div>


                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="magazaEkleModal" tabindex="-1" role="dialog"
         aria-labelledby="magazaEkleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="magazaEkleModal">Mağaza Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" action="/adminpanel/magazaekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="email" value="ownerless-store@kafeyinapp.com">
                            <div class="form-group row">
                                <label for="cityID" class="col-md-3 col-form-label">Şehir</label>
                                <div class="col-md-9">
                                    <select data-plugin="selectCity" required class="form-control" name="cityID">
                                        <option></option>
                                        @foreach($ccities as $city)
                                            <option value="{{$city->id}}">#{{$city->id}} - {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="locationID" class="col-md-3 col-form-label">Lokasyon</label>
                                <div class="col-md-9">
                                    <select data-plugin="selectLoc" required class="form-control" name="locationID">
                                        <option></option>
                                        @foreach($ccities as $city)
                                            @if(count($city->locations))
                                                <optgroup label="{{$city->name}}">
                                                    @foreach($city->locations as $loc)
                                                        <option value="{{$loc->id}}">#{{$loc->id}}
                                                            - {{$loc->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="brandID" class="col-md-3 col-form-label">Marka</label>
                                <div class="col-md-9">
                                    <select data-plugin="selectBrand" required class="form-control" name="brandID">
                                        <option></option>
                                        @foreach($bbrands as $brand)
                                            <option value="{{$brand->id}}">#{{$brand->id}} - {{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isCafe" class="col-md-3 col-form-label">Kafe mi?</label>
                                <div class="custom-control custom-radio mt-2 ml-3">
                                    <input type="radio" id="isCafe" name="isCafe" value="1" class="custom-control-input"
                                           checked>
                                    <label class="custom-control-label" for="isCafe">Olumlu</label>
                                </div>
                                <div class="custom-control custom-radio ml-4 mt-2">
                                    <input type="radio" id="isCafe2" name="isCafe" value="0"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="isCafe2">Olumsuz</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="isActive" class="col-md-3 col-form-label">Aktiflik</label>
                                <div class="custom-control custom-radio mt-2 ml-3">
                                    <input type="radio" id="isActive" name="isActive" value="1"
                                           class="custom-control-input" checked>
                                    <label class="custom-control-label" for="isActive">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio ml-4 mt-2">
                                    <input type="radio" id="isActive2" name="isActive" value="0"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="isActive2">Pasif</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label">Ad</label>
                                <div class="col-md-9">
                                    <input type="text" name="name" required class="form-control" id="name"
                                           placeholder="Ad">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="featured" class="col-md-3 col-form-label">Öne çıkan</label>
                                <div class="col-md-9">
                                    <textarea type="text" rows="2" name="featured" class="form-control" id="featured"
                                              placeholder="Öne çıkan"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-md-3 col-form-label">Adres</label>
                                <div class="col-md-9">
                                    <textarea type="text" rows="2" name="address" required class="form-control"
                                              id="address"
                                              placeholder="Adres"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="latitude" class="col-md-3 col-form-label">Enlem</label>
                                <div class="col-md-9">
                                    <input type="text" name="latitude" class="form-control"
                                           data-inputmask-alias="99.999999" id="latitude" required placeholder="Enlem">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="longitude" class="col-md-3 col-form-label">Boylam</label>
                                <div class="col-md-9">
                                    <input type="text" name="longitude" class="form-control"
                                           data-inputmask-alias="99.999999" id="longitude" required
                                           placeholder="Boylam">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="landPhoneNumber" class="col-md-3 col-form-label">Sabit telefon</label>
                                <div class="col-md-9">
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">+90</div>
                                        </div>
                                        <input type="text" name="landPhoneNumber" class="form-control"
                                               data-inputmask-alias="9999999999" id="landPhoneNumber"
                                               placeholder="Sabit telefon">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="monOpen" class="col-md-3 col-form-label">Pazartesi Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="monO-tp" name="monOpen" required class="form-control"
                                                   placeholder="Pazartesi Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="monClose" class="col-md-3 col-form-label">Pazartesi Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="monC-tp" name="monClose" required
                                                   class="form-control" placeholder="Pazartesi Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="tueOpen" class="col-md-3 col-form-label">Salı Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="tueO-tp" name="tueOpen" required class="form-control"
                                                   placeholder="Salı Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="tueClose" class="col-md-3 col-form-label">Salı Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="tueC-tp" name="tueClose" required
                                                   class="form-control" placeholder="Salı Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="wedOpen" class="col-md-3 col-form-label">Çarşamba Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="wedO-tp" name="wedOpen" required class="form-control"
                                                   placeholder="Çarşamba Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="wedClose" class="col-md-3 col-form-label">Çarşamba Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="wedC-tp" name="wedClose" required
                                                   class="form-control" placeholder="Çarşamba Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="thuOpen" class="col-md-3 col-form-label">Perşembe Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="thuO-tp" name="thuOpen" required class="form-control"
                                                   placeholder="Perşembe Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="thuClose" class="col-md-3 col-form-label">Perşembe Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="thuC-tp" name="thuClose" required
                                                   class="form-control" placeholder="Perşembe Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="friOpen" class="col-md-3 col-form-label">Cuma Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="friO-tp" name="friOpen" required class="form-control"
                                                   placeholder="Cuma Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="friClose" class="col-md-3 col-form-label">Cuma Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="friC-tp" name="friClose" required
                                                   class="form-control" placeholder="Cuma Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="satOpen" class="col-md-3 col-form-label">Cumartesi Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="satO-tp" name="satOpen" required class="form-control"
                                                   placeholder="Cumartesi Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="satClose" class="col-md-3 col-form-label">Cumartesi Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="satC-tp" name="satClose" required
                                                   class="form-control" placeholder="Cumartesi Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="sunOpen" class="col-md-3 col-form-label">Pazar Açılış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="sunO-tp" name="sunOpen" required class="form-control"
                                                   placeholder="Pazar Açılış">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="sunClose" class="col-md-3 col-form-label">Pazar Kapanış</label>
                                        <div class="col-md-9">
                                            <input type="text" id="sunC-tp" name="sunClose" required
                                                   class="form-control" placeholder="Pazar Kapanış">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isStudy" class="col-md-6 col-form-label">Ders çalışma ortamı</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isStudy" name="isStudy" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isStudy">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isStudy2" name="isStudy" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isStudy2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isDate" class="col-md-6 col-form-label">Buluşmaya uygun</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isDate" name="isDate" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isDate">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isDate2" name="isDate" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isDate2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isLatteArt" class="col-md-6 col-form-label">Latte-art</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isLatteArt" name="isLatteArt" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isLatteArt">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isLatteArt2" name="isLatteArt" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isLatteArt2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isPetFriendly" class="col-md-6 col-form-label">Hayvan dostu</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isPetFriendly" name="isPetFriendly" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isPetFriendly">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isPetFriendly2" name="isPetFriendly" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isPetFriendly2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isDessert" class="col-md-6 col-form-label">Tatlı</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isDessert" name="isDessert" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isDessert">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isDessert2" name="isDessert" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isDessert2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isMeeting" class="col-md-6 col-form-label">Toplantıya uygun</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isMeeting" name="isMeeting" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isMeeting">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isMeeting2" name="isMeeting" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isMeeting2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isAlcohol" class="col-md-6 col-form-label">Alkollü magaza</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isAlcohol" name="isAlcohol" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isAlcohol">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isAlcohol2" name="isAlcohol" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isAlcohol2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isOutside" class="col-md-6 col-form-label">Dış magaza</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isOutside" name="isOutside" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isOutside">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isOutside2" name="isOutside" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isOutside2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isMeal" class="col-md-6 col-form-label">Yemek</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isMeal" name="isMeal" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isMeal">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isMeal2" name="isMeal" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isMeal2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isBreakfast" class="col-md-6 col-form-label">Kahvaltı</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isBreakfast" name="isBreakfast" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isBreakfast">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isBreakfast2" name="isBreakfast" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isBreakfast2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isChocolate" class="col-md-6 col-form-label">Çikolata</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isChocolate" name="isChocolate" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isChocolate">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isChocolate2" name="isChocolate" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isChocolate2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isTakePhoto" class="col-md-6 col-form-label">Fotoğraf için
                                            dekor</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isTakePhoto" name="isTakePhoto" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isTakePhoto">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isTakePhoto2" name="isTakePhoto" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isTakePhoto2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isSelfService" class="col-md-6 col-form-label">Self-servis</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isSelfService" name="isSelfService" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isSelfService">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isSelfService2" name="isSelfService" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isSelfService2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isTea" class="col-md-6 col-form-label">Çay</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isTea" name="isTea" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isTea">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isTea2" name="isTea" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isTea2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <label for="isLiveMusic" class="col-md-6 col-form-label">Canlı müzik</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="isLiveMusic" name="isLiveMusic" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label" for="isLiveMusic">Olumlu</label>
                                        </div>
                                        <div class="custom-control custom-radio ml-4 mt-2">
                                            <input type="radio" id="isLiveMusic2" name="isLiveMusic" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="isLiveMusic2">Olumsuz</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="image2" class="col-md-3 col-form-label">Kapak fotoğrafı</label>
                                <div class="col-md-9">
                                    <input type="file" id="image2" name="image2" data-max-file-size="1M" required
                                           data-show-loader="true" data-allowed-formats="square"
                                           data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                            </div>


                            <div class="offset-md-3">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="adminKullaniciEkle" tabindex="-1" role="dialog"
         aria-labelledby="adminKullaniciEkle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="adminKullaniciEkle">Admin Kullanıcı Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/adminpanel/adminkullaniciekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="userType" value="admin">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" required class="form-control" id="name"
                                           placeholder="Ad">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label">Soyad</label>
                                <div class="col-md-8">
                                    <input type="text" name="surname" required class="form-control" id="surname"
                                           placeholder="Soyad">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">E-posta</label>
                                <div class="col-md-8">
                                    <input type="email" name="email" required class="form-control" id="email"
                                           placeholder="E-posta">
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="magazaKullaniciEkle" tabindex="-1" role="dialog"
         aria-labelledby="magazaKullaniciEkle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="magazaKullaniciEkle">Mağaza Kullanıcı Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/adminpanel/magazakullaniciekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="userType" value="store">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" required class="form-control" id="name"
                                           placeholder="Ad">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label">Soyad</label>
                                <div class="col-md-8">
                                    <input type="text" name="surname" required class="form-control" id="surname"
                                           placeholder="Soyad">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">E-posta</label>
                                <div class="col-md-8">
                                    <input type="email" name="email" required class="form-control" id="email"
                                           placeholder="E-posta">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label">Şifre</label>
                                <div class="col-md-8">
                                    <input type="text" name="password" required class="form-control" id="password"
                                           placeholder="Şifre">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="isBrandManager" class="col-md-4 col-form-label">Marka yöneticisi mi?</label>
                                <div class="custom-control custom-radio mt-2 ml-2">
                                    <input type="radio" id="isBrandManager" name="isBrandManager" value="1"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="isBrandManager">Olumlu</label>
                                </div>
                                <div class="custom-control custom-radio ml-4 mt-2">
                                    <input type="radio" id="isBrandManager2" name="isBrandManager" value="0"
                                           class="custom-control-input" checked>
                                    <label class="custom-control-label" for="isBrandManager2">Olumsuz</label>
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="normalKullaniciEkle" tabindex="-1" role="dialog"
         aria-labelledby="normalKullaniciEkle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="normalKullaniciEkle">Normal Kullanıcı Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/adminpanel/normalkullaniciekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="userType" value="user">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" required class="form-control" id="name"
                                           placeholder="Ad">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="surname" class="col-md-4 col-form-label">Soyad</label>
                                <div class="col-md-8">
                                    <input type="text" name="surname" required class="form-control" id="surname"
                                           placeholder="Soyad">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label">E-posta</label>
                                <div class="col-md-8">
                                    <input type="email" name="email" required class="form-control" id="email"
                                           placeholder="E-posta">
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
        var series11 = [
            @foreach(array_reverse($l15ds) as $du)
            {{$du}},
            @endforeach
        ];

        var series22 = [
            @foreach(array_reverse($l15is) as $du)
            {{$du}},
            @endforeach
        ];

        var labels12 = [
            @foreach(array_reverse($l15days) as $day)
            new Date({{$day}}).toLocaleDateString(),
            @endforeach
        ];

        var options12 = {
            chart: {
                height: 374,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            series: [{
                name: 'Mağaza sayısı',
                data: series11
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#43d39e'],
            xaxis: {
                type: 'string',
                categories: labels12,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#sto-change-chart"), options12);
        chart.render();

        var options23 = {
            chart: {
                height: 374,
                type: 'area'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            series: [{
                name: 'Ürün sayısı',
                data: series22
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#427dd3'],
            xaxis: {
                type: 'string',
                categories: labels12,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var chart2 = new ApexCharts(document.querySelector("#item-change-chart"), options23);
        chart2.render();
    </script>
    <script>
        var series = [
            @foreach($cuc as $c)
            {{$c->users_count}},
            @endforeach
        ];
        var labels = [
                @foreach($cuc as $c)
            ["{{$c->name}}"],
            @endforeach
        ];
        var options = {
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%'
                    },
                    expandOnClick: true
                }
            },
            chart: {
                height: 291,
                type: 'donut'
            },
            legend: {
                show: true,
                position: 'right',
                horizontalAlign: 'left',
                itemMargin: {
                    horizontal: 0,
                    vertical: 0
                }
            },
            series: series,
            labels: labels,
            responsive: [{
                breakpoint: 4,
                options: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function formatter(value) {
                        return value + " kullanıcı";
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#cuchart"), options);
        chart.render();
    </script>
    <script>
        var series = [
            @foreach(array_reverse($l7du) as $du)
            {{$du}},
            @endforeach
        ];
        var options2 = {
            chart: {
                type: 'area',
                height: 45,
                width: 90,
                sparkline: {
                    enabled: true
                }
            },
            series: [{
                data: series,
            }],
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            yaxis: {
                floating: false,
                labels: {
                    formatter: function (val) {
                        return Math.floor(val)
                    }
                }
            },
            colors: @if($l7du[0] > $l7du[1]) ["#43d39e"] @elseif($l7du[0] < $l7du[1]) ["#ff5c75"] @else ["#ff8c00"] @endif,
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function (seriesName) {
                            return '';
                        }
                    },
                },
                marker: {
                    show: false
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        new ApexCharts(document.querySelector("#tuchart"), options2).render();
        var series2 = [
            @foreach(array_reverse($l7dc) as $du)
            {{$du}},
            @endforeach
        ];
        var options3 = {
            chart: {
                type: 'area',
                height: 45,
                width: 90,
                sparkline: {
                    enabled: true
                }
            },
            series: [{
                data: series2,
            }],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            colors: @if($l7dc[0] > $l7dc[1]) ["#43d39e"] @elseif($l7dc[0] < $l7dc[1]) ["#ff5c75"] @else ["#ff8c00"] @endif ,
            yaxis: {
                floating: false,
                labels: {
                    formatter: function (val) {
                        return Math.floor(val)
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false,
                },
                y: {
                    title: {
                        formatter: function (seriesName) {
                            return '';
                        }
                    },
                },
                marker: {
                    show: false
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [8, 100]
                }
            }
        };
        new ApexCharts(document.querySelector("#tcchart"), options3).render();
        var series3 = [
            @foreach(array_reverse($l7dp) as $du)
            {{$du}},
            @endforeach
        ];
        var options4 = {
            chart: {
                type: 'area',
                height: 45,
                width: 90,
                sparkline: {
                    enabled: true
                }
            },
            series: [{
                data: series3,
            }],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            colors: @if($l7dp[0] > $l7dp[1]) ["#43d39e"] @elseif($l7dp[0] < $l7dp[1]) ["#ff5c75"] @else ["#ff8c00"] @endif ,
            yaxis: {
                floating: false,
                labels: {
                    formatter: function (val) {
                        return Math.floor(val)
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                fixed: {
                    enabled: false
                },
                x: {
                    show: false,
                },
                y: {
                    title: {
                        formatter: function (seriesName) {
                            return '';
                        }
                    },
                },
                marker: {
                    show: false
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [8, 100]
                }
            }
        };
        new ApexCharts(document.querySelector("#tpchart"), options4).render();
    </script>
    <script>
        $('[data-plugin="selectCity"]').select2();
        $('[data-plugin="selectBrand"]').select2();
        $('[data-plugin="selectLoc"]').select2();
        $('#monO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#monC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#tueO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#tueC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#wedO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#wedC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#thuO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#thuC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#friO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#friC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#satO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#satC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#sunO-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        $('#sunC-tp').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        @if (session('brAdd'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Marka eklenmiştir.',
            type: "success",
        });
        @elseif (session('stAdd'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Mağaza eklenmiştir.',
            type: "success",
        });
        @elseif (session('configClean'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Config:Clear komutu çalıştırıldı.',
            type: "success",
        });
        @elseif (session('cacheClean'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Cache:Clear komutu çalıştırıldı.',
            type: "success",
        });
        @elseif (session('configCache'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Config:Cache komutu çalıştırıldı.',
            type: "success",
        });
        @elseif (session('optimizeClear'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Optimize:Clear komutu çalıştırıldı.',
            type: "success",
        });
        @elseif (session('serverUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Sunucu açıldı.',
            type: "success",
        });
        @elseif (session('serverDown'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Sunucu kapatıldı.',
            type: "success",
        });
        @elseif (session('emailExists'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Girdiğiniz e-posta adresi ile kayıtlı bir kullanıcı bulunuyor.',
            type: "warning",
        });
        @elseif (session('userAdd'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Kullanıcı eklenmiştir.',
            type: "success",
        });
        @endif
    </script>

@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
