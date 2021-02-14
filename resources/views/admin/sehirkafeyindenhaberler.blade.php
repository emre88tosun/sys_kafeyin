@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler/{{$city->id}}">#{{$city->id}}
                            - {{$city->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kafeyin'den Haberler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Kafeyin'den Haberler</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Başlık</th>
                                <th>Eklenme Tarihi</th>
                                <th class="w-25"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($khaberlers as $khaberler)
                                <tr>
                                    <th scope="row">{{$khaberler->id}}</th>
                                    <td>
                                        <div class="popup-gallery" data-source="{{$khaberler->imageLink}}">
                                            <a href="{{$khaberler->imageLink}}" title="">
                                                <img src="{{$khaberler->imageLink}}" alt="img"
                                                     class="avatar-md rounded">
                                            </a>
                                        </div>
                                    </td>
                                    <td>{{$khaberler->title}}</td>
                                    <td>{{\Carbon\Carbon::createFromTimeString($khaberler->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <a href="javascript:void(0);" type="button" data-toggle="modal"
                                           data-target="#haberModal{{$khaberler->id}}" class="card-link text-primary">Detay</a>
                                        <a
                                            href="javascript:void(0);" type="button" data-id="{{$khaberler->id}}"
                                            class="card-link text-danger sa-kNewsSil">Sil</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($khaberlers as $khaberler)
                            <div class="modal fade" id="haberModal{{$khaberler->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="haberModal{{$khaberler->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="haberModal{{$khaberler->id}}">Haber detay</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>{{$khaberler->title}}</h6>
                                            <hr>
                                            <p>{{$khaberler->desc}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Haber ekle</h5>
                    <form method="post" enctype="multipart/form-data" action="/adminpanel/khaberekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="cityID" value="{{$city->id}}">
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label">Başlık</label>
                                <div class="col-md-8">
                                    <input type="text" name="title" required class="form-control" id="title"
                                           placeholder="Başlık">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="desc" class="col-md-4 col-form-label">Detay</label>
                                <div class="col-md-8">
                                                    <textarea type="text" name="desc" rows="8" class="form-control"
                                                              id="desc"
                                                              required placeholder="Detay"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="desc" class="col-md-4 col-form-label">Görsel</label>
                                <div class="col-md-8">
                                    <input type="file" id="image" name="image" data-max-file-size="1M" required
                                           data-show-loader="true" data-allowed-formats="square"
                                           data-allowed-file-extensions="png jpg jpeg" class="dropify"/>
                                </div>
                            </div>
                            <div class="col-md-8 offset-md-4">
                                <input type="submit" class="btn btn-primary mr-1" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
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
        @if (session('locaAdd'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Lokasyon eklenmiştir.',
            type: "success",
        });
        @elseif(session('noImg'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Görsel eklemeden haber paylaşamazsınız',
            type: "warning",
        });
        @elseif (session('kNewsAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Haber eklenmiştir.',
                type: "success",
            });
        @elseif (session('kNewsDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Haber silinmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
