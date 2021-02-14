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
                    <li class="breadcrumb-item disabled" aria-current="page">Markam</li>
                    <li class="breadcrumb-item active" aria-current="page">Marka Bilgileri</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>

        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-5">
                            <h5 class="header-title mb-3 mt-0">Markanıza ait bilgiler</h5>
                            <div class="table-responsive table-hover">
                                <table class="table m-0">
                                    <tbody>
                                    <tr>
                                        <th scope="row">Logo</th>
                                        <td class="float-right">
                                            <div class="popup-gallery m-0" data-source="{{$user->brand->logo}}">
                                                <a href="{{$user->brand->logo}}" title="">
                                                    <img src="{{$user->brand->logo}}" alt="img" class="avatar-xxl rounded">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">ID</th>
                                        <td class="float-right">MRK88{{$user->brand->id}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Ad</th>
                                        <td class="float-right">{{$user->brand->name}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" >Damga sayısı <i class="uil-info-circle" data-toggle="tooltip" data-placement="top" title="Markanız için oluşturulan sadakat kartlarının tamamlanması için gereken damga sayısı"></i></th>
                                        <td class="float-right">{{$user->brand->needStampCount}}</td>
                                    </tr>
                                    @if($isPremiumPlanEnabled)
                                        <tr>
                                            <th scope="row">Plan</th>
                                            @if($user->brand->isPremium)
                                                <td class="float-right"><span class="badge badge-soft-success">Premium plan</span></td>
                                            @else
                                                <td class="float-right"><span class="badge badge-soft-danger">Temel plan</span></td>
                                            @endif
                                        </tr>
                                        @if($user->brand->isPremium)
                                            <tr>
                                                <th scope="row">Aylık Premium Plan ücreti <i class="uil-info-circle" data-toggle="tooltip" data-placement="top" title="Markanıza bağlı her bir dükkan için ödenecek aylık ücret"></i></th>
                                                <td class="float-right">{{$user->brand->premiumPlanFeePerStore}}TL</td>
                                            </tr>
                                        @endif
                                        @if($user->brand->isPremium && \App\Models\KafeyinBoolSetting::where('code','isTakeAwayOrderEnabled')->first()->value)
                                            <tr>
                                                <th scope="row">Al-götür sipariş komisyon oranı</th>
                                                <td class="float-right">{{$user->brand->takeAwayOrderCommissionPercent}}%</td>
                                            </tr>
                                        @endif
                                        @if($user->brand->isPremium && \App\Models\KafeyinBoolSetting::where('code','isLocalDeliveryOrderEnabled')->first()->value)
                                            <tr>
                                                <th scope="row">Şehir içi teslimat sipariş komisyon oranı</th>
                                                <td class="float-right">{{$user->brand->otherOrdersCommissionPercent}}%</td>
                                            </tr>
                                        @endif
                                        @if($user->brand->isPremium && \App\Models\KafeyinBoolSetting::where('code','isUpstateCargoOrderEnabled')->first()->value)
                                            <tr>
                                                <th scope="row">Şehir dışı kargo sipariş komisyon oranı</th>
                                                <td class="float-right">{{$user->brand->otherOrdersCommissionPercent}}%</td>
                                            </tr>
                                        @endif
                                        @if($user->brand->isPremium && \App\Models\KafeyinBoolSetting::where('code','isActivityTicketingCommissionEnabled')->first()->value&& \App\Models\KafeyinBoolSetting::where('code','isTicketingEnabled')->first()->value)
                                            <tr>
                                                <th scope="row">Etkinlik bileti satışı komisyon oranı</th>
                                                <td class="float-right">{{$user->brand->activityTicketingCommissionPercent}}%</td>
                                            </tr>
                                        @endif
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xl-7">
                            <h5 class="header-title mb-3 mt-0">Markanıza bağlı mağazalar</h5>
                            @foreach($user->brand->stores as $magaza)
                                <div class="card shadow-none rounded bg-light">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-md-3">
                                            <div class="popup-gallery" data-source="{{$magaza->coverImageLink}}">
                                                <a href="{{$magaza->coverImageLink}}" title="">
                                                    <img src="{{$magaza->coverImageLink}}" alt="img" class="img-fluid rounded">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body m-0">
                                                <div class="col-12">
                                                    <div class="row justify-content-between">
                                                        <div>
                                                            <h5 class="card-title mb-1">{{$magaza->name}} (ID:KFYN{{$magaza->id}})</h5>
                                                            <h6 class="text-muted font-weight-normal mt-0 mb-0">{{$magaza->location->name}}, {{$magaza->city->name}}</h6>
                                                        </div>
                                                        <div>
                                                            <p class="bg-primary rounded pr-2 pl-2 pt-1 pb-1 text-light ">Ort. Puan: {{$magaza->averagePoint == 0 ? "-" : round($magaza->averagePoint,1)}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-1 mb-1">
                                                <div class="row mb-0">
                                                    <div class="col">
                                                        <div class="media m-0">
                                                            <span class="icon-dual align-self-center mr-2" data-feather="eye"></span>
                                                            <div class="media-body">
                                                                <h5 class="mt-2 pt-1 mb-0 font-size-16">{{count($magaza->views)}}</h5>
                                                                <h6 class="font-weight-normal mt-0">Görüntülenme</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="media m-0">
                                                            <span class="icon-dual align-self-center mr-2" data-feather="bookmark"></span>
                                                            <div class="media-body">
                                                                <h5 class="mt-2 pt-1 mb-0 font-size-16">{{count($magaza->favorites)}}</h5>
                                                                <h6 class="font-weight-normal mt-0">Favori</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="media m-0">
                                                            <span class="icon-dual align-self-center mr-2" data-feather="pen-tool"></span>
                                                            <div class="media-body">
                                                                <h5 class="mt-2 pt-1 mb-0 font-size-16">{{count($magaza->comments)}}</h5>
                                                                <h6 class="font-weight-normal mt-0">Yorum</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="media m-0">
                                                            <span class="icon-dual align-self-center mr-2" data-feather="camera"></span>
                                                            <div class="media-body">
                                                                <h5 class="mt-2 pt-1 mb-0 font-size-16">{{count($magaza->photos)}}</h5>
                                                                <h6 class="font-weight-normal mt-0">Fotoğraf</h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-1 mb-3">
                                                <h6 class="font-weight-normal mt-0 mb-0">Mağaza yöneticisi: {{is_null($magaza->yonetici) ? "Tanımsız" : $magaza->yonetici->name." ".$magaza->yonetici->surname." (E-posta adresi: ".$magaza->yonetici->email.")"}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="alert">
                <div class="row align-items-center">
                    <div class="col-xl-auto">
                        <i class="uil-info-circle font-size-56 "></i>
                    </div>
                    <div class="col-xl-11">
                        <h4 class="font-weight-bold">Bilgi</h4>
                        <p> Marka bilgilerinde eksik veya hatalı bilgi olduğunu düşünüyorsanız, "destek@kafeyinapp.com" e-posta adresi üzerinden bize ulaşabilirsiniz.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    <p class="font-weight-bold">Marka logonuzu veya markanız için oluşturulan sadakat kartlarının tamamlanması için gereken damga sayısını değiştirmek istyirosanız, "destek@kafeyinapp.com" e-posta adresi üzerinden bizimle iletişime geçebilirsiniz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Markanız için oluşturulan sadakat kartlarının tamamlanması için gereken damga sayısını arttırmak istediğinizde, kazanılmış hak olması sebebiyle kullanılabilir durumda olan sadakat kartları bu değişiklikten etkilenmeyecektir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Markanız için oluşturulan sadakat kartlarının tamamlanması için gereken damga sayısını azaltmak istediğinizde, yeni gereken damga sayısına eşit veya fazlasına sahip aktif kartlar otomatik olarak kullanılabilir hale gelecektir.</p>
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
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY' );
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
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
