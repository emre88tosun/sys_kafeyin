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
                    <li class="breadcrumb-item active" aria-current="page">Sadakat Kartları</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Sadakat Kartları</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün sadakat kartları</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#aktif" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none">A</span>
                                <span class="d-none d-sm-block">Aktif Kartlar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#kullanilabilir" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none">K1</span>
                                <span class="d-none d-sm-block">Kullanılabilir Kartlar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#kullanilan" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none">K2</span>
                                <span class="d-none d-sm-block">Kullanılan Kartlar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#silinmis" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none">S</span>
                                <span class="d-none d-sm-block">Silinmiş Kartlar</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="aktif">
                            <table id="dtCommon" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marka</th>
                                    <th>Damga</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>En Son Güncellenme Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($activeCards as $activeCard)
                                    <tr>
                                        <td>{{$activeCard->id}}</td>
                                        <td><a class="text-muted" href="/adminpanel/markalar/{{$activeCard->brand->id}}">#{{$activeCard->brand->id}} - {{$activeCard->brand->name}}</a></td>
                                        <td>{{$activeCard->stampCount}} / {{$activeCard->brand->needStampCount}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($activeCard->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($activeCard->updated_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$activeCard->id}}"
                                               class="card-link text-danger sa-kartSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="kullanilabilir">
                            <table id="dtCommon2" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marka</th>
                                    <th>Damga</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>En Son Güncellenme Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($availableCards as $availableCard)
                                    <tr>
                                        <td>{{$availableCard->id}}</td>
                                        <td><a class="text-muted" href="/adminpanel/markalar/{{$availableCard->brand->id}}">#{{$availableCard->brand->id}} - {{$availableCard->brand->name}}</a></td>
                                        <td>{{$availableCard->stampCount}} / {{$availableCard->brand->needStampCount}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($availableCard->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($availableCard->updated_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$availableCard->id}}" class="card-link text-danger sa-kartSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="kullanilan">
                            <table id="dtCommon3" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marka</th>
                                    <th>Damga</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>En Son Güncellenme Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($usedCards as $usedCard)
                                    <tr>
                                        <td>{{$usedCard->id}}</td>
                                        <td><a class="text-muted" href="/adminpanel/markalar/{{$usedCard->brand->id}}">#{{$usedCard->brand->id}} - {{$usedCard->brand->name}}</a></td>
                                        <td>{{$usedCard->stampCount}} / {{$usedCard->brand->needStampCount}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($usedCard->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($usedCard->updated_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$usedCard->id}}"
                                               class="card-link text-danger sa-kartSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="silinmis">
                            <table id="dtCommon4" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Marka</th>
                                    <th>Damga</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>En Son Güncellenme Tarihi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deletedCards as $deletedCard)
                                    <tr>
                                        <td>{{$deletedCard->id}}</td>
                                        <td><a class="text-muted" href="/adminpanel/markalar/{{$deletedCard->brand->id}}">#{{$deletedCard->brand->id}} - {{$deletedCard->brand->name}}</a></td>
                                        <td>{{$deletedCard->stampCount}} / {{$deletedCard->brand->needStampCount}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($deletedCard->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($deletedCard->updated_at)->format('d/m/Y H:i')}}</td>
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
                    <p class="card-text text-muted">Aktif kartı sayısı: {{count($activeCards)}}</p>
                    <p class="card-text text-muted">Kullanılabilir kartı sayısı: {{count($availableCards)}}</p>
                    <p class="card-text text-muted">Kullanılan kartı sayısı: {{count($usedCards)}}</p>
                    <p class="card-text text-muted">Silinmiş kartı sayısı: {{count($deletedCards)}}</p>
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
        @if (session('cardDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Kart silinmiştir.',
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
