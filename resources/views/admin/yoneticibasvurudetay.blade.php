@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Başvurular</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/basvurular/yonetici">Yönetici Başvuruları</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Başvuru #{{$application->id}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Başvuru #{{$application->id}} Detay</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <h5 class="header-title mb-2 mt-0">Marka</h5>
                            <p class="mb-0">#{{$application->brand->id}} - {{$application->brand->name}}</p>
                            @if($detail["brandManagerEmailSent"] ?? false)
                                <p class="m-0">Bilgi e-postası: <text class="text-success font-weight-bold">Gönderildi.</text> </p>
                                <div class="accordion custom-accordionwitharrow mt-2 mb-2" id="akordiyonBrandPreUser">
                                    <div class="card mb-0 shadow-none border">
                                        <a href="" class="text-dark collapsed" data-toggle="collapse" data-target="#collapsePreBrandUser"
                                           aria-expanded="false" aria-controls="collapsePreBrandUser">
                                            <div class="card-header bg-light" id="headerPreBrandUser">
                                                <h5 class="m-0 font-size-16 text-blackish"> PreRegisteredStoreUser<i class="uil uil-angle-down float-right accordion-arrow"></i></h5>
                                            </div>
                                        </a>

                                        <div id="collapsePreBrandUser" class="collapse bg-light" aria-labelledby="headerPreBrandUser"
                                             data-parent="#akordiyonBrandPreUser">
                                            <div class="card-body text-muted pt-0">
                                                @if(\App\Models\PreRegisteredStoreUser::where('email',$detail['brandManagerEmail'])->exists())
                                                    <a class="btn btn-sm btn-primary mb-2 mt-0 sa-preregstoreusersil" data-id="{{\App\Models\PreRegisteredStoreUser::where('email',$detail['brandManagerEmail'])->first()->id}}" type="button" href="javascript:void(0);">Ön kullanıcıyı sil</a>
                                                    @foreach(\App\Models\PreRegisteredStoreUser::where('email',$detail['brandManagerEmail'])->first()->toArray() as $key => $value)
                                                        <li>
                                                            {{$key}}: {{$value}}
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="m-0">Bilgi e-postası: <text class="text-danger font-weight-bold">Henüz gönderilmedi.</text> </p>
                            @endif
                            @if($detail["brandManagerAccountCreated"] ?? false)
                                <p class="mb-0">Yönetici hesabı: <text class="text-success font-weight-bold">Oluşturuldu.</text> </p>
                                <div class="accordion custom-accordionwitharrow mt-2 mb-2" id="akordiyonBrandManager">
                                    <div class="card mb-0 shadow-none border">
                                        <a href="" class="text-dark collapsed" data-toggle="collapse" data-target="#collapseBrandManager"
                                           aria-expanded="false" aria-controls="collapseBrandManager">
                                            <div class="card-header bg-light" id="headerBrandManager">
                                                <h5 class="m-0 font-size-16 text-blackish"> User<i
                                                        class="uil uil-angle-down float-right accordion-arrow"></i>
                                                </h5>
                                            </div>
                                        </a>

                                        <div id="collapseBrandManager" class="collapse bg-light" aria-labelledby="headerBrandManager"
                                             data-parent="#akordiyonBrandManager">
                                            <div class="card-body text-muted">
                                                @if(\App\Models\User::where('email',$detail['brandManagerEmail'])->exists())
                                                    @foreach(\App\Models\User::where('email',$detail['brandManagerEmail'])->first()->toArray() as $key => $value)
                                                        <li>
                                                            {{$key}}: {{$value}}
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="mb-3">Yönetici hesabı: <text class="text-danger font-weight-bold">Henüz oluşturulmadı.</text> </p>
                            @endif
                            @if(count($application->brand->stores) > 1)
                                <h5 class="header-title mb-2 mt-4">Mağazalar</h5>
                            @else
                                <h5 class="header-title mb-2 mt-4">Mağaza</h5>
                            @endif
                            @foreach($application->brand->stores as $store)
                                <p class="m-0 mt-3">#{{$store->id}} - {{$store->name}}</p>
                                @if($detail["storeManagerEmailSent".$store->id] ?? false)
                                    <p class="m-0">Bilgi e-postası: <text class="text-success font-weight-bold">Gönderildi.</text> </p>
                                    <div class="accordion custom-accordionwitharrow mt-2 mb-2" id="akordiyonStorePreUser{{$store->id}}">
                                        <div class="card mb-0 shadow-none border">
                                            <a href="" class="text-dark collapsed" data-toggle="collapse" data-target="#collapeStorePreUser{{$store->id}}"
                                               aria-expanded="false" aria-controls="collapeStorePreUser{{$store->id}}">
                                                <div class="card-header bg-light" id="headerStorePreUser{{$store->id}}">
                                                    <h5 class="m-0 font-size-16 text-blackish"> PreRegisteredStoreUser<i
                                                            class="uil uil-angle-down float-right accordion-arrow"></i>
                                                    </h5>
                                                </div>
                                            </a>

                                            <div id="collapeStorePreUser{{$store->id}}" class="collapse bg-light" aria-labelledby="headerStorePreUser{{$store->id}}"
                                                 data-parent="#akordiyonStorePreUser{{$store->id}}">
                                                <div class="card-body text-muted">
                                                    @if($detail['ownerIsManager'.$store->id]??false)
                                                        @if(\App\Models\PreRegisteredStoreUser::where('email',$detail['storeOwnerEmail'.$store->id])->exists())
                                                            <a class="btn btn-sm btn-primary mb-2 mt-0 sa-preregstoreusersil" data-id="{{\App\Models\PreRegisteredStoreUser::where('email',$detail['storeOwnerEmail'.$store->id])->first()->id}}" type="button" href="javascript:void(0);">Ön kullanıcıyı sil</a>
                                                            @foreach(\App\Models\PreRegisteredStoreUser::where('email',$detail['storeOwnerEmail'.$store->id])->first()->toArray() as $key => $value)
                                                                <li>
                                                                    {{$key}}: {{$value}}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        @if(\App\Models\PreRegisteredStoreUser::where('email',$detail['storeManagerEmail'.$store->id])->exists())
                                                            <a class="btn btn-sm btn-primary mb-2 mt-0 sa-preregstoreusersil" data-id="{{\App\Models\PreRegisteredStoreUser::where('email',$detail['storeManagerEmail'.$store->id])->first()->id}}" type="button" href="javascript:void(0);">Ön kullanıcıyı sil</a>
                                                            @foreach(\App\Models\PreRegisteredStoreUser::where('email',$detail['storeManagerEmail'.$store->id])->first()->toArray() as $key => $value)
                                                                <li>
                                                                    {{$key}}: {{$value}}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="m-0">Bilgi e-postası: <text class="text-danger font-weight-bold">Henüz gönderilmedi.</text> </p>
                                @endif
                                @if($detail["storeManagerAccountCreated".$store->id] ?? false)
                                    <p class="m-0">Yönetici hesabı: <text class="text-success font-weight-bold">Oluşturuldu.</text> </p>
                                    <div class="accordion custom-accordionwitharrow mt-2 mb-2" id="akordiyonStoreManager{{$store->id}}">
                                        <div class="card mb-0 shadow-none border">
                                            <a href="" class="text-dark collapsed" data-toggle="collapse" data-target="#collapseStoreManager{{$store->id}}"
                                               aria-expanded="false" aria-controls="collapseStoreManager{{$store->id}}">
                                                <div class="card-header bg-light" id="headerStoreManager{{$store->id}}">
                                                    <h5 class="m-0 font-size-16 text-blackish"> User<i
                                                            class="uil uil-angle-down float-right accordion-arrow"></i>
                                                    </h5>
                                                </div>
                                            </a>

                                            <div id="collapseStoreManager{{$store->id}}" class="collapse bg-light" aria-labelledby="headerStoreManager{{$store->id}}"
                                                 data-parent="#akordiyonStoreManager{{$store->id}}">
                                                <div class="card-body text-muted">
                                                    @if($detail['ownerIsManager'.$store->id]??false)
                                                        @if(\App\Models\User::where('email',$detail['storeOwnerEmail'.$store->id])->exists())
                                                            @foreach(\App\Models\User::where('email',$detail['storeOwnerEmail'.$store->id])->first()->toArray() as $key => $value)
                                                                <li>
                                                                    {{$key}}: {{$value}}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @else
                                                        @if(\App\Models\User::where('email',$detail['storeManagerEmail'.$store->id])->exists())
                                                            @foreach(\App\Models\User::where('email',$detail['storeManagerEmail'.$store->id])->first()->toArray() as $key => $value)
                                                                <li>
                                                                    {{$key}}: {{$value}}
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="m-0">Yönetici hesabı: <text class="text-danger font-weight-bold">Henüz oluşturulmadı.</text> </p>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-xl-6">
                            @foreach ($detail as $key => $value)
                                <li>{{ $key }}: {{ $value }}</li>
                            @endforeach
                            <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#ilkBasvuruDuzenleModal" class="btn btn-sm btn-primary mt-2">Düzenle</a>
                            <div class="modal fade" id="ilkBasvuruDuzenleModal" tabindex="-1" role="dialog"
                                 aria-labelledby="ilkBasvuruDuzenleModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ilkBasvuruDuzenleModal">İlk Başvuru Detayı Güncelle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/ilkbasvuruduzenle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="applicationID" value="{{$application->id}}">
                                                    <div class="form-group mt-0">
                                                        <label for="detail" class="col-form-label">Detay</label>
                                                        <textarea type="text" rows="25" name="detail" required class="form-control" id="detail"
                                                                  placeholder="Detay">
                                                            {@foreach($detail as $key => $value)
                                                                "{{$key}}":"{{$value}}",
                                                            @endforeach}
                                                        </textarea>
                                                    </div>
                                                    <input type="submit" class="btn btn-primary " value="Güncelle">
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
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <a href="javascript:void(0);" type="button" class="btn btn-sm btn-success w-100 sa-yoneticibasvuruapprove mb-3" data-id="{{$application->id}}">Durum: Onayla</a>
                        </div>
                        <div class="col-xl-4">
                            <a href="javascript:void(0);" type="button" class="btn btn-sm btn-danger w-100 sa-yoneticibasvurureject mb-3" data-id="{{$application->id}}">Durum: Reddedildi</a>
                        </div>
                        <div class="col-xl-4">
                            <a href="javascript:void(0);" type="button" class="btn btn-sm btn-primary w-100 sa-yoneticibasvurupending mb-3" data-id="{{$application->id}}">Durum: İnceleniyor</a>
                        </div>
                    </div>
                    <h5 class="card-title font-size-16">PreRegisteredStoreUser oluştur ve bilgi e-postası gönder</h5>
                    <div class="media pt-0">
                        <form method="post" action="/adminpanel/preregisteredstoreuserolustur" class="col-12">
                            @csrf
                            <fieldset>
                                <input type="hidden" name="applicationID" value="{{$application->id}}">
                                <div class="form-group row">
                                    <label for="isBrandManager" class="col-md-4 col-form-label">isBrandManager</label>
                                    <div class="custom-control custom-radio mt-2 ml-2">
                                        <input type="radio" id="isBrandManager" name="isBrandManager" value="1"
                                               class="custom-control-input" @if($detail['brandManagerEmailSent']??false) disabled @endif >
                                        <label class="custom-control-label" for="isBrandManager" >Olumlu</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-4 mt-2">
                                        <input type="radio" id="isBrandManager2" name="isBrandManager" value="0"
                                               class="custom-control-input" @if($detail['brandManagerEmailSent']??false) checked @endif >
                                        <label class="custom-control-label" for="isBrandManager2">Olumsuz</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="brandID" class="col-md-4 col-form-label">Marka ID</label>
                                    <div class="col-md-8">
                                        <input type="text" name="brandID" readonly class="form-control" id="brandID"
                                               placeholder="Marka ID" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="isStoreManager" class="col-md-4 col-form-label">isStoreManager</label>
                                    <div class="custom-control custom-radio mt-2 ml-2">
                                        <input type="radio" id="isStoreManager" name="isStoreManager" value="1"
                                               class="custom-control-input" >
                                        <label class="custom-control-label" for="isStoreManager" >Olumlu</label>
                                    </div>
                                    <div class="custom-control custom-radio ml-4 mt-2">
                                        <input type="radio" id="isStoreManager2" name="isStoreManager" value="0"
                                               class="custom-control-input"  >
                                        <label class="custom-control-label" for="isStoreManager2">Olumsuz</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="storeID" class="col-md-4 col-form-label">Mağaza ID</label>
                                    <div class="col-md-8">
                                        <input type="text" name="storeID" class="form-control" id="storeID"
                                               placeholder="Mağaza ID" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label">Ad</label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" required class="form-control" id="name"
                                               placeholder="Ad" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="surname" class="col-md-4 col-form-label">Soyad</label>
                                    <div class="col-md-8">
                                        <input type="text" name="surname" required class="form-control" id="surname"
                                               placeholder="Soyad" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label">E-posta adresi</label>
                                    <div class="col-md-8">
                                        <input type="text" name="email" required class="form-control" id="email"
                                               placeholder="E-posta adresi" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gsmNumber" class="col-md-4 col-form-label">GSM</label>
                                    <div class="col-md-8">
                                        <input type="text" name="gsmNumber" required class="form-control" id="gsmNumber"
                                               placeholder="GSM" >
                                    </div>
                                </div>

                                <div class="offset-md-4">
                                    <input type="submit" class="btn btn-primary ml-2" value="Devam">
                                </div>
                            </fieldset>
                        </form>
                    </div>
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
    <script>
        @if (session('statUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Başvuru durumu güncellendi.',
            type: "success",
        });
        @elseif($errors->any())
        swal.fire({
            title: 'Hata!',
            text: "{{$errors->first('hata')}}",
            type: "error",
        });
        @elseif (session('emailSent'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Ön kullanıcı oluşturuldu ve bilgi e-postası gönderildi.',
            type: "success",
        });
        @elseif (session('basUpup'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Başvuru detayı güncellendi.',
            type: "success",
        });
        @elseif (session('puserdel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'PreRegisteredStoreUser silindi.',
            type: "success",
        });
        @endif
    </script>
    <script type="text/javascript">

        $("#isBrandManager").change(function (){
            if($("#isBrandManager").val()){
                $("#brandID").val("{{$detail['brandID']}}");
            }
        });
        $("#isBrandManager2").change(function (){
            if($("#isBrandManager2").val()){
                $("#brandID").val("");
            }
        });
        $("#isStoreManager").change(function (){
            if($("#isStoreManager").val()){
                document.getElementById("storeID").readOnly = false;
            }
        });
        $("#isStoreManager2").change(function (){
            if($("#isStoreManager2").val()){
                $("#storeID").val("");
                document.getElementById("storeID").readOnly = true;
            }
        });

    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
