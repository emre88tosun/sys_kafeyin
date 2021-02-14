@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/adminpanel/magazalar">Mağazalar</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/magazalar/{{$store->id}}">#{{$store->id}} - {{$store->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kafeyin Fotoğraflar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Kafeyin Fotoğraflar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="row">
                @foreach($photos as $foto)
                    <div class="col-xl-3 col-md-6">
                        <div class="card mb-4 mb-xl-4">
                            <div class="popup-gallery" data-source="{{$foto->imageLink}}">
                                <a class="pr-2 pt-2" href="{{$foto->imageLink}}" title="">
                                    <img class="card-img-top img-fluid " src="{{$foto->imageLink}}" alt="img">
                                </a>
                            </div>
                            <div class="card-body">
                                <a href="javascript:void(0);" type="button" data-id="{{$foto->id}}" class="card-link text-danger sa-kFotoSil">Fotoğrafı sil</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    @if($yorumCount == 0)
                        <p class="card-text text-muted">Ortalama puan: -</p>
                    @else
                        <p class="card-text text-muted">Ortalama puan: {{round(($totalPuan/$yorumCount),1)}}</p>
                    @endif
                    <p class="card-text text-muted">Yorum sayısı: {{$yorumCount}}</p>
                    <p class="card-text text-muted">Fotoğraf sayısı: {{$fotoCount}}</p>
                    <hr>
                    <h5 class="card-title font-size-16">İşlemler</h5>
                    <div class="table-responsive table-hover mt-2">
                        <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#kFotoEkleModal" class="card-link text-primary">Fotoğraf ekle</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="kFotoEkleModal" tabindex="-1" role="dialog"
             aria-labelledby="kFotoEkleModal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="kFotoEkleModal">Kafeyin fotoğraf ekle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" method="post" action="/adminpanel/kfotoekle">
                            @csrf
                            <fieldset>
                                <input type="hidden" name="storeID" value="{{$store->id}}">
                                <div class="form-group">
                                    <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                                <input class="btn btn-primary mt-0 mb-4" type="submit" value="Ekle">
                            </fieldset>
                        </form>
                    </div>
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
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        @if (session('kFotoDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Fotoğraf silinmiştir.',
                type: "success",
            });
        @elseif(session('fileErr'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz dosya ile ilgili bir problem oluştu.',
                type: "warning",
            });
        @elseif(session('kFotoUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Fotoğraf eklenmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
