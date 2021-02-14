@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
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
                    <li class="breadcrumb-item active" aria-current="page">Duyurular</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Duyurular</h4>
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
                                <th></th>
                                <th>Marka</th>
                                <th>Pozisyon</th>
                                <th>Görüntülenme Sayısı</th>
                                <th>Eklenme Tarihi</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($duyurus as $duyuru)
                                <tr>
                                    <th scope="row">{{$duyuru->id}}</th>
                                    <td>
                                        <div class="popup-gallery" data-source="{{$duyuru->imageLink}}">
                                            <a href="{{$duyuru->imageLink}}" title="">
                                                <img src="{{$duyuru->imageLink}}" alt="img" class="avatar-md rounded">
                                            </a>
                                        </div>
                                    </td>
                                    @if(!is_null($duyuru->brandID))
                                        <td><a class="card-link text-muted"
                                               href="/adminpanel/markalar/{{$duyuru->brand->id}}">#{{$duyuru->brand->id}}
                                                - {{$duyuru->brand->name}}</a></td>
                                    @else
                                        <td>Kafeyin</td>
                                    @endif
                                    <td>{{$duyuru->position}}</td>
                                    <td>{{$duyuru->viewCount}}</td>
                                    <td>{{\Carbon\Carbon::createFromTimeString($duyuru->created_at)->format('d/m/Y H:i')}}</td>
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
                                                <a href="javascript:void(0);" type="button" data-toggle="modal" data-target="#duyuruModal{{$duyuru->id}}"
                                                   class="dropdown-item">Detay</a>
                                                <a href="javascript:void(0);" type="button" data-toggle="modal"
                                                   data-target="#duyuruUp{{$duyuru->id}}"
                                                   class="dropdown-item">Düzenle</a>
                                                <a href="javascript:void(0);"
                                                   type="button"
                                                   data-id="{{$duyuru->id}}"
                                                   class="dropdown-item text-danger sa-duySil">Sil</a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @foreach($duyurus as $duyuru)
                            <div class="modal fade" id="duyuruModal{{$duyuru->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="duyuruModal{{$duyuru->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="duyuruModal{{$duyuru->id}}">Duyuru detay</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>{{$duyuru->title}}</h6>
                                            <hr>
                                            <p>{{$duyuru->desc}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="duyuruUp{{$duyuru->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="duyuruUp{{$duyuru->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="duyuruUp{{$duyuru->id}}">Duyuru düzenle</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form enctype="multipart/form-data" method="post"
                                                  action="/adminpanel/duyuruguncelle">
                                                @csrf
                                                <fieldset>
                                                    <input type="hidden" name="announcementID" value="{{$duyuru->id}}">
                                                    <div class="form-group row">
                                                        <label for="title"
                                                               class="col-md-2 col-form-label">Başlık</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="title" required
                                                                   class="form-control" id="title"
                                                                   placeholder="Başlık" value="{{$duyuru->title}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="desc"
                                                               class="col-md-2 col-form-label">Açıklama</label>
                                                        <div class="col-md-10">
                                                            <textarea type="text" name="desc" rows="15"
                                                                      class="form-control"
                                                                      id="desc"
                                                                      required
                                                                      placeholder="Detay">{{$duyuru->desc}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="brand"
                                                               class="col-md-2 col-form-label">Marka</label>
                                                        <div class="col-md-10">
                                                            <input type="text" name="brand" readonly
                                                                   class="form-control" id="brand"
                                                                   placeholder="Başlık"
                                                                   @if(!is_null($duyuru->brandID)) value="#{{$duyuru->brand->id}} - {{$duyuru->brand->name}}"
                                                                   @else value="Kafeyin" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="position"
                                                               class="col-md-2 col-form-label">Pozisyon</label>
                                                        <div class="col-md-10">
                                                            <input type="number" name="position" required
                                                                   class="form-control" id="position"
                                                                   placeholder="Pozisyon" value="{{$duyuru->position}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="image"
                                                               class="col-md-2 col-form-label">Görsel</label>
                                                        <div class="col-md-10">
                                                            <input type="file" id="image{{$duyuru->id}}" name="image"
                                                                   data-max-file-size="1M" data-show-loader="true"
                                                                   data-allowed-formats="landscape"
                                                                   data-allowed-file-extensions="png jpg jpeg"
                                                                   class="dropify"/>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Duyuru ekle</h5>
                    <form method="post" enctype="multipart/form-data" action="/adminpanel/duyuruekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" name="cityID" value="{{$city->id}}">
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
                                    <textarea type="text" name="desc" rows="15"
                                              class="form-control"
                                              id="desc"
                                              required
                                              placeholder="Detay"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="brandID" class="col-md-3 col-form-label">Marka</label>
                                <div class="col-md-9">
                                    <select data-plugin="customselects1" class="form-control" name="brandID" >
                                        <option></option>
                                        @foreach($markas as $marka)
                                            <option value="{{$marka->id}}">#{{$marka->id}} - {{$marka->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="position"
                                       class="col-md-3 col-form-label">Pozisyon</label>
                                <div class="col-md-9">
                                    <input type="number" name="position" required
                                           class="form-control" id="position"
                                           placeholder="Pozisyon">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image"
                                       class="col-md-3 col-form-label">Görsel</label>
                                <div class="col-md-9">
                                    <input type="file" id="image" name="image" required
                                           data-max-file-size="1M" data-show-loader="true"
                                           data-allowed-formats="landscape"
                                           data-allowed-file-extensions="png jpg jpeg"
                                           class="dropify"/>
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
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        @foreach($duyurus as $duyuru)
        //$('[data-plugin="customselect{}}"]').select2();

        $('#image' + '{{$duyuru->id}}').dropify();
        @endforeach

        $('[data-plugin="customselects1"]').select2();
        @if (session('duyUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Duyuru bilgileri güncellenmiştir.',
            type: "success",
        });
        @elseif (session('duyAdd'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Duyuru eklenmiştir.',
            type: "success",
        });
        @elseif (session('duyDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Duyuru silinmiştir.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
