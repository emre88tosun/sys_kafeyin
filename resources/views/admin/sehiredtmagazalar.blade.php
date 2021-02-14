@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                <li class="breadcrumb-item"><a href="/adminpanel/sehirler/{{$city->id}}">#{{$city->id}} - {{$city->name}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Editörün Tercihi Mağazalar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Editörün Tercihi Mağazalar</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mb-1">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mağaza</th>
                                <th>Pozisyon</th>
                                <th>Görüntülenme Sayısı</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($edtmagazas as $edtMagaza)
                                <tr>
                                    <th scope="row">{{$edtMagaza->id}}</th>
                                    <td><a class="card-link text-muted" href="/adminpanel/magazalar/{{$edtMagaza->store->id}}">#{{$edtMagaza->store->id}} - {{$edtMagaza->store->name}}</a></td>
                                    <td>{{$edtMagaza->position}}</td>
                                    <td>{{$edtMagaza->viewCount}}</td>
                                    <td>
                                        <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#edtMagUp{{$edtMagaza->id}}" class="card-link text-primary">Düzenle</a>
                                        <a href="javascript:void(0);" type="button" data-id="{{$edtMagaza->id}}"
                                            class="card-link text-danger sa-edtMagazaSil">Sil</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($edtmagazas as $edtMagaza)
                            <div class="modal fade" id="edtMagUp{{$edtMagaza->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="edtMagUp{{$edtMagaza->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="edtMagUp{{$edtMagaza->id}}">Editörün tercihi mağaza düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/edtmagazaguncelle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="edtStoreID" value="{{$edtMagaza->id}}">
                                                    <div class="form-group row">
                                                        <label for="storeID" class="col-md-4 col-form-label">Mağaza</label>
                                                        <div class="col-md-8">
                                                            <select data-plugin="customselect{{$edtMagaza->id}}" class="form-control" name="storeID" required >
                                                                @foreach($sehirmagazas as $sehirMagaza)
                                                                    <option value="{{$sehirMagaza->id}}" @if($edtMagaza->store->id == $sehirMagaza->id) selected @endif >#{{$sehirMagaza->id}} - {{$sehirMagaza->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="position" class="col-md-4 col-form-label">Pozisyon</label>
                                                        <div class="col-md-8">
                                                            <input type="number" name="position" required
                                                                   class="form-control" id="position"
                                                                   placeholder="Pozisyon" value="{{$edtMagaza->position}}">
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
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Editörün tercihi mağaza ekle</h5>
                    <form method="post"  action="/adminpanel/edtmagazaekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="cityID" value="{{$city->id}}">
                            <div class="form-group row">
                                <label for="storeID" class="col-md-4 col-form-label">Mağaza</label>
                                <div class="col-md-8">
                                    <select data-plugin="customselects1" class="form-control" name="storeID" required >
                                        <option></option>
                                        @foreach($sehirmagazas as $sehirMagaza)
                                            <option value="{{$sehirMagaza->id}}">#{{$sehirMagaza->id}} - {{$sehirMagaza->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="position" class="col-md-4 col-form-label">Pozisyon</label>
                                <div class="col-md-8">
                                    <input type="number" name="position" required
                                           class="form-control" id="position"
                                           placeholder="Pozisyon">
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
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        @foreach($edtmagazas as $edtMagaza)
            $('[data-plugin="customselect{{$edtMagaza->id}}"]').select2();
            $('[data-plugin="customselects1"]').select2();
        @endforeach
        @if (session('edtMagazaUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Editörün tercihi mağaza bilgileri güncellenmiştir.',
                type: "success",
            });
        @elseif (session('edtMagazaAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Editörün tercihi mağaza eklenmiştir.',
                type: "success",
            });
        @elseif (session('edtMagazaExists'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz mağaza zaten editörün tercihi mağazalar listesinde.',
                type: "warning",
            });
        @elseif (session('edtMagazaDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Editörün tercihi mağaza silinmiştir.',
                type: "success",
            });
        @elseif (session('alreadyPop'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz mağaza zaten popüler mağazalar listesinde.',
                type: "warning",
            });
        @elseif (session('alreadyEnSon'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Seçtiğiniz mağaza zaten en son eklenen mağazalar listesinde.',
                type: "warning",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
