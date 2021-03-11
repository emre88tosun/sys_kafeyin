@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Destek</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Destek</h4>
            @if(count(\App\Models\SupportTicket::where('userID', $user->id)->where('isAnswered',false)->get()) > 2)
                <a type="button" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Maksimum sayıda cevap bekleyen destek talebiniz bulunduğu için yeni bir destek talebi oluşturamazsınız." class="btn btn-outline-primary btn-sm mt-2" >Destek Talebi Oluştur</a>
            @else
                <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2" data-toggle="modal" data-target="#talepOlusturModal">Destek Talebi Oluştur</a>
            @endif
        </div>
    </div>
@endsection

@section('content')

    @if(count($tickets))
        @foreach($tickets->chunk(2) as $twoticket)
            <div class="card-deck">
                @if(count($twoticket) == 1)
                    @foreach($twoticket as $ticket)
                        <div class="card mb-3 ">
                            <div class="card-body p-2 mt-2 mb-2">
                                <div class="align-items-center d-flex ">
                                    <div class="col-xl-12">
                                        <div class="row justify-content-between">
                                            <div class="col-xl-10">
                                                <p class="font-weight-bold m-0 text-justify">{{$ticket->topic}}</p>
                                            </div>
                                            <div class="col-xl-auto">
                                                @if($ticket->isAnswered)
                                                    @if($ticket->isAnswerSeen)
                                                        <span class="badge badge-success" id="badge{{$ticket->id}}">Cevaplandı</span>
                                                    @else
                                                        <span class="badge badge-success2" id="badge{{$ticket->id}}">Cevaplandı</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-primary">Cevap bekleniyor</span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <small class="m-0">Oluşturulma tarihi: {{\Carbon\Carbon::createFromTimeString($ticket->created_at)->format('d/m/Y H:i')}}</small>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row justify-content-between m-0 align-items-center">
                                        <p class="font-weight-bold text-primary m-0">ID: DSTK{{97880000 + $ticket->id}}</p>
                                        <a href="javascript:void(0);" id="btnDSTK{{97880000 + $ticket->id}}" type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#talepDetayDSTK{{97880000 + $ticket->id}}">Detay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3 bg-transparent shadow-none"></div>
                    @endforeach
                @else
                    @foreach($twoticket as $ticket)
                        <div class="card mb-3">
                            <div class="card-body w-100 p-1 mt-2 mb-2">
                                <div class="col-xl-12">
                                    <div class="row justify-content-between">
                                        <div class="col-xl-10">
                                            <p class="font-weight-bold m-0 text-justify">{{$ticket->topic}}</p>
                                        </div>
                                        <div class="col-xl-auto">
                                            @if($ticket->isAnswered)
                                                @if($ticket->isAnswerSeen)
                                                    <span class="badge badge-success" id="badge{{$ticket->id}}">Cevaplandı</span>
                                                @else
                                                    <span class="badge badge-success2" id="badge{{$ticket->id}}">Cevaplandı</span>
                                                @endif
                                            @else
                                                <span class="badge badge-primary">Cevap bekleniyor</span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <small class="m-0">Oluşturulma tarihi: {{\Carbon\Carbon::createFromTimeString($ticket->created_at)->format('d/m/Y H:i')}}</small>
                                </div>
                                <div class="col-xl-12">
                                    <div class="row justify-content-between m-0 align-items-center">
                                        <p class="font-weight-bold text-primary m-0">ID: DSTK{{97880000 + $ticket->id}}</p>
                                        <a href="javascript:void(0);" id="btnDSTK{{97880000 + $ticket->id}}" type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#talepDetayDSTK{{97880000 + $ticket->id}}">Detay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    @else
        <div class="row">
            <div class="col-xl-12">
                <div class="col-xl-12">
                    <div class="col-12 text-center mt-5 pt-5" style="height: 23vh">
                        <i class="uil uil-ticket font-size-56 "></i>
                        <p class="font-weight-bold">Destek talebiniz bulunmamaktadır.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(count($tickets))
        {{$tickets->render()}}
    @endif
    <div class="modal fade" id="talepOlusturModal" tabindex="-1" role="dialog"
         aria-labelledby="talepOlusturModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="talepOlusturModal">Destek Talebi Oluştur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/destektalebigonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="topic" class="col-md-4 col-form-label">Konu</label>
                                <div class="col-md-8">
                                    <input type="text" name="topic" maxlength="180" required class="form-control" id="topic" placeholder="Konu"
                                    >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="userMessage" class="col-md-4 col-form-label">Mesaj</label>
                                <div class="col-md-8">
                                    <textarea type="text" rows="8" name="userMessage" required class="form-control"
                                           id="userMessage"
                                              placeholder="Mesaj"></textarea>
                                </div>
                            </div>
                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($tickets as $ticket)
        <div class="modal fade" id="talepDetayDSTK{{97880000 + $ticket->id}}" tabindex="-1" role="dialog"
             aria-labelledby="talepDetayDSTK{{97880000 + $ticket->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">DSTK{{97880000 + $ticket->id}} ID'li Destek Talebi Detayı @if($ticket->isAnswered)
                                <span class="badge badge-success">Cevaplandı</span>
                            @else
                                <span class="badge badge-primary">Cevap bekleniyor</span>
                            @endif</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="font-weight-bold m-0 text-justify">Konu: <text class="font-weight-medium">{{$ticket->topic}}</text></p>
                        <p class="m-0 text-justify font-weight-bold mt-2">Mesajınız: <text class="font-weight-medium">{{$ticket->userMessage}}</text></p>
                        <small class="m-0 mr-2 font-weight-bold">Oluşturulma tarihi: {{\Carbon\Carbon::createFromTimeString($ticket->created_at)->format('d/m/Y H:i')}}</small>
                        @if($ticket->isAnswered)
                            <hr>
                            <p class="font-weight-bold m-0 text-justify">Cevap: <text class="font-weight-medium">{{$ticket->adminMessage}}</text></p>
                            <small class="m-0 mr-2 font-weight-bold">Cevaplanma tarihi: {{\Carbon\Carbon::createFromTimeString($ticket->updated_at)->format('d/m/Y H:i')}}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script>
        @if(session('ticketSent'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Destek talebiniz gönderilmiştir.',
            type: "success",
        });
        @endif
    </script>
    <script type="text/javascript">
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        @foreach($tickets as $ticket)
        $('#btnDSTK{{97880000 + $ticket->id}}').click(function (){
            @if($ticket->isAnswered)
            $.ajax({
                url: "/yoneticipaneli/answerseen",
                type:"POST",
                data:{
                    id:"{{$ticket->id}}",
                    _token: CSRF_TOKEN
                },
            });
            @if(!$ticket->isAnswerSeen)
            $('#badge{{$ticket->id}}').removeClass('badge-success2');
            $('#badge{{$ticket->id}}').addClass('badge-success');
            @endif
            @endif

        });

        @endforeach
    </script>
@endsection

@section('script-bottom')
@endsection
