@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler">Şehirler</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/sehirler/{{$city->id}}">#{{$city->id}}
                            - {{$city->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Etkinlikler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Etkinlikler</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Aktif etkinlikler</h5>
                    <table id="dtCommon" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Mağaza Adı</th>
                            <th>Tarih - Saat</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th>Biletleme</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($etkinliks->where('isActive',true) as $etkinlik)
                            <tr>
                                <td>{{$etkinlik->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$etkinlik->imageLink}}">
                                        <a href="{{$etkinlik->imageLink}}" title="">
                                            <img src="{{$etkinlik->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>#{{$etkinlik->store->id}} - {{$etkinlik->store->name}}</td>
                                <td>{{$etkinlik->date}} {{$etkinlik->time}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($etkinlik->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$etkinlik->viewCount}}</td>
                                <td>{{$etkinlik->favorites_count}}</td>
                                @if($etkinlik->canTicketing)
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
                                               data-target="#etkinlikModal{{$etkinlik->id}}" class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);"
                                               type="button" data-toggle="modal"
                                               data-target="#duzenleModal{{$etkinlik->id}}"
                                               class="dropdown-item">Düzenle</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$etkinlik->id}}"
                                               class="dropdown-item sa-etkPasif">Pasifize et</a>
                                            <a
                                                href="javascript:void(0);" type="button" data-id="{{$etkinlik->id}}"
                                                class="dropdown-item text-danger sa-etkSil">Sil</a>
                                        </div>
                                    </div>



                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($etkinliks->where('isActive',true) as $etkinlik)
                        <div class="modal fade" id="etkinlikModal{{$etkinlik->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="etkinlikModal{{$etkinlik->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="$etkinlik->id">Etkinlik detay</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>{{$etkinlik->title}}</h6>
                                        <hr>
                                        <p>{{$etkinlik->desc}}</p>
                                        @if($etkinlik->canTicketing)
                                            <hr>
                                            <p>Bilet fiyatı: {{$etkinlik->ticketFee}}TL</p>
                                            <p>Kalan bilet sayısı: {{$etkinlik->availableTicketCount}}</p>
                                            <a class="card-link" target="_blank"
                                               href="/adminpanel/etkinlikler/{{$etkinlik->id}}/biletler">Biletler</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="duzenleModal{{$etkinlik->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="duzenleModal{{$etkinlik->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="duzenleModal{{$etkinlik->id}}">Etkinlik düzenle</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype="multipart/form-data" method="post"
                                              action="/adminpanel/etkguncelle">
                                            @csrf
                                            <fieldset>
                                                <input type="hidden" name="activityID" value="{{$etkinlik->id}}">
                                                <div class="form-group row">
                                                    <label for="title"
                                                           class="col-md-2 col-form-label">Başlık</label>
                                                    <div class="col-md-10">
                                                        <input type="text" name="title" required
                                                               class="form-control" id="title"
                                                               placeholder="Başlık" value="{{$etkinlik->title}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date"
                                                           class="col-md-2 col-form-label">Tarih</label>
                                                    <div class="col-md-10">
                                                        <input type="text" id="basic-datepicker{{$etkinlik->id}}" name="date" class="form-control" value="{{$etkinlik->date}}" placeholder="Tarih">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="time"
                                                           class="col-md-2 col-form-label">Saat</label>
                                                    <div class="col-md-10">
                                                        <input type="text" id="24hours-timepicker{{$etkinlik->id}}" name="time" class="form-control" value="{{$etkinlik->time}}" placeholder="Saat">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="desc" class="col-md-2 col-form-label">Açıklama</label>
                                                    <div class="col-md-10">
                                                            <textarea type="text" name="desc" rows="15"
                                                                      class="form-control"
                                                                      id="desc"
                                                                      required
                                                                      placeholder="Detay">{{$etkinlik->desc}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="image"
                                                           class="col-md-2 col-form-label">Görsel</label>
                                                    <div class="col-md-10">
                                                        <input type="file" id="image{{$etkinlik->id}}" name="image"
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
                    <h5 class="header-title mb-3 mt-4">Pasif etkinlikler</h5>
                    <table id="dtCommon2" class="table table-hover dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Mağaza Adı</th>
                            <th>Tarih</th>
                            <th>Saat</th>
                            <th>Eklenme Tarihi</th>
                            <th>Görüntülenme Sayısı</th>
                            <th>Favori Sayısı</th>
                            <th>Biletleme</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($etkinliks->where('isActive',false) as $etkinlik)
                            <tr>
                                <td>{{$etkinlik->id}}</td>
                                <td>
                                    <div class="popup-gallery" data-source="{{$etkinlik->imageLink}}">
                                        <a href="{{$etkinlik->imageLink}}" title="">
                                            <img src="{{$etkinlik->imageLink}}" alt="img" class="avatar-md rounded">
                                        </a>
                                    </div>
                                </td>
                                <td>#{{$etkinlik->store->id}} - {{$etkinlik->store->name}}</td>
                                <td>{{$etkinlik->date}}</td>
                                <td>{{$etkinlik->time}}</td>
                                <td>{{\Carbon\Carbon::createFromTimeString($etkinlik->created_at)->format('d/m/Y H:i')}}</td>
                                <td>{{$etkinlik->viewCount}}</td>
                                <td>{{$etkinlik->favorites_count}}</td>
                                @if($etkinlik->canTicketing)
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
                                               data-target="#etkinlikModal{{$etkinlik->id}}" class="dropdown-item">Detay</a>
                                            <a href="javascript:void(0);" type="button" data-id="{{$etkinlik->id}}"
                                                class="dropdown-item text-danger sa-etkSil">Sil</a>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($etkinliks->where('isActive',false) as $etkinlik)
                        <div class="modal fade" id="etkinlikModal{{$etkinlik->id}}" tabindex="-1" role="dialog"
                             aria-labelledby="etkinlikModal{{$etkinlik->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="$etkinlik->id">Etkinlik detay</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <h6>{{$etkinlik->title}}</h6>
                                        <hr>
                                        <p>{{$etkinlik->desc}}</p>
                                        @if($etkinlik->canTicketing)
                                            <hr>
                                            <p>Bilet fiyatı: {{$etkinlik->ticketFee}}TL</p>
                                            <p>Kalan bilet sayısı: {{$etkinlik->availableTicketCount}}</p>
                                            <a class="card-link" target="_blank"
                                               href="/adminpanel/etkinlikler/{{$etkinlik->id}}/biletler">Biletler</a>
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
                    <p class="card-text text-muted">Aktif etkinlik
                        sayısı: {{count($etkinliks->where('isActive',true))}}</p>
                    <p class="card-text text-muted">Pasif etkinlik
                        sayısı: {{count($etkinliks->where('isActive',false))}}</p>
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
    <script src="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        @foreach($etkinliks->where('isActive',true) as $etkinlik)
        $('#image'+'{{$etkinlik->id}}').dropify();
        $('#basic-datepicker'+"{{$etkinlik->id}}").flatpickr();
        $('#24hours-timepicker'+"{{$etkinlik->id}}").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
        @endforeach
        @if (session('etkPasif'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Etkinlik pasif hale getirilmiştir.',
            type: "success",
        });
        @elseif(session('etkSil'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Etkinlik silinmiştir.',
            type: "success",
        });
        @elseif(session('etkUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Etkinlik güncellenmiştir.',
            type: "success",
        });
        @elseif(session('etkNotActive'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Etkinlik aktif olmadığı için güncelleyemezsiniz.',
            type: "warning",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
