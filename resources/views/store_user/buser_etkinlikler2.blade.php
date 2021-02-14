@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item disabled">Mağazalar</li>
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}">{{$store->name}} (ID: KFYN{{$store->id}})</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Etkinlikler</li>
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
                    <h5 class="header-title mb-3 mt-0">Aktif etkinlikler</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktifEtkinliks as $etkinlik)
                            <tr>
                                <td>ETK{{$etkinlik->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$etkinlik->imageLink}}">
                                        <a href="{{$etkinlik->imageLink}}" title="">
                                            <img src="{{$etkinlik->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$etkinlik->title}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</td>
                                <td>{{$etkinlik->viewCount}}</td>
                                <td>{{$etkinlik->favorites_count}}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" type="button" data-toggle="modal" data-target="#detayModal{{$etkinlik->id}}">Detay</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Pasif etkinlikler</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasifEtkinliks as $etkinlik)
                            <tr>
                                <td>ETK{{$etkinlik->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$etkinlik->imageLink}}">
                                        <a href="{{$etkinlik->imageLink}}" title="">
                                            <img src="{{$etkinlik->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$etkinlik->title}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</td>
                                <td>{{$etkinlik->viewCount}}</td>
                                <td>{{$etkinlik->favorites_count}}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" type="button" data-toggle="modal" data-target="#detayModal{{$etkinlik->id}}">Detay</a>
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
                    @if(count($aktifEtkinliks) > 1)
                        <p class="card-text text-muted">Eklenebilir etkinlik sayısı: 0</p>
                    @else
                        <p class="card-text text-muted">Eklenebilir etkinlik sayısı: {{2-(count($aktifEtkinliks))}}</p>
                    @endif
                    <hr>
                    <p class="font-weight-bold">Etkinlikler <text class="text-primary">yarın ve takip eden 30 gün</text> için eklenebilir.</p>
                    <hr>
                    <p class="font-weight-bold">Etkinlikler, günü ve saati geldiğinde otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki etkinlikleri, daha önceden duyurmak suretiyle sistemlerimizden kaldırabiliriz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan etkinlikleri, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
        </div>
    </div>
    @foreach($aktifEtkinliks as $etkinlik)
        <div class="modal fade" id="detayModal{{$etkinlik->id}}" tabindex="-1" role="dialog"
             aria-labelledby="detayModal{{$etkinlik->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detayModal{{$etkinlik->id}}">ETK{{$etkinlik->id}} - Detay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row align-items-start">
                                <div class="col-md-4">
                                    <img src="{{$etkinlik->imageLink}}" alt="img" class="rounded" width=100%>
                                    <hr>
                                    <p>Görüntülenme sayısı: {{$etkinlik->viewCount}}</p>
                                    <hr>
                                    <p>Favoriye alınma sayısı: {{$etkinlik->favorites_count}}</p>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mt-0">{{$etkinlik->title}}</h5>
                                    <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($etkinlik->created_at)->format('d/m/Y H:i')}}</p>
                                    <hr class="mt-1">
                                    <p class="font-weight-bold text-muted">Etkinlik tarihi ve saati: <text class="font-weight-bold text-primary">{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}} {{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</text> </p>
                                    <p class="card-text text-muted">{{$etkinlik->desc}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($pasifEtkinliks as $etkinlik)
        <div class="modal fade" id="detayModal{{$etkinlik->id}}" tabindex="-1" role="dialog"
             aria-labelledby="detayModal{{$etkinlik->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detayModal{{$etkinlik->id}}">ETK{{$etkinlik->id}} - Detay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row align-items-start">
                                <div class="col-md-4">
                                    <img src="{{$etkinlik->imageLink}}" alt="img" class="rounded" width=100%>
                                    <hr>
                                    <p>Görüntülenme sayısı: {{$etkinlik->viewCount}}</p>
                                    <hr>
                                    <p>Favoriye alınma sayısı: {{$etkinlik->favorites_count}}</p>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mt-0">{{$etkinlik->title}}</h5>
                                    <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($etkinlik->created_at)->format('d/m/Y H:i')}}</p>
                                    <hr class="mt-1">
                                    <p class="font-weight-bold text-muted">Etkinlik tarihi ve saati: <text class="font-weight-bold text-primary">{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}} {{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</text> </p>
                                    <p class="card-text text-muted">{{$etkinlik->desc}}</p>
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
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY');
        });
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
