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
                    <li class="breadcrumb-item active" aria-current="page">OwnershipApplicationReferrals</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">OwnershipApplicationReferrals</h4>
            <a type="button" class="btn btn-sm btn-primary" href="javascript:void(0);" data-toggle="modal" data-target="#referralEkleModal">Referral ekle</a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Bütün referanslar</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Referans Kodu</th>
                            <th>Marka</th>
                            <th>Durum</th>
                            <th>isValid</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Güncellenme Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($referrals as $referral)
                            <tr>
                                <th scope="row">{{$referral->id}}</th>
                                <td>{{$referral->referralCode}}</td>
                                <td>#{{$referral->brand->id}} - {{$referral->brand->name}}</td>
                                @if($referral->isUsed)
                                    <td><text class="text-success">Kullanıldı</text></td>
                                @elseif(!$referral->isUsed)
                                    <td><text class="text-primary">Kullanılmadı</text></td>
                                @endif
                                @if($referral->isValid)
                                    <td><text class="text-success">true</text></td>
                                @elseif(!$referral->isValid)
                                    <td><text class="text-danger">false</text></td>
                                @endif
                                <td>{{\Carbon\Carbon::createFromTimeString($referral->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($referral->updated_at)->format('d/m/Y H:i')}}</td>
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
                                            @if($referral->basvuru)
                                                <a href="javascript:void(0);" type="button" class="dropdown-item" data-toggle="modal" data-target="#referralDetayModal{{$referral->id}}">Başvuru</a>
                                            @endif
                                            @if(!$referral->isUsed)
                                                <a href="javascript:void(0);" type="button" class="dropdown-item sa-oreferralcodeyenile" data-id="{{$referral->id}}" >Kodu yenile</a>
                                            @endif
                                            <a href="javascript:void(0);" type="button" class="dropdown-item" data-toggle="modal" data-target="#referralDuzenleModal{{$referral->id}}">Düzenle</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @foreach($referrals as $referral)
                        <div class="modal fade" id="referralDuzenleModal{{$referral->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="referralDuzenleModal{{$referral->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="referralDuzenleModal{{$referral->id}}">Referral düzenle</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="/adminpanel/oreferralduzenle">
                                            @csrf
                                            <fieldset>
                                                <input type="hidden" name="referralID" value="{{$referral->id}}">
                                                <div class="form-group row">
                                                    <label for="isUsed" class="col-md-4 col-form-label">isUsed</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="isUsed" required class="form-control" id="isUsed"
                                                               placeholder="1 / 0">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="isValid" class="col-md-4 col-form-label">isValid</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="isValid" required class="form-control" id="isValid"
                                                               placeholder="1 / 0">
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
                        @if($referral->basvuru)
                            <div class="modal fade" id="referralDetayModal{{$referral->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="referralDetayModal{{$referral->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="referralDetayModal{{$referral->id}}">Başvuru detay</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach(json_decode($referral->basvuru,true) as $key => $value)
                                                <li>{{$key}}: {{$value}}</li>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div class="modal fade" id="referralEkleModal" tabindex="-1" role="dialog"
                         aria-labelledby="referralEkleModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="referralEkleModal">Referral ekle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="/adminpanel/referralekle">
                                        @csrf
                                        <fieldset>
                                            <div class="form-group row">
                                                <label for="brandID" class="col-md-3 col-form-label">Marka</label>
                                                <div class="col-md-9">
                                                    <select data-plugin="selectBrand" required class="form-control" name="brandID">
                                                        <option></option>
                                                        @foreach($brands as $brand)
                                                            <option value="{{$brand->id}}">#{{$brand->id}} - {{$brand->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="offset-md-3">
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
        @elseif(session('referralup'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Referral güncellendi.',
            type: "success",
        });
        @endif
    </script>
    <script type="text/javascript">
        $('[data-plugin="selectBrand"]').select2();
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
