@extends('store_user.layouts.layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item disabled">Mağazalar</li>
                    <li class="breadcrumb-item active" aria-current="page">{{$store->name}} (ID: KFYN{{$store->id}})</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>

        </div>
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-3">
            @if($store->tag == "Popüler Mekan")
                <div class="alert alert-success shadow-green">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <i class="uil-heart font-size-56"></i>
                        </div>
                        <div class="col-xl-9">
                            <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                            <p>Mağaza, {{$store->city->name}} ilinin "Popüler Mekanlar" listesinde!</p>
                        </div>
                    </div>
                </div>
            @endif
            @if($store->tag == "Yeni Mekan")
                <div class="alert alert-success shadow-green">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <i class="uil-store font-size-56"></i>
                        </div>
                        <div class="col-xl-9">
                            <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                            <p>Mağaza, {{$store->city->name}} ilinin "Yeni Mekanlar" listesinde!</p>
                        </div>
                    </div>
                </div>
            @endif
            @if($store->tag == "Edt. Tercihi Mekan")
                <div class="alert alert-success shadow-green">
                    <div class="row align-items-center">
                        <div class="col-xl-3">
                            <i class="uil-star font-size-56"></i>
                        </div>
                        <div class="col-xl-9">
                            <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                            <p>Mağaza, {{$store->city->name}} ilinin "Editörün Tercihi Mekanlar"
                                listesinde!</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <h5 class="card-title header-title border-bottom p-3 mb-0">Mağaza & Mağaza Yöneticisi</h5>
                <div class="col-12 mt-2 mb-2 ml-3">
                    <div class="row">
                        <div class="popup-gallery mt-1" data-source="{{$store->brand->logo}}">
                            <a href="{{$store->brand->logo}}" title="">
                                <img src="{{$store->brand->logo}}" alt="img" class=" rounded avatar-md">
                            </a>
                        </div>
                        <div class="col">
                            <p class="m-0">Mağaza ID:
                                <text class="font-weight-bold">KFYN{{$store->id}}</text>
                            </p>
                            <p class="m-0">Mağaza adı:
                                <text class="font-weight-bold">{{$store->name}}</text>
                            </p>
                            <p class="m-0">Mağaza lokasyonu:
                                <text class="font-weight-bold">{{$store->location->name}}, {{$store->city->name}}</text>
                            </p>
                        </div>
                    </div>
                    <div class="col mt-3 m-0">
                        <div class="row mr-3">
                            <div class="col-xl-4 text-center">
                                <p class="font-weight-bold m-0">@if($store->averagePoint == 0)
                                        - @else {{round($store->averagePoint,1)}} @endif </p>
                                <p class="m-0">Ort. Puan</p>
                            </div>
                            <div class="col-xl-4 border-left border-right border-primary text-center">
                                <p class="font-weight-bold m-0">{{count($store->comments)}}</p>
                                <p class="m-0">Yorum</p>
                            </div>
                            <div class="col-xl-4 text-center">
                                <p class="font-weight-bold m-0">{{count($store->favorites)}}</p>
                                <p class="m-0">Favori</p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-2 mt-1">
                <div class="col-12 mt-2 mb-2 ml-0">
                    @if($store->yonetici)
                        <div class="row">
                            <div class="popup-gallery mt-1 ml-3" data-source="{{$store->yonetici->avatar}}">
                                <a href="{{$store->yonetici->avatar}}" title="">
                                    <img src="{{$store->yonetici->avatar}}" alt="img" class=" rounded-circle avatar-md">
                                </a>
                            </div>
                            <div class="col">
                                <p class="m-0">Yönetici:
                                    <text class="font-weight-bold">{{$store->yonetici->name}} {{$store->yonetici->surname}}</text>
                                </p>
                                <p class="m-0">E-posta:
                                    <text class="font-weight-bold">{{$store->yonetici->email}}</text>
                                </p>
                                <p class="m-0">GSM:
                                    <text class="font-weight-bold">{{$store->yonetici->gsmNumber}}</text>
                                </p>
                            </div>
                        </div>
                    @else
                        <p class="m-0 text-center mr-2 font-weight-bold text-danger">Mağazanın bir yöneticisi bulunmamaktadır.</p>
                    @endif

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
                                    <td><a href="javascript:void(0);" data-toggle="modal" data-target="#detayModal">Detay</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/yoneticipaneli/magazalar/KFYN{{$store->id}}/yorumlar">Yorumlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/yoneticipaneli/magazalar/KFYN{{$store->id}}/paylasimlar">Paylaşımlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/yoneticipaneli/magazalar/KFYN{{$store->id}}/yazilar">Yazılar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/yoneticipaneli/magazalar/KFYN{{$store->id}}/etkinlikler">Etkinlikler</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/yoneticipaneli/magazalar/KFYN{{$store->id}}/urunler">Ürünler</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($store->menu_items) == 0)
                <div class="card">
                    <h5 class="card-title header-title border-bottom p-3 mb-0">En fazla görüntülenen
                        ürünler</h5>
                    <div class="mt-2 mb-2">
                        <div class="col-12 text-center">
                            <i class="uil uil-coffee font-size-56 "></i>
                            <p class="font-weight-bold">Henüz mağazanın menüsüne ürün eklenmedi.</p>
                        </div>
                    </div>
                </div>
            @else
                @if(count($mvItems) > 0)
                    <div class="card">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">En fazla görüntülenen
                            ürünler</h5>
                        @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)
                            <div class="alert alert-primary mr-4 ml-4">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                        @else
                            <div class="mt-2 mb-2 ml-3">
                                <div class="col-12">
                                    @foreach($mvItems as $item)
                                        <div class="row mb-2">
                                            <div class="popup-gallery mt-1" data-source="{{$item->imageLink}}">
                                                <a href="{{$item->imageLink}}" title="">
                                                    <img src="{{$item->imageLink}}" alt="img"
                                                         class=" rounded avatar-md">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <p class="m-0 text-primary font-weight-bold"
                                                >{{$item->title}}</text> </p>
                                                <p class="m-0  text-primary">{{$item->category->desc}}
                                                    <text class="text-muted font-weight-normal">
                                                        / {{$item->subcategory->desc}}</text>
                                                </p>
                                                <p class="m-0">Görüntülenme sayısı:
                                                    <text class="font-weight-bold">{{$item->views_count}}</text>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
            <div class="alert ">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <i class="uil-asterisk font-size-56"></i>
                    </div>
                    <div class="col-xl-9">
                        <h4 class="font-weight-bold">Biz de yeni öğrendik</h4>
                        <p>{{\App\Models\KafeyinTrivia::where('id','>',0)->get()->random(1)->first()->desc}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card">
                <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan itibaren</h5>
                <div class="row ">
                    <div class="col-xl-3">
                        <div class="media px-3 py-3 border-right">
                            <div class="media-body">
                                <span class="text-muted mt-0">Mağaza</span>
                                <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdViewCount}}</h4>
                                <span class="text-muted">kez görüntülendi.</span>
                            </div>
                            <i data-feather="eye" class="align-self-center icon-dual icon-lg text-primary"></i>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="media px-3 py-3 border-right">
                            <div class="media-body">
                                <span class="text-muted">Mağazayı</span>
                                <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdFavCount}}</h4>
                                <span class="text-muted">kullanıcı favorilerine eklendi.</span>
                            </div>
                            <i data-feather="bookmark" class="align-self-center icon-dual icon-lg text-primary"></i>
                        </div>
                    </div>
                    <div class="col-xl-3">

                        <div class="media px-3 py-3 border-right">
                            <div class="media-body">
                                <span class="text-muted">Mağazaya</span>
                                <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdComCount}}</h4>
                                <span class="text-muted">yeni yorum eklendi.</span>
                            </div>
                            <i data-feather="pen-tool" class="align-self-center icon-dual icon-lg text-primary"></i>
                        </div>
                    </div>
                    <div class="col-xl-3">

                        <div class="media px-3 py-3">
                            <div class="media-body">
                                <span class="text-muted">Mağaza</span>
                                <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{count($store->todayssearches)}}</h4>
                                <span class="text-muted">kez arandı.</span>
                            </div>
                            <i data-feather="search" class="align-self-center icon-dual icon-lg text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-5" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">En son
                            eklenen @if(count($lastFiveStoreComments) > 0) {{count($lastFiveStoreComments)}}
                            yorum @else yorumlar @endif </h5>
                        @if(count($lastFiveStoreComments) == 0)
                            <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                <i class="uil uil-comment-slash font-size-56 "></i>
                                <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazaya yorum eklemedi.</p>
                            </div>
                        @else
                            <div class="slimscroll ml-3 mt-3 mb-3 mr-1" style="max-height: 320px;">
                                @foreach($lastFiveStoreComments as $yorum)
                                    <div class="col">
                                        <div class="media align-items-center border-bottom">
                                            <img src="{{$yorum->commenter->avatar}}"
                                                 class="avatar-sm rounded-circle mr-3 mb-2" height="24"
                                                 alt="avatar">
                                            <div class="media-body">
                                                <p class="mt-0 mb-0 font-size-15 font-weight-bold text-muted">{{$yorum->commenter->name}} {{$yorum->commenter->surname}}</p>
                                                @if(\Carbon\Carbon::now()->diffInMinutes($yorum->created_at) < 60)
                                                    <h6 class="text-primary font-weight-normal mt-0 mb-2">{{\Carbon\Carbon::now()->diffInMinutes($yorum->created_at)}}
                                                        dakika önce</h6>
                                                @elseif(\Carbon\Carbon::now()->diffInHours($yorum->created_at) < 24)
                                                    <h6 class="text-primary font-weight-normal mt-0 mb-2">{{\Carbon\Carbon::now()->diffInHours($yorum->created_at)}}
                                                        saat önce</h6>
                                                @elseif(\Carbon\Carbon::now()->diffInDays($yorum->created_at) < 14)
                                                    <h6 class="text-primary font-weight-normal mt-0 mb-2">{{\Carbon\Carbon::now()->diffInDays($yorum->created_at)}}
                                                        gün önce</h6>
                                                @else
                                                    <h6 class="text-primary font-weight-normal mt-0 mb-2">{{\Carbon\Carbon::createFromTimeString($yorum->created_at)->format('d/m/Y H:i')}}</h6>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="card-text text-muted mt-2">{{$yorum->commentText}}</p>
                                        @if(count($yorum->photos) > 0)
                                            <div class="row ml-1">
                                                @foreach($yorum->photos as $foto)
                                                    <div class="popup-gallery mr-2"
                                                         data-source="{{$foto->imageLink}}">
                                                        <a class="pr-2 pt-2" href="{{$foto->imageLink}}" title="">
                                                            <img src="{{$foto->imageLink}}" alt="img"
                                                                 class="avatar-md rounded">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <p class="card-text text-muted font-weight-bold mt-3">Puan:
                                            <text class="text-primary">{{$yorum->commentPoint}}</text>
                                            <text class="font-weight-bold text-muted">/ 10</text>
                                        </p>
                                        <p class="card-text text-muted font-weight-bold mt-3">{{$yorum->likes_count}}
                                            kişi beğendi.</p>
                                        <hr class="mb-3">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium) class="col-xl-6" @else class="col-xl-7" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Günlük ortalama puan <span
                                class="text-muted font-size-14 font-weight-normal">(Son 15 gün)</span></h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                <div id="avg_chart" class="apex-charts m-0" dir="ltr"></div>
                            @else
                                @if($user->brand->isPremium)
                                    <div id="avg_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            <div id="avg_chart" class="apex-charts m-0" dir="ltr"></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-7" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Günlük görüntülenme <span
                                class="text-muted font-size-14 font-weight-normal">(Son 15 gün)</span></h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                            @else
                                @if($user->brand->isPremium)
                                    <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                        @endif
                    </div>
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-5" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Görüntülemelerin şehirlere göre
                            dağılımı <span class="text-muted font-size-14 font-weight-normal">(Tüm zamanlar)</span>
                        </h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                @if(count($viewsByCity) == 0)
                                    <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                        <i class="uil uil-eye-slash font-size-56 "></i>
                                        <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazayı görüntülemedi.</p>
                                    </div>
                                @else
                                    <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                @endif
                            @else
                                @if($user->brand->isPremium)
                                    @if(count($viewsByCity) == 0)
                                        <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                            <i class="uil uil-eye-slash font-size-56 "></i>
                                            <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazayı görüntülemedi.</p>
                                        </div>
                                    @else
                                        <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                    @endif
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            @if(count($viewsByCity) == 0)
                                <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                    <i class="uil uil-eye-slash font-size-56 "></i>
                                    <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazayı görüntülemedi.</p>
                                </div>
                            @else
                                <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-5" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Favoriye alınmaların şehirlere
                            göre dağılımı <span
                                class="text-muted font-size-14 font-weight-normal">(Tüm zamanlar)</span></h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                @if(count($favsByCity) == 0)
                                    <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                        <i class="uil uil-folder-slash font-size-56 "></i>
                                        <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazayı favorilerine eklemedi.</p>
                                    </div>
                                @else
                                    @foreach($favsByCity as $cityFav)
                                        @if($cityFav['count'] != 0)
                                            <div class="media px-4 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                    <span class="text-muted">{{$cityFav['city']}}</span>
                                                </div>
                                                <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/count($store->favorites)*100),1)}}
                                                    %</h4>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            @else
                                @if($user->brand->isPremium)
                                    @if(count($favsByCity) == 0)
                                        <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                            <i class="uil uil-folder-slash font-size-56 "></i>
                                            <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazayı favorilerine eklemedi.</p>
                                        </div>
                                    @else
                                        @foreach($favsByCity as $cityFav)
                                            @if($cityFav['count'] != 0)
                                                <div class="media px-4 py-4 border-bottom">
                                                    <div class="media-body">
                                                        <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                        <span class="text-muted">{{$cityFav['city']}}</span>
                                                    </div>
                                                    <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/count($store->favorites)*100),1)}}
                                                        %</h4>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            @if(count($favsByCity) == 0)
                                <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                    <i class="uil uil-folder-slash font-size-56 "></i>
                                    <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazayı favorilerine eklemedi.</p>
                                </div>
                            @else
                                @foreach($favsByCity as $cityFav)
                                    @if($cityFav['count'] != 0)
                                        <div class="media px-4 py-4 border-bottom">
                                            <div class="media-body">
                                                <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                <span class="text-muted">{{$cityFav['city']}}</span>
                                            </div>
                                            <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/count($store->favorites)*100),1)}}
                                                %</h4>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endif

                    </div>
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-7" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Günlük favoriye eklenme <span
                                class="text-muted font-size-14 font-weight-normal">(Son 15 gün)</span></h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                <div id="favs_chart" class="apex-charts m-0" dir="ltr"></div>
                            @else
                                @if($user->brand->isPremium)
                                    <div id="favs_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            <div id="favs_chart" class="apex-charts m-0" dir="ltr"></div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row">
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-7" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Günlük QR kod kullanımı <span
                                class="text-muted font-size-14 font-weight-normal">(Son 15 gün)</span></h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                <div id="uqrs_chart" class="apex-charts m-0" dir="ltr"></div>
                            @else
                                @if($user->brand->isPremium)
                                    <div id="uqrs_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            <div id="uqrs_chart" class="apex-charts m-0" dir="ltr"></div>
                        @endif
                    </div>
                    <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-5" @endif >
                        <h5 class="card-title header-title border-bottom p-3 mb-0">En fazla QR kod kullanılan
                            ürünler <span
                                class="text-muted font-size-14 font-weight-normal">(Tüm zamanlar)</span></h5>
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                @if(count($mquItems) > 0)
                                    <div class="col-12 mt-2">
                                        @foreach($mquItems as $item)
                                            <div class="row mb-2 ml-3">
                                                <div class="popup-gallery mt-1" data-source="{{$item->imageLink}}">
                                                    <a href="{{$item->imageLink}}" title="">
                                                        <img src="{{$item->imageLink}}" alt="img"
                                                             class=" rounded avatar-md">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <p class="m-0 text-primary font-weight-bold" >{{$item->title}} </p>
                                                    <p class="m-0  text-primary">{{$item->category->desc}}
                                                        <text class="text-muted font-weight-normal">
                                                            / {{$item->subcategory->desc}}</text>
                                                    </p>
                                                    <p class="m-0">Kullanılan QR kod sayısı:
                                                        <text class="font-weight-bold">{{$item->u_qrcodes_count}}</text>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                        <i class="uil uil-mobey-bill-slash font-size-56 "></i>
                                        <p class="font-weight-bold">Henüz mağazanın hiçbir ürünü için QR kod kullanılmadı.</p>
                                    </div>
                                @endif
                            @else
                                @if($user->brand->isPremium)
                                    @if(count($mquItems) > 0)
                                        <div class="col-12 mt-2">
                                            @foreach($mquItems as $item)
                                                <div class="row mb-2 ml-3">
                                                    <div class="popup-gallery mt-1" data-source="{{$item->imageLink}}">
                                                        <a href="{{$item->imageLink}}" title="">
                                                            <img src="{{$item->imageLink}}" alt="img"
                                                                 class=" rounded avatar-md">
                                                        </a>
                                                    </div>
                                                    <div class="col">
                                                        <p class="m-0 text-primary font-weight-bold"
                                                            >{{$item->title}} </p>
                                                        <p class="m-0  text-primary">{{$item->category->desc}}
                                                            <text class="text-muted font-weight-normal">
                                                                / {{$item->subcategory->desc}}</text>
                                                        </p>
                                                        <p class="m-0">Kullanılan QR kod sayısı:
                                                            <text class="font-weight-bold">{{$item->u_qrcodes_count}}</text>
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                            <i class="uil uil-mobey-bill-slash font-size-56 "></i>
                                            <p class="font-weight-bold">Henüz mağazanın hiçbir ürünü için QR kod kullanılmadı.</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            @if(count($mquItems) > 0)
                                <div class="col-12 mt-2">
                                    @foreach($mquItems as $item)
                                        <div class="row mb-2 ml-3">
                                            <div class="popup-gallery mt-1" data-source="{{$item->imageLink}}">
                                                <a href="{{$item->imageLink}}" title="">
                                                    <img src="{{$item->imageLink}}" alt="img"
                                                         class=" rounded avatar-md">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <p class="m-0 text-primary font-weight-bold"
                                                   >{{$item->title}} </p>
                                                <p class="m-0  text-primary">{{$item->category->desc}}
                                                    <text class="text-muted font-weight-normal">
                                                        / {{$item->subcategory->desc}}</text>
                                                </p>
                                                <p class="m-0">Kullanılan QR kod sayısı:
                                                    <text class="font-weight-bold">{{$item->u_qrcodes_count}}</text>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                    <i class="uil uil-mobey-bill-slash font-size-56 "></i>
                                    <p class="font-weight-bold">Henüz mağazanın hiçbir ürünü için QR kod kullanılmadı.</p>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detayModal" tabindex="-1" role="dialog"
         aria-labelledby="detayModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detayModal">Mağaza Detayı</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="alert alert-primary shadow-kfyn">
                                    <div class="row align-items-center">
                                        <div class="col-xl-3">
                                            <i class="uil-eye font-size-56"></i>
                                        </div>
                                        <div class="col-xl-9">
                                            <h4 class="font-weight-bold text-light">Görüntülenme sayısı</h4>
                                            <p>Mağazanın toplam görüntülenme sayısı: {{count($store->views)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="alert alert-primary shadow-kfyn">
                                    <div class="row align-items-center">
                                        <div class="col-xl-3">
                                            <i class="uil-bookmark font-size-56"></i>
                                        </div>
                                        <div class="col-xl-9">
                                            <h4 class="font-weight-bold text-light">Favoriye alan sayısı</h4>
                                            <p>Mağazayı favoriye alan toplam kullanıcı sayısı: {{count($store->favorites)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="alert @if(count($store->todayssearches) == 0) alert-danger shadow-red @else alert-success shadow-green @endif">
                                    <div class="row align-items-center">
                                        <div class="col-xl-3">
                                            <i class="uil-search font-size-56"></i>
                                        </div>
                                        <div class="col-xl-9">
                                            <h4 class="font-weight-bold text-light">Aranma sayısı</h4>
                                            <p>Mağazanın bugünkü aranma sayısı: {{count($store->todayssearches)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-xl-4">
                                <h5 class="header-title mb-3 mt-0">Mağazaya ait bilgiler</h5>
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <tr>
                                            <th scope="row">ID</th>
                                            <td class="float-right">KFYN{{$store->id}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Ad</th>
                                            <td class="float-right">{{$store->name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Lokasyon</th>
                                            <td class="float-right">{{$store->location->name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Şehir</th>
                                            <td class="float-right">{{$store->city->name}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Adres</th>
                                            <td class="float-right">{{$store->address}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Sabit telefon</th>
                                            <td class="float-right">@if($store->landPhoneNumber) {{$store->landPhoneNumber}} @else <text class="text-danger font-weight-bold">Eksik</text> @endif</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Enlem</th>
                                            <td class="float-right">{{$store->latitude}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Boylam</th>
                                            <td class="float-right">{{$store->longitude}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Öne çıkan</th>
                                            <td class="float-right">@if($store->featured) {{$store->featured}} @else <text class="text-danger font-weight-bold">Eksik</text> @endif</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Ortalama Puan</th>
                                            <td class="float-right">@if($store->averagePoint == 0) - @else {{round($store->averagePoint,1)}} @endif</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Yorum Sayısı</th>
                                            <td class="float-right">{{count($store->comments)}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Fotoğraf Sayısı</th>
                                            <td class="float-right">{{count($store->photos)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <h5 class="header-title mb-3 mt-0">Çalışma saatleri</h5>
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <tr>
                                            <th scope="row">Pazartesi</th>
                                            @if($store->monOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->monOpen,0,5)}} - {{substr($store->monClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Salı</th>
                                            @if($store->tueOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->tueOpen,0,5)}} - {{substr($store->tueClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Çarşamba</th>
                                            @if($store->wedOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->wedOpen,0,5)}} - {{substr($store->wedClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Perşembe</th>
                                            @if($store->thuOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->thuOpen,0,5)}} - {{substr($store->thuClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Cuma</th>
                                            @if($store->friOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->friOpen,0,5)}} - {{substr($store->friClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Cumartesi</th>
                                            @if($store->satOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->satOpen,0,5)}} - {{substr($store->satClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Pazar</th>
                                            @if($store->sunOpen == "16:50:00")
                                                <td class="float-right">Kapalı</td>
                                            @else
                                                <td class="float-right">{{substr($store->sunOpen,0,5)}} - {{substr($store->sunClose,0,5)}}</td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                {{--@if($isOnlineOrderEnabled)
                                    <h5 class="header-title mb-3 mt-3">Sipariş alma bilgileri</h5>
                                    <div class="table-responsive table-hover">
                                        <table class="table m-0">
                                            <tbody>
                                            @if($isTakeAwayOrderEnabled)
                                                @if($store->canTakeTakeAwayOrder)
                                                    <tr>
                                                        <th scope="row">Al-götür sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-success">Açık</span></td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th scope="row">Al-götür sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-danger">Kapalı</span></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($isLocalDeliveryOrderEnabled)
                                                @if($store->canTakeLocalDeliveryOrder)
                                                    <tr>
                                                        <th scope="row">Şehiriçi teslimatlı sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-success">Açık</span></td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th scope="row">Şehiriçi teslimatlı sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-danger">Kapalı</span></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($isLocalCargoOrderEnabled)
                                                @if($store->canTakeLocalCargoOrder)
                                                    <tr>
                                                        <th scope="row">Şehir içi kargo sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-success">Açık</span></td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th scope="row">Şehir içi kargo sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-danger">Kapalı</span></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            @if($isUpstateCargoOrderEnabled)
                                                @if($store->canTakeUpstateCargoOrder)
                                                    <tr>
                                                        <th scope="row">Şehir dışı kargo sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-success">Açık</span></td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <th scope="row">Şehir dışı kargo sipariş</th>
                                                        <td class="float-right"><span class="badge badge-soft-danger">Kapalı</span></td>
                                                    </tr>
                                                @endif
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                @endif--}}
                            </div>
                            <div class="col-xl-4">
                                <h5 class="header-title mb-3 mt-0">Mağaza özellikleri</h5>
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <tr>
                                            <th scope="row">Ders çalışma ortamı</th>
                                            @if($store->isStudy)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Buluşmaya uygun</th>
                                            @if($store->isDate)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Latte-art</th>
                                            @if($store->isLatteArt)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Hayvan dostu</th>
                                            @if($store->isPetFriendly)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Tatlı</th>
                                            @if($store->isDessert)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Toplantıya uygun</th>
                                            @if($store->isMeeting)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Alkollü mekan</th>
                                            @if($store->isAlcohol)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Dış mekan</th>
                                            @if($store->isOutside)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Yemek</th>
                                            @if($store->isMeal)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Kahvaltı</th>
                                            @if($store->isBreakfast)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Çikolata</th>
                                            @if($store->isChocolate)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Fotoğraf için dekor</th>
                                            @if($store->isTakePhoto)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Self-servis</th>
                                            @if($store->isSelfService)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Çay</th>
                                            @if($store->isTea)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th scope="row">Canlı müzik</th>
                                            @if($store->isLiveMusic)
                                                <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                            @else
                                                <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="alert mb-0">
                            <div class="row align-items-center">
                                <div class="col-xl-1">
                                    <i class="uil-info-circle font-size-56 "></i>
                                </div>
                                <div class="col-xl-11">
                                    <h4 class="font-weight-bold">Bilgi</h4>
                                    <p> Mağaza bilgilerinde eksik veya hatalı bilgi olduğunu düşünüyorsanız, "destek@kafeyinapp.com" e-posta adresi üzerinden bize ulaşabilirsiniz.</p>
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
    <script src="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>
    <script>
        var galleryTop = new Swiper('.gallery-top', {
            autoHeight: true,
            spaceBetween: 10,
            autoplay: true,
            loop: false,
            loopedSlides: 5, //looped slides should be the same
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
        var daysLabels = [
            @foreach(array_reverse($l15days) as $day)
            new Date({{$day}}).toLocaleDateString(),
            @endforeach
        ];

        var viewSeries = [
            @foreach(array_reverse($l15dvs) as $dv)
            {{$dv}},
            @endforeach
        ];
        var viewsOptions = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [{
                name: 'Görüntülenme sayısı',
                data: viewSeries
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#ff8c00'],
            xaxis: {
                type: 'string',
                categories: daysLabels,
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
        var viewsChart = new ApexCharts(document.querySelector("#views_chart"), viewsOptions);
        viewsChart.render();

        var favsSeries = [
            @foreach(array_reverse($l15dfs) as $df)
            {{$df}},
            @endforeach
        ];
        var favsOptions = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [{
                name: 'Favoriye eklenme sayısı',
                data: favsSeries
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#564ab1'],
            xaxis: {
                type: 'string',
                categories: daysLabels,
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
        var favsChart = new ApexCharts(document.querySelector("#favs_chart"), favsOptions);
        favsChart.render();

        var avgSeries = [
            @foreach(array_reverse($l15daps) as $dap)
            {{$dap}},
            @endforeach
        ];
        var avgOptions = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'Ortalama puan',
                data: avgSeries
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#25c2e3'],
            xaxis: {
                type: 'string',
                categories: daysLabels,
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
                        //return Math.round(val);
                        return val.toFixed(1);
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
        var avgChart = new ApexCharts(document.querySelector("#avg_chart"), avgOptions);
        avgChart.render();

        var uqrsSeries = [
            @foreach(array_reverse($l15duqs) as $duq)
            {{$duq}},
            @endforeach
        ];
        var uqrsOptions = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'Kullanılan QR kod sayısı',
                data: uqrsSeries
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#25c2e3'],
            xaxis: {
                type: 'string',
                categories: daysLabels,
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
        var uqrChart = new ApexCharts(document.querySelector("#uqrs_chart"), uqrsOptions);
        uqrChart.render();

        var citiesSeries = [
            @foreach($viewsByCity as $view)
            {{$view['count']}},
            @endforeach
        ];
        var citiesLabels = [
                @foreach($viewsByCity as $view)
            ["{{$view['city']}}"],
            @endforeach
        ];
        var vvccOptions = {
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%'
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
            series: citiesSeries,
            labels: citiesLabels,
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
                        return value + " görüntüleme";
                    }
                }
            }
        };
        var viewsViaCityChart = new ApexCharts(document.querySelector("#views_via_cities_chart"), vvccOptions);
        viewsViaCityChart.render();
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
