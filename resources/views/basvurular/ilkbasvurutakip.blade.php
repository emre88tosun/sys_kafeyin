@extends('layouts.non-auth')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.css') }}" type="text/css"/>
@endsection

@section('content')

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="col-md-12 p-5">
                                <div class="mb-4">
                                    <a href="#">
                                        <img src="/assets/images/logo.png" alt="logo" height="36"/>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h4 class="">İlk Başvuru Takibi</h4>
                                        <p class="text-muted  mb-0">Başvuru referans kodu: <text class="text-primary font-weight-bold">{{$detail['referral']}}</text> </p>
                                        @if($detail['status'] == 'need_approval')
                                            <p class="text-muted  mb-0">Başvuru durumu: <text class="text-primary font-weight-bold"> İnceleniyor</text> </p>
                                        @elseif($detail['status'] == 'approved')
                                            <p class="text-muted font-weight-bold mb-0">Başvuru durumu: <text class="text-success font-weight-bold"> Onaylandı</text> </p>
                                        @else
                                            <p class="text-muted font-weight-bold mb-0">Başvuru durumu: <text class="text-danger font-weight-bold"> Bir hata oluştu. Lütfen destek@kafeyinapp.com e-posta adresi üzerinden bizimle iletişime geçiniz.</text> </p>
                                        @endif
                                        <h5 class=" mt-3 mb-1 text-blackish">Marka Bilgileri</h5>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <p class="m-0">Marka adı: <text class="text-primary font-weight-bold">{{$application->brand->name}}</text> </p>
                                            </div>
                                            <div class="col-xl-6">
                                                <p class="m-0">Marka ID: <text class="text-primary font-weight-bold">MRK88{{$application->brand->id}}</text> </p>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-xl-6">
                                                <p class="m-0">Yönetici adı-soyadı: <text class="text-primary font-weight-bold">{{ucfirst($detail['brandManagerName'])}} {{ucfirst($detail['brandManagerSurname'])}}</text> </p>
                                            </div>
                                            <div class="col-xl-6">
                                                <p class="m-0">Yönetici GSM numarası: <text class="text-primary font-weight-bold">+90 {{$detail['brandManagerGSM']}}</text> </p>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-xl-12">
                                                <p class="m-0">Yönetici e-posta adresi: <text class="text-primary font-weight-bold">{{$detail['brandManagerEmail']}}</text> </p>
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-xl-12">
                                                @if($detail["brandManagerEmailSent"] ?? false)
                                                    <p class="m-0">Bilgi e-postası: <text class="text-success font-weight-bold">Gönderildi.</text> </p>
                                                @else
                                                    <p class="m-0">Bilgi e-postası: <text class="text-danger font-weight-bold">Henüz gönderilmedi.</text> </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-0">
                                            <div class="col-xl-12">
                                                @if($detail["brandManagerAccountCreated"] ?? false)
                                                    <p class="m-0">Yönetici hesabı: <text class="text-success font-weight-bold">Oluşturuldu.</text> </p>
                                                @else
                                                    <p class="m-0">Yönetici hesabı: <text class="text-danger font-weight-bold">Henüz oluşturulmadı.</text> </p>
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                        @foreach($application->brand->stores as $store)
                                            <h5 class=" mt-3 mb-1 text-blackish">KFYN{{$store->id}} - Mağaza Bilgileri</h5>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <p class="m-0">Mağaza adı: <text class="text-primary font-weight-bold">{{$store->name}}</text> </p>
                                                </div>
                                                <div class="col-xl-6">
                                                    <p class="m-0">Mağaza ID: <text class="text-primary font-weight-bold">KFYN{{$store->id}}</text> </p>
                                                </div>
                                            </div>
                                            <div class="row mt-0">
                                                <div class="col-xl-6">
                                                    @if($detail["ownerIsManager".$store->id] ?? false)
                                                        <p class="m-0">Yönetici adı-soyadı: <text class="text-primary font-weight-bold">{{ucfirst($detail['storeOwnerName'.$store->id])}} {{ucfirst($detail['storeOwnerSurname'.$store->id])}}</text> </p>
                                                    @else
                                                        <p class="m-0">Yönetici adı-soyadı: <text class="text-primary font-weight-bold">{{ucfirst($detail['storeManagerName'.$store->id])}} {{ucfirst($detail['storeManagerName'.$store->id])}}</text> </p>
                                                    @endif
                                                </div>
                                                <div class="col-xl-6">
                                                    @if($detail["ownerIsManager".$store->id] ?? false)
                                                        <p class="m-0">Yönetici GSM numarası: <text class="text-primary font-weight-bold">+90 {{$detail['storeOwnerGSM'.$store->id]}}</text> </p>
                                                    @else
                                                        <p class="m-0">Yönetici GSM numarası: <text class="text-primary font-weight-bold">+90 {{$detail['storeManagerGSM'.$store->id]}}</text> </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-0">
                                                <div class="col-xl-12">
                                                    @if($detail["ownerIsManager".$store->id] ?? false)
                                                        <p class="m-0">Yönetici e-posta adresi: <text class="text-primary font-weight-bold">{{$detail['storeOwnerEmail'.$store->id]}}</text> </p>
                                                    @else
                                                        <p class="m-0">Yönetici e-posta adresi: <text class="text-primary font-weight-bold">{{$detail['storeManagerEmail'.$store->id]}}</text> </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-0">
                                                <div class="col-xl-12">
                                                    @if($detail["storeManagerEmailSent".$store->id] ?? false)
                                                        <p class="m-0">Bilgi e-postası: <text class="text-success font-weight-bold">Gönderildi.</text> </p>
                                                    @else
                                                        <p class="m-0">Bilgi e-postası: <text class="text-danger font-weight-bold">Henüz gönderilmedi.</text> </p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-0">
                                                <div class="col-xl-12">
                                                    @if($detail["storeManagerAccountCreated".$store->id] ?? false)
                                                        <p class="m-0">Yönetici hesabı: <text class="text-success font-weight-bold">Oluşturuldu.</text> </p>
                                                    @else
                                                        <p class="m-0">Yönetici hesabı: <text class="text-danger font-weight-bold">Henüz oluşturulmadı.</text> </p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if (!$loop->last)
                                                <hr>
                                            @endif

                                        @endforeach
                                    </div>
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
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
