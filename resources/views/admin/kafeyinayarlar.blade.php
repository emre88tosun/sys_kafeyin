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
                <li class="breadcrumb-item active" aria-current="page">Kafeyin Ayarlar</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Kafeyin Ayarlar</h4>
        <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 ml-1" data-toggle="modal" data-target="#boolEkleModal">Boolean ayar ekle</a>
        <a type="button" href="javascript:void(0);" class="btn btn-outline-primary btn-sm mt-2 ml-1" data-toggle="modal" data-target="#stringEkleModal">String ayar ekle</a>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Boolean Ayarlar</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kod</th>
                                <th>Açıklama</th>
                                <th>Değer</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($boolSettings as $setting)
                                <tr>
                                    <th scope="row">{{$setting->id}}</th>
                                    <td>{{$setting->code}}</td>
                                    <td>{{$setting->desc}}</td>
                                    @if($setting->value)
                                        <td><span class="badge badge-soft-success py-1">Olumlu</span></td>
                                    @else
                                        <td><span class="badge badge-soft-danger py-1">Olumsuz</span></td>
                                    @endif
                                    <td>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">İşlemler<i
                                                    class="icon"><span
                                                        data-feather="chevron-down"></span></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="javascript:void(0);" type="button" data-toggle="modal"
                                                   data-target="#boolDuzenleModal{{$setting->id}}"
                                                   class="dropdown-item">Düzenle</a>
                                                <a href="javascript:void(0);" type="button" data-id="{{$setting->id}}"
                                                   class="dropdown-item text-danger sa-boolSetSil">Sil</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($boolSettings as $setting)
                            <div class="modal fade" id="boolDuzenleModal{{$setting->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="boolDuzenleModal{{$setting->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="boolDuzenleModal{{$setting->id}}">Boolean Ayar Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/boolayarduzenle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="boolID" value="{{$setting->id}}">
                                                    <div class="form-group row">
                                                        <label for="code" class="col-md-4 col-form-label">Code</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="code" required readonly class="form-control" id="code"
                                                                   placeholder="Code" value="{{$setting->code}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="desc" class="col-md-4 col-form-label">Açıklama</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="desc" required readonly class="form-control" id="desc"
                                                                   placeholder="Açıklama" value="{{$setting->desc}}">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label for="value{{$setting->id}}1" class="col-md-4 col-form-label">Değer</label>
                                                        <div class="custom-control custom-radio mt-2 ml-2">
                                                            <input type="radio" id="value{{$setting->id}}1" name="value" value="1"
                                                                   class="custom-control-input" @if($setting->value) checked @endif >
                                                            <label class="custom-control-label" for="value{{$setting->id}}1" >Olumlu</label>
                                                        </div>
                                                        <div class="custom-control custom-radio ml-4 mt-2">
                                                            <input type="radio" id="value{{$setting->id}}2" name="value" value="0"
                                                                   class="custom-control-input" @if(!$setting->value) checked @endif >
                                                            <label class="custom-control-label" for="value{{$setting->id}}2">Olumsuz</label>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">String Ayarlar</h5>
                    <div class="table-responsive mb-3">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kod</th>
                                <th>Açıklama</th>
                                <th>Değer</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stringSettings as $setting)
                                <tr>
                                    <th scope="row">{{$setting->id}}</th>
                                    <td>{{$setting->code}}</td>
                                    <td>{{$setting->desc}}</td>
                                    <td>{{$setting->value}}</td>

                                    <td>
                                        <div class="btn-group">
                                            <button type="button"
                                                    class="btn btn-outline-primary btn-sm dropdown-toggle"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false">İşlemler<i
                                                    class="icon"><span
                                                        data-feather="chevron-down"></span></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="javascript:void(0);" type="button" data-toggle="modal"
                                                   data-target="#stringDuzenleModal{{$setting->id}}"
                                                   class="dropdown-item">Düzenle</a>
                                                <a href="javascript:void(0);" type="button" data-id="{{$setting->id}}"
                                                   class="dropdown-item text-danger sa-stringSetSil">Sil</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($stringSettings as $setting)
                            <div class="modal fade" id="stringDuzenleModal{{$setting->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="stringDuzenleModal{{$setting->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="stringDuzenleModal{{$setting->id}}">String Ayar Düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/stringayarduzenle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="stringID" value="{{$setting->id}}">
                                                    <div class="form-group row">
                                                        <label for="code" class="col-md-4 col-form-label">Code</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="code" required readonly class="form-control" id="code"
                                                                   placeholder="Code" value="{{$setting->code}}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="desc" class="col-md-4 col-form-label">Açıklama</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="desc" required readonly class="form-control" id="desc"
                                                                   placeholder="Açıklama" value="{{$setting->desc}}">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label for="value" class="col-md-4 col-form-label">Değer</label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="value" required  class="form-control" id="value"
                                                                   placeholder="Değer" value="{{$setting->value}}">
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="boolEkleModal" tabindex="-1" role="dialog"
         aria-labelledby="boolEkleModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="boolEkleModal">Boolean Ayar Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/adminpanel/boolayarekle">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="code" class="col-md-4 col-form-label">Code</label>
                                <div class="col-md-8">
                                    <input type="text" name="code" required class="form-control" id="code"
                                           placeholder="Code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="desc" class="col-md-4 col-form-label">Açıklama</label>
                                <div class="col-md-8">
                                    <input type="text" name="desc" required class="form-control" id="desc"
                                           placeholder="Açıklama">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="value88" class="col-md-4 col-form-label">Değer</label>
                                <div class="custom-control custom-radio mt-2 ml-2">
                                    <input type="radio" id="value88" name="value" value="1"
                                           class="custom-control-input">
                                    <label class="custom-control-label" for="value88">Olumlu</label>
                                </div>
                                <div class="custom-control custom-radio ml-4 mt-2">
                                    <input type="radio" id="value89" name="value" value="0"
                                           class="custom-control-input" checked>
                                    <label class="custom-control-label" for="value89">Olumsuz</label>
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="stringEkleModal" tabindex="-1" role="dialog"
         aria-labelledby="stringEkleModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stringEkleModal">String Ayar Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/adminpanel/stringayarekle">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="code" class="col-md-4 col-form-label">Code</label>
                                <div class="col-md-8">
                                    <input type="text" name="code" required class="form-control" id="code"
                                           placeholder="Code">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="desc" class="col-md-4 col-form-label">Açıklama</label>
                                <div class="col-md-8">
                                    <input type="text" name="desc" required class="form-control" id="desc"
                                           placeholder="Açıklama">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="value" class="col-md-4 col-form-label">Değer</label>
                                <div class="col-md-8">
                                    <input type="text" name="value" required class="form-control" id="value"
                                           placeholder="Değer">
                                </div>
                            </div>

                            <div class="offset-md-4">
                                <input type="submit" class="btn btn-primary ml-2" value="Ekle">
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
    <script>
        @if (session('setAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Ayar eklendi.',
                type: "success",
            });
        @elseif (session('setUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Ayar güncellendi.',
                type: "success",
            });
        @elseif (session('setDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Ayar silindi.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
