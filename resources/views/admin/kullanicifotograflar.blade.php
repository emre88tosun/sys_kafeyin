@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kullanıcılar</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal">Normal Kullanıcılar</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal/{{$user->id}}">#{{$user->id}} - {{$user->name}} {{$user->surname}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fotoğraflar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Fotoğraflar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün fotoğraflar</h5>
                    <div class="row ml-1">
                        @foreach($photos as $foto)
                            <div class="popup-gallery mr-2 mb-2" data-source="{{$foto->imageLink}}">
                                <a class="pr-2 pt-2" href="{{$foto->imageLink}}" title="">
                                    <img src="{{$foto->imageLink}}" alt="img" class="avatar-md rounded">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{$photos->render()}}
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Fotoğraf sayısı: {{count($photos)}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
@endsection

@section('script-bottom')
@endsection
