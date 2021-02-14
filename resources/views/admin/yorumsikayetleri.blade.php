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
                <li class="breadcrumb-item"><a href="#">Diğer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Yorum Şikayetleri</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Yorum Şikayetleri</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            @foreach($sikayets->chunk(2) as $sikayets2)
                <div class="row">
                    @foreach($sikayets2 as $sikayet)
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title font-size-16">Şikayet sahibi</h5>
                                            <div class="media">
                                                <img src="{{$sikayet->user->avatar}}" class="avatar-sm rounded-circle mr-3" height="24" alt="avatar">
                                                <div class="media-body">
                                                    <a href="/adminpanel/kullanicilar/normal/{{$sikayet->user->id}}" class="mt-0 mb-0 font-size-15">#{{$sikayet->user->id}} - {{$sikayet->user->name}} {{$sikayet->user->surname}}</a>
                                                    <h6 class="text-muted font-weight-normal mt-0 mb-3">Oluşturulma tarihi: {{\Carbon\Carbon::createFromTimeString($sikayet->created_at)->format('d/m/Y H:i')}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown align-self-center float-right">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                                               aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu ">
                                                <a href="javascript:void(0);"
                                                   type="button"
                                                   data-id="{{$sikayet->id}}"
                                                   class="dropdown-item text-primary sa-tskMail1">Şikayet sahibine teşekkür e-postası gönder</a>
                                                @if($sikayet->comment)
                                                    <a href="javascript:void(0);"
                                                       type="button"
                                                       data-id="{{$sikayet->id}}"
                                                       class="dropdown-item text-danger sa-yorumSil2">Yorumu sil</a>
                                                @endif
                                                <a href="javascript:void(0);"
                                                   type="button"
                                                   data-id="{{$sikayet->id}}"
                                                   class="dropdown-item text-danger sa-sikayetSil">Şikayeti sil</a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="mt-1 mb-2">
                                    @if($sikayet->comment)
                                        <h5 class="card-title font-size-16">Yorum</h5>
                                        <div class="media">
                                            <img src="{{$sikayet->comment->commenter->avatar}}" class="avatar-sm rounded-circle mr-3" height="24" alt="avatar">
                                            <div class="media-body">
                                                <a href="/adminpanel/kullanicilar/normal/{{$sikayet->comment->commenter->id}}" class="mt-0 mb-0 font-size-15">#{{$sikayet->comment->commenter->id}} - {{$sikayet->comment->commenter->name}} {{$sikayet->comment->commenter->surname}}</a>
                                                <h6 class="text-muted font-weight-normal mt-0 mb-3">{{\Carbon\Carbon::createFromTimeString($sikayet->comment->created_at)->format('d/m/Y H:i')}}</h6>
                                            </div>
                                        </div>
                                        <p class="card-text text-muted mt-1">{{$sikayet->comment->commentText}}</p>
                                        <div class="row ml-1">
                                            @foreach($sikayet->comment->photos as $foto)
                                                <div class="popup-gallery mr-2" data-source="{{$foto->imageLink}}">
                                                    <a class="pr-2 pt-2" href="{{$foto->imageLink}}" title="">
                                                        <img src="{{$foto->imageLink}}" alt="img" class="avatar-md rounded">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                        <p class="card-text text-muted mt-3">Puan: {{$sikayet->comment->commentPoint}} / 10</p>
                                        <p class="card-text text-muted mt-3">Yorum ID: #{{$sikayet->comment->id}}</p>
                                        <ul class="list-group list-group-flush text-muted">
                                            <li class="list-group-item">{{count($sikayet->comment->likes)}} kişi beğendi.</li>
                                        </ul>
                                        <h5 class="card-title font-size-16 mt-3">Yorum yapılan mağaza</h5>
                                        <div class="media">
                                            <img src="{{$sikayet->comment->store->brand->logo}}" class="avatar-sm rounded mr-3" height="24" alt="avatar">
                                            <div class="media-body">
                                                <a href="/adminpanel/magazalar/{{$sikayet->comment->store->id}}" class="mt-0 mb-0 font-size-15">#{{$sikayet->comment->store->id}} - {{$sikayet->comment->store->name}}</a>
                                                <h6 class="text-muted font-weight-normal mt-0 mb-3">{{$sikayet->comment->store->location->name}}, {{$sikayet->comment->store->city->name}}</h6>
                                            </div>
                                        </div>
                                    @else
                                        <p class="card-text text-muted mt-3">Şikayet edilen yorum bulunamadı.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @endforeach
            {{$sikayets->render()}}
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Şikayet sayısı: {{count($sikayets)}}</p>
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
        @if (session('emailSent1'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Şikayet sahibine teşekkür e-postası gönderildi.',
                type: "success",
            });
        @elseif (session('yorumSil2'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Yorum silindi ve sahibine bilgi e-postası gönderildi.',
                type: "success",
            });
        @elseif (session('sikayetDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Şikayet silinmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
