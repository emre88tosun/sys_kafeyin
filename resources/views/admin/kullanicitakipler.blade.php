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
                    <li class="breadcrumb-item active" aria-current="page">Takipler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Takipler</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün takipler</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#takipler" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-user-plus"></i></span>
                                <span class="d-none d-sm-block">Takipler</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#takipciler" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-user-check"></i></span>
                                <span class="d-none d-sm-block">Takipçiler</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="takipler">
                            <table id="dtCommon" class="table table-hover dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Kullanıcı</th>
                                    <th>Takip Etme Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($followings as $following)
                                    <tr>
                                        <td>{{$following->id}}</td>
                                        <td>
                                            <div class="popup-gallery" data-source="{{$following->following_user->avatar}}">
                                                <a href="{{$following->following_user->avatar}}" title="">
                                                    <img src="{{$following->following_user->avatar}}" alt="img" class="avatar-sm rounded-circle">
                                                </a>
                                            </div>
                                        </td>
                                        <td><a class="text-muted" href="/adminpanel/kullanicilar/normal/{{$following->following_user->id}}">#{{$following->following_user->id}} - {{$following->following_user->name}} {{$following->following_user->surname}}</a></td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($following->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$following->id}}"
                                               class="card-link text-danger sa-takipSil">Sil</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="takipciler">
                            <table id="dtCommon2" class="table table-hover dt-responsive nowrap " cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th></th>
                                    <th>Kullanıcı</th>
                                    <th>Takip Edilme Tarihi</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($followers as $follower)
                                    <tr>
                                        <td>{{$follower->id}}</td>
                                        <td>
                                            <div class="popup-gallery" data-source="{{$follower->follower_user->avatar}}">
                                                <a href="{{$follower->follower_user->avatar}}" title="">
                                                    <img src="{{$follower->follower_user->avatar}}" alt="img" class="avatar-sm rounded-circle">
                                                </a>
                                            </div>
                                        </td>
                                        <td><a class="text-muted" href="/adminpanel/kullanicilar/normal/{{$follower->follower_user->id}}">#{{$follower->follower_user->id}} - {{$follower->follower_user->name}} {{$follower->follower_user->surname}}</a></td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($follower->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>
                                            <a href="javascript:void(0);" type="button" data-id="{{$follower->id}}"
                                               class="card-link text-danger sa-takipSil">Sil</a>
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
                    <p class="card-text text-muted">Takip sayısı: {{count($followings)}}</p>
                    <p class="card-text text-muted">Takipçi sayısı: {{count($followers)}}</p>
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
        @if (session('followDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Takip silinmiştir.',
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
