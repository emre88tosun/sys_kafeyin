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
                <li class="breadcrumb-item active" aria-current="page">Mağaza Önerileri</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Mağaza Önerileri</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            @foreach($oneris->chunk(2) as $oneris2)
                <div class="row">
                    @foreach($oneris2 as $oneri)
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="card-title font-size-16">Öneren</h5>
                                            <div class="media">
                                                <img src="{{$oneri->user->avatar}}" class="avatar-sm rounded-circle mr-3" height="24" alt="avatar">
                                                <div class="media-body">
                                                    <a href="/adminpanel/kullanicilar/normal/{{$oneri->user->id}}" class="mt-0 mb-0 font-size-15">#{{$oneri->user->id}} - {{$oneri->user->name}} {{$oneri->user->surname}}</a>
                                                    <h6 class="text-muted font-weight-normal mt-0 mb-3">Oluşturulma tarihi: {{\Carbon\Carbon::createFromTimeString($oneri->created_at)->format('d/m/Y H:i')}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="dropdown align-self-center float-right">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                                               aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu ">
                                                @if(!$oneri->isRead)
                                                    <a href="javascript:void(0);"
                                                       type="button"
                                                       data-id="{{$oneri->id}}"
                                                       class="dropdown-item text-primary sa-oneriOkundu">Okundu olarak işaretle</a>
                                                @endif
                                                <a href="javascript:void(0);"
                                                   type="button"
                                                   data-id="{{$oneri->id}}"
                                                   class="dropdown-item text-danger sa-oneriSil">Öneriyi sil</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if($oneri->isRead)
                                        <span class="badge badge-soft-success">Okundu</span>
                                    @else
                                        <span class="badge badge-primary">Okunmadı</span>
                                    @endif
                                    <hr>
                                    <h5 class="card-title font-size-16">Önerilen mekanın;</h5>
                                    <p class="card-text text-muted">Adı: {{$oneri->storeName}}</p>
                                    <p class="card-text text-muted">Lokasyonu: {{$oneri->storeLocation}}</p>
                                    <p class="card-text text-muted">Şehri: {{$oneri->storeCity}}</p>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @endforeach
            {{$oneris->render()}}
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Okunmamış öneri sayısı: {{count($oneris->where('isRead',false))}}</p>
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
        @if (session('oneriRead'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Öneri okundu olarak güncellendi.',
                type: "success",
            });
        @elseif (session('oneriDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Öneri silindi.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
