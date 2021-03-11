@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/urunler">Ürünler</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$kategori1->desc}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($canAddMenuItem)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle">Ürün Ekle</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Bu özellik kısa süreliğine devre dışı bırakıldı." >Ürün Ekle</a>
            @endif
            @if($user->isBrandManager && $hasBrand)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 ml-1" data-toggle="modal" data-target="#altKatEkleModal">Alt Kategori Ekle</a>
            @endif
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">{{$kategori1->desc}}</h5>
                    <table @if($kategori1->canGenerateQrCode) id="tblUruns" @else id="tblUruns2" @endif class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th></th>
                            <th>Ad</th>
                            <th>Alt kategori</th>
                            <th>Fiyat</th>
                            <th>Aktiflik</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            @if($kategori1->canGenerateQrCode)
                                <th>Aktif QR Kod Sayısı</th>
                            @endif
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($uruns as $urun)
                            <tr>
                                <td></td>
                                <td>URN{{$urun->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$urun->imageLink}}">
                                        <a href="{{$urun->imageLink}}" title="">
                                            <img src="{{$urun->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td data-toggle="tooltip" data-placement="right" title=" @if($urun->tag1 == "1")Sıcak, @elseif($urun->tag1 == "2")Soğuk, @endif @if($urun->tag2 == "1")Kahve baskın, @elseif($urun->tag2 == "2")Süt baskın, @elseif($urun->tag2 == "3")Diğer, @endif @if($urun->tag3 == "1")Hafif içim @elseif($urun->tag3 == "2")Orta içim @elseif($urun->tag3 == "3")Yoğun içim @endif ">{{$urun->title}}</td>
                                <td>{{$urun->subcategory->desc}}</td>
                                <td>{{$urun->fee??"-"}}TL</td>
                                @if($urun->isActive)
                                    <td><span class="badge badge-soft-success">Aktif</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Pasif</span></td>
                                @endif
                                <td>{{\Carbon\Carbon::createFromTimeString($urun->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$urun->views_count}}</td>
                                @if($kategori1->canGenerateQrCode)
                                    <td>{{count($urun->qrcodes->where('status','active'))}}</td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-light btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"><i class="icon"><span data-feather="more-horizontal"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a href="/yoneticipaneli/urunler/URN{{$urun->id}}" type="button"
                                               class="dropdown-item text-dark">Detay</a>
                                            @if($kategori1->canGenerateQrCode)
                                                <a href="javascript:void(0);" type="button" data-id="{{$urun->id}}"
                                                   class="dropdown-item text-dark sa-stoUrnQr">Qr Kod Oluştur</a>
                                            @endif
                                            @if($urun->isActive)
                                                <a href="javascript:void(0);" type="button" data-id="{{$urun->id}}"
                                                   class="dropdown-item text-dark sa-stoUrnPasif">Pasifize et</a>
                                            @else
                                                <a href="javascript:void(0);" type="button" data-id="{{$urun->id}}"
                                                   class="dropdown-item text-dark sa-stoUrnAktif">Aktive et</a>
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
                    <p class="font-weight-bold">Ürünlerinizi eklerken kullandığınız görsel ve yazdığınız detaylı ürün açıklamaları, kahveseverlerin mağazanıza ve markanıza olan ilgisini arttıracaktır.</p>
                    <hr>
                    @if(!$hasBrand)
                        <p class="font-weight-bold text-primary">Eklemek istediğiniz ürünün alt kategorisi mevcut değil ise marka yöneticiniz ile iletişime geçiniz.</p>
                        <hr>
                    @endif
                    @if($kategori1->canGenerateQrCode)
                        <p class="font-weight-bold text-primary">Bir ürününüzü pasif hale getirdiğinizde; bu ürüne bağlı aktif QR kod bulunuyorsa, QR kodlar da ürün ile birlikte pasif hale gelecek ve bir daha kullanılamayacaktır.</p>
                        <hr>
                    @endif
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan yazıları, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16 mb-4">Alt kategoriler</h5>
                    @if(count($kategori1->subcategories->where('brandID',$user->magaza->brandID)))
                        @foreach($kategori1->subcategories->where('brandID',$user->magaza->brandID) as $subCat)
                            <p class="font-weight-bold text-primary">{{$subCat->desc}}</p>
                            <p class="text-muted">{{count($subCat->items)}} ürün</p>
                            <hr>
                        @endforeach
                    @else
                        <p class="font-weight-bold text-primary mb-0">Bu kategori için tanımlı alt kategori bulunmamaktadır.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="right-bar">
        <div class="rightbar-title">
            <a href="javascript:void(0);" class="right-bar-toggle float-right">
                <i data-feather="x-circle"></i>
            </a>
            <h5 class="">Ürün ekle</h5>
        </div>
        <div class="slimscroll">
            <form id="frmUrnEkle" enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/urnekle">
                @csrf
                <fieldset>
                    <input type="hidden" name="catID" value="{{$kategori1->id}}">
                    <div class="form-group">
                        <label for="title" class="col-md-12 col-form-label">Ürün adı</label>
                        <div class="col-md-12">
                            <input id="title" class="form-control" minlength="2" maxlength="35" required name="title" type="text" placeholder="Ürün adı en az 2 ve en fazla 35 karakter olmalıdır.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc" class="col-md-12 col-form-label">Açıklama</label>
                        <div class="col-md-12">
                            <textarea id="desc" class="form-control" required minlength="500" rows="20" name="desc" type="text" placeholder="Açıklama en az 500 karakter olmalıdır."></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kat" class="col-md-12 col-form-label">Kategori</label>
                        <div class="col-md-12">
                            <input id="kat" class="form-control" disabled readonly name="kat" type="text" value="{{$kategori1->desc}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subCatID" class="col-md-12 col-form-label">Alt kategori</label>
                        <div class="col-md-12 mr-5">
                            <select data-plugin="customselects1" class="form-control" required name="subCatID" >
                                <option></option>
                                @foreach($altKategoris as $altKat)
                                    <option value="{{$altKat->id}}">{{$altKat->desc}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if($kategori1->code == "hot_coffee" || $kategori1->code == "cold_coffee" || $kategori1->code == "hot_drink" || $kategori1->code == "cold_drink")
                        @if($kategori1->code == "hot_coffee" || $kategori1->code == "hot_drink")
                            <div class="form-group">
                                <label for="tag1" class="col-md-12 col-form-label">Sıcaklık</label>
                                <div class="custom-control custom-radio mt-0 ml-3">
                                    <input type="radio" id="tag1" name="tag1" value="1" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="tag1">Sıcak</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag12" name="tag1" value="2" class="custom-control-input" disabled>
                                    <label class="custom-control-label" for="tag12">Soğuk</label>
                                </div>
                            </div>
                        @elseif($kategori1->code == "cold_coffee" || $kategori1->code == "cold_drink")
                            <div class="form-group">
                                <label for="tag1" class="col-md-12 col-form-label">Sıcaklık</label>
                                <div class="custom-control custom-radio mt-0 ml-3">
                                    <input type="radio" id="tag1" name="tag1" value="1" class="custom-control-input" disabled>
                                    <label class="custom-control-label" for="tag1">Sıcak</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag12" name="tag1" value="2" class="custom-control-input" checked >
                                    <label class="custom-control-label" for="tag12">Soğuk</label>
                                </div>
                            </div>
                        @endif
                            <div class="form-group">
                                <label for="tag2" class="col-md-12 col-form-label">Baskın</label>
                                <div class="custom-control custom-radio mt-0 ml-3">
                                    <input type="radio" id="tag2" name="tag2" value="1" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="tag2">Kahve baskın</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag22" name="tag2" value="2" class="custom-control-input">
                                    <label class="custom-control-label" for="tag22">Süt baskın</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag23" name="tag2" value="3" class="custom-control-input">
                                    <label class="custom-control-label" for="tag23">Diğer</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tag2" class="col-md-12 col-form-label">Sertlik</label>
                                <div class="custom-control custom-radio mt-0 ml-3">
                                    <input type="radio" id="tag3" name="tag3" value="1" class="custom-control-input" checked>
                                    <label class="custom-control-label" for="tag3">Hafif içim</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag32" name="tag3" value="2" class="custom-control-input">
                                    <label class="custom-control-label" for="tag32">Orta içim</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag33" name="tag3" value="3" class="custom-control-input">
                                    <label class="custom-control-label" for="tag33">Yoğun içim</label>
                                </div>
                            </div>
                    @endif
                    <div class="form-group">
                        <label for="fee" class="col-md-12 col-form-label">Ürün fiyatı</label>
                        <p class="card-text text-primary col-md-12 font-size-13">*Ürün fiyatını belirtmek istemiyorsanız boş bırakabilirsiniz.</p>
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">TL</div>
                                </div>
                                <input type="text" name="fee" class="form-control" data-inputmask-alias="9{1,4}.99" id="fee" placeholder="Ürün fiyatı">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-md-12 col-form-label">Görsel</label>
                        <div class="col-md-12">
                            <input type="file" id="image" name="image" data-max-file-size="1M" required  data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <input type="submit" class="btn btn-primary mb-5" value="Ekle">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    <div class="rightbar-overlay"></div>
    <div class="modal fade" id="altKatEkleModal" tabindex="-1" role="dialog"
         aria-labelledby="altKatEkleModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="altKatEkleModal">Alt Kategori Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmAltKatEkle" method="post" action="/yoneticipaneli/subcatadd">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="catID" value="{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII',str_replace(' ', '', $kategori1->desc)))}}">
                            <div class="form-group row">
                                <label for="cat" class="col-md-4 col-form-label">Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" name="cat" disabled readonly class="form-control" id="cat"
                                           value="{{$kategori1->desc}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subCatName" class="col-md-4 col-form-label">Yeni alt kategori adı</label>
                                <div class="col-md-8">
                                    <input type="text" name="subCatName" minlength="2" maxlength="35" required class="form-control"
                                           id="subCatName"
                                           placeholder="Yeni alt kategori adı">
                                </div>
                            </div>
                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY HH:mm' );
        });
    </script>
    <script type="text/javascript">
        $('#frmUrnEkle').submit(function(e){
            $('body').removeClass('right-bar-enabled')
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
        $('#frmAltKatEkle').submit(function(e){
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
    </script>
    <script>
        $('[data-plugin="customselects1"]').select2({
            dropdownParent: $(".right-bar")
        });
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                html: "{{$errors->first('urn')}}",
                type: "error",
            });
        @elseif(session('urnPas'))
            swal.fire({
                title: 'Başarılı!',
                text: "Ürün başarıyla pasif hale getirildi.",
                type: "success",
            });
        @elseif(session('urnAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "Ürün başarıyla eklendi.",
                type: "success",
            });
        @elseif(session('urnAkt'))
            swal.fire({
                title: 'Başarılı!',
                text: "Ürün başarıyla aktif hale getirildi.",
                type: "success",
            });
        @elseif(session('multiUrnPas'))
            swal.fire({
                title: 'Başarılı!',
                text: "Seçtiğiniz ürünler başarıyla pasifize edildi.",
                type: "success",
            });
        @elseif(session('qrSent'))
            swal.fire({
                title: 'Başarılı!',
                text: "Ürününüz için oluşturulan QR kodlar, kayıtlı e-posta adresinize gönderildi.",
                type: "success",
            });
        @elseif(session('multiQrSent'))
            swal.fire({
                title: 'Başarılı!',
                text: "Seçtiğiniz ürünler için oluşturulan QR kodlar, kayıtlı e-posta adresinize gönderildi.",
                type: "success",
            });
        @elseif(session('subCatAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "Yeni alt kategoriniz başarıyla eklendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
