@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item disabled">Mağazalar</li>
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}">{{$store->name}} (ID: KFYN{{$store->id}})</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yazılar</li>
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
                    <h5 class="header-title mb-3 mt-0">Aktif yazılar</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktifYazis as $yazi)
                            <tr>
                                <td>YAZ{{$yazi->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$yazi->imageLink}}">
                                        <a href="{{$yazi->imageLink}}" title="">
                                            <img src="{{$yazi->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$yazi->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$yazi->viewCount}}</td>
                                <td>{{$yazi->favorites_count}}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" type="button" data-toggle="modal" data-target="#detayModal{{$yazi->id}}">Detay</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Pasif yazılar</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasifYazis as $yazi)
                            <tr>
                                <td>YAZ{{$yazi->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$yazi->imageLink}}">
                                        <a href="{{$yazi->imageLink}}" title="">
                                            <img src="{{$yazi->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$yazi->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$yazi->viewCount}}</td>
                                <td>{{$yazi->favorites_count}}</td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" type="button" data-toggle="modal" data-target="#detayModal{{$yazi->id}}">Detay</a>
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
                    @if(count($aktifYazis) > 1)
                        <p class="card-text text-muted">Eklenebilir yazı sayısı: 0</p>
                    @else
                        <p class="card-text text-muted">Eklenebilir yazı sayısı: {{2-(count($aktifYazis))}}</p>
                    @endif
                    <hr>
                    <p class="font-weight-bold">Çekirdek halinden bardaklarımıza gelene kadar uzun bir yola sahip olan kahve ile ilgili üretilecek özgün içerikler, kahveseverlerin mağaza ve markaya olan ilgisini arttıracaktır.</p>
                    <hr>
                    <p class="font-weight-bold">Yazılar, eklendikten 7 gün sonra otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki yazıları, daha önceden bildirmek suretiyle sistemlerimizden kaldırabiliriz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan yazıları, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
        </div>
    </div>
    @foreach($aktifYazis as $yazi)
        <div class="modal fade" id="detayModal{{$yazi->id}}" tabindex="-1" role="dialog"
             aria-labelledby="detayModal{{$yazi->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detayModal{{$yazi->id}}">YAZ{{$yazi->id}} - Detay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row align-items-start">
                                <div class="col-md-4">
                                    <img src="{{$yazi->imageLink}}" alt="img" class="rounded" width=100%>
                                    <hr>
                                    <p>Görüntülenme sayısı: {{$yazi->viewCount}}</p>
                                    <hr>
                                    <p>Favoriye alınma sayısı: {{$yazi->favorites_count}}</p>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mt-0">{{$yazi->title}}</h5>
                                    <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</p>
                                    <hr class="mt-1">
                                    <p class="card-text text-muted">{{$yazi->desc}}</p>
                                    @if($yazi->hasVideo)
                                        <h5 class="mt-4">Video</h5>
                                        <hr class="mt-1 mb-0">
                                        <div class="embed-responsive embed-responsive-16by9 mt-4 mb-3">
                                            <video src="{{$yazi->videoLink}}" controls controlsList="nodownload" ></video>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($pasifYazis as $yazi)
        <div class="modal fade" id="detayModal{{$yazi->id}}" tabindex="-1" role="dialog"
             aria-labelledby="detayModal{{$yazi->id}}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detayModal{{$yazi->id}}">YAZ{{$yazi->id}} - Detay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="row align-items-start">
                                <div class="col-md-4">
                                    <img src="{{$yazi->imageLink}}" alt="img" class="rounded" width=100%>
                                    <hr>
                                    <p>Görüntülenme sayısı: {{$yazi->viewCount}}</p>
                                    <hr>
                                    <p>Favoriye alınma sayısı: {{$yazi->favorites_count}}</p>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="mt-0">{{$yazi->title}}</h5>
                                    <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</p>
                                    <hr class="mt-1">
                                    <p class="card-text text-muted">{{$yazi->desc}}</p>
                                    @if($yazi->hasVideo)
                                        <h5 class="mt-4">Video</h5>
                                        <hr class="mt-1 mb-0">
                                        <div class="embed-responsive embed-responsive-16by9 mt-4 mb-3">
                                            <video src="{{$yazi->videoLink}}" controls controlsList="nodownload" ></video>
                                        </div>
                                    @endif
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
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment('DD/MM/YYYY HH:mm');
        });
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
