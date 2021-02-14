@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Admin Kullanıcılar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Admin Kullanıcılar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Bütün Admin kullanıcılar</h4>
                    <table id="dtCommon5" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad-Soyad</th>
                            <th>E-posta</th>
                            <th>Üyelik Tarihi</th>
                            <th>Onay Tarihi</th>
                            <th>Son Giriş Tarihi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td><a class="text-muted" href="/adminpanel/kullanicilar/admin/{{$user->id}}">{{$user->name}} {{$user->surname}}</a></td>
                                <td>{{$user->email}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($user->created_at)->format('d/m/Y H:i')}}</td>
                                @if($user->email_verified_at)
                                    <td>{{\Carbon\Carbon::createFromTimeString($user->email_verified_at)->format('d/m/Y H:i')}}</td>
                                @else
                                    <td></td>
                                @endif
                                @if($user->lastLogin)
                                    <td>{{\Carbon\Carbon::createFromTimeString($user->lastLogin)->format('d/m/Y H:i')}}</td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script>
        @if(session('userDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Kullanıcı silinmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
