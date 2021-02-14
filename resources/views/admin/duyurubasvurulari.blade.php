@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Başvurular</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Duyuru Başvuruları</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Duyuru Başvuruları</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Onay bekleyen başvurular</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marka</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Son Güncellenme Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($applications->where('status','need_approval') as $application)
                            <tr>
                                <th scope="row">{{$application->id}}</th>
                                <td><a class="text-muted" href="/adminpanel/markalar/{{$application->brand->id}}">#{{$application->brand->id}} - {{$application->brand->name}}</a></td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$application->imageLink}}">
                                        <a href="{{$application->imageLink}}" title="">
                                            <img src="{{$application->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$application->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->updated_at)->format('d/m/Y H:i')}}</td>
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
                                               data-target="#descModal{{$application->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#upUpModal{{$application->id}}"
                                               class="dropdown-item">Güncelleme iste</a>
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#approveModal{{$application->id}}"
                                               class="dropdown-item">Onayla</a>
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#rejectModal{{$application->id}}"
                                               class="dropdown-item">Reddet</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$application->id}}"
                                               class="dropdown-item text-danger sa-dBasvuruSil">Sil</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Güncelleme bekleyen başvurular</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marka</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Son Güncellenme Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($applications->where('status','need_update') as $application)
                            <tr>
                                <th scope="row">{{$application->id}}</th>
                                <td><a class="text-muted" href="/adminpanel/markalar/{{$application->brand->id}}">#{{$application->brand->id}} - {{$application->brand->name}}</a></td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$application->imageLink}}">
                                        <a href="{{$application->imageLink}}" title="">
                                            <img src="{{$application->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$application->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->updated_at)->format('d/m/Y H:i')}}</td>
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
                                               data-target="#descModal{{$application->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#upUpModal{{$application->id}}"
                                               class="dropdown-item">Güncelleme iste</a>
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#rejectModal{{$application->id}}"
                                               class="dropdown-item">Reddet</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$application->id}}"
                                               class="dropdown-item text-danger sa-dBasvuruSil">Sil</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Onaylanan başvurular</h5>
                    <table id="dtCommon3" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marka</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Son Güncellenme Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($applications->where('status','approved') as $application)
                            <tr>
                                <th scope="row">{{$application->id}}</th>
                                <td><a class="text-muted" href="/adminpanel/markalar/{{$application->brand->id}}">#{{$application->brand->id}} - {{$application->brand->name}}</a></td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$application->imageLink}}">
                                        <a href="{{$application->imageLink}}" title="">
                                            <img src="{{$application->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$application->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->updated_at)->format('d/m/Y H:i')}}</td>
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
                                               data-target="#descModal{{$application->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-toggle="modal"
                                               data-target="#rejectModal{{$application->id}}"
                                               class="dropdown-item">Reddet</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$application->id}}"
                                               class="dropdown-item text-danger sa-dBasvuruSil">Sil</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Reddedilen başvurular</h5>
                    <table id="dtCommon4" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marka</th>
                            <th></th>
                            <th>Başlık</th>
                            <th>Oluşturulma Tarihi</th>
                            <th>Son Güncellenme Tarihi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($applications->where('status','rejected') as $application)
                            <tr>
                                <th scope="row">{{$application->id}}</th>
                                <td><a class="text-muted" href="/adminpanel/markalar/{{$application->brand->id}}">#{{$application->brand->id}} - {{$application->brand->name}}</a></td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$application->imageLink}}">
                                        <a href="{{$application->imageLink}}" title="">
                                            <img src="{{$application->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>{{$application->title}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($application->updated_at)->format('d/m/Y H:i')}}</td>
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
                                               data-target="#descModal{{$application->id}}"
                                               class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$application->id}}"
                                               class="dropdown-item text-danger sa-dBasvuruSil">Sil</a>

                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @foreach($applications as $duyuru)
                <div class="modal fade" id="descModal{{$duyuru->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="descModal{{$duyuru->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="descModal{{$duyuru->id}}">Başvuru detay</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6>{{$duyuru->title}}</h6>
                                <hr>
                                <p>{{$duyuru->desc}}</p>
                                @if($duyuru->status == "need_approval")
                                    <p class="text-primary">Durum: Onay bekliyor</p>
                                @elseif($duyuru->status == "need_update")
                                    <p class="text-primary">Durum: Güncelleme bekliyor</p>
                                @elseif($duyuru->status == "approved")
                                    <p class="text-success">Durum: Onaylandı</p>
                                @elseif($duyuru->status == "rejected")
                                    <p class="text-danger">Durum: Reddedildi</p>
                                @endif
                                @if($duyuru->adminMessage)
                                    <hr>
                                    <td>Admin notu: {{$duyuru->adminMessage}}</td>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="upUpModal{{$duyuru->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="upUpModal{{$duyuru->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="upUpModal{{$duyuru->id}}">Güncelleme iste</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form  method="post"
                                      action="/adminpanel/basvuruguncellemeiste">
                                    @csrf
                                    <fieldset>
                                        <input type="hidden" name="duyuruBasID" value="{{$duyuru->id}}">
                                        <div class="form-group row">
                                            <label for="reason"
                                                   class="col-md-2 col-form-label">Neden</label>
                                            <div class="col-md-10">
                                                <input type="text" name="reason" required
                                                       class="form-control" id="reason"
                                                       placeholder="Neden" value="{{$duyuru->adminMessage}}">
                                            </div>
                                        </div>

                                        <div class="offset-md-2">
                                            <input type="submit" class="btn btn-primary ml-1" value="Güncelle">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="rejectModal{{$duyuru->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="rejectModal{{$duyuru->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectModal{{$duyuru->id}}">Reddet</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post"
                                      action="/adminpanel/basvurureddet">
                                    @csrf
                                    <fieldset>
                                        <input type="hidden" name="duyuruBasID" value="{{$duyuru->id}}">
                                        <div class="form-group row">
                                            <label for="reason"
                                                   class="col-md-2 col-form-label">Neden</label>
                                            <div class="col-md-10">
                                                <input type="text" name="reason" required
                                                       class="form-control" id="reason"
                                                       placeholder="Neden" >
                                            </div>
                                        </div>

                                        <div class="offset-md-2">
                                            <input type="submit" class="btn btn-primary ml-1" value="Reddet">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="approveModal{{$duyuru->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="approveModal{{$duyuru->id}}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="approveModal{{$duyuru->id}}">Onayla</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post"
                                      action="/adminpanel/basvuruonayla">
                                    @csrf
                                    <fieldset>
                                        <input type="hidden" name="duyuruBasID" value="{{$duyuru->id}}">
                                        <div class="form-group row">
                                            <label for="adminMessage"
                                                   class="col-md-2 col-form-label">Mesaj</label>
                                            <div class="col-md-10">
                                                <input type="text" name="adminMessage" required
                                                       class="form-control" id="adminMessage"
                                                       placeholder="Tarih aralığı açıklamalı" value="Duyurunuz dd/mm/YYYY 00:00 tarihinde yayınlanacak olup dd/mm/YYYY 23:59 tarihinde yayından kaldırılacaktır." >
                                            </div>
                                        </div>

                                        <div class="offset-md-2">
                                            <input type="submit" class="btn btn-primary ml-1" value="Onayla">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">İstatistikler</h5>
                    <p class="card-text text-muted">Onay bekleyen başvuru sayısı: {{count($applications->where('status','need_approval'))}}</p>
                    <p class="card-text text-muted">Güncelleme bekleyen başvuru sayısı: {{count($applications->where('status','need_update'))}}</p>
                    <p class="card-text text-muted">Onaylanan başvuru sayısı: {{count($applications->where('status','approved'))}}</p>
                    <p class="card-text text-muted">Reddedilen başvuru sayısı: {{count($applications->where('status','rejected'))}}</p>
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
    <script>
        @if (session('applUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Başvuru detayı güncellenmiştir.',
            type: "success",
        });
        @elseif(session('applRejected'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Başvuru reddedilmiştir.',
            type: "success",
        });
        @elseif(session('dBasDel'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Başvuru silinmiştir.',
            type: "success",
        });
        @elseif(session('dBasApproved'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Başvuru onaylanmıştır.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
