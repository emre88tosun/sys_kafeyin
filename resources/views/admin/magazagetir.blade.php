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
                <li class="breadcrumb-item"><a href="/adminpanel/magazalar">Mağazalar</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{$store->id}} - {{$store->name}}</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">#{{$store->id}} - {{$store->name}}</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Mağazaya ait bilgiler</h5>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#detay" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-block d-sm-none"><i class="uil-info-circle"></i></span>
                                <span class="d-none d-sm-block">Detay</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#loglar" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-list-ul"></i></span>
                                <span class="d-none d-sm-block">Loglar</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#duzenle" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-edit"></i></span>
                                <span class="d-none d-sm-block">Düzenle</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#ayarlar" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-block d-sm-none"><i class="uil-cog"></i></span>
                                <span class="d-none d-sm-block">Ayarlar</span>
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
                                                <td>{{$store->id}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ad</th>
                                                <td>{{$store->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lokasyon</th>
                                                <td>{{$store->location->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Şehir</th>
                                                <td>{{$store->city->name}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Adres</th>
                                                <td>{{$store->address}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Sabit telefon numarası</th>
                                                <td>{{$store->landPhoneNumber}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Enlem</th>
                                                <td>{{$store->latitude}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Boylam</th>
                                                <td>{{$store->longitude}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Etiket</th>
                                                <td>{{$store->tag}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Öne çıkan</th>
                                                <td>{{$store->featured}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Aktif mi?</th>
                                                @if($store->isActive)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Kafe mi?</th>
                                                @if($store->isCafe)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Bugünkü aranma sayısı</th>
                                                <td>{{$store->todaysSearchCount}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Kalan günlük paylaşım sayısı</th>
                                                <td>{{$store->leftDailyStoryCount}}</td>
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
                                                <th scope="row">Pazartesi</th>
                                                @if($store->monOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->monOpen,0,5)}} - {{substr($store->monClose,0,5)}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Salı</th>
                                                @if($store->tueOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->tueOpen,0,5)}} - {{substr($store->tueClose,0,5)}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Çarşamba</th>
                                                @if($store->wedOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->wedOpen,0,5)}} - {{substr($store->wedClose,0,5)}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Perşembe</th>
                                                @if($store->thuOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->thuOpen,0,5)}} - {{substr($store->thuClose,0,5)}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Cuma</th>
                                                @if($store->friOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->friOpen,0,5)}} - {{substr($store->friClose,0,5)}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Cumartesi</th>
                                                @if($store->satOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->satOpen,0,5)}} - {{substr($store->satClose,0,5)}}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Pazar</th>
                                                @if($store->sunOpen == "16:50:00")
                                                    <td>Kapalı</td>
                                                @else
                                                    <td>{{substr($store->sunOpen,0,5)}} - {{substr($store->sunClose,0,5)}}</td>
                                                @endif
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
                                                <th scope="row">Ders çalışma ortamı</th>
                                                @if($store->isStudy)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Buluşmaya uygun</th>
                                                @if($store->isDate)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Latte-art</th>
                                                @if($store->isLatteArt)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Hayvan dostu</th>
                                                @if($store->isPetFriendly)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Tatlı</th>
                                                @if($store->isDessert)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Toplantıya uygun</th>
                                                @if($store->isMeeting)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Alkollü magaza</th>
                                                @if($store->isAlcohol)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Dış magaza</th>
                                                @if($store->isOutside)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Yemek</th>
                                                @if($store->isMeal)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Kahvaltı</th>
                                                @if($store->isBreakfast)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Çikolata</th>
                                                @if($store->isChocolate)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Fotoğraf için dekor</th>
                                                @if($store->isTakePhoto)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Self-servis</th>
                                                @if($store->isSelfService)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Çay</th>
                                                @if($store->isTea)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row">Canlı müzik</th>
                                                @if($store->isLiveMusic)
                                                    <td>Olumlu</td>
                                                @else
                                                    <td>Olumsuz</td>
                                                @endif
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="loglar">
                            <div class="col-xl-12">
                                <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kullanıcı</th>
                                        <th>Detay</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($store->logs as $log)
                                        <tr>
                                            <td>{{$log->id}}</td>
                                            <td>#{{$log->user->id}} - {{$log->user->name}} {{$log->user->surname}}</td>
                                            <td>{{$log->desc}}</td>
                                            <td>{{\Carbon\Carbon::createFromTimeString($log->created_at)->format('H:i d/m/Y')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="duzenle">
                            <div class="row">
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/magazaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" required class="form-control" id="name"
                                                           placeholder="Ad" value="{{$store->name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="city" class="col-md-4 col-form-label">Şehir</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="city" class="form-control" id="city"
                                                           placeholder="Şehir" readonly value="{{$store->city->name}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="locationID" class="col-md-4 col-form-label">Lokasyon</label>
                                                <div class="col-md-8">
                                                    <select data-plugin="customselect" name="locationID" id="locationID" class="form-control" required>
                                                        @foreach($locations as $location)
                                                            <option value="{{$location->id}}" @if($store->locationID == $location->id) selected @endif >{{$location->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tag" class="col-md-4 col-form-label">Etiket</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="tag" class="form-control" id="tag"
                                                           placeholder="Etiket" value="{{$store->tag}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="featured" class="col-md-4 col-form-label">Öne çıkan</label>
                                                <div class="col-md-8">
                                                    <textarea type="text" name="featured" rows="4" class="form-control" id="featured"
                                                              placeholder="Öne çıkan">{{$store->featured}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="address" class="col-md-4 col-form-label">Adres</label>
                                                <div class="col-md-8">
                                                    <textarea type="text" required name="address" rows="4" class="form-control" id="address"
                                                              placeholder="Adres">{{$store->address}}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="latitude" class="col-md-4 col-form-label">Enlem</label>
                                                <div class="col-md-8">
                                                    <input type="text" required name="latitude" class="form-control" id="latitude"
                                                           placeholder="Enlem" value="{{$store->latitude}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="longitude" class="col-md-4 col-form-label">Boylam</label>
                                                <div class="col-md-8">
                                                    <input type="text" required name="longitude" class="form-control" id="longitude"
                                                           placeholder="Boylam" value="{{$store->longitude}}">
                                                </div>
                                            </div>
                                            <div class="offset-md-4">
                                                <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/magazaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">
                                            <div class="form-group row">
                                                <label for="monOpen" class="col-md-6 col-form-label">Pazartesi açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="monOpen" required class="form-control" id="monOpen"
                                                           placeholder="08:00:00" value="{{$store->monOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="monClose" class="col-md-6 col-form-label">Pazartesi kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="monClose" required class="form-control" id="monClose"
                                                           placeholder="23:00:00" value="{{$store->monClose}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="tueOpen" class="col-md-6 col-form-label">Salı açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="tueOpen" required class="form-control" id="tueOpen"
                                                           placeholder="08:00:00" value="{{$store->tueOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="tueClose" class="col-md-6 col-form-label">Salı kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="tueClose" required class="form-control" id="tueClose"
                                                           placeholder="23:00:00" value="{{$store->tueClose}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="wedOpen" class="col-md-6 col-form-label">Çarşamba açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="wedOpen" required class="form-control" id="wedOpen"
                                                           placeholder="08:00:00" value="{{$store->wedOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="wedClose" class="col-md-6 col-form-label">Çarşamba kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="wedClose" required class="form-control" id="wedClose"
                                                           placeholder="23:00:00" value="{{$store->wedClose}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="thuOpen" class="col-md-6 col-form-label">Perşembe açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="thuOpen" required class="form-control" id="thuOpen"
                                                           placeholder="08:00:00" value="{{$store->thuOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="thuClose" class="col-md-6 col-form-label">Perşembe kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="thuClose" required class="form-control" id="thuClose"
                                                           placeholder="23:00:00" value="{{$store->thuClose}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="friOpen" class="col-md-6 col-form-label">Cuma açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="friOpen" required class="form-control" id="friOpen"
                                                           placeholder="08:00:00" value="{{$store->friOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="friClose" class="col-md-6 col-form-label">Cuma kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="friClose" required class="form-control" id="friClose"
                                                           placeholder="23:00:00" value="{{$store->friClose}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="satOpen" class="col-md-6 col-form-label">Cumartesi açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="satOpen" required class="form-control" id="satOpen"
                                                           placeholder="08:00:00" value="{{$store->satOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="satClose" class="col-md-6 col-form-label">Cumartesi kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="satClose" required class="form-control" id="satClose"
                                                           placeholder="23:00:00" value="{{$store->satClose}}">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="sunOpen" class="col-md-6 col-form-label">Pazar açılış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="sunOpen" required class="form-control" id="sunOpen"
                                                           placeholder="08:00:00" value="{{$store->sunOpen}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="sunClose" class="col-md-6 col-form-label">Pazar kapanış</label>
                                                <div class="col-md-6">
                                                    <input type="text" name="sunClose" required class="form-control" id="sunClose"
                                                           placeholder="23:00:00" value="{{$store->sunClose}}">
                                                </div>
                                            </div>

                                            <div class="offset-md-6">
                                                <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/magazaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">

                                            <div class="form-group row">
                                                <label for="isStudy" class="col-md-6 col-form-label">Ders çalışma ortamı</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isStudy" name="isStudy" value="1" class="custom-control-input" @if($store->isStudy) checked @endif>
                                                    <label class="custom-control-label" for="isStudy">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isStudy2" name="isStudy" value="0" class="custom-control-input" @if(!$store->isStudy) checked @endif>
                                                    <label class="custom-control-label" for="isStudy2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isDate" class="col-md-6 col-form-label">Buluşmaya uygun</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isDate" name="isDate" value="1" class="custom-control-input" @if($store->isDate) checked @endif>
                                                    <label class="custom-control-label" for="isDate">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isDate2" name="isDate" value="0" class="custom-control-input" @if(!$store->isDate) checked @endif>
                                                    <label class="custom-control-label" for="isDate2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isLatteArt" class="col-md-6 col-form-label">Latte-art</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isLatteArt" name="isLatteArt" value="1" class="custom-control-input" @if($store->isLatteArt) checked @endif>
                                                    <label class="custom-control-label" for="isLatteArt">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isLatteArt2" name="isLatteArt" value="0" class="custom-control-input" @if(!$store->isLatteArt) checked @endif>
                                                    <label class="custom-control-label" for="isLatteArt2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isPetFriendly" class="col-md-6 col-form-label">Hayvan dostu</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isPetFriendly" name="isPetFriendly" value="1" class="custom-control-input" @if($store->isPetFriendly) checked @endif>
                                                    <label class="custom-control-label" for="isPetFriendly">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isPetFriendly2" name="isPetFriendly" value="0" class="custom-control-input" @if(!$store->isPetFriendly) checked @endif>
                                                    <label class="custom-control-label" for="isPetFriendly2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isDessert" class="col-md-6 col-form-label">Tatlı</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isDessert" name="isDessert" value="1" class="custom-control-input" @if($store->isDessert) checked @endif>
                                                    <label class="custom-control-label" for="isDessert">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isDessert2" name="isDessert" value="0" class="custom-control-input" @if(!$store->isDessert) checked @endif>
                                                    <label class="custom-control-label" for="isDessert2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isMeeting" class="col-md-6 col-form-label">Toplantıya uygun</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isMeeting" name="isMeeting" value="1" class="custom-control-input" @if($store->isMeeting) checked @endif>
                                                    <label class="custom-control-label" for="isMeeting">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isMeeting2" name="isMeeting" value="0" class="custom-control-input" @if(!$store->isMeeting) checked @endif>
                                                    <label class="custom-control-label" for="isMeeting2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isAlcohol" class="col-md-6 col-form-label">Alkollü magaza</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isAlcohol" name="isAlcohol" value="1" class="custom-control-input" @if($store->isAlcohol) checked @endif>
                                                    <label class="custom-control-label" for="isAlcohol">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isAlcohol2" name="isAlcohol" value="0" class="custom-control-input" @if(!$store->isAlcohol) checked @endif>
                                                    <label class="custom-control-label" for="isAlcohol2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isOutside" class="col-md-6 col-form-label">Dış magaza</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isOutside" name="isOutside" value="1" class="custom-control-input" @if($store->isOutside) checked @endif>
                                                    <label class="custom-control-label" for="isOutside">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isOutside2" name="isOutside" value="0" class="custom-control-input" @if(!$store->isOutside) checked @endif>
                                                    <label class="custom-control-label" for="isOutside2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isMeal" class="col-md-6 col-form-label">Yemek</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isMeal" name="isMeal" value="1" class="custom-control-input" @if($store->isMeal) checked @endif>
                                                    <label class="custom-control-label" for="isMeal">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isMeal2" name="isMeal" value="0" class="custom-control-input" @if(!$store->isMeal) checked @endif>
                                                    <label class="custom-control-label" for="isMeal2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isBreakfast" class="col-md-6 col-form-label">Kahvaltı</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isBreakfast" name="isBreakfast" value="1" class="custom-control-input" @if($store->isBreakfast) checked @endif>
                                                    <label class="custom-control-label" for="isBreakfast">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isBreakfast2" name="isBreakfast" value="0" class="custom-control-input" @if(!$store->isBreakfast) checked @endif>
                                                    <label class="custom-control-label" for="isBreakfast2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isChocolate" class="col-md-6 col-form-label">Çikolata</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isChocolate" name="isChocolate" value="1" class="custom-control-input" @if($store->isChocolate) checked @endif>
                                                    <label class="custom-control-label" for="isChocolate">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isChocolate2" name="isChocolate" value="0" class="custom-control-input" @if(!$store->isChocolate) checked @endif>
                                                    <label class="custom-control-label" for="isChocolate2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isTakePhoto" class="col-md-6 col-form-label">Fotoğraf için dekor</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isTakePhoto" name="isTakePhoto" value="1" class="custom-control-input" @if($store->isTakePhoto) checked @endif>
                                                    <label class="custom-control-label" for="isTakePhoto">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isTakePhoto2" name="isTakePhoto" value="0" class="custom-control-input" @if(!$store->isTakePhoto) checked @endif>
                                                    <label class="custom-control-label" for="isTakePhoto2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isSelfService" class="col-md-6 col-form-label">Self-servis</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isSelfService" name="isSelfService" value="1" class="custom-control-input" @if($store->isSelfService) checked @endif>
                                                    <label class="custom-control-label" for="isSelfService">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isSelfService2" name="isSelfService" value="0" class="custom-control-input" @if(!$store->isSelfService) checked @endif>
                                                    <label class="custom-control-label" for="isSelfService2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isTea" class="col-md-6 col-form-label">Çay</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isTea" name="isTea" value="1" class="custom-control-input" @if($store->isTea) checked @endif>
                                                    <label class="custom-control-label" for="isTea">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isTea2" name="isTea" value="0" class="custom-control-input" @if(!$store->isTea) checked @endif>
                                                    <label class="custom-control-label" for="isTea2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="isLiveMusic" class="col-md-6 col-form-label">Canlı müzik</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isLiveMusic" name="isLiveMusic" value="1" class="custom-control-input" @if($store->isLiveMusic) checked @endif>
                                                    <label class="custom-control-label" for="isLiveMusic">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isLiveMusic2" name="isLiveMusic" value="0" class="custom-control-input" @if(!$store->isLiveMusic) checked @endif>
                                                    <label class="custom-control-label" for="isLiveMusic2">Olumsuz</label>
                                                </div>
                                            </div>

                                            <div class="offset-md-6">
                                                <input type="submit" class="btn btn-primary" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <form enctype="multipart/form-data" method="post" action="/adminpanel/magazakapakguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">
                                            <div class="form-group">
                                                <label for="image">Kapak fotoğrafı güncelle</label>
                                                <input type="file" id="image" name="image" data-max-file-size="1M" required data-show-loader="true" data-allowed-formats="square" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                            </div>
                                            <div class="offset-md-0">
                                                <input type="submit" class="btn btn-primary" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="ayarlar">
                            <div class="row">
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/magazaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">

                                            <div class="form-group row">
                                                <label for="canTakeTakeAwayOrder" class="col-md-6 col-form-label">Al-götür</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="canTakeTakeAwayOrder" name="canTakeTakeAwayOrder" value="1" class="custom-control-input" @if($store->canTakeTakeAwayOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeTakeAwayOrder">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="canTakeTakeAwayOrder2" name="canTakeTakeAwayOrder" value="0" class="custom-control-input" @if(!$store->canTakeTakeAwayOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeTakeAwayOrder2">Kapalı</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="canTakeLocalDeliveryOrder" class="col-md-6 col-form-label">Şehiriçi teslimat</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="canTakeLocalDeliveryOrder" name="canTakeLocalDeliveryOrder" value="1" class="custom-control-input" @if($store->canTakeLocalDeliveryOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeLocalDeliveryOrder">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="canTakeLocalDeliveryOrder2" name="canTakeLocalDeliveryOrder" value="0" class="custom-control-input" @if(!$store->canTakeLocalDeliveryOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeLocalDeliveryOrder2">Kapalı</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="canTakeLocalCargoOrder" class="col-md-6 col-form-label">Şehiriçi kargo</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="canTakeLocalCargoOrder" name="canTakeLocalCargoOrder" value="1" class="custom-control-input" @if($store->canTakeLocalCargoOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeLocalCargoOrder">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="canTakeLocalCargoOrder2" name="canTakeLocalCargoOrder" value="0" class="custom-control-input" @if(!$store->canTakeLocalCargoOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeLocalCargoOrder2">Kapalı</label>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="canTakeUpstateCargoOrder" class="col-md-6 col-form-label">Şehirdışı kargo</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="canTakeUpstateCargoOrder" name="canTakeUpstateCargoOrder" value="1" class="custom-control-input" @if($store->canTakeUpstateCargoOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeUpstateCargoOrder">Açık</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="canTakeUpstateCargoOrder2" name="canTakeUpstateCargoOrder" value="0" class="custom-control-input" @if(!$store->canTakeUpstateCargoOrder) checked @endif>
                                                    <label class="custom-control-label" for="canTakeUpstateCargoOrder2">Kapalı</label>
                                                </div>
                                            </div>


                                            <div class="offset-md-6">
                                                <input type="submit" class="btn btn-primary mr-1" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/magazaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">
                                            <div class="form-group row">
                                                <label for="isActive" class="col-md-6 col-form-label">Aktiflik</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isActive" name="isActive" value="1" class="custom-control-input" @if($store->isActive) checked @endif>
                                                    <label class="custom-control-label" for="isActive">Aktif</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isActive2" name="isActive" value="0" class="custom-control-input" @if(!$store->isActive) checked @endif>
                                                    <label class="custom-control-label" for="isActive2">Pasif</label>
                                                </div>
                                            </div>
                                            <div class="offset-md-6">
                                                <input type="submit" class="btn btn-primary mr-1" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                    <form class="mt-3" method="post" action="/adminpanel/magazaguncelle">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">

                                            <div class="form-group row">
                                                <label for="isCafe" class="col-md-6 col-form-label">Kafe mi?</label>
                                                <div class="custom-control custom-radio mt-2">
                                                    <input type="radio" id="isCafe" name="isCafe" value="1" class="custom-control-input" @if($store->isCafe) checked @endif>
                                                    <label class="custom-control-label" for="isCafe">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isCafe2" name="isCafe" value="0" class="custom-control-input" @if(!$store->isCafe) checked @endif>
                                                    <label class="custom-control-label" for="isCafe2">Olumsuz</label>
                                                </div>
                                            </div>



                                            <div class="offset-md-6">
                                                <input type="submit" class="btn btn-primary mr-1" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <div class="col-xl-4">
                                    <form method="post" action="/adminpanel/magazakullanicidegistir">
                                        @csrf
                                        <fieldset>
                                            <input type="hidden" name="storeID" value="{{$store->id}}">
                                            <div class="form-group row">
                                                <label for="userID" class="col-md-4 col-form-label">Yönetici</label>
                                                <div class="col-md-8">
                                                    <select data-plugin="customselect" name="userID" id="userID" class="form-control" required>
                                                        <option value="0" @if($store->email == 'ownerless-store@kafeyinapp.com') selected @endif >Sahipsiz</option>
                                                        @foreach($storeUsers as $storeUser)
                                                            <option value="{{$storeUser->id}}" @if($store->email == $storeUser->email) selected @endif >#{{$storeUser->id}} - {{$storeUser->name}} {{$storeUser->surname}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="offset-md-4">
                                                <input type="submit" class="btn btn-primary ml-2" value="Güncelle">
                                            </div>
                                        </fieldset>
                                    </form>
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
                    <div class="row">
                        <div class="col-6">
                            <h6 class="header-title mb-4">Kapak fotoğrafı</h6>
                            <div class="media pt-0">
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <div class="popup-gallery" data-source="{{$store->coverImageLink}}">
                                            <a href="{{$store->coverImageLink}}" title="">
                                                <img src="{{$store->coverImageLink}}" alt="img" class="avatar-xxl rounded">
                                            </a>
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="header-title mb-4">Logo</h6>
                            <div class="media pt-0">
                                <div class="table-responsive table-hover">
                                    <table class="table m-0">
                                        <tbody>
                                        <div class="popup-gallery" data-source="{{$store->brand->logo}}">
                                            <a href="{{$store->brand->logo}}" title="">
                                                <img src="{{$store->brand->logo}}" alt="img" class="avatar-xxl rounded">
                                            </a>
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Bağlantılar</h6>
                    <div class="media pt-0">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/yorumlar">Yorumlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/fotograflar">Fotoğraflar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/kafeyinfotograflar">Kafeyin Fotoğraflar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/paylasimlar">Paylaşımlar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/yazilar">Yazılar</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/etkinlikler">Etkinlikler</a></td>
                                </tr>
                                <tr>
                                    <td><a href="/adminpanel/magazalar/{{$store->id}}/urunler">Ürünler</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Marka bilgileri</h6>
                    <div class="media border-top pt-3">
                        <img src="{{$store->brand->logo}}" class="avatar rounded mr-3" alt="logo">
                        <div class="media-body">
                            <h6 class="mt-1 mb-0 font-size-15">{{$store->brand->name}}</h6>
                            @if($store->brand->isPremium)
                                <span class="badge badge-soft-success">Premium plan</span>
                            @else
                                <span class="badge badge-soft-danger">Temel plan</span>
                            @endif
                        </div>
                        <div class="dropdown align-self-center float-right">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="uil uil-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="/adminpanel/markalar/{{$store->brand->id}}" class="dropdown-item"><i
                                        class="uil uil-eye mr-2"></i>Görüntüle</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Mağaza yöneticisi</h6>
                    <div class="media border-top pt-3">
                        @if($store->yonetici)
                            <img src="{{$store->yonetici->avatar}}" class="avatar rounded-circle mr-3" alt="logo">
                            <div class="media-body">
                                <h6 class="mt-1 mb-0 font-size-15">#{{$store->yonetici->id}} - {{$store->yonetici->name}} {{$store->yonetici->surname}}</h6>
                                <h6 class="text-muted font-weight-normal mt-1 mb-3">{{$store->yonetici->email}}</h6>
                            </div>
                            <div class="dropdown align-self-center float-right">
                                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                                   aria-expanded="false">
                                    <i class="uil uil-ellipsis-v"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="/adminpanel/kullanicilar/magaza/{{$store->yonetici->id}}" class="dropdown-item"><i
                                            class="uil uil-eye mr-2"></i>Görüntüle</a>

                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                Mağazanın bir yöneticisi bulunmamaktadır.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body pt-2">
                    <h6 class="header-title mb-4">Sipariş alma bilgileri</h6>
                    <div class="media border-top pt-3">
                        <div class="table-responsive table-hover">
                            <table class="table m-0">
                                <tbody>
                                <tr>
                                    @if($store->canTakeTakeAwayOrder)
                                        <th scope="row">Al-götür<span class="badge badge-success ml-5">Açık</span></th>
                                    @else
                                        <th scope="row">Al-götür<span class="badge badge-danger ml-5">Kapalı</span></th>
                                    @endif
                                </tr>
                                <tr>
                                    @if($store->canTakeLocalDeliveryOrder)
                                        <th scope="row">Şehiriçi teslimat<span class="badge badge-success ml-5">Açık</span></th>
                                    @else
                                        <th scope="row">Şehiriçi teslimat<span class="badge badge-danger ml-5">Kapalı</span></th>
                                    @endif
                                </tr>
                                <tr>
                                    @if($store->canTakeLocalCargoOrder)
                                        <th scope="row">Şehiriçi kargo<span class="badge badge-success ml-5">Açık</span></th>
                                    @else
                                        <th scope="row">Şehiriçi kargo<span class="badge badge-danger ml-5">Kapalı</span></th>
                                    @endif
                                </tr>
                                <tr>
                                    @if($store->canTakeUpstateCargoOrder)
                                        <th scope="row">Şehirdışı kargo<span class="badge badge-success ml-5">Açık</span></th>
                                    @else
                                        <th scope="row">Şehirdışı kargo<span class="badge badge-danger ml-5">Kapalı</span></th>
                                    @endif
                                </tr>
                                </tbody>
                            </table>
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
        $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
            $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
        } );
        @if (session('stUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Mağaza bilgileri güncellenmiştir.',
                type: "success",
            });
        @elseif(session('sameUser'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Aynı kullanıcıyı seçtiniz.',
                type: "warning",
            });
        @elseif(session('alreadyStoreUser'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz kullanıcı zaten bir mağaza yöneticisi.',
                type: "warning",
            });
        @elseif(session('fileErr'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz dosya ile ilgili bir problem oluştu.',
                type: "warning",
            });
        @elseif(session('coverUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Kapak fotoğrafı güncellendi.',
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
