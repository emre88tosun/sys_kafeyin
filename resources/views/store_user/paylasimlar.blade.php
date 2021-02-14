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
                    <li class="breadcrumb-item active" aria-current="page">Paylaşımlar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($canAddStory)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle" >Paylaşım Ekle</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Bu özellik kısa süreliğine devre dışı bırakıldı." >Paylaşım Ekle</a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif paylaşımlar</h5>
                    <table id="tblActSto" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th></th>
                            <th>Paylaşım Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktifPaylasims as $paylasim)
                            <tr>
                                <td></td>
                                <td>PAY{{$paylasim->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                        <a href="{{$paylasim->imageLink}}" title="">
                                            <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$paylasim->viewCount}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                               class="dropdown-item text-dark sa-stoPayPasif">Pasifize et</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                               class="dropdown-item text-danger sa-stoPaySil">Sil</a>

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
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Pasif paylaşımlar</h5>
                    <table id="tblPasSto" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th></th>
                            <th>Paylaşım Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasifPaylasims as $paylasim)
                            <tr>
                                <td></td>
                                <td>PAY{{$paylasim->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$paylasim->imageLink}}">
                                        <a href="{{$paylasim->imageLink}}" title="">
                                            <img src="{{$paylasim->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{\Carbon\Carbon::createFromTimeString($paylasim->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$paylasim->viewCount}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="javascript:void(0);" type="button" data-id="{{$paylasim->id}}"
                                               class="dropdown-item text-danger sa-stoPaySil">Sil</a>

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
                    @if($isPremiumEnabled)
                        @if($user->magaza->brand->isPremium)
                            <p class="card-text text-muted">Kalan günlük paylaşım sayınız: <text class="text-success">Sınırsız</text> </p>
                        @else
                            <p class="card-text text-muted">Kalan günlük paylaşım sayınız: {{$user->magaza->leftDailyStoryCount}}</p>
                        @endif
                    @else
                        <p class="card-text text-muted">Kalan günlük paylaşım sayınız: {{$user->magaza->leftDailyStoryCount}}</p>
                    @endif
                    <hr>
                    <p class="font-weight-bold">Paylaşımlarınız, paylaşıldıktan 24 saat sonra otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold">Yeni ürün duyuruları, kampanya duyuruları veya özgün içerikleriniz ile kahveseverlerin mağazanıza ve markanıza olan ilgisini arttırabilirsiniz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki paylaşımları, daha önceden duyurmak suretiyle sistemlerimizden kaldırabiliriz.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i data-feather="x-circle"></i>
            </a>
            <h5 class="">Paylaşım ekle</h5>
        </div>
        @if($isPremiumEnabled)
            @if($user->magaza->brand->isPremium)
                <form enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/payekle">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                            </div>
                        </div>
                        <div class="offset-md-0">
                            <input type="submit" class="btn btn-primary ml-3" value="Ekle">
                        </div>
                    </fieldset>
                </form>
            @else
                @if($user->magaza->leftDailyStoryCount == 0)
                    <div class="alert alert-danger ml-4 mr-4">Günlük paylaşım hakkınız kalmadığı için yeni bir paylaşım ekleyemezsiniz.</div>
                    <div class="alert alert-primary ml-4 mr-4">Markanızı Premium Plan'a taşıyıp gün içerisinde istediğiniz kadar paylaşım ekleyebilirsiniz.</div>
                @else
                    <form enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/payekle">
                        @csrf
                        <fieldset>
                            <div class="form-group">
                                <label for="image" class="col-md-12 col-form-label">Görsel</label>
                                <div class="col-md-12">
                                    <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                            </div>
                            <div class="offset-md-0">
                                <input type="submit" class="btn btn-primary ml-3" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                @endif
            @endif
        @else
            @if($user->magaza->leftDailyStoryCount == 0)
                <div class="alert alert-danger ml-4 mr-4">Günlük paylaşım hakkınız kalmadığı için yeni bir paylaşım ekleyemezsiniz.</div>
            @else
                <form enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/payekle">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                            </div>
                        </div>
                        <div class="offset-md-0">
                            <input type="submit" class="btn btn-primary ml-3" value="Ekle">
                        </div>
                    </fieldset>
                </form>
            @endif
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
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('paylasim')}}",
                type: "error",
            });
        @elseif(session('stoDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Paylaşımınız başarıyla silindi.",
                type: "success",
            });
        @elseif(session('stoPas'))
            swal.fire({
                title: 'Başarılı!',
                text: "Paylaşımınız başarıyla pasif hale getirildi.",
                type: "success",
            });
        @elseif(session('multiStoDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Seçtiğiniz paylaşımlar başarıyla silindi.",
                type: "success",
            });
        @elseif(session('stoAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "Paylaşımınız başarıyla eklendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
