@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
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
                    <li class="breadcrumb-item active" aria-current="page">Yazılar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Yazılar</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif yazılar</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Mağaza Adı</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme</th>
                            <th>Favori Sayısı</th>
                            <th>Video</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($yazis->where('isActive',true) as $yazi)
                            <tr>
                                <td>{{$yazi->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$yazi->imageLink}}">
                                        <a href="{{$yazi->imageLink}}" title="">
                                            <img src="{{$yazi->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>#{{$yazi->store->id}} - {{$yazi->store->name}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$yazi->viewCount}}</td>
                                <td>{{$yazi->favorites_count}}</td>
                                @if($yazi->hasVideo)
                                    <td><span class="badge badge-soft-success">Olumlu</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Olumsuz</span></td>
                                @endif
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
                                               data-target="#yaziModal{{$yazi->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);"
                                               type="button" data-toggle="modal"
                                               data-target="#duzenleModal{{$yazi->id}}"
                                               class="dropdown-item">Düzenle</a>
                                            <a href="javascript:void(0);"
                                               type="button"
                                               data-id="{{$yazi->id}}"
                                               class="dropdown-item sa-yaziPasif">Pasifize
                                                et</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$yazi->id}}"
                                               class="dropdown-item text-danger sa-yaziSil">Sil</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($yazis->where('isActive',true) as $yazi)
                        <div class="modal fade" id="yaziModal{{$yazi->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="yaziModal{{$yazi->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="yaziModal{{$yazi->id}}">Yazı detay</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>{{$yazi->title}}</h6>
                                        <hr>
                                        <p>{{$yazi->desc}}</p>
                                        @if($yazi->hasVideo)
                                            <hr>
                                            <td>Video bağlantısı: {{$yazi->videoLink}}</td>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="duzenleModal{{$yazi->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="duzenleModal{{$yazi->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="duzenleModal{{$yazi->id}}">Yazı düzenle</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype="multipart/form-data" method="post"
                                              action="/adminpanel/yaziguncelle">
                                            @csrf
                                            <fieldset>
                                                <input type="hidden" name="articleID" value="{{$yazi->id}}">
                                                <div class="form-group row">
                                                    <label for="title"
                                                           class="col-md-2 col-form-label">Başlık</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="title" required
                                                               class="form-control" id="title"
                                                               placeholder="Başlık" value="{{$yazi->title}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="desc" class="col-md-2 col-form-label">Açıklama</label>
                                                    <div class="col-md-10">
                                                            <textarea type="text" name="desc" rows="15"
                                                                      class="form-control"
                                                                      id="desc"
                                                                      required
                                                                      placeholder="Detay">{{$yazi->desc}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="image"
                                                           class="col-md-2 col-form-label">Görsel</label>
                                                    <div class="col-md-10">
                                                        <input type="file" id="image{{$yazi->id}}" name="image"
                                                               data-max-file-size="1M" data-show-loader="true"
                                                               data-allowed-formats="square"
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
                    <h5 class="header-title mb-3 mt-4">Pasif yazılar</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Mağaza Adı</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme</th>
                            <th>Favori Sayısı</th>
                            <th>Video</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($yazis->where('isActive',false) as $yazi)
                            <tr>
                                <td>{{$yazi->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$yazi->imageLink}}">
                                        <a href="{{$yazi->imageLink}}" title="">
                                            <img src="{{$yazi->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>#{{$yazi->store->id}} - {{$yazi->store->name}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($yazi->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$yazi->viewCount}}</td>
                                <td>{{$yazi->favorites_count}}</td>
                                @if($yazi->hasVideo)
                                    <td><span class="badge badge-soft-success">Olumlu</span></td>
                                @else
                                    <td><span class="badge badge-soft-danger">Olumsuz</span></td>
                                @endif
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
                                               data-target="#yaziModal{{$yazi->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);"
                                               type="button"
                                               data-id="{{$yazi->id}}"
                                               class="dropdown-item text-danger sa-yaziSil">Sil</a>

                                        </div>
                                    </div>


                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($yazis->where('isActive',false) as $yazi)
                        <div class="modal fade" id="yaziModal{{$yazi->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="yaziModal{{$yazi->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="yaziModal{{$yazi->id}}">Yazı detay</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>{{$yazi->title}}</h6>
                                        <hr>
                                        <p>{{$yazi->desc}}</p>
                                        @if($yazi->hasVideo)
                                            <hr>
                                            <td>Video bağlantısı: {{$yazi->videoLink}}</td>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Aktif yazı sayısı: {{count($yazis->where('isActive',true))}}</p>
                    <p class="card-text text-muted">Pasif yazı sayısı: {{count($yazis->where('isActive',false))}}</p>
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
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script>
        @foreach($yazis->where('isActive',true) as $yazi)
        $('#image'+'{{$yazi->id}}').dropify();
        @endforeach
        @if (session('yaziSil'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Yazı silinmiştir.',
                type: "success",
            });
        @elseif(session('yaziPasif'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Yazı pasif hale getirilmiştir.',
                type: "success",
            });
        @elseif(session('yaziUp'))
            swal.fire({
                title: 'Başarılı!',
                text: 'Yazı güncellenmiştir.',
                type: "success",
            });
        @elseif(session('yaziNotActive'))
            swal.fire({
                title: 'Uyarı!',
                text: 'Yazı aktif olmadığı için güncelleyemezsiniz.',
                type: "warning",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
