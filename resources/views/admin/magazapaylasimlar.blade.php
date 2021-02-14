@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminpanel/magazalar">Mağazalar</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/magazalar/{{$store->id}}">#{{$store->id}}
                            - {{$store->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Paylaşımlar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Paylaşımlar</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif paylaşımlar</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Paylaşım Tarihi</th>
                                <th>Görüntülenme Sayısı</th>
                                <th class="w-25"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($aktifPaylasimlar as $paylasim)
                                <tr>
                                    <th scope="row">{{$paylasim->id}}</th>
                                    <td>
                                        <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                            <a href="{{$paylasim->imageLink}}" title="">
                                                <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>{{$paylasim->viewCount}}</td>
                                    <td><a href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                           class="card-link text-primary sa-payPasif">Pasifize et</a> <a
                                            href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                            class="card-link text-danger sa-paySil">Sil</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h5 class="header-title mb-3 mt-0">Pasif paylaşımlar</h5>
                    <div class="table-responsive">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Paylaşım Tarihi</th>
                                <th>Görüntülenme Sayısı</th>
                                <th class="w-25"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pasifPaylasimlar as $paylasim)
                                <tr>
                                    <th scope="row">{{$paylasim->id}}</th>
                                    <td>
                                        <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                            <a href="{{$paylasim->imageLink}}" title="">
                                                <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>{{$paylasim->viewCount}}</td>
                                    <td><a href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                           class="card-link text-danger sa-paySil">Sil</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Kalan günlük paylaşım sayısı: {{$store->leftDailyStoryCount}}</p>
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
        @if (session('yorumDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Yorum silinmiştir.',
                type: "success",
            });
        @elseif (session('payPasif'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Paylaşım pasif hale getirilmiştir.',
                type: "success",
            });
        @elseif (session('paySil'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Paylaşım silinmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
