@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Kullanıcılar</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal">Normal Kullanıcılar</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal/{{$user->id}}">#{{$user->id}} - {{$user->name}} {{$user->surname}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Favoriler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Favoriler</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün favoriler</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#yazilar" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-pen"></i></span>
                                <span class="d-none d-sm-block">Favori yazılar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#etkinlikler" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-calendar-alt"></i></span>
                                <span class="d-none d-sm-block">Favori etkinlikler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#magazalar" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-store-alt"></i></span>
                                <span class="d-none d-sm-block">Favori mağazalar</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="yazilar">
                            <table id="dtCommon" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Fav. ID</th>
                                    <th></th>
                                    <th>Yazı</th>
                                    <th>Aktiflik</th>
                                    <th>Mağaza Adı</th>
                                    <th>Fav. Alınma Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($favArticles as $favYazi)
                                    <tr>
                                        <td>{{$favYazi->id}}</td>
                                        <td>
                                            <div class="popup-gallery" data-source="{{$favYazi->article->imageLink}}">
                                                <a href="{{$favYazi->article->imageLink}}" title="">
                                                    <img src="{{$favYazi->article->imageLink}}" alt="img" class="avatar-md rounded">
                                                </a>
                                            </div>
                                        </td>
                                        <td>#{{$favYazi->article->id}} - {{$favYazi->article->title}}</td>
                                        @if($favYazi->article->isActive)
                                            <td><span
                                                    class="badge badge-soft-success">Aktif</span>
                                            </td>
                                        @else
                                            <td><span
                                                    class="badge badge-soft-danger">Pasif</span>
                                            </td>
                                        @endif
                                        <td><a class="text-muted" href="/adminpanel/magazalar/{{$favYazi->article->store->id}}">#{{$favYazi->article->store->id}} - {{$favYazi->article->store->name}}</a></td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($favYazi->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$favYazi->id}}"
                                               class="card-link text-danger sa-favArtSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="etkinlikler">
                            <table id="dtCommon2" class="table table-hover dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Fav. ID</th>
                                    <th></th>
                                    <th>Etkinlik</th>
                                    <th>Aktiflik</th>
                                    <th>Mağaza Adı</th>
                                    <th>Fav. Alınma Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($favActivities as $favEtk)
                                    <tr>
                                        <td>{{$favEtk->id}}</td>
                                        <td>
                                            <div class="popup-gallery" data-source="{{$favEtk->activity->imageLink}}">
                                                <a href="{{$favEtk->activity->imageLink}}" title="">
                                                    <img src="{{$favEtk->activity->imageLink}}" alt="img" class="avatar-md rounded">
                                                </a>
                                            </div>
                                        </td>
                                        <td>#{{$favEtk->activity->id}} - {{$favEtk->activity->title}}</td>
                                        @if($favEtk->activity->isActive)
                                            <td><span
                                                    class="badge badge-soft-success">Aktif</span>
                                            </td>
                                        @else
                                            <td><span
                                                    class="badge badge-soft-danger">Pasif</span>
                                            </td>
                                        @endif
                                        <td><a class="text-muted" href="/adminpanel/magazalar/{{$favEtk->activity->store->id}}">#{{$favEtk->activity->store->id}} - {{$favEtk->activity->store->name}}</a></td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($favEtk->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$favEtk->id}}"
                                               class="card-link text-danger sa-favActSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="magazalar">
                            <table id="dtCommon3" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>Fav. ID</th>
                                    <th></th>
                                    <th>Mağaza Adı</th>
                                    <th>Fav. Alınma Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($favStores as $favSto)
                                    <tr>
                                        <td>{{$favSto->id}}</td>
                                        <td>
                                            <div class="popup-gallery" data-source="{{$favSto->store->brand->logo}}">
                                                <a href="{{$favSto->store->brand->logo}}" title="">
                                                    <img src="{{$favSto->store->brand->logo}}" alt="img" class="avatar-md rounded">
                                                </a>
                                            </div>
                                        </td>
                                        <td><a class="text-muted" href="/adminpanel/magazalar/{{$favSto->store->id}}">#{{$favSto->store->id}} - {{$favSto->store->name}}</a></td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($favSto->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$favSto->id}}"
                                               class="card-link text-danger sa-favStoSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Favori yazı sayısı: {{count($favArticles)}}</p>
                    <p class="card-text text-muted">Favori etkinlik sayısı: {{count($favActivities)}}</p>
                    <p class="card-text text-muted">Favori mağaza sayısı: {{count($favStores)}}</p>
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
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script>
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        } );
        @if (session('favArtDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Favori yazı silinmiştir.',
            type: "success",
        });
        @elseif(session('favActDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Favori etkinlik silinmiştir.',
            type: "success",
        });
        @elseif(session('favStoDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Favori mağaza silinmiştir.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
