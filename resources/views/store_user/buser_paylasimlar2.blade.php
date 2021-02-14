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
                    <li class="breadcrumb-item active" aria-current="page">Paylaşımlar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif paylaşımlar</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Paylaşım Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktifPaylasims as $paylasim)
                            <tr>
                                <td>PAY{{$paylasim->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                        <a href="{{$paylasim->imageLink}}" title="">
                                            <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$paylasim->viewCount}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Pasif paylaşımlar</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Paylaşım Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasifPaylasims as $paylasim)
                            <tr>
                                <td>PAY{{$paylasim->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                        <a href="{{$paylasim->imageLink}}" title="">
                                            <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$paylasim->viewCount}}</td>

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
                    @if($isPremiumEnabled)
                        @if($store->brand->isPremium)
                            <p class="card-text text-muted">Kalan günlük paylaşım sayısı: <text class="text-success">Sınırsız</text> </p>
                        @else
                            <p class="card-text text-muted">Kalan günlük paylaşım sayısı: {{$store->leftDailyStoryCount}}</p>
                        @endif
                    @else
                        <p class="card-text text-muted">Kalan günlük paylaşım sayısı: {{$store->leftDailyStoryCount}}</p>
                    @endif
                    <hr>
                    <p class="font-weight-bold">Paylaşımlar, paylaşıldıktan 24 saat sonra otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold">Yeni ürün duyuruları, kampanya duyuruları veya özgün içerikler ile kahveseverlerin mağaza ve markaya olan ilgisini arttırılabilir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki paylaşımları, daha önceden bildirmek suretiyle sistemlerimizden kaldırabiliriz.</p>
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
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
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
@endsection
