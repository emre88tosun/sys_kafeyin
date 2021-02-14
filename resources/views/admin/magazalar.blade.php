@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Mağazalar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Mağazalar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Bütün mağazalar</h4>
                    <table id="dtCommon" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ad</th>
                            <th>Şehir</th>
                            <th>Lokasyon</th>
                            <th>Ort. Puan</th>
                            <th>Yorum Sayısı</th>
                            <th>Fotoğraf Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th>Plan</th>
                            <th>Yönetici</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stores as $store)
                            <tr>
                                <td>{{$store->id}}</td>
                                <td><a class="text-muted" href="/adminpanel/magazalar/{{$store->id}}">{{$store->name}}</a></td>
                                <td>{{$store->city->name}}</td>
                                <td>{{$store->location->name}}</td>
                                @if($store->averagePoint == 0)
                                    <td>-</td>
                                @else
                                    <td>{{number_format($store->averagePoint,2)}}</td>
                                @endif
                                <td>{{$store->comments_count}}</td>
                                <td>{{$store->photos_count}}</td>
                                <td>{{$store->favorites_count}}</td>
                                @if($store->brand->isPremium)
                                    <td><span class="badge badge-soft-success">Premium plan</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Temel plan</span></td>
                                @endif
                                @if($store->yonetici)
                                    <td><span class="badge badge-soft-success">Tanımlı</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Tanımsız</span></td>
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
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
