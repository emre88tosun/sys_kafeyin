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
                    <li class="breadcrumb-item"><a href="#">Başvurular</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yönetici Başvuruları</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Yönetici Başvuruları</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün başvurular</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marka</th>
                            <th>Ad Soyad</th>
                            <th>E-posta</th>
                            <th>Oluşturulma Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <th scope="row">{{$application->id}}</th>
                                <td><a class="text-muted" href="/adminpanel/markalar/{{$application->brand->id}}">#{{$application->brand->id}} - {{$application->brand->name}}</a></td>
                                <td>{{$application->nameSurname}}</td>
                                <td>{{$application->email}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->created_at)->format('d/m/Y H:i')}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">İşlemler <i
                                                class="icon"><span
                                                    data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#descModal{{$application->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$application->id}}"
                                               class="dropdown-item text-primary sa-yBasvuruSil1">Kodu güncelle ve sil</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$application->id}}"
                                               class="dropdown-item text-danger sa-yBasvuruSil2">Kod ile beraber sil</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @foreach($applications as $basvuru)
                <div class="modal fade" id="descModal{{$basvuru->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="descModal{{$basvuru->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="descModal{{$basvuru->id}}">Başvuru detay</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6 class="mb-3">Marka: {{$basvuru->brand->name}}</h6>
                                <p>Ad-soyad: {{$basvuru->nameSurname}}</p>
                                <p>E-posta: {{$basvuru->email}}</p>
                                <p>Şifre: {{$basvuru->password}}</p>
                                <p>Referans: #{{$basvuru->ref->id}} - {{$basvuru->ref->referralCode}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Bugün yapılan başvuru sayısı: {{count($applications->where('created_at','>',\Carbon\Carbon::today()->startOfDay()->toDateTimeString()))}}</p>
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
        @if (session('yBasDel1'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Referans kodu güncellendi ve başvuru silindi.',
            type: "success",
        });
        @elseif(session('yBasDel2'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Referans kodu ve başvuru silindi.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
