@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Anketler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mağaza Anketleri</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">Mağaza Anketleri</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive mb-0">
                        <table class="table table-hover m-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hedef</th>
                                <th>Başlık</th>
                                <th>Onay Cümlesi</th>
                                <th>Red Cümlesi</th>
                                <th>Aktiflik</th>
                                <th>Eklenme Tarihi</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ankets as $anket)
                                <tr>
                                    <th scope="row">{{$anket->id}}</th>
                                    @if($anket->type == 88)
                                        <td>Genel</td>
                                    @else
                                        @foreach($cities as $city)
                                            @if($city->id == $anket->type)
                                                <td>{{$city->name}}</td>
                                            @endif
                                        @endforeach
                                    @endif
                                    <td>{{$anket->title}}</td>
                                    <td>{{$anket->trueString}}</td>
                                    <td>{{$anket->falseString}}</td>
                                    @if($anket->isActive)
                                        <td><span class="badge badge-soft-success">Aktif</span></td>
                                    @else
                                        <td><span class="badge badge-soft-danger">Pasif</span></td>
                                    @endif
                                    <td>{{\Carbon\Carbon::createFromTimeString($anket->created_at)->format('d/m/Y H:i')}}</td>
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
                                                <a href="javascript:void(0);" type="button" data-toggle="modal"
                                                   data-target="#anketModal{{$anket->id}}"
                                                   class="dropdown-item">Detay</a>
                                                @if(count($anket->answers))
                                                    <a href="javascript:void(0);" type="button" data-toggle="modal"
                                                       data-target="#ekstraModal{{$anket->id}}"
                                                       class="dropdown-item">Yanıtlar</a>
                                                @endif
                                                @if($anket->isActive)
                                                    <a href="javascript:void(0);"
                                                       type="button" data-toggle="modal"
                                                       data-target="#duzenleModal{{$anket->id}}"
                                                       class="dropdown-item">Düzenle</a>
                                                    <a href="javascript:void(0);"
                                                       type="button"
                                                       data-id="{{$anket->id}}"
                                                       class="dropdown-item sa-mAnketPasif">Pasifize
                                                        et</a>
                                                @endif
                                                <a href="javascript:void(0);" type="button" data-id="{{$anket->id}}"
                                                   class="dropdown-item text-danger sa-mAnketSil">Sil</a>

                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($ankets as $anket)
                            <div class="modal fade" id="anketModal{{$anket->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="anketModal{{$anket->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="anketModal{{$anket->id}}">Anket detay</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>{{$anket->title}}</h6>
                                            <hr>
                                            <p>{{$anket->desc}}</p>
                                            <hr>
                                            <p>Onay cümlesi: {{$anket->trueString}}</p>
                                            <p>Red cümlesi: {{$anket->falseString}}</p>
                                            <hr>
                                            <p>Onay sayısı: {{count($anket->answers->where('answer',true))}} - @if(count($anket->answers->where('answer',true))) {{number_format((double)(100*count($anket->answers->where('answer',true))/count($anket->answers)),1,'.','')}}% @else 0% @endif </p>
                                            <p>Red sayısı: {{count($anket->answers->where('answer',false))}} - @if(count($anket->answers->where('answer',false))) {{number_format((double)(100*count($anket->answers->where('answer',false))/count($anket->answers)),1,'.','')}}% @else 0% @endif </p>
                                            <p>Toplam katılım: {{count($anket->answers)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="duzenleModal{{$anket->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="duzenleModal{{$anket->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="duzenleModal{{$anket->id}}">Anket düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="/adminpanel/manketguncelle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="surveyID" value="{{$anket->id}}">
                                                    <div class="form-group row">
                                                        <label for="title"
                                                               class="col-md-2 col-form-label">Başlık</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="title" required
                                                                   class="form-control" id="title"
                                                                   placeholder="Başlık" value="{{$anket->title}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="desc" class="col-md-2 col-form-label">Detay</label>
                                                        <div class="col-md-10">
                                                            <textarea type="text" name="desc" rows="4"
                                                                      class="form-control"
                                                                      id="desc"
                                                                      required
                                                                      placeholder="Detay">{{$anket->desc}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="trueString"
                                                               class="col-md-2 col-form-label">Onay Cümlesi</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="trueString" required
                                                                   class="form-control" id="trueString"
                                                                   placeholder="Onay Cümlesi" value="{{$anket->trueString}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="falseString"
                                                               class="col-md-2 col-form-label">Red Cümlesi</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="falseString" required
                                                                   class="form-control" id="falseString"
                                                                   placeholder="Red Cümlesi" value="{{$anket->falseString}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="type" class="col-md-2 col-form-label">Hedef</label>
                                                        <div class="col-md-10">
                                                            <select data-plugin="customselects1" class="form-control" required name="type" >
                                                                <option value="88" @if($anket->type == 88) selected @endif >Genel</option>
                                                                @foreach($cities as $city)
                                                                    <option value="{{$city->id}}" @if($anket->type == $city->id) selected @endif >#{{$city->id}} - {{$city->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="offset-md-2">
                                                        <input type="submit" class="btn btn-primary" value="Güncelle">
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="ekstraModal{{$anket->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="ekstraModal{{$anket->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ekstraModal{{$anket->id}}">Yanıtlar</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <h6>Onaylayanlar</h6>
                                                    @foreach($anket->answers->where('answer',true) as $answer)
                                                        <p>{{$answer->additionalMessage}}</p>
                                                        <a href="/adminpanel/markalar/{{$answer->brand->id}}" class="text-muted text-dark">#{{$answer->brand->id}} - {{$answer->brand->name}}</a>
                                                    @endforeach
                                                </div>
                                                <div class="col-6">
                                                    <h6>Reddedenler</h6>
                                                    @foreach($anket->answers->where('answer',false) as $answer)
                                                        <p>{{$answer->additionalMessage}}</p>
                                                        <a href="/adminpanel/markalar/{{$answer->brand->id}}" class="text-muted text-dark">#{{$answer->brand->id}} - {{$answer->brand->name}}</a>
                                                    @endforeach
                                                </div>
                                            </div>

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
                    <h5 class="card-title font-size-16">Anket ekle</h5>
                    <form method="post" action="/adminpanel/manketekle">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="title"
                                       class="col-md-3 col-form-label">Başlık</label>
                                <div class="col-md-9">
                                    <input type="text" name="title" required
                                           class="form-control" id="title"
                                           placeholder="Başlık">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="desc"
                                       class="col-md-3 col-form-label">Detay</label>
                                <div class="col-md-9">
                                    <textarea type="text" name="desc" rows="6"
                                              class="form-control"
                                              id="desc"
                                              required
                                              placeholder="Detay"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-md-3 col-form-label">Hedef</label>
                                <div class="col-md-9">
                                    <select data-plugin="customselects2" required class="form-control" name="type" >
                                        <option></option>
                                        <option value="88">Genel</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">#{{$city->id}} - {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="trueString"
                                       class="col-md-3 col-form-label">Onay Cümlesi</label>
                                <div class="col-md-9">
                                    <input type="text" name="trueString" required
                                           class="form-control" id="trueString"
                                           placeholder="Onay Cümlesi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="falseString"
                                       class="col-md-3 col-form-label">Red Cümlesi</label>
                                <div class="col-md-9">
                                    <input type="text" name="falseString" required
                                           class="form-control" id="falseString"
                                           placeholder="Red Cümlesi">
                                </div>
                            </div>
                            <div class="offset-md-3">
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
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        $('[data-plugin="customselects1"]').select2();
        $('[data-plugin="customselects2"]').select2();
        @if (session('surUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Anket güncellenmiştir.',
                type: "success",
            });
        @elseif(session('surPasif'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Anket pasifize edilmiştir.',
                type: "success",
            });
        @elseif(session('surDel'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Anket silinmiştir.',
                type: "success",
            });
        @elseif(session('surAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Anket eklenmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
