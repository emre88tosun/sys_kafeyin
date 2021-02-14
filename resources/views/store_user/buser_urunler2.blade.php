@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item disabled">Mağazalar</li>
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}">{{$store->name}} (ID: KFYN{{$store->id}})</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ürünler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            @foreach($kategoris->chunk(6) as $fourKategoris)
                <div class="row">
                    @foreach($fourKategoris as $kategori)
                        <div class="col-xl-2">
                            <a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}/urunler/{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII',str_replace(' ', '', $kategori->desc)))}}">
                                <div class="card shadow bg-primary">
                                    <div class="card-body">
                                        <h6 class="card-title mt-0 mb-0 font-size-16 text-light">{{$kategori->desc}}</h6>
                                    </div>
                                    <ul class="list-group list-group-flush text-light mt-0 ">
                                        <li class="list-group-item bg-primary">{{count($kategori->subcategories)}} alt kategori</li>
                                        <li class="list-group-item bg-primary">{{$uruns->where('categoryID',$kategori->id)->count()}} ürün</li>
                                        @if($kategori->canGenerateQrCode)
                                            <li class="list-group-item bg-primary text-light font-weight-bold">QR kod oluşturulabilir</li>
                                        @else
                                            <li class="list-group-item text-light bg-primary">QR kod oluşturulamaz</li>
                                        @endif
                                    </ul>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
