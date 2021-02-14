@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{$city->id}} - {{$city->name}}</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">#{{$city->id}} - {{$city->name}}</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Şehre ait bilgiler</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#detay" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-info-circle"></i></span>
                                <span class="d-none d-sm-block">Detay</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#sayilar" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class=" uil-arrow-growth"></i></span>
                                <span class="d-none d-sm-block">Sayılar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#ayarlar" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-cog"></i></span>
                                <span class="d-none d-sm-block">Ayarlar</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="detay">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="header-title mt-1">Popüler mağazalar</h5>
                                        <a href="/adminpanel/sehirler/{{$city->id}}/populermagazalar">Düzenle</a>
                                    </div>
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Adı</th>
                                                <th>Pozisyon</th>
                                                <th>Görüntülenme</th>
                                                <th>Tür</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city->popularstores as $pmagaza)
                                                <tr>
                                                    <th scope="row">{{$pmagaza->id}}</th>
                                                    <td><a class="card-link text-muted" href="/adminpanel/magazalar/{{$pmagaza->store->id}}">#{{$pmagaza->store->id}} - {{$pmagaza->store->name}}</a></td>
                                                    <td>{{$pmagaza->position}}</td>
                                                    <td>{{$pmagaza->viewCount}}</td>
                                                    @if($pmagaza->isPaid)
                                                        <th scope="row"><span class="badge badge-success">Sponsorlu</span></th>
                                                    @else
                                                        <th scope="row"><span class="badge badge-primary">Normal</span></th>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="header-title mt-1">En son eklenen mağazalar</h5>
                                        <a href="/adminpanel/sehirler/{{$city->id}}/ensoneklenenmagazalar">Düzenle</a>
                                    </div>
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Adı</th>
                                                <th>Pozisyon</th>
                                                <th>Görüntülenme</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city->lastaddedstores as $pmagaza)
                                                <tr>
                                                    <th scope="row">{{$pmagaza->id}}</th>
                                                    <td><a class="card-link text-muted" href="/adminpanel/magazalar/{{$pmagaza->store->id}}">#{{$pmagaza->store->id}} - {{$pmagaza->store->name}}</a></td>
                                                    <td>{{$pmagaza->position}}</td>
                                                    <td>{{$pmagaza->viewCount}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-6">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="header-title mt-1">Editörün tercihi mağazalar</h5>
                                        <a href="/adminpanel/sehirler/{{$city->id}}/etercihimagazalar">Düzenle</a>
                                    </div>
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Adı</th>
                                                <th>Pozisyon</th>
                                                <th>Görüntülenme</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city->editorsstores as $pmagaza)
                                                <tr>
                                                    <th scope="row">{{$pmagaza->id}}</th>
                                                    <td><a class="card-link text-muted" href="/adminpanel/magazalar/{{$pmagaza->store->id}}">#{{$pmagaza->store->id}} - {{$pmagaza->store->name}}</a></td>
                                                    <td>{{$pmagaza->position}}</td>
                                                    <td>{{$pmagaza->viewCount}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="header-title mt-1">Kafeyin lokasyonlar</h5>
                                        <a href="/adminpanel/sehirler/{{$city->id}}/kafeyinlokasyonlar">Düzenle</a>
                                    </div>
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Lokasyon adı</th>
                                                <th>Enlem</th>
                                                <th>Boylam</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city->kafeyinlocations as $kloca)
                                                <tr>
                                                    <th scope="row">{{$kloca->id}}</th>
                                                    <td>{{$kloca->name}}</td>
                                                    <td>{{$kloca->latitude}}</td>
                                                    <td>{{$kloca->longitude}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-xl-12">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="header-title mt-1">Duyurular</h5>
                                        <a href="/adminpanel/sehirler/{{$city->id}}/duyurular">Düzenle</a>
                                    </div>
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th></th>
                                                <th>Marka</th>
                                                <th>Pozisyon</th>
                                                <th>Görüntülenme</th>
                                                <th>Eklenme Tarihi</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($city->announcements as $duyuru)
                                                <tr>
                                                    <th scope="row">{{$duyuru->id}}</th>
                                                    <td>
                                                        <div class="popup-gallery" data-source="{{$duyuru->imageLink}}">
                                                            <a href="{{$duyuru->imageLink}}" title="">
                                                                <img src="{{$duyuru->imageLink}}" alt="img" class="avatar-md rounded">
                                                            </a>
                                                        </div>
                                                    </td>
                                                    @if(!is_null($duyuru->brandID))
                                                        <td><a class="card-link text-muted" href="/adminpanel/markalar/{{$duyuru->brand->id}}">#{{$duyuru->brand->id}} - {{$duyuru->brand->name}}</a></td>
                                                    @else
                                                        <td>Kafeyin</td>
                                                    @endif
                                                    <td>{{$duyuru->position}}</td>
                                                    <td>{{$duyuru->viewCount}}</td>
                                                    <td>{{\Carbon\Carbon::createFromTimeString($duyuru->created_at)->format('d/m/Y H:i')}}</td>
                                                    <td> <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#duyuruModal{{$duyuru->id}}" class="card-link text-primary">Detay</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @foreach($city->announcements as $duyuru)
                                            <div class="modal fade" id="duyuruModal{{$duyuru->id}}" tabindex="-1" role="dialog"
                                                 aria-labelledby="duyuruModal{{$duyuru->id}}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="duyuruModal{{$duyuru->id}}">Duyuru detay</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>{{$duyuru->title}}</h6>
                                                            <hr>
                                                            <p>{{$duyuru->desc}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="sayilar">
                            <h5 class="header-title mt-1">{{\Carbon\Carbon::today()->startOfDay()->format('H:i d/m/Y')}} itibariyle</h5>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Kayıt olan kullanıcı sayısı</th>
                                                <td>{{$tdyRegUserCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Giriş yapan kullanıcı sayısı</th>
                                                <td>{{$tdyLogUserCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Oluşturulan sadakat kartı sayısı</th>
                                                <td>{{$tdyLoyCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kullanılan sadakat kartı sayısı</th>
                                                <td>{{$tdyUsedLoyCount}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Eklenen yazı sayısı</th>
                                                <td>{{$tdyArtCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Eklenen etkinlik sayısı</th>
                                                <td>{{$tdyActCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Eklenen paylaşım sayısı</th>
                                                <td>{{$tdyStoCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Makina kullanım sayısı</th>
                                                <td>{{$tdyMakUsageCount}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="table-responsive mt-1">
                                        <table class="table table-hover m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Yapılan yorum sayısı</th>
                                                <td>{{$tdyCommentCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Eklenen fotoğraf sayısı</th>
                                                <td>{{$tdyPhotoCount}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ayarlar">
                            <div class="row">
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/sehirguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="cityID" value="{{$city->id}}">

                                            <div class="form-group row">
                                                <label for="isActive" class="col-md-6 col-form-label">Aktiflik</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isActive" name="isActive" value="1" class="custom-control-input" @if($city->isActive) checked @endif>
                                                    <label class="custom-control-label" for="isActive">Aktif</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isActive2" name="isActive" value="0" class="custom-control-input" @if(!$city->isActive) checked @endif>
                                                    <label class="custom-control-label" for="isActive2">Pasif</label>
                                                </div>
                                            </div>


                                            <div class="col-md-8 offset-md-4">
                                                <input type="submit" class="btn btn-primary mr-1" value="Güncelle">
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
                    <h6 class="header-title mb-4">Bağlantılar</h6>
                    <div class="media pt-0">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    <td><a href="/adminpanel/sehirler/{{$city->id}}/yazilar">Yazılar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/sehirler/{{$city->id}}/etkinlikler">Etkinlikler</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/sehirler/{{$city->id}}/paylasimlar">Paylaşımlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/sehirler/{{$city->id}}/lokasyonlar">Lokasyonlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/sehirler/{{$city->id}}/kafeyindenhaberler">Kafeyin'den haberler</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Bilgiler</h6>
                    <div class="media border-top">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    @if($city->isActive)
                                        <th scope="row">Aktiflik:<span class="badge badge-success ml-2">Aktif</span></th>
                                    @else
                                        <th scope="row">Aktiflik:<span class="badge badge-danger ml-2">Pasif</span></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row">Mağaza sayısı: {{$storeCount}}</th>
                                </tr>
                                <tr>
                                    <th scope="row">Kullanıcı sayısı: {{$kullaniciCount}}</th>
                                </tr>
                                <tr>
                                    <th scope="row">Aktif yazı sayısı: {{$yaziCount}}</th>
                                </tr>
                                <tr>
                                    <th scope="row">Aktif etkinlik sayısı: {{$etkinlikCount}}</th>
                                </tr>
                                <tr>
                                    <th scope="row">Aktif paylaşım sayısı: {{$paylasimCount}}</th>
                                </tr>
                                <tr>
                                    <th scope="row">Aktif ürün sayısı: {{$urunCount}}</th>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
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
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script>
        @if (session('cityUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Şehir bilgileri güncellenmiştir.',
                type: "success",
            });
        @elseif(session('sameUser'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Aynı kullanıcıyı seçtiniz.',
                type: "warning",
            });
        @elseif(session('alreadyStoreUser'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz kullanıcı zaten bir mağaza yöneticisi.',
                type: "warning",
            });
        @endif
        $('#dtCommon').on('click', 'tbody tr ', function (id)
        {
            window.location.href = $(this).data('href');
        });
        $('#dtCommon2').on('click', 'tbody tr ', function (id)
        {
            window.location.href = $(this).data('href');
        });
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
