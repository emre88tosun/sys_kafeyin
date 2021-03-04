@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/urunler">Ürünler</a></li>
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/urunler/kategoriler/{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII',str_replace(' ', '', $kategori->desc)))}}">{{$kategori->desc}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$urun->title}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($urun->isActive)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle">Düzenle</a>
            @endif
            @if(count($urun->qrcodes->where('status','active')) > 0) <a type="button" href="javascript:void(0);" data-id="{{$urun->id}}" class="btn btn-outline-primary btn-sm mt-2 ml-2 sa-stoDelUrnQr">Aktif QR kodları sil</a> @endif
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
                            <div class="popup-gallery mr-2" data-source="{{$urun->imageLink}}">
                                <a class="pr-2 pt-2" href="{{$urun->imageLink}}" title="">
                                    <img src="{{$urun->imageLink}}" alt="img" class="rounded" width=100%>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mt-0 mb-1">{{$urun->title}} (ID:URN{{$urun->id}})</h5>
                            <h6 class="mt-0 mb-0 font-weight-bold text-primary">{{$urun->subcategory->desc}}</h6>
                            <h6 class="text-primary font-weight-bold mt-2 mb-1">
                                @if($urun->tag1 == "1")
                                    Sıcak,
                                @elseif($urun->tag1 == "2")
                                    Soğuk,
                                @endif
                                @if($urun->tag2 == "1")
                                    Kahve baskın,
                                @elseif($urun->tag2 == "2")
                                    Süt baskın,
                                @elseif($urun->tag2 == "3")
                                    Diğer,
                                @endif
                                @if($urun->tag3 == "1")
                                    Hafif içim
                                @elseif($urun->tag3 == "2")
                                    Orta içim
                                @elseif($urun->tag3 == "3")
                                    Yoğun içim
                                @endif
                            </h6>
                            <p class="font-weight-bold text-muted mb-1">Ürün fiyatı: <text class="font-weight-bold text-primary">{{$urun->fee??"-"}}TL</text> </p>
                            <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($urun->created_at)->format('d/m/Y H:i')}}</p>
                            <hr class="mt-1">
                            <p class="card-text text-muted">{{$urun->desc}}</p>
                            <h5 class="mt-4 mb-0">İstatistikler</h5>
                            <hr class="mt-1">
                            @if($isPremiumPlanEnabled)
                                @if($user->magaza->brand->isPremium)
                                    <p class="font-weight-bold text-muted mb-2">Günlük görüntülenme</p>
                                    <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                                    @if($kategori->canGenerateQrCode)
                                        <p class="font-weight-bold text-muted mb-2 mt-4">QR kod sayısı</p>
                                        <div id="qr_chart" class="apex-charts m-0" dir="ltr"></div>
                                        <p class="font-weight-bold text-muted mb-2 mt-4">Günlük kullanılan QR kod sayısı</p>
                                        <div id="qr_du_chart" class="apex-charts m-0" dir="ltr"></div>
                                    @endif
                                @else
                                    <p class="text-primary mb-0">Markanızı Premium Plan'a taşıyıp, ürünlerinize ait detaylı istatistiklere ulaşabilirsiniz.</p>
                                @endif
                            @else
                                <p class="font-weight-bold text-muted mb-2">Günlük görüntülenme</p>
                                <div id="views_chart" class="apex-charts m-0" dir="ltr"></div>
                                @if($kategori->canGenerateQrCode)
                                    <p class="font-weight-bold text-muted mb-2 mt-4">QR kod sayısı</p>
                                    <div id="qr_chart" class="apex-charts m-0" dir="ltr"></div>
                                    <p class="font-weight-bold text-muted mb-2 mt-4">Günlük kullanılan QR kod sayısı</p>
                                    <div id="qr_du_chart" class="apex-charts m-0" dir="ltr"></div>
                                @endif
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
                    <p>Toplam görüntülenme sayısı: {{$urun->views_count}}</p>
                    <hr>
                    @if($kategori->canGenerateQrCode)
                        <p>Aktif QR kod sayısı: {{count($urun->qrcodes->where('status','active'))}}</p>
                        <hr>
                        <p>Kullanılan QR kod sayısı: {{count($urun->qrcodes->where('status','used'))}}</p>
                        <hr>
                        <p>Silinen QR kod sayısı: {{count($urun->qrcodes->where('isDeleted',true))}}</p>
                        <hr>
                        <p class="mb-0">Bugün kullanılan QR kod sayısı: {{count($urun->qrcodes->where('status','used')->where('updated_at','>=',\Carbon\Carbon::today()->startOfDay()))}}</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @if($urun->isActive)
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i data-feather="x-circle"></i>
                </a>
                <h5 class="">Ürün düzenle</h5>
            </div>
            <div class="slimscroll">
                <form enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/urnguncelle">
                    @csrf
                    <fieldset>
                        <input type="hidden" name="urnID" value="URN{{$urun->id}}">
                        <div class="form-group">
                            <label for="title" class="col-md-12 col-form-label">Ad</label>
                            <div class="col-md-12">
                                <input id="title" class="form-control" minlength="2" maxlength="35" required name="title" type="text" placeholder="Ürün adı en az 2 ve en fazla 35 karakter olmalıdır." value="{{$urun->title}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-md-12 col-form-label">Açıklama</label>
                            <div class="col-md-12">
                                <textarea id="desc" class="form-control" required minlength="500" rows="20" name="desc" type="text" placeholder="Açıklama en az 500 karakter olmalıdır.">{{$urun->desc}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kat" class="col-md-12 col-form-label">Kategori</label>
                            <div class="col-md-12">
                                <input id="kat" class="form-control" disabled readonly name="kat" type="text" value="{{$kategori->desc}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subCatID" class="col-md-12 col-form-label">Alt kategori</label>
                            <div class="col-md-12 mr-5">
                                <select data-plugin="customselects1" class="form-control" required name="subCatID" >
                                    <option></option>
                                    @foreach($altKategoris as $altKat)
                                        <option value="{{$altKat->id}}" @if($altKat->id == $urun->subCategoryID) selected @endif >{{$altKat->desc}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if($urun->tag1 == "1")
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
                        @elseif($urun->tag1 == "2")
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
                        @if($urun->tag2)
                            <div class="form-group">
                                <label for="tag2" class="col-md-12 col-form-label">Baskın</label>
                                <div class="custom-control custom-radio mt-0 ml-3">
                                    <input type="radio" id="tag2" name="tag2" value="1" class="custom-control-input" @if($urun->tag2 == "1") checked @endif >
                                    <label class="custom-control-label" for="tag2">Kahve baskın</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag22" name="tag2" value="2" class="custom-control-input" @if($urun->tag2 == "2") checked @endif>
                                    <label class="custom-control-label" for="tag22">Süt baskın</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag23" name="tag2" value="3" class="custom-control-input" @if($urun->tag2 == "3") checked @endif>
                                    <label class="custom-control-label" for="tag23">Diğer</label>
                                </div>
                            </div>
                        @endif
                        @if($urun->tag3)
                            <div class="form-group">
                                <label for="tag2" class="col-md-12 col-form-label">Sertlik</label>
                                <div class="custom-control custom-radio mt-0 ml-3">
                                    <input type="radio" id="tag3" name="tag3" value="1" class="custom-control-input"  @if($urun->tag3 == "1") checked @endif >
                                    <label class="custom-control-label" for="tag3">Hafif içim</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag32" name="tag3" value="2" class="custom-control-input" @if($urun->tag3 == "2") checked @endif >
                                    <label class="custom-control-label" for="tag32">Orta içim</label>
                                </div>
                                <div class="custom-control custom-radio ml-3 mt-2">
                                    <input type="radio" id="tag33" name="tag3" value="3" class="custom-control-input" @if($urun->tag3 == "3") checked @endif >
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
                                    <input type="text"  name="fee" class="form-control" data-inputmask-alias="9{1,4}.99" id="fee" placeholder="Ürün fiyatı" value="{{$urun->fee}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <p class="card-text text-primary col-md-12 font-size-13">*Görseli güncellemek istemiyorsanız boş bırakabilirsiniz.</p>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M"  data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                            </div>
                        </div>
                        <div class="offset-md-0">
                            <input type="submit" class="btn btn-primary ml-3 mb-5" value="Güncelle">
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
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        $('[data-plugin="customselects1"]').select2({
            dropdownParent: $(".right-bar")
        });
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('hata')}}",
                type: "error",
            });
        @elseif(session('urnUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Ürün başarıyla güncellendi.",
                type: "success",
            });
        @elseif(session('qrsDel'))
            swal.fire({
                title: 'Başarılı!',
                text: "Ürününüze ait aktif QR kodları silindi.",
                type: "success",
            });
        @endif
    </script>
    <script>
        var series11 = [
            @foreach(array_reverse($l15dvs) as $dv)
            {{$dv}},
            @endforeach
        ];

        var labels12 = [
            @foreach(array_reverse($l15days) as $day)
            new Date({{$day}}).toLocaleDateString(),
            @endforeach
        ];

        var options12 = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            series: [{
                name: 'Görüntülenme sayısı',
                data: series11
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#43d39e'],
            xaxis: {
                type: 'string',
                categories: labels12,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#views_chart"), options12);
        chart.render();

    </script>
    <script>
        var series99 = [
            @foreach(array_reverse($l15daqs) as $aq)
            {{$aq}},
            @endforeach
        ];
        var series94 = [
            @foreach(array_reverse($l15dauqs) as $auq)
            {{$auq}},
            @endforeach
        ];
        var series98 = [
            @foreach(array_reverse($l15duqs) as $uq)
            {{$uq}},
            @endforeach
        ];

        var labels97 = [
            @foreach(array_reverse($l15days) as $day)
            new Date({{$day}}).toLocaleDateString(),
            @endforeach
        ];

        var options96 = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            series: [{
                name: 'Toplam QR kod sayısı',
                data: series99
            },
            {
                name: 'Toplam kullanılan QR kod sayısı',
                data: series94
            }
            ],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#564ab1','#ff8c00'],
            xaxis: {
                type: 'string',
                categories: labels97,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var chart2 = new ApexCharts(document.querySelector("#qr_chart"), options96);
        chart2.render();

        var options93 = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 4
            },
            series: [{
                name: 'Günlük kullanılan QR kod sayısı',
                data: series98
            },
            ],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#25c2e3'],
            xaxis: {
                type: 'string',
                categories: labels97,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var chart3 = new ApexCharts(document.querySelector("#qr_du_chart"), options93);
        chart3.render();

    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
