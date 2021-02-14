@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Markalar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Markalar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Bütün markalar</h4>
                    <table id="dtCommon" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Ad</th>
                            <th>Plan</th>
                            <th>Yönetici</th>
                            <th>Mağaza Sayısı</th>
                            <th>QR & Sadakat Kartı</th>
                            <th>Gereken Damga Sayısı</th>
                            <th>Admin Notu</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td>{{$brand->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$brand->logo}}">
                                        <a href="{{$brand->logo}}" title="">
                                            <img src="{{$brand->logo}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td><a class="text-muted" href="/adminpanel/markalar/{{$brand->id}}">{{$brand->name}}</a></td>
                                @if($brand->isPremium)
                                    <td><span class="badge badge-soft-success">Premium plan</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Temel plan</span></td>
                                @endif
                                @if($brand->manager)
                                    <td><span class="badge badge-soft-success">Tanımlı</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Tanımsız</span></td>
                                @endif
                                <td>{{$brand->stores_count}}</td>
                                @if($brand->isEnabledLoyaltyCard)
                                    <td><span class="badge badge-soft-success">Aktif</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Pasif</span></td>
                                @endif
                                <td>{{$brand->needStampCount}}</td>
                                <td>{{$brand->adminNote}}</td>
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
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
