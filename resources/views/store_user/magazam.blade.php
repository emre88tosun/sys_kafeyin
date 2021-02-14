@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Mağazam</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>

        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <h5 class="header-title mb-3 mt-0">Mağazanıza ait bilgiler</h5>
                            <div class="table-responsive table-hover">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">ID</th>
                                        <td class="float-right">KFYN{{$user->magaza->id}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ad</th>
                                        <td class="float-right">{{$user->magaza->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Lokasyon</th>
                                        <td class="float-right">{{$user->magaza->location->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Şehir</th>
                                        <td class="float-right">{{$user->magaza->city->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Adres</th>
                                        <td class="float-right">{{$user->magaza->address}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Sabit telefon</th>
                                        <td class="float-right">@if($user->magaza->landPhoneNumber) {{$user->magaza->landPhoneNumber}} @else <text class="text-danger font-weight-bold">Eksik</text> @endif</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Enlem</th>
                                        <td class="float-right">{{$user->magaza->latitude}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Boylam</th>
                                        <td class="float-right">{{$user->magaza->longitude}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Öne çıkan</th>
                                        <td class="float-right">@if($user->magaza->featured) {{$user->magaza->featured}} @else <text class="text-danger font-weight-bold">Eksik</text> @endif</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ortalama Puan</th>
                                        <td class="float-right">@if($user->magaza->averagePoint == 0) - @else {{round($user->magaza->averagePoint,1)}} @endif</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Yorum Sayısı</th>
                                        <td class="float-right">{{count($user->magaza->comments)}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Fotoğraf Sayısı</th>
                                        <td class="float-right">{{count($user->magaza->photos)}}</td>
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
                                        @if($user->magaza->monOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->monOpen,0,5)}} - {{substr($user->magaza->monClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Salı</th>
                                        @if($user->magaza->tueOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->tueOpen,0,5)}} - {{substr($user->magaza->tueClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Çarşamba</th>
                                        @if($user->magaza->wedOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->wedOpen,0,5)}} - {{substr($user->magaza->wedClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Perşembe</th>
                                        @if($user->magaza->thuOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->thuOpen,0,5)}} - {{substr($user->magaza->thuClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Cuma</th>
                                        @if($user->magaza->friOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->friOpen,0,5)}} - {{substr($user->magaza->friClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Cumartesi</th>
                                        @if($user->magaza->satOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->satOpen,0,5)}} - {{substr($user->magaza->satClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Pazar</th>
                                        @if($user->magaza->sunOpen == "16:50:00")
                                            <td class="float-right">Kapalı</td>
                                        @else
                                            <td class="float-right">{{substr($user->magaza->sunOpen,0,5)}} - {{substr($user->magaza->sunClose,0,5)}}</td>
                                        @endif
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @if($isOnlineOrderEnabled)
                                <h5 class="header-title mb-3 mt-3">Sipariş alma bilgileri</h5>
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        @if($isTakeAwayOrderEnabled)
                                            @if($user->magaza->canTakeTakeAwayOrder)
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
                                            @if($user->magaza->canTakeLocalDeliveryOrder)
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
                                            @if($user->magaza->canTakeLocalCargoOrder)
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
                                            @if($user->magaza->canTakeUpstateCargoOrder)
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
                            @endif
                        </div>
                        <div class="col-xl-4">
                            <h5 class="header-title mb-3 mt-0">Mağaza özellikleri</h5>
                            <div class="table-responsive table-hover">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Ders çalışma ortamı</th>
                                        @if($user->magaza->isStudy)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Buluşmaya uygun</th>
                                        @if($user->magaza->isDate)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Latte-art</th>
                                        @if($user->magaza->isLatteArt)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Hayvan dostu</th>
                                        @if($user->magaza->isPetFriendly)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Tatlı</th>
                                        @if($user->magaza->isDessert)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Toplantıya uygun</th>
                                        @if($user->magaza->isMeeting)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Alkollü mekan</th>
                                        @if($user->magaza->isAlcohol)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Dış mekan</th>
                                        @if($user->magaza->isOutside)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Yemek</th>
                                        @if($user->magaza->isMeal)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Kahvaltı</th>
                                        @if($user->magaza->isBreakfast)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Çikolata</th>
                                        @if($user->magaza->isChocolate)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Fotoğraf için dekor</th>
                                        @if($user->magaza->isTakePhoto)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Self-servis</th>
                                        @if($user->magaza->isSelfService)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Çay</th>
                                        @if($user->magaza->isTea)
                                            <td class="float-right"><i class="uil-check-circle text-success "></i></td>
                                        @else
                                            <td class="float-right"><i class="uil-times-circle text-danger "></i></td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th scope="row">Canlı müzik</th>
                                        @if($user->magaza->isLiveMusic)
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
                </div>
            </div>
            <div class="alert">
                <div class="row align-items-center">
                    <div class="col-xl-auto">
                        <i class="uil-info-circle font-size-56 "></i>
                    </div>
                    <div class="col-xl-11">
                        <h4 class="font-weight-bold">Bilgi</h4>
                        <p> Mağaza bilgilerinde eksik veya hatalı bilgi olduğunu düşünüyorsanız, "destek@kafeyinapp.com" e-posta adresi üzerinden bize ulaşabilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="header-title mb-4">Logo</h6>
                            <div class="media pt-0">
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <div class="popup-gallery" data-source="{{$user->magaza->brand->logo}}">
                                            <a href="{{$user->magaza->brand->logo}}" title="">
                                                <img src="{{$user->magaza->brand->logo}}" alt="img" class="avatar-xxl rounded">
                                            </a>
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="header-title mb-4">Kapak fotoğrafı</h6>
                            <div class="media pt-0">
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <div class="popup-gallery" data-source="{{$user->magaza->coverImageLink}}">
                                            <a href="{{$user->magaza->coverImageLink}}" title="">
                                                <img src="{{$user->magaza->coverImageLink}}" alt="img" class="avatar-xxl rounded">
                                            </a>
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($user->magaza->kafeyin_photos) != 0)
                <div class="card">
                    <div class="card-body pt-2">
                        <h6 class="header-title mb-4">Kafeyin tarafından sağlanan fotoğraflar</h6>
                        <div class="col-xl-12">
                            <div class="row">
                                @foreach($user->magaza->kafeyin_photos as $kPhoto)
                                    <div class="popup-gallery mr-2" data-source="{{$kPhoto->imageLink}}">
                                        <a href="{{$kPhoto->imageLink}}" title="">
                                            <img src="{{$kPhoto->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            @endif
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
                            <p>Mağazanız, {{$user->magaza->city->name}} ilinin "Editörün Tercihi Mekanlar" listesinde!</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="alert alert-primary shadow-kfyn">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <i class="uil-eye font-size-56"></i>
                    </div>
                    <div class="col-xl-9">
                        <h4 class="font-weight-bold text-light">Görüntülenme sayısı</h4>
                        <p>Mağazanızın toplam görüntülenme sayısı: {{count($user->magaza->views)}}</p>
                    </div>
                </div>
            </div>
            <div class="alert alert-primary shadow-kfyn">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <i class="uil-bookmark font-size-56"></i>
                    </div>
                    <div class="col-xl-9">
                        <h4 class="font-weight-bold text-light">Favoriye alan sayısı</h4>
                        <p>Mağazanızı favoriye alan toplam kullanıcı sayısı: {{count($user->magaza->favorites)}}</p>
                    </div>
                </div>
            </div>
            <div class="alert @if(count($user->magaza->todayssearches) == 0) alert-danger shadow-red @else alert-success shadow-green @endif">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <i class="uil-search font-size-56"></i>
                    </div>
                    <div class="col-xl-9">
                        <h4 class="font-weight-bold text-light">Aranma sayısı</h4>
                        <p>Mağazanızın bugünkü aranma sayısı: {{count($user->magaza->todayssearches)}}</p>
                    </div>
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
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('yazi')}}",
                type: "error",
            });
        @elseif(session('artDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla silindi.",
                type: "success",
            });
        @elseif(session('artPas'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla pasif hale getirildi.",
                type: "success",
            });
        @elseif(session('multiArtDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Seçtiğiniz yazılar başarıyla silindi.",
                type: "success",
            });
        @elseif(session('artAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla eklendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
