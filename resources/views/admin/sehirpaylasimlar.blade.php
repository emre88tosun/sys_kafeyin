@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler/{{$city->id}}">#{{$city->id}}
                            - {{$city->name}}</a></li>
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
                    <table id="dtCommon" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Mağaza Adı</th>
                            <th>Paylaşım Tarihi</th>
                            <th>Görüntülenme</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paylasims->where('isActive',true) as $paylasim)
                            <tr>
                                <td>{{$paylasim->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                        <a href="{{$paylasim->imageLink}}" title="">
                                            <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>#{{$paylasim->store->id}} - {{$paylasim->store->name}}</td>
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
                    <h5 class="header-title mb-3 mt-4">Pasif paylaşımlar</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Mağaza Adı</th>
                            <th>Paylaşım Tarihi</th>
                            <th>Görüntülenme</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paylasims->where('isActive',false) as $paylasim)
                            <tr>
                                <td>{{$paylasim->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                        <a href="{{$paylasim->imageLink}}" title="">
                                            <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>#{{$paylasim->store->id}} - {{$paylasim->store->name}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$paylasim->viewCount}}</td>
                                <td><a
                                        href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                        class="card-link text-danger sa-paySil">Sil</a></td>
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
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Aktif paylaşım
                        sayısı: {{count($paylasims->where('isActive',true))}}</p>
                    <p class="card-text text-muted">Pasif paylaşım
                        sayısı: {{count($paylasims->where('isActive',false))}}</p>
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
    <script>
        @if (session('yorumDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Yorum silinmiştir.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
