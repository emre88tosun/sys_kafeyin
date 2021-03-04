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
                    <li class="breadcrumb-item active" aria-current="page">Anasayfa</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Hoşgeldiniz, {{$user->name}} {{$user->surname}}!</h4>
        </div>
    </div>
@endsection

@section('content')

    @if($hasBrand && !$hasMagaza)
        <div class="row">
            <div class="col-xl-9">
                <div class="card">
                    <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan itibaren</h5>
                    <div class="row ">
                        <div class="col-xl-3">
                            <div class="media px-3 py-3 border-right">
                                <div class="media-body">
                                    @if(count($user->brand->stores) > 1)
                                        <span class="text-muted mt-0">Mağazalarınız</span>
                                    @else
                                        <span class="text-muted mt-0">Mağazanız</span>
                                    @endif
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdViewCount}}</h4>
                                    <span class="text-muted">kez görüntülendi.</span>
                                </div>
                                <i data-feather="eye" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="media px-3 py-3 border-right">
                                <div class="media-body">
                                    @if(count($user->brand->stores) > 1)
                                        <span class="text-muted">Mağazalarınızı</span>
                                    @else
                                        <span class="text-muted">Mağazanızı</span>
                                    @endif
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdFavCount}}</h4>
                                    <span class="text-muted">kullanıcı favorilerine eklendi.</span>
                                </div>
                                <i data-feather="bookmark" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-3">

                            <div class="media px-3 py-3 border-right">
                                <div class="media-body">
                                    @if(count($user->brand->stores) > 1)
                                        <span class="text-muted">Mağazalarınıza</span>
                                    @else
                                        <span class="text-muted">Mağazanıza</span>
                                    @endif
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdComCount}}</h4>
                                    <span class="text-muted">yeni yorum eklendi.</span>
                                </div>
                                <i data-feather="pen-tool" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-3">

                            <div class="media px-3 py-3">
                                <div class="media-body">
                                    @if(count($user->brand->stores) > 1)
                                        <span class="text-muted">Mağazalarınız</span>
                                    @else
                                        <span class="text-muted">Mağazanız</span>
                                    @endif
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdSearchCount}}</h4>
                                    <span class="text-muted">kez arandı.</span>
                                </div>
                                <i data-feather="search" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="row">
                        <div class="col-xl-12" >
                            <h5 class="card-title header-title border-bottom p-3 mb-0">
                                @if(count($user->brand->stores) > 1)
                                    Mağazalarınıza en son eklenen
                                    @if(count($ccoms) > 0)
                                        {{count($ccoms)}} yorum
                                    @else
                                        yorumlar
                                    @endif
                                @else
                                    Mağazanıza en son eklenen
                                    @if(count($ccoms) > 0)
                                        {{count($ccoms)}} yorum
                                    @else
                                        yorumlar
                                    @endif
                                @endif
                                </h5>
                            @if(count($ccoms) == 0)
                                <p class="text-center text-danger mt-3 font-weight-bold">
                                    @if(count($user->brand->stores) > 1)
                                        Henüz mağazalaranıza yorum eklenmedi.
                                    @else
                                        Henüz mağazanıza yorum eklenmedi.
                                    @endif
                                    </p>
                            @else
                                <div class="slimscroll ml-3 mt-3 mb-3 mr-1" style="max-height: 500px;">
                                    @foreach($ccoms->chunk(2) as $ccoms2)
                                        <div class="row">
                                            @foreach($ccoms2 as $yorum)
                                                <div class="col-xl-6">
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
                                                    <p class="card-text text-muted font-weight-bold mt-3">Mağaza:
                                                        <text class="text-primary">{{$yorum->store->name}} (ID: KFYN{{$yorum->store->id}})</text>
                                                    </p>
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
                                    @endforeach
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="row">
                        <div class="col-xl-12" >
                            <h5 class="card-title header-title border-bottom p-3 mb-0">Günlük ortalama puan <span
                                    class="text-muted font-size-14 font-weight-normal">(Son 15 gün)</span></h5>
                            @if($isPremiumPlanEnabled)
                                @if($isStatisticsFree)
                                    <div id="avg_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    @if($user->brand->isPremium)
                                        <div id="avg_chart" class="apex-charts m-0" dir="ltr"></div>
                                    @else
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak markanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
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
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak markanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                            @endif
                        </div>
                        <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-5" @endif >
                            <h5 class="card-title header-title border-bottom p-3 mb-0">Görüntülenmelerin şehirlere göre
                                dağılımı <span class="text-muted font-size-14 font-weight-normal">(Tüm zamanlar)</span>
                            </h5>
                            @if($isPremiumPlanEnabled)
                                @if($isStatisticsFree)
                                    <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                @else
                                    @if($user->brand->isPremium)
                                        <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                    @else
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak markanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
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
                                    @if($fsc == 0)
                                        <p class="m-0 text-center mr-2 font-weight-bold text-danger">
                                            @if(count($user->brand->stores) > 1)
                                                Henüz mağazalarınızı favoriye ekleyen kullanıcı bulunmamaktadır.
                                            @else
                                                Henüz mağazanızı favoriye ekleyen kullanıcı bulunmamaktadır.
                                            @endif
                                        </p>
                                    @else
                                        @foreach($favsByCity as $cityFav)
                                            @if($cityFav['count'] != 0)
                                                <div class="media px-4 py-4 border-bottom">
                                                    <div class="media-body">
                                                        <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                        <span class="text-muted">{{$cityFav['city']}}</span>
                                                    </div>
                                                    <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/($fsc)*100),1)}}
                                                        %</h4>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @else
                                    @if($user->brand->isPremium)
                                        @if($fsc == 0)
                                            <p class="m-0 text-center mr-2 font-weight-bold text-danger">
                                                @if(count($user->brand->stores) > 1)
                                                    Henüz mağazalarınızı favoriye ekleyen kullanıcı bulunmamaktadır.
                                                @else
                                                    Henüz mağazanızı favoriye ekleyen kullanıcı bulunmamaktadır.
                                                @endif
                                            </p>
                                        @else
                                            @foreach($favsByCity as $cityFav)
                                                @if($cityFav['count'] != 0)
                                                    <div class="media px-4 py-4 border-bottom">
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                            <span class="text-muted">{{$cityFav['city']}}</span>
                                                        </div>
                                                        <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/($fsc)*100),1)}}
                                                            %</h4>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    @else
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak markanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                @if($fsc == 0)
                                    <p class="m-0 text-center mr-2 font-weight-bold text-danger">
                                        @if(count($user->brand->stores) > 1)
                                            Henüz mağazalarınızı favoriye ekleyen kullanıcı bulunmamaktadır.
                                        @else
                                            Henüz mağazanızı favoriye ekleyen kullanıcı bulunmamaktadır.
                                        @endif
                                    </p>
                                @else
                                    @foreach($favsByCity as $cityFav)
                                        @if($cityFav['count'] != 0)
                                            <div class="media px-4 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                    <span class="text-muted">{{$cityFav['city']}}</span>
                                                </div>
                                                <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/($fsc)*100),1)}}
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
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak markanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                <div id="favs_chart" class="apex-charts m-0" dir="ltr"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                @if($hasBrand) @if($survey)
                    <div class="card shadow-kfyn">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">{{$survey->title}}</h5>
                        <div class="col-12 mt-2 mb-2">
                            <p>{{$survey->desc}}</p>
                            <form method="post" action="/yoneticipaneli/anketcevapla">
                                @csrf
                                <fieldset>
                                    <input type="hidden" name="id" value="{{$survey->id}}">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="answer" name="answer" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label"
                                                   for="answer">{{$survey->trueString}}</label>
                                        </div>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="answer2" name="answer" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label"
                                                   for="answer2">{{$survey->falseString}}</label>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="submit" class="btn btn-primary w-100 btn-sm mb-2" value="Yanıtla">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                @endif @endif
                    <div class="card">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Marka</h5>
                        <div class="col-12 mt-2 mb-2 ml-0">
                            <div class="row">
                                <div class="popup-gallery mt-1 ml-3" data-source="{{$user->brand->logo}}">
                                    <a href="{{$user->brand->logo}}" title="">
                                        <img src="{{$user->brand->logo}}" alt="img" class=" rounded avatar-md">
                                    </a>
                                </div>
                                <div class="col">
                                    <p class="m-0 mr-3 d-flex justify-content-between">
                                        <text>Marka ID:
                                            <text class="font-weight-bold"> @if($hasBrand) MRK88{{$user->brand->id}} @else ***** @endif </text>
                                        </text> @if($isPremiumPlanEnabled) @if($user->brand->isPremium) <span
                                            class="badge badge-success">Premium Plan</span> @else <span
                                            class="badge badge-danger">Temel Plan</span> @endif @endif </p>
                                    <p class="m-0">Marka adı:
                                        <text class="font-weight-bold">{{$user->brand->name}}</text>
                                    </p>
                                    <p class="m-0" data-toggle="tooltip" data-placement="left"
                                       title="Markanız için oluşturulan sadakat kartlarının tamamlanması için gereken damga sayısı">
                                        Damga sayısı:
                                        <text class="font-weight-bold">{{$user->brand->needStampCount}}</text>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    @if(count($user->brand->stores->where('tag','!=',null)) > 0)
                        @foreach($user->brand->stores->where('tag','!=',null) as $sto)
                            @if($sto->tag == "Popüler Mekan")
                                <div class="alert alert-success shadow-green">
                                    <div class="row align-items-center">
                                        <div class="col-xl-3">
                                            <i class="uil-star font-size-56"></i>
                                        </div>
                                        <div class="col-xl-9">
                                            <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                                            <p>{{$sto->name}} (ID: KFYN{{$sto->id}}), {{$sto->city->name}} ilinin "Popüler Mekanlar"
                                                listesinde!</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($sto->tag == "Yeni Mekan")
                                <div class="alert alert-success shadow-green">
                                    <div class="row align-items-center">
                                        <div class="col-xl-3">
                                            <i class="uil-star font-size-56"></i>
                                        </div>
                                        <div class="col-xl-9">
                                            <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                                            <p>{{$sto->name}} (ID: KFYN{{$sto->id}}), {{$sto->city->name}} ilinin "Yeni Mekanlar"
                                                listesinde!</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($sto->tag == "Edt. Tercihi Mekan")
                                <div class="alert alert-success shadow-green">
                                    <div class="row align-items-center">
                                        <div class="col-xl-3">
                                            <i class="uil-star font-size-56"></i>
                                        </div>
                                        <div class="col-xl-9">
                                            <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                                            <p>{{$sto->name}} (ID: KFYN{{$sto->id}}), {{$sto->city->name}} ilinin "Editörün Tercihi Mekanlar"
                                                listesinde!</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                @if($hasBrand) @if(count($announces) > 0)
                    <div class="card">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Markanıza ait aktif duyurular</h5>
                        <div class="mt-2 mb-2 ml-3" >
                            <div class="col-12">
                                @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)
                                    <div class="alert alert-primary mr-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                @else
                                    @foreach($announces as $item)
                                        <div class="row mb-2">
                                            <div class="popup-gallery mt-1" data-source="{{$item->imageLink}}">
                                                <a href="{{$item->imageLink}}" title="">
                                                    <img src="{{$item->imageLink}}" alt="img"
                                                         class=" rounded avatar-md">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="m-0 text-primary font-weight-bold" href="javascript:void(0);" data-toggle="modal" data-target="#duyuruModal{{$item->id}}" >{{$item->title}}</a>
                                                <p class="m-0">Görüntülenme sayısı: <text class="font-weight-bold">{{$item->viewCount}}</text>
                                                <p class="m-0">Şehir: <text class="font-weight-bold">{{$item->city->name}}</text>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                @endif @endif
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
        </div>
    @else
        <div class="row">
            <div class="col-xl-9">
                @if($kafeyinNews != null && count($kafeyinNews) > 0)
                    <div class="card">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">Kafeyin'den Haberler</h5>
                        <div class="swiper-container gallery-top mt-3 mb-3">
                            <div class="swiper-wrapper">
                                @foreach($kafeyinNews as $news)
                                    <div class="swiper-slide">
                                        <div class="row ml-5 mr-5">
                                            <div class="col-xl-3">
                                                <div class="popup-gallery" data-source="{{$news->imageLink}}">
                                                    <a href="{{$news->imageLink}}" title="">
                                                        <img src="{{$news->imageLink}}" alt="img"
                                                             class="rounded img-fluid">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-xl-9">
                                                @if(\Carbon\Carbon::createFromTimeString($news->created_at)->format('d/m/Y') == \Carbon\Carbon::today()->format('d/m/Y'))
                                                    <td><span class="badge badge-primary">Yeni haber!</span></td> @endif
                                                <h5 class="header-title">{{$news->title}}</h5>
                                                <p class="font-weight-bold">Eklenme
                                                    tarihi: {{\Carbon\Carbon::createFromTimeString($news->created_at)->format('d/m/Y')}}</p>
                                                <hr>
                                                <p>{{$news->desc}}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-button-next swiper-button-kfyn"></div>
                            <div class="swiper-button-prev swiper-button-kfyn"></div>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <h5 class="card-title header-title border-bottom p-3 mb-0">00.00'dan itibaren</h5>
                    <div class="row ">
                        <div class="col-xl-3">
                            <div class="media px-3 py-3 border-right">
                                <div class="media-body">
                                    <span class="text-muted mt-0">Mağazanız</span>
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdViewCount}}</h4>
                                    <span class="text-muted">kez görüntülendi.</span>
                                </div>
                                <i data-feather="eye" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class="media px-3 py-3 border-right">
                                <div class="media-body">
                                    <span class="text-muted">Mağazanızı</span>
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdFavCount}}</h4>
                                    <span class="text-muted">kullanıcı favorilerine eklendi.</span>
                                </div>
                                <i data-feather="bookmark" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-3">

                            <div class="media px-3 py-3 border-right">
                                <div class="media-body">
                                    <span class="text-muted">Mağazanıza</span>
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{$tdComCount}}</h4>
                                    <span class="text-muted">yeni yorum eklendi.</span>
                                </div>
                                <i data-feather="pen-tool" class="align-self-center icon-dual icon-lg text-primary"></i>
                            </div>
                        </div>
                        <div class="col-xl-3">

                            <div class="media px-3 py-3">
                                <div class="media-body">
                                    <span class="text-muted">Mağazanız</span>
                                    <h4 class="mt-1 mb-1 font-size-22 font-weight-bold">{{count($user->magaza->todayssearches)}}</h4>
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
                                    <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanıza yorum eklenmedi.</p>
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
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
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
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
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
                                            <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanızı görüntülemedi.</p>
                                        </div>
                                    @else
                                        <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                    @endif
                                @else
                                    @if($user->brand->isPremium)
                                        @if(count($viewsByCity) == 0)
                                            <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                                <i class="uil uil-eye-slash font-size-56 "></i>
                                                <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanızı görüntülemedi.</p>
                                            </div>
                                        @else
                                            <div id="views_via_cities_chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                        @endif
                                    @else
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                @if(count($viewsByCity) == 0)
                                    <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                        <i class="uil uil-eye-slash font-size-56 "></i>
                                        <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanızı görüntülemedi.</p>
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
                                            <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanızı favorilerine eklemedi.</p>
                                        </div>
                                    @else
                                        @foreach($favsByCity as $cityFav)
                                            @if($cityFav['count'] != 0)
                                                <div class="media px-4 py-4 border-bottom">
                                                    <div class="media-body">
                                                        <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                        <span class="text-muted">{{$cityFav['city']}}</span>
                                                    </div>
                                                    <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/count($user->magaza->favorites)*100),1)}}
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
                                                <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanızı favorilerine eklemedi.</p>
                                            </div>
                                        @else
                                            @foreach($favsByCity as $cityFav)
                                                @if($cityFav['count'] != 0)
                                                    <div class="media px-4 py-4 border-bottom">
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                            <span class="text-muted">{{$cityFav['city']}}</span>
                                                        </div>
                                                        <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/count($user->magaza->favorites)*100),1)}}
                                                            %</h4>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    @else
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                @if(count($favsByCity) == 0)
                                    <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                                        <i class="uil uil-folder-slash font-size-56 "></i>
                                        <p class="font-weight-bold">Henüz hiçbir kullanıcı mağazanızı favorilerine eklemedi.</p>
                                    </div>
                                @else
                                    @foreach($favsByCity as $cityFav)
                                        @if($cityFav['count'] != 0)
                                            <div class="media px-4 py-4 border-bottom">
                                                <div class="media-body">
                                                    <h4 class="mt-0 mb-1 font-size-22 font-weight-normal">{{$cityFav['count']}}</h4>
                                                    <span class="text-muted">{{$cityFav['city']}}</span>
                                                </div>
                                                <h4 class="font-weight-bold text-primary mr-5">{{round(($cityFav['count']/count($user->magaza->favorites)*100),1)}}
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
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
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
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @endif
                                @endif
                            @else
                                <div id="uqrs_chart" class="apex-charts m-0" dir="ltr"></div>
                            @endif
                        </div>
                        <div @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)  class="col-xl-6" @else  class="col-xl-5" @endif >
                            <h5 class="card-title header-title border-bottom p-3 mb-0">En fazla QR kod kullanılan
                                ürünleriniz <span
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
                                                        <a class="m-0 text-primary font-weight-bold"
                                                           href="/yoneticipaneli/urunler/URN{{$item->id}}">{{$item->title}}</text> </a>
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
                                            <p class="font-weight-bold">Henüz mağazanızın hiçbir ürünü için QR kod kullanılmadı.</p>
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
                                                            <a class="m-0 text-primary font-weight-bold"
                                                               href="/yoneticipaneli/urunler/URN{{$item->id}}">{{$item->title}}</text> </a>
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
                                                <p class="font-weight-bold">Henüz mağazanızın hiçbir ürünü için QR kod kullanılmadı.</p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="alert alert-primary ml-4 mr-4 mt-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
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
                                                    <a class="m-0 text-primary font-weight-bold"
                                                       href="/yoneticipaneli/urunler/URN{{$item->id}}">{{$item->title}}</text> </a>
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
                                        <p class="font-weight-bold">Henüz mağazanızın hiçbir ürünü için QR kod kullanılmadı.</p>
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                @if($hasBrand) @if($survey)
                    <div class="card shadow-kfyn">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">{{$survey->title}}</h5>
                        <div class="col-12 mt-2 mb-2">
                            <p>{{$survey->desc}}</p>
                            <form method="post" action="/yoneticipaneli/anketcevapla">
                                @csrf
                                <fieldset>
                                    <input type="hidden" name="id" value="{{$survey->id}}">
                                    <div class="form-group">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="answer" name="answer" value="1"
                                                   class="custom-control-input" checked>
                                            <label class="custom-control-label"
                                                   for="answer">{{$survey->trueString}}</label>
                                        </div>
                                        <div class="custom-control custom-radio mt-2">
                                            <input type="radio" id="answer2" name="answer" value="0"
                                                   class="custom-control-input">
                                            <label class="custom-control-label"
                                                   for="answer2">{{$survey->falseString}}</label>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="submit" class="btn btn-primary w-100 btn-sm mb-2" value="Yanıtla">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                @endif @endif
                @if($user->magaza->tag == "Popüler Mekan")
                    <div class="alert alert-success shadow-green">
                        <div class="row align-items-center">
                            <div class="col-xl-3">
                                <i class="uil-heart font-size-56"></i>
                            </div>
                            <div class="col-xl-9">
                                <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                                <p>Mağazanız, {{$user->magaza->city->name}} ilinin "Popüler Mekanlar" listesinde!</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if($user->magaza->tag == "Yeni Mekan")
                    <div class="alert alert-success shadow-green">
                        <div class="row align-items-center">
                            <div class="col-xl-3">
                                <i class="uil-store font-size-56"></i>
                            </div>
                            <div class="col-xl-9">
                                <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                                <p>Mağazanız, {{$user->magaza->city->name}} ilinin "Yeni Mekanlar" listesinde!</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if($user->magaza->tag == "Edt. Tercihi Mekan")
                    <div class="alert alert-success shadow-green">
                        <div class="row align-items-center">
                            <div class="col-xl-3">
                                <i class="uil-star font-size-56"></i>
                            </div>
                            <div class="col-xl-9">
                                <h4 class="font-weight-bold text-light">Tebrikler!</h4>
                                <p>Mağazanız, {{$user->magaza->city->name}} ilinin "Editörün Tercihi Mekanlar"
                                    listesinde!</p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card">
                    <h5 class="card-title header-title border-bottom p-3 mb-0">Mağaza & Marka</h5>
                    <div class="col-12 mt-2 mb-2 ml-3">
                        <div class="row">
                            <div class="popup-gallery mt-1" data-source="{{$user->magaza->brand->logo}}">
                                <a href="{{$user->magaza->brand->logo}}" title="">
                                    <img src="{{$user->magaza->brand->logo}}" alt="img" class=" rounded avatar-md">
                                </a>
                            </div>
                            <div class="col">
                                <p class="m-0">Mağaza ID:
                                    <text class="font-weight-bold">KFYN{{$user->magaza->id}}</text>
                                </p>
                                <p class="m-0">Mağaza adı:
                                    <text class="font-weight-bold">{{$user->magaza->name}}</text>
                                </p>
                                <p class="m-0">Mağaza lokasyonu:
                                    <text class="font-weight-bold">{{$user->magaza->location->name}}
                                        , {{$user->magaza->city->name}}</text>
                                </p>
                            </div>
                        </div>
                        <div class="col mt-3 m-0">
                            <div class="row mr-3">
                                <div class="col-xl-4 text-center">
                                    <p class="font-weight-bold m-0">@if($user->magaza->averagePoint == 0)
                                            - @else {{round($user->magaza->averagePoint,1)}} @endif </p>
                                    <p class="m-0">Ort. Puan</p>
                                </div>
                                <div class="col-xl-4 border-left border-right border-primary text-center">
                                    <p class="font-weight-bold m-0">{{count($user->magaza->comments)}}</p>
                                    <p class="m-0">Yorum</p>
                                </div>
                                <div class="col-xl-4 text-center">
                                    <p class="font-weight-bold m-0">{{count($user->magaza->favorites)}}</p>
                                    <p class="m-0">Favori</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2 mt-1">
                    <div class="col-12 mt-2 mb-2 ml-0">
                        <div class="row">
                            <div class="popup-gallery mt-1 ml-3" data-source="{{$user->magaza->brand->logo}}">
                                <a href="{{$user->magaza->brand->logo}}" title="">
                                    <img src="{{$user->magaza->brand->logo}}" alt="img" class=" rounded avatar-md">
                                </a>
                            </div>
                            <div class="col">
                                <p class="m-0 mr-3 d-flex justify-content-between">
                                    <text>Marka ID:
                                        <text class="font-weight-bold"> @if($hasBrand) MRK88{{$user->magaza->brand->id}} @else ***** @endif </text>
                                    </text> @if($isPremiumPlanEnabled) @if($user->magaza->brand->isPremium) <span
                                        class="badge badge-success">Premium Plan</span> @else <span
                                        class="badge badge-danger">Temel Plan</span> @endif @endif </p>
                                <p class="m-0">Marka adı:
                                    <text class="font-weight-bold">{{$user->magaza->brand->name}}</text>
                                </p>
                                <p class="m-0" data-toggle="tooltip" data-placement="left"
                                   title="Markanız için oluşturulan sadakat kartlarının tamamlanması için gereken damga sayısı">
                                    Damga sayısı:
                                    <text class="font-weight-bold">{{$user->magaza->brand->needStampCount}}</text>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="align-items-center d-flex justify-content-between">
                        <h5 class="card-title header-title border-bottom p-3 mb-0 mt-0">Sadakat kartı onayla</h5>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#approvalInfoDialog" class="card-title header-title border-bottom p-3 mb-0 mt-0"><i class="uil-info-circle"></i></a>
                    </div>
                    <div class="card-body">
                        <form id="frmApproveCard" method="post" action="/yoneticipaneli/kartonayla">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <input type="text" oninput="let p = this.selectionStart; this.value = this.value.toUpperCase();this.setSelectionRange(p, p);" id="referralCode" name="referralCode" class="form-control" required minlength="8" maxlength="8" placeholder="8 karakterlik referans kodu"/>
                                </div>
                                <input class="btn btn-primary btn-sm w-100 mt-0 float-right" id="btnApproveCard" type="submit" value="Onayla">
                            </fieldset>
                        </form>
                    </div>
                </div>
                @if(!$isPremiumPlanEnabled)
                    @if($user->magaza->leftDailyStoryCount == 1 && count($user->magaza->paylasims->where('isActive',true)) == 0)
                        <div class="alert alert-primary shadow-kfyn">
                            <div class="row align-items-center">
                                <div class="col-xl-3">
                                    <i class="uil-bell font-size-56"></i>
                                </div>
                                <div class="col-xl-9">
                                    <h4 class="font-weight-bold text-light">Hatırlatma</h4>
                                    <p>Günlük paylaşımınızı eklemeyi unutmayın!</p>
                                    <a href="/yoneticipaneli/paylasimlar" class="btn btn-sm btn-secondary float-right">Paylaşımlar</a>
                                </div>
                            </div>
                        </div>
                    @elseif($user->magaza->leftDailyStoryCount == 1 && count($user->magaza->paylasims->where('isActive',true)) == 1)
                        <div class="alert alert-light shadow-sm">
                            <div class="row align-items-center">
                                <div class="col-xl-3">
                                    <div class="popup-gallery"
                                         data-source="{{$user->magaza->paylasims->where('isActive',true)->first()->imageLink}}">
                                        <a class=""
                                           href="{{$user->magaza->paylasims->where('isActive',true)->first()->imageLink}}"
                                           title="">
                                            <img class="avatar-lg rounded img-fluid "
                                                 src="{{$user->magaza->paylasims->where('isActive',true)->first()->imageLink}}"
                                                 alt="img">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-9">
                                    <h4 class="font-weight-bold">Bilgi</h4>
                                    <p>
                                        @if(\Carbon\Carbon::now()->diffInMinutes($user->magaza->paylasims->where('isActive',true)->first()->created_at) < 60)
                                            {{\Carbon\Carbon::now()->diffInMinutes($user->magaza->paylasims->where('isActive',true)->first()->created_at)}}
                                            dakika önce
                                        @else
                                            {{\Carbon\Carbon::now()->diffInHours($user->magaza->paylasims->where('isActive',true)->first()->created_at)}}
                                            saat önce
                                        @endif
                                        paylaştığınız
                                        PAY{{$user->magaza->paylasims->where('isActive',true)->first()->id}} ID'li
                                        paylaşımınız {{$user->magaza->paylasims->where('isActive',true)->first()->viewCount}}
                                        kez görüntülendi.
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row align-items-center">
                                <div class="col-xl-3">
                                    <i class="uil-bell font-size-56"></i>
                                </div>
                                <div class="col-xl-9">
                                    <h4 class="font-weight-bold ">Hatırlatma</h4>
                                    <p>Günlük paylaşımınızı eklemeyi unutmayın!</p>
                                    <a href="/yoneticipaneli/paylasimlar" class="btn btn-sm btn-primary float-right">Paylaşımlar</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    @if(!$user->magaza->brand->isPremium)
                        @if($user->magaza->leftDailyStoryCount == 1 && count($user->magaza->paylasims->where('isActive',true)) == 0)
                            <div class="alert alert-primary shadow-kfyn">
                                <div class="row align-items-center">
                                    <div class="col-xl-3">
                                        <i class="uil-bell font-size-56"></i>
                                    </div>
                                    <div class="col-xl-9">
                                        <h4 class="font-weight-bold text-light">Hatırlatma</h4>
                                        <p>Günlük paylaşımınızı eklemeyi unutmayın!</p>
                                        <a href="/yoneticipaneli/paylasimlar"
                                           class="btn btn-sm btn-secondary float-right">Paylaşımlar</a>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->magaza->leftDailyStoryCount == 1 && count($user->magaza->paylasims->where('isActive',true)) == 1)
                            <div class="alert alert-light shadow-sm">
                                <div class="row align-items-center">
                                    <div class="col-xl-3">
                                        <div class="popup-gallery"
                                             data-source="{{$user->magaza->paylasims->where('isActive',true)->first()->imageLink}}">
                                            <a class=""
                                               href="{{$user->magaza->paylasims->where('isActive',true)->first()->imageLink}}"
                                               title="">
                                                <img class="avatar-lg rounded img-fluid "
                                                     src="{{$user->magaza->paylasims->where('isActive',true)->first()->imageLink}}"
                                                     alt="img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-9">
                                        <h4 class="font-weight-bold">Bilgi</h4>
                                        <p>
                                            @if(\Carbon\Carbon::now()->diffInMinutes($user->magaza->paylasims->where('isActive',true)->first()->created_at) < 60)
                                                {{\Carbon\Carbon::now()->diffInMinutes($user->magaza->paylasims->where('isActive',true)->first()->created_at)}}
                                                dakika önce
                                            @else
                                                {{\Carbon\Carbon::now()->diffInHours($user->magaza->paylasims->where('isActive',true)->first()->created_at)}}
                                                saat önce
                                            @endif
                                            paylaştığınız
                                            PAY{{$user->magaza->paylasims->where('isActive',true)->first()->id}} ID'li
                                            paylaşımınız {{$user->magaza->paylasims->where('isActive',true)->first()->viewCount}}
                                            kez görüntülendi.
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row align-items-center">
                                    <div class="col-xl-3">
                                        <i class="uil-bell font-size-56"></i>
                                    </div>
                                    <div class="col-xl-9">
                                        <h4 class="font-weight-bold ">Hatırlatma</h4>
                                        <p>Günlük paylaşımınızı eklemeyi unutmayın!</p>
                                        <a href="/yoneticipaneli/paylasimlar"
                                           class="btn btn-sm btn-primary float-right">Paylaşımlar</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        @if(count($user->magaza->paylasims->where('isActive',true)) == 0)
                            <div class="alert alert-primary shadow-kfyn">
                                <div class="row align-items-center">
                                    <div class="col-xl-3">
                                        <i class="uil-image font-size-56"></i>
                                    </div>
                                    <div class="col-xl-9">
                                        <h4 class="font-weight-bold text-light">Bilgi</h4>
                                        <p>Aktif bir paylaşımınız bulunmuyor. Kahveseverler ilgi çekici içeriklerinizi
                                            bekliyor!</p>
                                        <a href="/yoneticipaneli/paylasimlar"
                                           class="btn btn-sm btn-secondary float-right">Paylaşımlar</a>
                                    </div>
                                </div>
                            </div>
                        @elseif(count($user->magaza->paylasims->where('isActive',true)) > 0)
                            <div class="alert alert-light shadow-sm">
                                <div class="row align-items-center">
                                    <div class="col-xl-3">
                                        <div class="popup-gallery"
                                             data-source="{{$user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->imageLink}}">
                                            <a class=""
                                               href="{{$user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->imageLink}}"
                                               title="">
                                                <img class="avatar-lg rounded img-fluid "
                                                     src="{{$user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->imageLink}}"
                                                     alt="img">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-9">
                                        <h4 class="font-weight-bold">Bilgi</h4>
                                        <p>
                                            @if(\Carbon\Carbon::now()->diffInMinutes($user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->created_at) < 60)
                                                {{\Carbon\Carbon::now()->diffInMinutes($user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->created_at)}}
                                                dakika önce
                                            @else
                                                {{\Carbon\Carbon::now()->diffInHours($user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->created_at)}}
                                                saat önce
                                            @endif
                                            paylaştığınız
                                            PAY{{$user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->id}}
                                            ID'li
                                            paylaşımınız {{$user->magaza->paylasims->where('isActive',true)->sortByDesc('created_at')->first()->viewCount}}
                                            kez görüntülendi.
                                        </p>

                                        <a href="/yoneticipaneli/paylasimlar"
                                           class="btn btn-sm btn-primary float-right">Paylaşımlar</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endif
                @if($hasBrand) @if(count($announces) > 0)
                        <div class="card">
                            <h5 class="card-title header-title border-bottom p-3 mb-0">Markanıza ait aktif duyurular</h5>
                            <div class="mt-2 mb-2 ml-3" >
                                <div class="col-12">
                                    @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)
                                        <div class="alert alert-primary mr-3">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
                                    @else
                                        @foreach($announces as $item)
                                            <div class="row mb-2">
                                                <div class="popup-gallery mt-1" data-source="{{$item->imageLink}}">
                                                    <a href="{{$item->imageLink}}" title="">
                                                        <img src="{{$item->imageLink}}" alt="img"
                                                             class=" rounded avatar-md">
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a class="m-0 text-primary font-weight-bold" href="javascript:void(0);" data-toggle="modal" data-target="#duyuruModal{{$item->id}}" >{{$item->title}}</a>
                                                    <p class="m-0">Görüntülenme sayısı: <text class="font-weight-bold">{{$item->viewCount}}</text>
                                                    <p class="m-0">Şehir: <text class="font-weight-bold">{{$item->city->name}}</text>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif @endif
                @if(count($user->magaza->menu_items) == 0)
                    <div class="card">
                        <h5 class="card-title header-title border-bottom p-3 mb-0">En fazla görüntülenen
                            ürünleriniz</h5>
                        <div class="col-12 text-center" style="height: 23vh">
                            <i class="uil uil-coffee font-size-56 "></i>
                            <p class="font-weight-bold">Henüz mağazanızın menüsüne ürün eklemediniz.</p>
                            <a href="/yoneticipaneli/urunler"
                               class="btn btn-sm btn-secondary mr-2 mt-2 mb-2 float-right">Ürünler</a>
                        </div>
                    </div>
                @else
                    @if(count($mvItems) > 0)
                        <div class="card">
                            <h5 class="card-title header-title border-bottom p-3 mb-0">En fazla görüntülenen
                                ürünleriniz</h5>
                            @if($isPremiumPlanEnabled && !$isStatisticsFree && !$user->brand->isPremium)
                                <div class="alert alert-primary mr-4 ml-4">Markanızı Premium Plan'a taşıyarak mağazanızın detaylı istatistiklerine ulaşabilirsiniz.</div>
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
                                                    <a class="m-0 text-primary font-weight-bold"
                                                       href="/yoneticipaneli/urunler/URN{{$item->id}}">{{$item->title}}</text> </a>
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
        </div>
        @if(count($announces) > 0)
            @foreach($announces as $item)
                <div class="modal fade" id="duyuruModal{{$item->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="duyuruModal{{$item->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="duyuruModal{{$item->id}}">DYR{{$item->id}} - Detay</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-xl-12">
                                    <div class="popup-gallery mr-2" data-source="{{$item->imageLink}}">
                                        <img src="{{$item->imageLink}}" alt="img" class="rounded" width=100%>
                                    </div>
                                    <h6 class="mt-4 mb-0">{{$item->title}} (Şehir: <text class="font-weight-bold">{{$item->city->name}}</text>)</h6>
                                    <small class="mt-0">Yayın tarihleri: {{\Carbon\Carbon::createFromTimeString($item->created_at)->startOfDay()->format('d/m/Y H:i')}} - {{\Carbon\Carbon::createFromTimeString($item->created_at)->addDays(\App\Models\KafeyinStringSetting::where('code','announcementViewDayCount')->first()->value)->endOfDay()->format('d/m/Y H:i')}}</small>
                                    <hr class="mt-2 mb-3">
                                    <p>{{$item->desc}}</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
    <div class="modal fade" id="approvalInfoDialog" tabindex="-1" role="dialog"
         aria-labelledby="approvalInfoDialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approvalInfoDialog">Bilgi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-xl-12">
                        <p>Mağazanızın bağlı olduğu marka için oluşturulan ve tamamlanan sadakat kartlarını,
                            Kafeyin kullanıcılarının isteği üzerine oluşturulan referans kodları ile onaylayabilir ve ödüllerini verebilirsiniz. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(count($announces) > 0)
        @foreach($announces as $item)
            <div class="modal fade" id="duyuruModal{{$item->id}}" tabindex="-1" role="dialog"
                 aria-labelledby="duyuruModal{{$item->id}}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="duyuruModal{{$item->id}}">DYR{{$item->id}} - Detay</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-xl-12">
                                <div class="popup-gallery mr-2" data-source="{{$item->imageLink}}">
                                    <img src="{{$item->imageLink}}" alt="img" class="rounded" width=100%>
                                </div>
                                <h6 class="mt-4 mb-0">{{$item->title}} (Şehir: <text class="font-weight-bold">{{$item->city->name}}</text>)</h6>
                                <small class="mt-0">Yayın tarihleri: {{\Carbon\Carbon::createFromTimeString($item->created_at)->startOfDay()->format('d/m/Y H:i')}} - {{\Carbon\Carbon::createFromTimeString($item->created_at)->addDays(\App\Models\KafeyinStringSetting::where('code','announcementViewDayCount')->first()->value)->endOfDay()->format('d/m/Y H:i')}}</small>
                                <hr class="mt-2 mb-3">
                                <p>{{$item->desc}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
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
    <script type="text/javascript">
        $('#frmApproveCard').submit(function(e){
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
    </script>
    @if($hasMagaza)
        <script>
            var galleryTop = new Swiper('.gallery-top', {
                autoHeight: true,
                spaceBetween: 10,
                autoplay: true,
                loop: false,
                loopedSlides: 5,
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
    @endif
    @if($hasBrand && !$hasMagaza)
        <script>
            var daysLabels = [
                @foreach(array_reverse($l15days) as $day)
                new Date({{$day}}).toLocaleDateString(),
                @endforeach
            ];

            var avgSeries = [
                @foreach(array_chunk($l15daps,15) as $daps)
                [
                    @foreach(array_reverse($daps) as $dap)
                    {{$dap}},
                    @endforeach
                ],
                @endforeach

            ];

            var viewsSeries = [
                    @foreach(array_chunk($l15dvs,15) as $daps)
                [
                    @foreach(array_reverse($daps) as $dap)
                    {{$dap}},
                    @endforeach
                ],
                @endforeach

            ];

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
                    height: 330,
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

            var colorArray = ["#008FFB", "#00E396", "#FEB019", "#FF4560", "#775DD0",
                "#3f51b5", "#03a9f4", "#4caf50", "#f9ce1d", "#FF9800",
                "#33b2df", "#546E7A", "#d4526e", "#13d8aa", "#A5978B"
            ];

            var names = [];
            var colors = [];
            var colors2 = [];
            var colors3 = [];
            @foreach($stos as $sto)
                names.push("{{$sto}}");
                colors.push(colorArray[Math.floor(Math.random() * colorArray.length)]);
                colors2.push(colorArray[Math.floor(Math.random() * colorArray.length)]);
                colors3.push(colorArray[Math.floor(Math.random() * colorArray.length)]);
            @endforeach
            var series = [];
            avgSeries.forEach(function (seri,index) {
                var ss = {
                    name:names[index],
                    data: seri,
                };
                series.push(ss);
            });
            var avgOptions = {
                chart: {
                    height: 400,
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
                series: series,
                zoom: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                colors: colors,
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

            var series2 = [];
            viewsSeries.forEach(function (seri,index) {
                var ss = {
                    name:names[index],
                    data: seri,
                };
                series2.push(ss);
            });
            var viewsOptions = {
                chart: {
                    height: 400,
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
                series: series2,
                zoom: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                colors: colors2,
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
                    @foreach(array_chunk($l15dfs,15) as $daps)
                [
                    @foreach(array_reverse($daps) as $dap)
                    {{$dap}},
                    @endforeach
                ],
                @endforeach
            ];

            var series3 = [];
            favsSeries.forEach(function (seri,index) {
                var ss = {
                    name:names[index],
                    data: seri,
                };
                series3.push(ss);
            });

            var favsOptions = {
                chart: {
                    height: 400,
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
                series: series3,
                zoom: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                colors: colors3,
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

        </script>
    @endif
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('hata')}}",
                type: "error",
            });
        @elseif (session('surAns'))
        swal.fire({
            title: 'Teşekkür ederiz!',
            html: 'Görüşünüzü bildirdiğiniz için teşekkür ederiz.<br><text class="text-primary">Kahve aşkına!</text>',
            type: "success",
        });
        @elseif (session('appr') && session('cardownerfav'))
            swal.fire({
                title: 'Başarılı!',
                html: '<text class="text-success">Kullanıcı, sadakat kartını tamamladı ve belirlediğiniz ödülü kazandı.</text><br><text class="text-success">Kullanıcı, mağazanızı favorilerine eklemiş.</text>',
                type: "success",
            });
        @elseif (session('appr') && !session('cardownerfav'))
        swal.fire({
            title: 'Başarılı!',
            html: '<text class="text-success">Kullanıcı, sadakat kartını tamamladı ve belirlediğiniz ödülü kazandı.</text><br><text class="text-danger">Kullanıcı, mağazanızı favorilerine eklememiş.</text>',
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
