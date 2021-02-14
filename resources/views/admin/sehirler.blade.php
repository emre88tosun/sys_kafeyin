@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Şehirler</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Şehirler</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Aktif şehirler</h4>
                    <table id="dtCommon" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Lokasyon Sayısı</th>
                            <th>Mağaza Sayısı</th>
                            <th>Kullanıcı Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sehirs->where('isActive',true) as $sehir)
                            <tr>
                                <td>{{$sehir->id}}</td>
                                <td><a class="text-muted" href="/adminpanel/sehirler/{{$sehir->id}}">{{$sehir->name}}</a></td>
                                <td>{{$sehir->locations_count}}</td>
                                <td>{{$sehir->stores_count}}</td>
                                <td>{{$sehir->users_count}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Pasif şehirler</h4>
                    <table id="dtCommon2" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Lokasyon Sayısı</th>
                            <th>Mağaza Sayısı</th>
                            <th>Kullanıcı Sayısı</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sehirs->where('isActive',false) as $sehir)
                            <tr>
                                <td>{{$sehir->id}}</td>
                                <td><a class="text-muted" href="/adminpanel/sehirler/{{$sehir->id}}">{{$sehir->name}}</a></td>
                                <td>{{$sehir->locations_count}}</td>
                                <td>{{$sehir->stores_count}}</td>
                                <td>{{$sehir->users_count}}</td>
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
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
