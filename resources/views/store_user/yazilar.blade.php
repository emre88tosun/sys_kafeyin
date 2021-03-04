@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Yazılar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($canPublishArticle)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle" >Yazı Ekle</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Bu özellik kısa süreliğine devre dışı bırakıldı." >Yazı Ekle</a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif yazılar</h5>
                    <table id="tblActArt" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktifYazis as $yazi)
                            <tr>
                                <td></td>
                                <td>YAZ{{$yazi->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$yazi->imageLink}}">
                                        <a href="{{$yazi->imageLink}}" title="">
                                            <img src="{{$yazi->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$yazi->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$yazi->viewCount}}</td>
                                <td>{{$yazi->favorites_count}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="/yoneticipaneli/yazilar/YAZ{{$yazi->id}}" type="button"
                                               class="dropdown-item text-dark">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$yazi->id}}"
                                               class="dropdown-item text-dark sa-stoArtPasif">Pasifize et</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$yazi->id}}"
                                               class="dropdown-item text-danger sa-stoArtSil">Sil</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Pasif yazılar</h5>
                    <table id="tblPasArt" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasifYazis as $yazi)
                            <tr>
                                <td></td>
                                <td>YAZ{{$yazi->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$yazi->imageLink}}">
                                        <a href="{{$yazi->imageLink}}" title="">
                                            <img src="{{$yazi->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$yazi->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$yazi->viewCount}}</td>
                                <td>{{$yazi->favorites_count}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="/yoneticipaneli/yazilar/YAZ{{$yazi->id}}" type="button"
                                               class="dropdown-item text-dark">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$yazi->id}}"
                                               class="dropdown-item text-danger sa-stoArtSil">Sil</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    @if(count($aktifYazis) > 1)
                        <p class="card-text text-muted">Ekleyebileceğiniz yazı sayısı: 0</p>
                    @else
                        <p class="card-text text-muted">Ekleyebileceğiniz yazı sayısı: {{2-(count($aktifYazis))}}</p>
                    @endif
                    <hr>
                    <p class="font-weight-bold">Çekirdek halinden bardaklarımıza gelene kadar uzun bir yola sahip olan kahve ile ilgili üreteceğiniz özgün içerikler, kahveseverlerin mağazanıza ve markanıza olan ilgisini arttıracaktır.</p>
                    <hr>
                    <p class="font-weight-bold">Yazılarınız, eklendikten 7 gün sonra otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki yazıları, daha önceden duyurmak suretiyle sistemlerimizden kaldırabiliriz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan yazıları, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i data-feather="x-circle"></i>
            </a>
            <h5 class="">Yazı ekle</h5>
        </div>
        @if(count($aktifYazis) > 1)
            <div class="alert alert-danger ml-4 mr-4">Maksimum sayıda aktif yazınız olduğu için yeni bir yazı ekleyemezsiniz.</div>
        @else
            <div class="slimscroll">
                <form id="frmYazEkle" enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/yaziekle">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="title" class="col-md-12 col-form-label">Başlık</label>
                            <div class="col-md-12">
                                <textarea id="title" class="form-control" rows="2" minlength="30" maxlength="90" required name="title" type="text" placeholder="Başlığınız en az 30 ve en fazla 90 karakter olmalıdır."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-md-12 col-form-label">Yazı</label>
                            <div class="col-md-12">
                                <textarea id="desc" class="form-control" required minlength="1500" rows="20" name="desc" type="text" placeholder="Yazınız en az 1500 karakter olmalıdır."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                            </div>
                        </div>
                        @if($isVideoUploadEnabled)
                            @if($user->magaza->brand->isPremium)
                                <div class="form-group">
                                    <label for="video" class="col-md-12 col-form-label">Video</label>
                                    <p class="card-text text-primary col-md-12 font-size-13">*Yazınıza video eklemek istemiyorsanız boş bırakabilirsiniz.</p>
                                    <div class="col-md-12">
                                        <input type="file" id="video" name="video" data-max-file-size="64M" data-show-loader="true"  data-allowed-file-extensions="mp4" class="dropify"/>
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
                        <div class="offset-md-0">
                            <input type="submit" class="btn btn-primary ml-3 mb-5" value="Ekle">
                        </div>
                    </fieldset>
                </form>
            </div>
        @endif
    </div>
    <div class="rightbar-overlay"></div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );
        });
    </script>
    <script type="text/javascript">
        $('#frmYazEkle').submit(function(e){
            $('body').removeClass('right-bar-enabled')
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
    </script>
    <script type="text/javascript">
        function checkForm(event){
            var video = document.getElementById("video").value;
            if(video != ""){
                $('body').removeClass('right-bar-enabled');
                swal.fire({
                    type: 'info',
                    title: "Video yükleniyor",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                });
            }
        }
    </script>
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('yazi')}}",
                type: "error",
            });
        @elseif(session('artDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla silindi.",
                type: "success",
            });
        @elseif(session('artPas'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla pasif hale getirildi.",
                type: "success",
            });
        @elseif(session('multiArtDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Seçtiğiniz yazılar başarıyla silindi.",
                type: "success",
            });
        @elseif(session('artAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yazınız başarıyla eklendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
