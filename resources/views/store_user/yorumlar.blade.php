@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Yorumlar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            <div class="btn-group mt-2">
                <button type="button"
                        class="btn btn-outline-primary btn-sm dropdown-toggle"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false">Sırala<i
                        class="icon"><span
                            data-feather="chevron-down"></span></i>
                </button>
                <div class="dropdown-menu">
                    <a href="/yoneticipaneli/yorumlar?sort=-created_at" type="button" class="dropdown-item @if(request()->sort == null || request()->sort == '-created_at') text-primary @endif ">Yeniden eskiye</a>
                    <a href="/yoneticipaneli/yorumlar?sort=created_at" type="button" class="dropdown-item @if(request()->sort == 'created_at') text-primary @endif ">Eskiden yeniye</a>
                    <a href="/yoneticipaneli/yorumlar?sort=-points" type="button" class="dropdown-item @if(request()->sort == '-points') text-primary @endif ">Azalan puan</a>
                    <a href="/yoneticipaneli/yorumlar?sort=points" type="button" class="dropdown-item @if(request()->sort == 'points') text-primary @endif ">Artan puan</a>
                    <a href="/yoneticipaneli/yorumlar?sort=likes_count" type="button" class="dropdown-item @if(request()->sort == 'likes_count') text-primary @endif ">En çok beğenilen</a>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            @foreach($yorums->chunk(2) as $yorums2)
                <div class="card-deck mb-4">
                    @foreach($yorums2 as $yorum)
                        <div class="card">
                            <div class="card-body">
                                <div class="media border-bottom">
                                    <img src="{{$yorum->commenter->avatar}}" class="avatar-sm rounded-circle mr-3" height="24" alt="avatar">
                                    <div class="media-body">
                                        <p class="mt-0 mb-0 font-size-15 text-primary">{{$yorum->commenter->name}} {{$yorum->commenter->surname}}</p>
                                        <h6 class="text-muted font-weight-normal mt-0 mb-3">{{\Carbon\Carbon::createFromTimeString($yorum->created_at)->format('d/m/Y H:i')}}</h6>
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
                            </div>
                            <ul class="list-group list-group-flush text-muted">
                                <li class="list-group-item">{{$yorum->likes_count}} kişi beğendi.</li>
                            </ul>
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
                    @if($user->magaza->averagePoint == 0)
                        <p class="card-text text-muted">Ortalama puan: -</p>
                    @else
                        <p class="card-text text-muted">Ortalama puan: {{round($user->magaza->averagePoint,1)}}</p>
                    @endif
                    <p class="card-text text-muted">Yorum sayısı: {{$yorumCount}}</p>
                    <p class="card-text text-muted">Fotoğraf sayısı: {{$fotoCount}}</p>
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
