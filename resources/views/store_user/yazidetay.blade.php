@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/yazilar">Yazılar</a></li>
                    <li class="breadcrumb-item active" aria-current="page">YAZ{{$yazi->id}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($yazi->isActive)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle">Düzenle</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Pasif haldeki yazınızı düzenleyemezsiniz.">Düzenle</a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-md-4">
                            <div class="popup-gallery mr-2" data-source="{{$yazi->imageLink}}">
                                <a class="pr-2 pt-2" href="{{$yazi->imageLink}}" title="">
                                    <img src="{{$yazi->imageLink}}" alt="img" class="rounded" width=100%>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mt-0">{{$yazi->title}}</h5>
                            <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</p>
                            <hr class="mt-1">
                            <p class="card-text text-muted">{{$yazi->desc}}</p>
                            @if($yazi->hasVideo)
                                <h5 class="mt-4">Video</h5>
                                <hr class="mt-1 mb-0">
                                <div class="embed-responsive embed-responsive-16by9 mt-4 mb-3">
                                    <video src="{{$yazi->videoLink}}" controls controlsList="nodownload" ></video>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    <p>Görüntülenme sayısı: {{$yazi->viewCount}}</p>
                    <hr>
                    <p>Favoriye alınma sayısı: {{$yazi->favorites_count}}</p>
                </div>
            </div>
        </div>
    </div>
    @if($yazi->isActive)
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i data-feather="x-circle"></i>
                </a>
                <h5 class="">Yazı düzenle</h5>
            </div>

            <div class="slimscroll">
                <form id="frmYazDuzenle" enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/yaziguncelle">
                    @csrf
                    <fieldset>
                        <input type="hidden" name="artID" value="YAZ{{$yazi->id}}">
                        <div class="form-group">
                            <label for="title" class="col-md-12 col-form-label">Başlık</label>
                            <div class="col-md-12">
                                <textarea id="title" class="form-control" rows="2" minlength="30" maxlength="90" required name="title" type="text" placeholder="Başlığınız en az 30 ve en fazla 90 karakter olmalıdır.">{{$yazi->title}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-md-12 col-form-label">Yazı</label>
                            <div class="col-md-12">
                                <textarea id="desc" class="form-control" required minlength="1500" rows="20" name="desc" type="text" placeholder="Yazınız en az 1500 karakter olmalıdır.">{{$yazi->desc}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <p class="card-text text-primary col-md-12 font-size-13">*Görseli güncellemek istemiyorsanız lütfen boş bırakınız.</p>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M" data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                            </div>
                        </div>
                        @if($isVideoUploadEnabled)
                            @if($yazi->hasVideo)
                                <div class="form-group">
                                    <label for="video" class="col-md-12 col-form-label">Video</label>
                                    <p class="card-text text-primary col-md-12 font-size-13">*Yazınızı ekledikten sonra videoyu güncelleyemezsiniz.</p>
                                    <div class="col-md-12">
                                        <input type="file" id="video" name="video" data-max-file-size="64M" disabled data-show-loader="true"  data-allowed-file-extensions="mp4" class="dropify"/>
                                    </div>
                                </div>
                            @else
                                @if($user->magaza->brand->isPremium)
                                    <div class="form-group">
                                        <label for="video" class="col-md-12 col-form-label">Video</label>
                                        <p class="card-text text-primary col-md-12 font-size-13">*Yazınızı ekledikten sonra video ekleyemezsiniz.</p>
                                        <div class="col-md-12">
                                            <input type="file" id="video" name="video" data-max-file-size="64M" data-show-loader="true" disabled data-allowed-file-extensions="mp4" class="dropify"/>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="video" class="col-md-12 col-form-label">Video</label>
                                        <div class="col-md-12">
                                            <div class="alert alert-primary ">Markanızı Premium Plan'a taşıyıp, yazılarınızı video ile paylaşabilirsiniz.</div>
                                            <input type="file" id="video" name="video" disabled data-max-file-size="64M" data-show-loader="true"  data-allowed-file-extensions="mp4" class="dropify"/>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endif
                        <div class="col-12">
                            <input type="submit" class="btn btn-primary mb-5" value="Güncelle">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="rightbar-overlay"></div>
    @endif
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script type="text/javascript">
        $('#frmYazDuzenle').submit(function(e){
            $('body').removeClass('right-bar-enabled')
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
    </script>
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('hata')}}",
                type: "error",
            });
        @elseif(session('artUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla güncellendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
