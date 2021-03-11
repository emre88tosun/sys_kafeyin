@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item disabled">Mağazalar</li>
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}">{{$store->name}} (ID: KFYN{{$store->id}})</a></li>
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}/urunler">Ürünler</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$kategori1->desc}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">{{$kategori1->desc}}</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Ad</th>
                            <th>Alt kategori</th>
                            <th>Fiyat</th>
                            <th>Aktiflik</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            @if($kategori1->canGenerateQrCode)
                                <th>Aktif QR Kod Sayısı</th>
                            @endif
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($uruns as $urun)
                            <tr>
                                <td>URN{{$urun->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$urun->imageLink}}">
                                        <a href="{{$urun->imageLink}}" title="">
                                            <img src="{{$urun->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td data-toggle="tooltip" data-placement="right" title=" @if($urun->tag1 == "1")Sıcak, @elseif($urun->tag1 == "2")Soğuk, @endif @if($urun->tag2 == "1")Kahve baskın, @elseif($urun->tag2 == "2")Süt baskın, @elseif($urun->tag2 == "3")Diğer, @endif @if($urun->tag3 == "1")Hafif içim @elseif($urun->tag3 == "2")Orta içim @elseif($urun->tag3 == "3")Yoğun içim @endif ">{{$urun->title}}</td>
                                <td>{{$urun->subcategory->desc}}</td>
                                <td>{{$urun->fee??"-"}}TL</td>
                                @if($urun->isActive)
                                    <td><span class="badge badge-soft-success">Aktif</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Pasif</span></td>
                                @endif
                                <td>{{\Carbon\Carbon::createFromTimeString($urun->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$urun->views_count}}</td>
                                @if($kategori1->canGenerateQrCode)
                                    <td>{{count($urun->qrcodes->where('status','active'))}}</td>
                                @endif
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" type="button" data-toggle="modal" data-target="#detayModal{{$urun->id}}">Detay</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    <p class="font-weight-bold">Ürünleri eklerken kullanılan görsel ve yazılan detaylı ürün açıklamaları, kahveseverlerin mağaza ve markaya olan ilgisini arttıracaktır.</p>
                    <hr>
                    @if(!$hasBrand)
                        <p class="font-weight-bold text-primary">Eklemek istenen ürünün alt kategorisi mevcut değil ise marka yöneticinisi yeni alt kategoriyi ekleyebilir..</p>
                        <hr>
                    @endif
                    @if($kategori1->canGenerateQrCode)
                        <p class="font-weight-bold text-primary">Bir ürün pasif hale geldiğinde; bu ürüne bağlı aktif QR kod bulunuyorsa, QR kodlar da ürün ile birlikte pasif hale gelecek ve bir daha kullanılamayacaktır.</p>
                        <hr>
                    @endif
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan yazıları, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16 mb-4">Alt kategoriler</h5>
                    @if(count($kategori1->subcategories->where('brandID',$user->brand->id)))
                        @foreach($kategori1->subcategories->where('brandID',$user->brand->id) as $subCat)
                            <p class="font-weight-bold text-primary">{{$subCat->desc}}</p>
                            <p class="text-muted">{{count($subCat->items)}} ürün</p>
                            <hr>
                        @endforeach
                    @else
                        <p class="font-weight-bold text-primary mb-0">Bu kategori için tanımlı alt kategori bulunmamaktadır.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @foreach($uruns as $urun)
        <div class="modal fade" id="detayModal{{$urun->id}}" tabindex="-1" role="dialog"
             aria-labelledby="detayModal{{$urun->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detayModal{{$urun->id}}">URN{{$urun->id}} - Detay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row align-items-start">
                                <div class="col-md-4">
                                    <img src="{{$urun->imageLink}}" alt="img" class="rounded" width=100%>
                                    <hr>
                                    <p>Toplam görüntülenme sayısı: {{$urun->views_count}}</p>
                                    <hr>
                                    @if($kategori1->canGenerateQrCode)
                                        <p>Aktif QR kod sayısı: {{count($urun->qrcodes->where('status','active'))}}</p>
                                        <hr>
                                        <p>Kullanılan QR kod sayısı: {{count($urun->qrcodes->where('status','used'))}}</p>
                                        <hr>
                                        <p>Silinen QR kod sayısı: {{count($urun->qrcodes->where('isDeleted',true))}}</p>
                                        <hr>
                                        <p class="mb-0">Bugün kullanılan QR kod sayısı: {{count($urun->qrcodes->where('status','used')->where('updated_at','>=',\Carbon\Carbon::today()->startOfDay()))}}</p>
                                        <hr>
                                    @endif
                                    <p class="mb-0">Bugün görüntülenme sayısı: {{count($urun->views->where('created_at','>=',\Carbon\Carbon::today()->startOfDay()))}}</p>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mt-0 mb-1">{{$urun->title}}</h5>
                                    <h6 class="mt-0 mb-0 font-weight-bold text-primary">{{$urun->subcategory->desc}}</h6>
                                    <h6 class="text-primary font-weight-bold mt-2 mb-1">
                                        @if($urun->tag1 == "1")
                                            Sıcak,
                                        @elseif($urun->tag1 == "2")
                                            Soğuk,
                                        @endif
                                        @if($urun->tag2 == "1")
                                            Kahve baskın,
                                        @elseif($urun->tag2 == "2")
                                            Süt baskın,
                                        @elseif($urun->tag2 == "3")
                                            Diğer,
                                        @endif
                                        @if($urun->tag3 == "1")
                                            Hafif içim
                                        @elseif($urun->tag3 == "2")
                                            Orta içim
                                        @elseif($urun->tag3 == "3")
                                            Yoğun içim
                                        @endif
                                    </h6>
                                    <p class="font-weight-bold text-muted mb-1">Ürün fiyatı: <text class="font-weight-bold text-primary">{{$urun->fee??"-"}}TL</text> </p>
                                    <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($urun->created_at)->format('d/m/Y H:i')}}</p>
                                    <hr class="mt-1">
                                    <p class="card-text text-muted">{{$urun->desc}}</p>
                                    {{--<h5 class="mt-4 mb-0">İstatistikler</h5>
                                    <hr class="mt-1">
                                    @if($isPremiumPlanEnabled)
                                        @if($user->magaza->brand->isPremium)
                                            <p class="font-weight-bold text-muted mb-2">Günlük görüntülenme</p>
                                            <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                                            @if($kategori->canGenerateQrCode)
                                                <p class="font-weight-bold text-muted mb-2 mt-4">QR kod sayısı</p>
                                                <div id="qr_chart" class="apex-charts m-0" dir="ltr"></div>
                                                <p class="font-weight-bold text-muted mb-2 mt-4">Günlük kullanılan QR kod sayısı</p>
                                                <div id="qr_du_chart" class="apex-charts m-0" dir="ltr"></div>
                                            @endif
                                        @else
                                            <p class="text-primary mb-0">Markanızı Premium Plan'a taşıyıp, ürünlerinize ait detaylı istatistiklere ulaşabilirsiniz.</p>
                                        @endif
                                    @else
                                        <p class="font-weight-bold text-muted mb-2">Günlük görüntülenme</p>
                                        <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                                        @if($kategori->canGenerateQrCode)
                                            <p class="font-weight-bold text-muted mb-2 mt-4">QR kod sayısı</p>
                                            <div id="qr_chart" class="apex-charts m-0" dir="ltr"></div>
                                            <p class="font-weight-bold text-muted mb-2 mt-4">Günlük kullanılan QR kod sayısı</p>
                                            <div id="qr_du_chart" class="apex-charts m-0" dir="ltr"></div>
                                        @endif
                                    @endif--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );
        });
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
