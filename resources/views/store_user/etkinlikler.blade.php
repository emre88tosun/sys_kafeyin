@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Etkinlikler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($canAddActivity)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle" >Etkinlik Ekle</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Bu özellik kısa süreliğine devre dışı bırakıldı." >Etkinlik Ekle</a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif etkinlikler</h5>
                    <table id="tblActAct" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($aktifEtkinliks as $etkinlik)
                            <tr>
                                <td>ETK{{$etkinlik->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$etkinlik->imageLink}}">
                                        <a href="{{$etkinlik->imageLink}}" title="">
                                            <img src="{{$etkinlik->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$etkinlik->title}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</td>
                                <td>{{$etkinlik->viewCount}}</td>
                                <td>{{$etkinlik->favorites_count}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="/yoneticipaneli/etkinlikler/ETK{{$etkinlik->id}}" type="button"
                                               class="dropdown-item text-dark">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$etkinlik->id}}"
                                               class="dropdown-item text-dark sa-stoActPasif">Pasifize et</a>
                                            @if(!$isTicketingEnabled)
                                                <a href="javascript:void(0);" type="button" data-id="{{$etkinlik->id}}"
                                                   class="dropdown-item text-danger sa-stoActSil">Sil</a>
                                            @endif

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
                    <h5 class="header-title mb-3 mt-0">Pasif etkinlikler</h5>
                    <table id="tblPasAct" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pasifEtkinliks as $etkinlik)
                            <tr>
                                <td>ETK{{$etkinlik->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$etkinlik->imageLink}}">
                                        <a href="{{$etkinlik->imageLink}}" title="">
                                            <img src="{{$etkinlik->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$etkinlik->title}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</td>
                                <td>{{$etkinlik->viewCount}}</td>
                                <td>{{$etkinlik->favorites_count}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="/yoneticipaneli/etkinlikler/ETK{{$etkinlik->id}}" type="button"
                                               class="dropdown-item text-dark">Detay</a>
                                            @if(!$isTicketingEnabled)
                                                <a href="javascript:void(0);" type="button" data-id="{{$etkinlik->id}}"
                                                   class="dropdown-item text-danger sa-stoActSil">Sil</a>
                                            @endif

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
                    @if(count($aktifEtkinliks) > 1)
                        <p class="card-text text-muted">Ekleyebileceğiniz etkinlik sayısı: 0</p>
                    @else
                        <p class="card-text text-muted">Ekleyebileceğiniz etkinlik sayısı: {{2-(count($aktifEtkinliks))}}</p>
                    @endif
                    <hr>
                    <p class="font-weight-bold">Etkinliklerinizi <text class="text-primary">yarın ve takip eden 30 gün</text> için ekleyebilirsiniz.</p>
                    <hr>
                    <p class="font-weight-bold">Etkinlikleriniz, günü ve saati geldiğinde otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki etkinlikleri, daha önceden duyurmak suretiyle sistemlerimizden kaldırabiliriz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan etkinlikleri, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i data-feather="x-circle"></i>
            </a>
            <h5 class="">Etkinlik ekle</h5>
        </div>
        @if(count($aktifEtkinliks) > 1)
            <div class="alert alert-danger ml-4 mr-4">Maksimum sayıda aktif etkinliğiniz olduğu için yeni bir yazı ekleyemezsiniz.</div>
        @else
            <div class="slimscroll">
                <form id="frmEtkEkle" enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/etkekle">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="title" class="col-md-12 col-form-label">Başlık</label>
                            <div class="col-md-12">
                                <textarea id="title" class="form-control" rows="2" minlength="30" maxlength="90" required name="title" type="text" placeholder="Başlığınız en az 30 ve en fazla 90 karakter olmalıdır."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-md-12 col-form-label">Açıklama</label>
                            <div class="col-md-12">
                                <textarea id="desc" class="form-control" required minlength="1000" rows="20" name="desc" type="text" placeholder="Açıklamanız en az 1000 karakter olmalıdır."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dpicker" class="col-md-12 col-form-label">Tarih</label>
                            <div class="col-md-12">
                                <input type="text" id="dpicker" required name="date" class="form-control" placeholder="Tarih">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tpicker" class="col-md-12 col-form-label">Saat</label>
                            <div class="col-md-12">
                                <input type="text" id="tpicker" required name="time" class="form-control" placeholder="Saat">
                            </div>
                        </div>
                        @if($isTicketingEnabled)
                            @if($user->magaza->brand->isPremium)
                                <div class="form-group">
                                    <label for="canTicketing" class="col-md-12 col-form-label">Bilet</label>
                                    <div class="custom-control custom-radio mt-0 ml-3">
                                        <input type="radio" id="canTicketing" name="canTicketing" value="1" class="custom-control-input">
                                        <label class="custom-control-label" for="canTicketing">Satılacak</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-3 mt-2">
                                        <input type="radio" id="canTicketing2" name="canTicketing" value="0" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="canTicketing2">Satılmayacak</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="availableTicketCount" class="col-md-12 col-form-label">Satılacak bilet sayısı</label>
                                    <p class="card-text text-primary col-md-12 font-size-13">*Bilet satılmayacak ise 0 değerini giriniz.</p>
                                    <div class="col-md-12">
                                        <input id="availableTicketCount" class="form-control" required name="availableTicketCount" min="0" type="number" value="0" placeholder="Satılacak bilet sayısı">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ticketFee" class="col-md-12 col-form-label">Bilet fiyatı</label>
                                    <p class="card-text text-primary col-md-12 font-size-13">*Bilet satılmayacak ise 0.00 değerini giriniz.</p>
                                    <p class="card-text text-primary col-md-12 font-size-13">**Etkinliğinizi oluşturduktan sonra bilet fiyatında değişiklik yapamazsınız.</p>
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">TL</div>
                                            </div>
                                            <input type="text" name="ticketFee" class="form-control" data-inputmask-alias="9{1,4}.99" required id="ticketFee" placeholder="Bilet fiyatı" value="0.00">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="canTicketing" class="col-md-12 col-form-label">Bilet</label>
                                    <div class="alert alert-primary ml-3 mr-3 ">Markanızı Premium Plan'a taşıyıp, etkinlikleriniz için bilet satabilirsiniz.</div>
                                    <div class="custom-control custom-radio mt-0 ml-3">
                                        <input type="radio" id="canTicketing" name="canTicketing" value="1" class="custom-control-input" disabled>
                                        <label class="custom-control-label" for="canTicketing">Satılacak</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-3 mt-2">
                                        <input type="radio" id="canTicketing2" name="canTicketing" value="0" class="custom-control-input" checked disabled>
                                        <label class="custom-control-label" for="canTicketing2">Satılmayacak</label>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                            </div>
                        </div>
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
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY' );
        });
    </script>
    <script type="text/javascript">
        $('#frmEtkEkle').submit(function(e){
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
        $("#dpicker").flatpickr({
            minDate: new Date().fp_incr(1),
            maxDate: new Date().fp_incr(31),
            dateFormat: "d/m/Y",
            allowInput: true,
        });
        $('#tpicker').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            allowInput: true,
        });
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('etk')}}",
                type: "error",
            });
        @elseif(session('actDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Etkinliğiniz başarıyla silindi.",
                type: "success",
            });
        @elseif(session('actPas'))
            swal.fire({
                title: 'Başarılı!',
                text: "Etkinliğiniz başarıyla pasif hale getirildi.",
                type: "success",
            });
        @elseif(session('multiArtDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Seçtiğiniz yazılar başarıyla silindi.",
                type: "success",
            });
        @elseif(session('etkAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "Etkinliğiniz başarıyla eklendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
