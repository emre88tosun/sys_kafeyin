@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/sehirler/{{$city->id}}">#{{$city->id}} - {{$city->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kafeyin Lokasyonlar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Kafeyin Lokasyonlar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mb-1">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ad</th>
                                <th>Enlem</th>
                                <th>Boylam</th>
                                <th>Kullanımı Sayısı</th>
                                <th>Oluşturulma Tarihi</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($klokasyons as $klokasyon)
                                <tr>
                                    <th scope="row">{{$klokasyon->id}}</th>
                                    <td>{{$klokasyon->name}}</td>
                                    <td>{{$klokasyon->latitude}}</td>
                                    <td>{{$klokasyon->longitude}}</td>
                                    <td>{{$klokasyon->usage_count}}</td>
                                    <td>{{\Carbon\Carbon::createFromTimeString($klokasyon->created_at)->format('d/m/Y H:i')}}</td>
                                    <td>
                                        <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#kLok{{$klokasyon->id}}" class="card-link text-primary">Düzenle</a>
                                        <a href="javascript:void(0);" type="button" data-id="{{$klokasyon->id}}"
                                            class="card-link text-danger sa-kLokSil">Sil</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($klokasyons as $klokasyon)
                            <div class="modal fade" id="kLok{{$klokasyon->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="kLok{{$klokasyon->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="kLok{{$klokasyon->id}}">Kafeyin lokasyon düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/klokasyonguncelle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="kLokasyonID" value="{{$klokasyon->id}}">
                                                    <div class="form-group row">
                                                        <label for="name" class="col-md-4 col-form-label">Ad</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="name" required class="form-control" id="name"
                                                                   placeholder="Ad" value="{{$klokasyon->name}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="latitude"
                                                               class="col-md-4 col-form-label">Enlem</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="latitude" class="form-control" data-inputmask-alias="99.999999" required id="latitude" placeholder="Enlem" value="{{$klokasyon->latitude}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="longitude"
                                                               class="col-md-4 col-form-label">Boylam</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="longitude" class="form-control" data-inputmask-alias="99.999999" required id="longitude" placeholder="Boylam" value="{{$klokasyon->longitude}}">
                                                        </div>
                                                    </div>
                                                    <input class="btn btn-primary mt-0 mb-2" type="submit" value="Güncelle">
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
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Kafeyin lokasyon ekle</h5>
                    <form method="post"  action="/adminpanel/klokasyonekle">
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
                            <div class="form-group row">
                                <label for="latitude"
                                       class="col-md-4 col-form-label">Enlem</label>
                                <div class="col-md-8">
                                    <input type="text" name="latitude" class="form-control" data-inputmask-alias="99.999999" id="latitude" required placeholder="Enlem" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="longitude"
                                       class="col-md-4 col-form-label">Boylam</label>
                                <div class="col-md-8">
                                    <input type="text" name="longitude" class="form-control" data-inputmask-alias="99.999999" id="longitude" required placeholder="Boylam">
                                </div>
                            </div>
                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2"
                                       value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script>
        @if (session('kLokUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Lokasyon bilgileri güncellenmiştir.',
                type: "success",
            });
        @elseif (session('kLokAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Lokasyon eklenmiştir.',
                type: "success",
            });
        @elseif (session('kLokDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Lokasyon silinmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
