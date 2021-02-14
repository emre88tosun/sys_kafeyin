@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/yoneticipaneli/etkinlikler">Etkinlikler</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ETK{{$etkinlik->id}}</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
            @if($etkinlik->isActive)
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 right-bar-toggle">Düzenle</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="tooltip" data-placement="right" title="Pasif haldeki etkinliğinizi düzenleyemezsiniz.">Düzenle</a>
            @endif
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
                            <div class="popup-gallery mr-2" data-source="{{$etkinlik->imageLink}}">
                                <a class="pr-2 pt-2" href="{{$etkinlik->imageLink}}" title="">
                                    <img src="{{$etkinlik->imageLink}}" alt="img" class="rounded" width=100%>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="mt-0">{{$etkinlik->title}}</h5>
                            <p class="font-size-13 mb-0">Eklenme tarihi: {{\Carbon\Carbon::createFromTimeString($etkinlik->created_at)->format('d/m/Y H:i')}}</p>
                            <hr class="mt-1">
                            <p class="font-weight-bold text-muted">Etkinlik tarihi ve saati: <text class="font-weight-bold text-primary">{{\Carbon\Carbon::createFromDate($etkinlik->date)->format('d/m/Y')}} {{\Carbon\Carbon::createFromDate($etkinlik->time)->format('H:i')}}</text> </p>
                            <p class="card-text text-muted">{{$etkinlik->desc}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            @if($isTicketingEnabled)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title font-size-16">Bilet satışı</h5>
                        @if($user->magaza->brand->isPremium)
                            @if($etkinlik->canTicketing || count($etkinlik->sold_tickets) > 0 || !is_null($etkinlik->ticketFee))
                                @if($etkinlik->canTicketing && $etkinlik->isActive)
                                    <p>Bilet satışı: <text class="text-success font-weight-bold">Var</text></p>
                                    <div class="row"><div class="col-xl-12"><button href="javascript:void(0);" data-id="{{$etkinlik->id}}" class="btn btn-sm btn-outline-danger w-100 sa-stoActTickCancel">Bilet satışını durdur</button></div></div>
                                    <hr>
                                    <p>Satılabilir bilet sayısı: <text class="font-weight-bold">{{$etkinlik->availableTicketCount}}</text></p>
                                    <div class="row"><div class="col-xl-12"><button href="javascript:void(0);" data-toggle="modal" data-target="#addTicketModal" class="btn btn-sm btn-outline-primary w-100">Satılabilir bilet ekle</button></div></div>
                                    @if($etkinlik->availableTicketCount > 0)
                                        <div class="row"><div class="col-xl-12 mt-2"><button href="javascript:void(0);" data-toggle="modal" data-target="#decTicketModal" class="btn btn-sm btn-outline-danger w-100">Satılabilir bilet sayısını azalt</button></div></div>
                                    @endif
                                    <hr>
                                @else
                                    <p>Bilet satışı: <text class="text-danger font-weight-bold">Yok</text></p>
                                    @if(!is_null($etkinlik->ticketFee) && $etkinlik->isActive)
                                        <div class="row"><div class="col-xl-12"><button href="javascript:void(0);" data-id="{{$etkinlik->id}}" class="btn btn-sm btn-outline-success w-100 sa-stoActTickOpen">Bilet satışını aç</button></div></div>
                                    @endif
                                    <hr>
                                    <p>Satılabilir bilet sayısı: <text class="font-weight-bold">{{$etkinlik->availableTicketCount ?? 0}}</text></p>
                                    <hr>
                                @endif
                                <p>Bilet fiyatı: <text class="font-weight-bold">{{$etkinlik->ticketFee ?? 0}}TL</text></p>
                                <hr>
                                <p>Satılan bilet sayısı: <text class="font-weight-bold">{{count($etkinlik->sold_tickets)}}</text></p>
                                @if(count($etkinlik->sold_tickets) > 0)
                                    <div class="row"><div class="col-xl-12"><button href="javascript:void(0);" data-toggle="modal" data-target="#biletlerModal" class="btn btn-sm btn-primary w-100">Biletler</button></div></div>
                                @endif
                                <hr class="mb-0">
                            @endif
                        @else
                            <p class="text-primary mb-0">Markanızı Premium Plan'a taşıyıp, etkinlikleriniz için bilet satabilirsiniz.</p>
                        @endif
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    <p>Görüntülenme sayısı: {{$etkinlik->viewCount}}</p>
                    <hr>
                    <p class="mb-0">Favoriye alınma sayısı: {{$etkinlik->favorites_count}}</p>
                </div>
            </div>
        </div>
    </div>
    @if($etkinlik->isActive)
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i data-feather="x-circle"></i>
                </a>
                <h5 class="">Etkinlik düzenle</h5>
            </div>

            <div class="slimscroll">
                <form enctype="multipart/form-data" class="ml-2 mr-2" method="post" action="/yoneticipaneli/etkguncelle">
                    @csrf
                    <fieldset>
                        <input type="hidden" name="actID" value="ETK{{$etkinlik->id}}">
                        <div class="form-group">
                            <label for="title" class="col-md-12 col-form-label">Başlık</label>
                            <div class="col-md-12">
                                <textarea id="title" class="form-control" rows="2" minlength="30" maxlength="90" required name="title" type="text" placeholder="Başlığınız en az 30 ve en fazla 90 karakter olmalıdır.">{{$etkinlik->title}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="desc" class="col-md-12 col-form-label">Yazı</label>
                            <div class="col-md-12">
                                <textarea id="desc" class="form-control" required minlength="1500" rows="20" name="desc" type="text" placeholder="Yazınız en az 1500 karakter olmalıdır.">{{$etkinlik->desc}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-12 col-form-label">Görsel</label>
                            <p class="card-text text-primary col-md-12 font-size-13">*Görseli güncellemek istemiyorsanız lütfen boş bırakınız.</p>
                            <div class="col-md-12">
                                <input type="file" id="image" name="image" data-max-file-size="1M" data-show-loader="true" data-allowed-formats="square landscape portrait" data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
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
    <div class="modal fade" id="addTicketModal" tabindex="-1" role="dialog"
         aria-labelledby="addTicketModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTicketModal">Satılabilir bilet ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/biletekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="id" value="ETK{{$etkinlik->id}}">
                            <div class="form-group row">
                                <label for="count" class="col-md-4 col-form-label">Eklenecek bilet sayısı</label>
                                <div class="col-md-8">
                                    <input type="number" name="count" required class="form-control" id="count"
                                           placeholder="Eklenecek bilet sayısı" min="1">
                                </div>
                            </div><div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="decTicketModal" tabindex="-1" role="dialog"
         aria-labelledby="decTicketModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="decTicketModal">Satılabilir bilet sayısını azalt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/biletazalt">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="id" value="ETK{{$etkinlik->id}}">
                            <div class="form-group row">
                                <label for="count" class="col-md-4 col-form-label">Azaltılacak bilet sayısı</label>
                                <div class="col-md-8">
                                    <input type="number" name="count" required class="form-control" id="count"
                                           placeholder="Azaltılacak bilet sayısı" min="1">
                                </div>
                            </div><div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Azalt">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="biletlerModal" tabindex="-1" role="dialog"
         aria-labelledby="biletlerModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="biletlerModal">Biletler</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($etkinlik->sold_tickets->chunk(2) as $twotickets)
                        <div class="row">
                            @foreach($twotickets as $ticket)
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body alert-light">
                                            <p class="font-weight-bold">Kullanıcı: {{maskString($ticket->buyer->name)}} {{maskString($ticket->buyer->surname)}}</p>
                                            <p class="font-weight-bold">Satın aldığı tarih: {{\Carbon\Carbon::createFromTimeString($ticket->created_at)->format('d/m/Y')}}</p>
                                            <p class="font-weight-bold">Referans kodu: {{maskString($ticket->referralCode)}}</p>
                                            <p class="font-weight-bold mb-0">Bilet kullanıldı mı?: @if($ticket->isUsed) <text class="text-success">Kullanıldı</text> @else <text class="text-danger">Kullanılmadı</text> @endif </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
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
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        @if($errors->any())
            swal.fire({
                title: 'Hata!',
                text: "{{$errors->first('hata')}}",
                type: "error",
            });
        @elseif(session('actBilSatAc'))
            swal.fire({
                title: 'Başarılı!',
                text: "Bilet satışı açıldı.",
                type: "success",
            });
        @elseif(session('actBilSatDur'))
            swal.fire({
                title: 'Başarılı!',
                text: "Bilet satışı durduruldu.",
                type: "success",
            });
        @elseif(session('actBilInc'))
            swal.fire({
                title: 'Başarılı!',
                text: "Etkinliğinizin satılabilir bilet sayısı arttırıldı.",
                type: "success",
            });
        @elseif(session('actBilDec'))
            swal.fire({
                title: 'Başarılı!',
                text: "Etkinliğinizin satılabilir bilet sayısı azaltıldı.",
                type: "success",
            });
        @elseif(session('actUp'))
            swal.fire({
                title: 'Başarılı!',
                text: "Etkinliğiniz başarıyla güncellendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
