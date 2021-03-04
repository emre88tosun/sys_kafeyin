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
                    <li class="breadcrumb-item disabled">Başvuru</li>
                    <li class="breadcrumb-item active" aria-current="page">Duyuru Başvuruları</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>
            @if($isAnnouncementApplicationEnabled)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle" >Yeni başvuru</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Bu özellik kısa süreliğine devre dışı bırakıldı." >Yeni başvuru</a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="row">
                @foreach($ogBasvurus as $item)
                    <div class="col-xl-6">
                        <div class="card">

                            <div class="card-body">
                                <div class="align-items-center d-flex justify-content-between">
                                    <h5 class="header-title">#DYRBSV{{\App\Models\KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value + $item->id}}</h5>
                                    <div class="row align-items-center">
                                        @if($item->status == 'need_approval')
                                            <span class="badge badge-soft-primary">Onay bekleniyor</span>
                                        @elseif($item->status == "need_update")
                                            <span class="badge badge-primary">Güncelleme bekleniyor</span>
                                        @endif
                                        <div class="btn-group ml-3">
                                            <button type="button"
                                                    class="btn btn-light btn-xs dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="javascript:void(0);" type="button" data-id="{{$item->id}}"
                                                   class="dropdown-item text-danger sa-cancelDBasvuru">Başvuruyu iptal et</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-gallery mt-2" data-source="{{$item->imageLink}}">
                                    <img src="{{$item->imageLink}}" alt="img" class="rounded" width=100%>
                                </div>
                                <h6 class=" mb-0">{{$item->title}}</h6>
                                <small class="mt-0">Başvuru tarihi: {{\Carbon\Carbon::createFromTimeString($item->created_at)->format('d/m/Y H:i')}}</small>
                                <hr class="mt-2 mb-3">
                                <p>{{$item->desc}}</p>
                                @if($item->status == "need_update")
                                    <hr class="mt-2 mb-3">
                                    <small class="mt-0">Güncelleme tarihi: {{\Carbon\Carbon::createFromTimeString($item->updated_at)->format('d/m/Y H:i')}}</small>
                                    <p class="font-weight-bold text-primary mb-0">Sistem mesajı: <text class="font-weight-bold text-muted">{{$item->adminMessage}}</text></p>
                                    <a type="button" href="javascript:void(0);" class="btn btn-primary btn-sm mt-1" data-toggle="modal" data-target="#guncelleModal{{$item->id}}">Başvuru güncelle</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Sonuçlanan başvurular</h5>
                    <table id="tblFBasvurus" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Duyuru Başlığı</th>
                            <th>Başvuru Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fBasvurus as $item)
                            <tr>
                                <td>DYRBSV{{\App\Models\KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value + $item->id}}</td>
                                @if($item->status == "rejected")
                                    <td><span class="badge badge-soft-danger">Reddedildi</span></td>
                                @elseif($item->status == "approved")
                                    <td>
                                        <span class="badge badge-soft-success">Onaylandı</span></td>
                                @endif
                                <td>{{$item->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($item->created_at)->format('d/m/Y')}}</td>
                                <td>
                                    <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#duyuruModal{{$item->id}}">Detay</a>
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
                    <p class="font-weight-bold">Başvuru sürecini olabildiğince kısa tutmak için; duyuru görselinin gereken özelliklere sahip olduğundan, duyuru başlığı ve detayının imla - noktalama kurallarına uygun olduğundan emin olunuz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Kafeyin tarafından güncellenmesi istenen başvurular, güncelleme yapılmadığı takdirde zaman aşımından dolayı reddedilecektir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Sonuçlanan başvuruları, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
        </div>
    </div>
    @foreach($fBasvurus as $item)
        <div class="modal fade" id="duyuruModal{{$item->id}}" tabindex="-1" role="dialog"
             aria-labelledby="duyuruModal{{$item->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="duyuruModal{{$item->id}}">DYRBSV{{\App\Models\KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value + $item->id}} - Detay</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xl-12">
                            <div class="popup-gallery" data-source="{{$item->imageLink}}">
                                <img src="{{$item->imageLink}}" alt="img" class="rounded" width=100%>
                            </div>
                            @if($item->status == "rejected")
                                <div class="alert alert-danger mt-2 mb-2">Red sebebi: {{$item->adminMessage}}</div>
                            @elseif($item->status == "approved")
                                <div class="alert alert-success mt-2 mb-2">Onay bilgisi: {{$item->adminMessage}}</div>
                            @endif
                            <h6 class=" mb-0">{{$item->title}}</h6>
                            <small class="mt-0">Başvuru tarihi: {{\Carbon\Carbon::createFromTimeString($item->created_at)->format('d/m/Y')}}</small>
                            <hr class="mt-2 mb-3">
                            <p>{{$item->desc}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($ogBasvurus->where('status','need_update') as $item)
        <div class="modal fade" id="guncelleModal{{$item->id}}" tabindex="-1" role="dialog"
             aria-labelledby="guncelleModal{{$item->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="guncelleModal{{$item->id}}">DYRBSV{{\App\Models\KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value + $item->id}} - Güncelle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frmDBas"  method="post" enctype="multipart/form-data"
                               action="/yoneticipaneli/dbasvuruguncelle">
                            @csrf
                            <fieldset>
                                <input type="hidden" name="dbID" value="DYRBSV{{\App\Models\KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value + $item->id}}">
                                <div class="form-group row">
                                    <label for="title"
                                           class="col-md-2 col-form-label">Başlık</label>
                                    <div class="col-md-10">
                                        <input type="text" name="title" required
                                               class="form-control" id="title"
                                               placeholder="Başlık" minlength="20" maxlength="90" value="{{$item->title}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="desc" class="col-md-2 col-form-label">Detay</label>
                                    <div class="col-md-10">
                                                    <textarea type="text" name="desc" rows="12" class="form-control"
                                                              id="desc" minlength="300" maxlength="1000"
                                                              required placeholder="Detay">{{$item->desc}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lImage" class="col-md-2 col-form-label">Görsel</label>
                                    <div class="col-md-10">
                                        <input type="file" id="lImage" name="image" data-max-file-size="1M"
                                               data-show-loader="true" data-allowed-formats="landscape"
                                               data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                    </div>
                                </div>
                                <div class="offset-md-2">
                                    <input type="submit" class="btn btn-primary ml-1" value="Güncelle">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i data-feather="x-circle"></i>
            </a>
            <h5 class="">Yeni başvuru</h5>
        </div>
        @if($isPremiumPlanEnabled)
            @if($user->brand->isPremium)
                @if(count($ogBasvurus) > 0)
                    <div class="alert alert-danger ml-4 mr-4">Halihazırda devam eden bir başvurunuz olduğu için yenisini ekleyemezsiniz.</div>
                @elseif(\App\Models\AnnouncementApplication::where('brandID',$user->brand->id)->where('updated_at','>=',\Carbon\Carbon::today()->endOfDay()->subDays(5))->count() > 0)
                    <div class="alert alert-danger ml-4 mr-4">Son 5 gün içerisinde değerlendirilmiş bir başvurunuz bulunduğu için yenisini ekleyemezsiniz.</div>
                @else
                    <div class="slimscroll">
                        <form id="frmDBas" enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/dbasvuruekle">
                            @csrf
                            <fieldset>
                                <div class="form-group">
                                    <label for="title" class="col-md-12 col-form-label">Başlık</label>
                                    <div class="col-md-12">
                                        <textarea id="title" class="form-control"  rows="2" minlength="20" maxlength="90" required name="title" type="text" placeholder="Başlığınız en az 20 ve en fazla 90 karakter olmalıdır."></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="desc" class="col-md-12 col-form-label">Detay</label>
                                    <div class="col-md-12">
                                        <textarea id="desc" class="form-control" required minlength="300" maxlength="1500" rows="16" name="desc" type="text" placeholder="Detay en az 300 ve en fazla 1500 karakter olmalıdır."></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lImage2" class="col-md-12 col-form-label">Görsel</label>
                                    <div class="col-md-12">
                                        <input type="file" id="lImage2" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="landscape" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                    </div>
                                </div>
                                <div class="offset-md-0">
                                    <input type="submit" class="btn btn-primary ml-3 mb-5" value="Gönder">
                                </div>
                            </fieldset>
                        </form>
                    </div>
                @endif
            @else
                <div class="alert alert-danger ml-4 mr-4">Markanızı Premium Plan'a taşıyıp duyuru başvurusu yapabilirsiniz.</div>
            @endif
        @else
            @if(count($ogBasvurus) > 0)
                <div class="alert alert-danger ml-4 mr-4">Halihazırda devam eden bir başvurunuz olduğu için yenisini ekleyemezsiniz.</div>
            @elseif(\App\Models\AnnouncementApplication::where('brandID',$user->brand->id)->where('updated_at','>=',\Carbon\Carbon::today()->endOfDay()->subDays(5))->count() > 0)
                <div class="alert alert-danger ml-4 mr-4">Son 5 gün içerisinde değerlendirilmiş bir başvurunuz bulunduğu için yenisini ekleyemezsiniz.</div>
            @else
                <div class="slimscroll">
                    <form id="frmDBas" enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/dbasvuruekle">
                        @csrf
                        <fieldset>
                            <div class="form-group">
                                <label for="title" class="col-md-12 col-form-label">Başlık</label>
                                <div class="col-md-12">
                                    <textarea id="title" class="form-control"  rows="2" minlength="20" maxlength="90" required name="title" type="text" placeholder="Başlığınız en az 20 ve en fazla 90 karakter olmalıdır."></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="desc" class="col-md-12 col-form-label">Detay</label>
                                <div class="col-md-12">
                                    <textarea id="desc" class="form-control" required minlength="300" maxlength="1500" rows="16" name="desc" type="text" placeholder="Detay en az 300 ve en fazla 1500 karakter olmalıdır."></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lImage2" class="col-md-12 col-form-label">Görsel</label>
                                <div class="col-md-12">
                                    <input type="file" id="lImage2" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="landscape" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                            </div>
                            <div class="offset-md-0">
                                <input type="submit" class="btn btn-primary ml-3 mb-5" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
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
            $.fn.dataTable.moment( 'DD/MM/YYYY' );
        });
    </script>
    <script type="text/javascript">
        $('#frmDBas').submit(function(e){
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
        @elseif(session('applUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Duyuru başvurunuz başarıyla güncellendi.",
                type: "success",
            });
        @elseif(session('dBasDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Başvurunuz başarıyla iptal edilmiştir.",
                type: "success",
            });
        @elseif(session('addAppl'))
            swal.fire({
                title: 'Başarılı!',
                text: "Başvurunuz başarıyla gönderilmiştir. Ekibimiz en kısa sürede inceleyecek ve geri dönüş sağlayacaktır.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
