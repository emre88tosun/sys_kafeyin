@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/adminpanel/markalar">Markalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{$brand->id}} - {{$brand->name}}</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">#{{$brand->id}} - {{$brand->name}}</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Markaya ait bilgiler</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#detay" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-info-circle"></i></span>
                                <span class="d-none d-sm-block">Detay</span>
                            </a>
                        </li>
                        {{--<li class="nav-item">
                            <a href="#loglar" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-list-ul"></i></span>
                                <span class="d-none d-sm-block">Loglar</span>
                            </a>
                        </li>--}}
                        <li class="nav-item">
                            <a href="#duzenle" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-cog"></i></span>
                                <span class="d-none d-sm-block">Düzenle</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane show active" id="detay">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="table-responsive table-hover">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">ID</th>
                                                <td>{{$brand->id}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ad</th>
                                                <td>{{$brand->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Mağaza sayısı</th>
                                                <td>{{$brand->stores_count}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Plan</th>
                                                @if($brand->isPremium)
                                                    <td>Premium plan</td>
                                                @else
                                                    <td>Temel plan</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">QR & Sadakat Kartı</th>
                                                @if($brand->isEnabledLoyaltyCard)
                                                    <td>Aktif</td>
                                                @else
                                                    <td>Pasif</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Gereken damga sayısı</th>
                                                <td>{{$brand->needStampCount}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="table-responsive table-hover">
                                        <table class="table m-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Yönetici</th>
                                                @if($brand->manager)
                                                    <td><a class="text-muted" href="/adminpanel/kullanicilar/magaza/{{$brand->manager->id}}">#{{$brand->manager->id}} - {{$brand->manager->name}} {{$brand->manager->surname}}</a></td>
                                                @else
                                                    <td>Tanımlı değil</td>
                                                @endif
                                            </tr>
                                            @if($brand->manager)
                                                <tr>
                                                    <th scope="row">E-posta adresi</th>
                                                    <td>{{$brand->manager->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">GSM</th>
                                                    <td>{{$brand->manager->gsmNumber}}</td>
                                                </tr>
                                                @if($brand->manager->marka_yoneticisi_bilgileri)
                                                    <tr>
                                                        <th scope="row">Şehir</th>
                                                        <td>{{$brand->manager->marka_yoneticisi_bilgileri->city}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Ülke</th>
                                                        <td>{{$brand->manager->marka_yoneticisi_bilgileri->country}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Adres</th>
                                                        <td>{{$brand->manager->marka_yoneticisi_bilgileri->address}}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="duzenle">
                            <div class="row">
                                <div class="col-xl-6">
                                    <form method="post" action="/adminpanel/markaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="brandID" value="{{$brand->id}}">
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" required class="form-control" id="name"
                                                           placeholder="Ad" value="{{$brand->name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="needStampCount" class="col-md-4 col-form-label">Gereken damga sayısı</label>
                                                <div class="col-md-8">
                                                    <input type="number" name="needStampCount" required class="form-control" id="needStampCount"
                                                           placeholder="Gereken damga sayısı" value="{{$brand->needStampCount}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="isEnabledLoyaltyCard" class="col-md-4 col-form-label">QR & Sadakat kartı</label>
                                                <div class="custom-control custom-radio mt-2 ml-3">
                                                    <input type="radio" id="isEnabledLoyaltyCard" name="isEnabledLoyaltyCard" value="1" class="custom-control-input" @if($brand->isEnabledLoyaltyCard) checked @endif>
                                                    <label class="custom-control-label" for="isEnabledLoyaltyCard">Aktif</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isEnabledLoyaltyCard2" name="isEnabledLoyaltyCard" value="0" class="custom-control-input" @if(!$brand->isEnabledLoyaltyCard) checked @endif>
                                                    <label class="custom-control-label" for="isEnabledLoyaltyCard2">Pasif</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="isPremium" class="col-md-4 col-form-label">Plan</label>
                                                <div class="custom-control custom-radio mt-2 ml-3">
                                                    <input type="radio" id="isPremium" name="isPremium" value="1" class="custom-control-input" @if($brand->isPremium) checked @endif>
                                                    <label class="custom-control-label" for="isPremium">Premium plan</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isPremium2" name="isPremium" value="0" class="custom-control-input" @if(!$brand->isPremium) checked @endif>
                                                    <label class="custom-control-label" for="isPremium2">Temel plan</label>
                                                </div>
                                            </div>
                                            <div class="offset-md-4">
                                                <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                    <form class="mt-5" enctype="multipart/form-data" method="post" action="/adminpanel/markalogoguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="brandID" value="{{$brand->id}}">
                                            <div class="form-group">
                                                <label for="image">Logo güncelle</label>
                                                <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                            </div>
                                            <div class="offset-md-0">
                                                <input type="submit" class="btn btn-primary" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-xl-6">
                                    <form method="post" action="/adminpanel/markayoneticiguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="brandID" value="{{$brand->id}}">
                                            <div class="form-group row">
                                                <label for="userID" class="col-md-4 col-form-label">Yönetici</label>
                                                <div class="col-md-8">
                                                    <select data-plugin="customselect" name="userID" id="userID" class="form-control" required>
                                                        <option value="0">Sahipsiz</option>
                                                        @foreach($brandmanagers as $brandManager)
                                                            <option value="{{$brandManager->id}}" @if($brand->manager && $brandManager->brandID == $brand->manager->brandID) selected @endif >#{{$brandManager->id}} - {{$brandManager->name}} {{$brandManager->surname}} ({{$brandManager->email}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="offset-md-4">
                                                <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                    @if($brand->manager && $brand->manager->marka_yoneticisi_bilgileri)
                                        <form class="pt-4" method="post" action="/adminpanel/mrkyntcekstblgguncelle">
                                            @csrf
                                            <fieldset>
                                                <input type="hidden" name="userID" value="{{$brand->manager->id}}">
                                                <div class="form-group row">
                                                    <label for="city" class="col-md-4 col-form-label">Şehir</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="city" class="form-control" id="city"
                                                               placeholder="Şehir" value="{{$brand->manager->marka_yoneticisi_bilgileri->city}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="country" class="col-md-4 col-form-label">Ülke</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="country" class="form-control" id="country"
                                                               placeholder="Ülke" value="{{$brand->manager->marka_yoneticisi_bilgileri->country}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="address" class="col-md-4 col-form-label">Adres</label>
                                                    <div class="col-md-8">
                                                        <textarea type="text" name="address" class="form-control" id="address" rows="3" placeholder="Adres">{{$brand->manager->marka_yoneticisi_bilgileri->address}}</textarea>
                                                    </div>
                                                </div>

                                                <div class="offset-md-4">
                                                    <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                                </div>
                                            </fieldset>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Logo</h6>
                    <div class="media pt-0">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <div class="popup-gallery" data-source="{{$brand->logo}}">
                                    <a href="{{$brand->logo}}" title="">
                                        <img src="{{$brand->logo}}" alt="img" class="avatar-xxl rounded">
                                    </a>
                                </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Admin Notu</h6>
                    <div class="media pt-0">
                        <div class="col-12">
                            @if($brand->adminNote)
                                <p>{{$brand->adminNote}}</p>
                            @else
                                <p>Not bulunmamaktadır.</p>
                            @endif
                            <a href="javascript:void(0);"
                               type="button" data-toggle="modal"
                               data-target="#duzenleNoteModal"
                               class="btn btn-primary btn-sm">Düzenle</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Mağazalar</h6>
                    <div class="media pt-0">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                @foreach($brand->stores as $store)
                                    <tr>
                                        <td><a href="/adminpanel/magazalar/{{$store->id}}">#{{$store->id}} - {{$store->name}} ({{$store->location->name}}, {{$store->city->name}})</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="duzenleNoteModal" tabindex="-1" role="dialog"
                 aria-labelledby="duzenleNoteModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="duzenleNoteModal">Not düzenle</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/adminpanel/markaguncelle">
                                @csrf
                                <fieldset>
                                    <input type="hidden" name="brandID" value="{{$brand->id}}">
                                    <div class="form-group row">
                                        <label for="adminNote" class="col-md-2 col-form-label">Not</label>
                                        <div class="col-md-10">
                                                            <textarea type="text" name="adminNote" rows="4"
                                                                      class="form-control"
                                                                      id="adminNote"
                                                                      placeholder="Not">{{$brand->adminNote}}</textarea>
                                        </div>
                                    </div>
                                    <div class="offset-md-2">
                                        <input type="submit" class="btn btn-primary" value="Güncelle">
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script>
        @if (session('stBrManUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Marka yöneticisi bilgileri güncellenmiştir.',
                type: "success",
            });
        @elseif(session('fileErr'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz dosya ile ilgili bir problem oluştu.',
                type: "warning",
            });
        @elseif (session('brExUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Marka yöneticisi ekstra bilgileri güncellenmiştir.',
                type: "success",
            });
        @elseif (session('logoUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Marka logosu güncellenmiştir.',
                type: "success",
            });
        @elseif (session('branUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Marka bilgileri güncellenmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
