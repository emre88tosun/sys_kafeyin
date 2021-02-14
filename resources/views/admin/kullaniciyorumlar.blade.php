@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Kullanıcılar</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal">Normal Kullanıcılar</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/kullanicilar/normal/{{$user->id}}">#{{$user->id}} - {{$user->name}} {{$user->surname}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Yorumlar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Yorumlar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            @foreach($yorums->chunk(2) as $yorums2)
                <div class="row">
                    @foreach($yorums2 as $yorum)
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media border-bottom">
                                        <img src="{{$yorum->store->brand->logo}}" class="avatar-sm rounded mr-3" height="24" alt="avatar">
                                        <div class="media-body">
                                            <a href="/adminpanel/magazalar/{{$yorum->store->id}}" class="mt-0 mb-0 font-size-15">#{{$yorum->store->id}} - {{$yorum->store->name}}</a>
                                            <h6 class="text-muted font-weight-normal mt-0 mb-3">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($yorum->created_at)->format('d/m/Y H:i')}}</h6>
                                        </div>
                                    </div>
                                    <p class="card-text text-muted mt-3">{{$yorum->commentText}}</p>
                                    <div class="row ml-1">
                                        @foreach($yorum->photos as $foto)
                                            <div class="popup-gallery mr-2" data-source="{{$foto->imageLink}}">
                                                <a class="pr-2 pt-2" href="{{$foto->imageLink}}" title="">
                                                    <img src="{{$foto->imageLink}}" alt="img" class="avatar-md rounded">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>

                                    <p class="card-text text-muted mt-3">Puan: {{$yorum->commentPoint}} / 10</p>
                                    <p class="card-text text-muted  mt-3">Yorum ID: #{{$yorum->id}}</p>
                                </div>
                                <ul class="list-group list-group-flush text-muted">
                                    <li class="list-group-item">{{$yorum->likes_count}} kişi beğendi.</li>
                                </ul>
                                <div class="card-body">
                                    <a href="javascript:void(0);" type="button" data-id="{{$yorum->id}}" class="card-link text-danger sa-yorumSil">Yorumu Sil</a>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @endforeach
            {{$yorums->render()}}
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Yorum sayısı: {{count($yorums)}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script>
        @if (session('yorumDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Yorum silinmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
