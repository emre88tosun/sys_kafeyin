@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler/{{$city->id}}">#{{$city->id}}
                            - {{$city->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lokasyonlar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Lokasyonlar</h4>
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
                                <th>Ad</th>
                                <th>Mağaza Sayısı</th>
                                <th>Eklenme Tarihi</th>
                                <th class="w-25"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lokasyons as $lokasyon)
                                <tr>
                                    <th scope="row">{{$lokasyon->id}}</th>
                                    <td>{{$lokasyon->name}}</td>
                                    <td>{{$lokasyon->stores_count}}</td>
                                    <td>{{\Carbon\Carbon::createFromTimeString($lokasyon->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#lokaUp{{$lokasyon->id}}" class="card-link text-primary">Düzenle</a>
                                        @if($lokasyon->stores_count == 0)
                                            <a
                                                href="javascript:void(0);" type="button" data-id="{{$lokasyon->id}}"
                                                class="card-link text-danger sa-lokaSil">Sil</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($lokasyons as $lokasyon)
                            <div class="modal fade" id="lokaUp{{$lokasyon->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="lokaUp{{$lokasyon->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="lokaUp{{$lokasyon->id}}">Lokasyon düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/lokaguncelle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="locationID" value="{{$lokasyon->id}}">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-4 col-form-label">Ad</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="name" required class="form-control" id="name"
                                                                   placeholder="Ad" value="{{$lokasyon->name}}">
                                                        </div>
                                                    </div>
                                                    <div class="offset-md-4">
                                                        <input type="submit" class="btn btn-primary ml-2"
                                                               value="Güncelle">
                                                    </div>
                                                </fieldset>
                                            </form>
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
                    <h5 class="card-title font-size-16">Lokasyon ekle</h5>
                    <form method="post" action="/adminpanel/lokasyonekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="cityID" value="{{$city->id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label">Ad</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" required class="form-control" id="name"
                                           placeholder="Ad">
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
    <script>
        @if (session('locaAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Lokasyon eklenmiştir.',
                type: "success",
            });
        @elseif(session('lokaHasStore'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Lokasyona bağlı mekanlar bulunduğu için silemezsiniz.',
                type: "warning",
            });
        @elseif(session('lokaDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Lokasyon silinmiştir.',
                type: "success",
            });
        @elseif(session('lokaUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Lokasyon güncellenmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
