@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">PreRegisteredStoreUsers</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">PreRegisteredStoreUsers</h4>
            <a type="button" class="btn btn-sm btn-primary" href="javascript:void(0);" data-toggle="modal"
               data-target="#pUserEkleModal">PreRegisteredStoreUser ekle</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün ön kullanıcılar</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Referans Kodu</th>
                            <th>E-posta</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Güncellenme Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pusers as $puser)
                            <tr>
                                <th scope="row">{{$puser->id}}</th>
                                <td>{{$puser->referralCode}}</td>
                                <td>{{$puser->email}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($puser->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($puser->updated_at)->format('d/m/Y H:i')}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false">İşlemler <i
                                                class="icon"><span
                                                    data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @if($puser->ilkbasvuru)
                                                <a href="javascript:void(0);" type="button" class="dropdown-item"
                                                   data-toggle="modal" data-target="#puserilkbasvuru{{$puser->id}}">Başvuru</a>
                                            @endif
                                            <a href="javascript:void(0);" type="button" class="dropdown-item"
                                               data-toggle="modal" data-target="#puserdetail{{$puser->id}}">Detay</a>
                                            @if(!$puser->ilkbasvuru)
                                                <a href="javascript:void(0);" type="button" class="dropdown-item sa-puserdel" data-id="{{$puser->id}}">Sil</a>
                                            @endif
                                            @if($puser->user)
                                                <a href="javascript:void(0);" type="button" class="dropdown-item"
                                                   data-toggle="modal" data-target="#puserkullanici{{$puser->id}}">Kullanıcı</a>
                                            @endif
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($pusers as $puser)
                        @if($puser->ilkbasvuru)
                            <div class="modal fade" id="puserilkbasvuru{{$puser->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="puserilkbasvuru{{$puser->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="puserilkbasvuru{{$puser->id}}">Ön kullanıcı ilk
                                                başvuru detay</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach(json_decode($puser->ilkbasvuru,true) as $key => $value)
                                                <li>{{$key}}: {{$value}}</li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($puser->user)
                            <div class="modal fade" id="puserkullanici{{$puser->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="puserkullanici{{$puser->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="puserkullanici{{$puser->id}}">Ön kullanıcı User
                                                model</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach(json_decode($puser->user) as $key => $value)
                                                <li>{{$key}}: {{$value}}</li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="modal fade" id="puserdetail{{$puser->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="puserdetail{{$puser->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="puserdetail{{$puser->id}}">Ön kullanıcı detay</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @foreach(json_decode($puser->first()) as $key => $value)
                                            <li>{{$key}}: {{$value}}</li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                    <div class="modal fade" id="pUserEkleModal" tabindex="-1" role="dialog"
                         aria-labelledby="pUserEkleModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pUserEkleModal">PreRegisteredStoreUser ekle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="/adminpanel/puserekle">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group row">
                                                <label for="isBrandManager" class="col-md-4 col-form-label">isBrandManager</label>
                                                <div class="custom-control custom-radio mt-2 ml-2">
                                                    <input type="radio" id="isBrandManager" name="isBrandManager"
                                                           value="1"
                                                           class="custom-control-input">
                                                    <label class="custom-control-label"
                                                           for="isBrandManager">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isBrandManager2" name="isBrandManager"
                                                           value="0"
                                                           class="custom-control-input">
                                                    <label class="custom-control-label"
                                                           for="isBrandManager2">Olumsuz</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="brandID" class="col-md-4 col-form-label">Marka ID</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="brandID" class="form-control" id="brandID"
                                                           placeholder="Marka ID">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="isStoreManager" class="col-md-4 col-form-label">isStoreManager</label>
                                                <div class="custom-control custom-radio mt-2 ml-2">
                                                    <input type="radio" id="isStoreManager" name="isStoreManager"
                                                           value="1"
                                                           class="custom-control-input">
                                                    <label class="custom-control-label"
                                                           for="isStoreManager">Olumlu</label>
                                                </div>
                                                <div class="custom-control custom-radio ml-4 mt-2">
                                                    <input type="radio" id="isStoreManager2" name="isStoreManager"
                                                           value="0"
                                                           class="custom-control-input">
                                                    <label class="custom-control-label"
                                                           for="isStoreManager2">Olumsuz</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="storeID" class="col-md-4 col-form-label">Mağaza ID</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="storeID" class="form-control" id="storeID"
                                                           placeholder="Mağaza ID">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="name" required class="form-control"
                                                           id="name"
                                                           placeholder="Ad">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="surname" class="col-md-4 col-form-label">Soyad</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="surname" required class="form-control"
                                                           id="surname"
                                                           placeholder="Soyad">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email" class="col-md-4 col-form-label">E-posta
                                                    adresi</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="email" required class="form-control"
                                                           id="email"
                                                           placeholder="E-posta adresi">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gsmNumber" class="col-md-4 col-form-label">GSM</label>
                                                <div class="col-md-8">
                                                    <input type="text" name="gsmNumber" required class="form-control"
                                                           id="gsmNumber"
                                                           placeholder="GSM">
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
                </div>
            </div>

        </div>

    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script>
        @if (session('referraladd'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Referral eklendi.',
            type: "success",
        });
        @elseif(session('referralcodeup'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Referralcode güncellendi.',
            type: "success",
        });
        @elseif($errors->any())
        swal.fire({
            title: 'Hata!',
            text: "{{$errors->first('hata')}}",
            type: "error",
        });
        @elseif(session('referralup'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Referral güncellendi.',
            type: "success",
        });
        @elseif(session('puserdel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Ön kullanıcı silindi.',
            type: "success",
        });
        @elseif(session('emailSent'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Ön kullanıcı oluşturuldu, bilgi e-postası gönderildi.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
