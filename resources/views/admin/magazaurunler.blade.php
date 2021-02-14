@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/adminpanel/magazalar">Mağazalar</a></li>
                    <li class="breadcrumb-item"><a href="/adminpanel/magazalar/{{$store->id}}">#{{$store->id}}
                            - {{$store->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ürünler</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Ürünler</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Toplam {{count($urunler)}} ürün listeleniyor</h5>
                    <ul class="nav nav-tabs">
                        @foreach($kategoris as $kategori)
                            <li class="nav-item">
                                <a href="#{{$kategori->code}}" data-toggle="tab" aria-expanded="false"
                                   class="nav-link @if($kategori->position == 1) active @endif ">
                                    <span class="d-block d-sm-none">{{$kategori->id}}</span>
                                    <span class="d-none d-sm-block">{{$kategori->desc}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content text-muted">
                        @foreach($kategoris as $kategori)
                            <div class="tab-pane @if($kategori->position == 1) show active @endif "
                                 id="{{$kategori->code}}">
                                <ul class="nav nav-pills navtab-bg ">
                                    @foreach($kategori->subcategories as $altkategori)
                                        <li class="nav-item">
                                            <a href="#altKategori{{$altkategori->id}}" data-toggle="tab"
                                               aria-expanded="false" class="nav-link">
                                                <span class="d-block d-sm-none">{{$altkategori->id}}</span>
                                                <span class="d-none d-sm-block">{{$altkategori->desc}}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content text-muted">
                                    @foreach($kategori->subcategories as $altkategori)
                                        <div class="tab-pane" id="altKategori{{$altkategori->id}}">
                                            <div class="table-responsive">
                                                <table class="table table-hover m-0">
                                                    <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th></th>
                                                        <th class="text-truncate">Ad</th>
                                                        <th>Aktiflik</th>
                                                        <th>Görüntülenme</th>
                                                        <th>Fiyat</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($urunler as $urun)
                                                        @if($urun->subCategoryID == $altkategori->id)
                                                            <tr>
                                                                <th scope="row">{{$urun->id}}</th>
                                                                <td>
                                                                    <div class="popup-gallery"
                                                                         data-source="{{$urun->imageLink}}">
                                                                        <a href="{{$urun->imageLink}}" title="">
                                                                            <img src="{{$urun->imageLink}}" alt="img"
                                                                                 class="avatar-md rounded">
                                                                        </a>
                                                                    </div>
                                                                </td>
                                                                <td>{{$urun->title}}</td>
                                                                @if($urun->isActive)
                                                                    <td><span
                                                                            class="badge badge-soft-success">Aktif</span>
                                                                    </td>
                                                                @else
                                                                    <td><span
                                                                            class="badge badge-soft-danger">Pasif</span>
                                                                    </td>
                                                                @endif
                                                                <td>{{$urun->views_count}}</td>
                                                                @if(is_null($urun->fee))
                                                                    <td>-</td>
                                                                @else
                                                                    <td>{{$urun->fee}}TL</td>
                                                                @endif
                                                                @if(!is_null($urun->tag1))
                                                                    @if($urun->tag1 == 1)
                                                                        <td><span
                                                                                class="badge badge-primary">Sıcak</span>
                                                                        </td>
                                                                    @elseif($urun->tag1 == 2)
                                                                        <td><span
                                                                                class="badge badge-primary">Soğuk</span>
                                                                        </td>
                                                                    @endif
                                                                    @if($urun->tag2 == 1)
                                                                        <td><span class="badge badge-primary">Kahve bazlı</span>
                                                                        </td>
                                                                    @elseif($urun->tag2 == 2)
                                                                        <td><span
                                                                                class="badge badge-primary">Süt bazlı</span>
                                                                        </td>
                                                                    @elseif($urun->tag2 == 3)
                                                                        <td><span
                                                                                class="badge badge-primary">Diğer</span>
                                                                        </td>
                                                                    @endif
                                                                    @if($urun->tag3 == 1)
                                                                        <td><span
                                                                                class="badge badge-primary">Hafif</span>
                                                                        </td>
                                                                    @elseif($urun->tag3 == 2)
                                                                        <td><span
                                                                                class="badge badge-primary">Orta</span>
                                                                        </td>
                                                                    @elseif($urun->tag3 == 3)
                                                                        <td><span
                                                                                class="badge badge-primary">Sert</span>
                                                                        </td>
                                                                    @endif
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
                                                                            <a href="javascript:void(0);" type="button"
                                                                               data-toggle="modal"
                                                                               data-target="#urunModal{{$urun->id}}"
                                                                               class="dropdown-item">Detay</a>
                                                                            @if($urun->isActive)
                                                                                <a href="javascript:void(0);"
                                                                                   type="button" data-toggle="modal"
                                                                                   data-target="#duzenleModal{{$urun->id}}"
                                                                                   class="dropdown-item">Düzenle</a>
                                                                                <a href="javascript:void(0);"
                                                                                   type="button"
                                                                                   data-id="{{$urun->id}}"
                                                                                   class="dropdown-item sa-urunPasif">Pasifize
                                                                                    et</a> @endif
                                                                            <a
                                                                                href="javascript:void(0);"
                                                                                type="button"
                                                                                data-id="{{$urun->id}}"
                                                                                class="dropdown-item text-danger sa-urunSil">Sil</a>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @foreach($urunler as $urun)
                            <div class="modal fade" id="urunModal{{$urun->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="urunModal{{$urun->id}}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="urunModal{{$urun->id}}">Ürün detay</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>{{$urun->title}}</h6>
                                            <hr>
                                            <p>{{$urun->desc}}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($urun->isActive)
                                <div class="modal fade" id="duzenleModal{{$urun->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="duzenleModal{{$urun->id}}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="duzenleModal{{$urun->id}}">Ürün düzenle</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Kapat">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form enctype="multipart/form-data" method="post"
                                                      action="/adminpanel/urunguncelle">
                                                    @csrf
                                                    <fieldset>
                                                        <input type="hidden" name="urunID" value="{{$urun->id}}">
                                                        <div class="form-group row">
                                                            <label for="title"
                                                                   class="col-md-2 col-form-label">Ad</label>
                                                            <div class="col-md-10">
                                                                <input type="text" name="title" required
                                                                       class="form-control" id="title"
                                                                       placeholder="Başlık" value="{{$urun->title}}">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="desc"
                                                                   class="col-md-2 col-form-label">Açıklama</label>
                                                            <div class="col-md-10">
                                                        <textarea type="text" name="desc" rows="10"
                                                                  class="form-control"
                                                                  id="desc"
                                                                  required
                                                                  placeholder="Detay">{{$urun->desc}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="fee"
                                                                   class="col-md-2 col-form-label">Fiyat</label>
                                                            <div class="col-md-10">
                                                                <input type="text" name="fee" class="form-control" data-inputmask-alias="9{1,4}.99" id="fee" placeholder="Fiyat" value="{{$urun->fee}}">
                                                            </div>
                                                        </div>
                                                        @if(!is_null($urun->tag1))
                                                            <div class="form-group row">
                                                                <label for="tag1"
                                                                       class="col-md-2 col-form-label">Sıcaklık</label>
                                                                <div class="col-md-10">
                                                                    <select data-plugin="customselect" class="form-control" name="tag1" required >
                                                                        <option value="1" @if($urun->tag1 == 1) selected @endif >Sıcak</option>
                                                                        <option value="2" @if($urun->tag1 == 2) selected @endif >Soğuk</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tag2"
                                                                       class="col-md-2 col-form-label">Baz</label>
                                                                <div class="col-md-10">
                                                                    <select data-plugin="customselect" class="form-control" name="tag2" required >
                                                                        <option value="1" @if($urun->tag2 == 1) selected @endif >Kahve bazlı</option>
                                                                        <option value="2" @if($urun->tag2 == 2) selected @endif >Süt bazlı</option>
                                                                        <option value="3" @if($urun->tag2 == 3) selected @endif >Diğer</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="tag3"
                                                                       class="col-md-2 col-form-label">Sertlik</label>
                                                                <div class="col-md-10">
                                                                    <select data-plugin="customselect" class="form-control" name="tag3" required >
                                                                        <option value="1" @if($urun->tag3 == 1) selected @endif >Hafif</option>
                                                                        <option value="2" @if($urun->tag3 == 2) selected @endif >Orta</option>
                                                                        <option value="3" @if($urun->tag3 == 3) selected @endif >Sert</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="form-group row">
                                                            <label for="subCategoryID"
                                                                   class="col-md-2 col-form-label">Alt kategori</label>
                                                            <div class="col-md-10">
                                                                <select data-plugin="customselect" class="form-control" name="subCategoryID" required >
                                                                    @foreach($altkategoris as $altkategori)
                                                                        @if($urun->categoryID == $altkategori->categoryID)
                                                                            <option value="{{$altkategori->id}}" @if($urun->subCategoryID == $altkategori->id) selected @endif >{{$altkategori->desc}}({{$altkategori->maincategory->desc}})</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label for="image{{$urun->id}}"
                                                                   class="col-md-2 col-form-label">Görsel</label>
                                                            <div class="col-md-10">
                                                                <input type="file" id="image{{$urun->id}}" name="image"
                                                                       data-max-file-size="1M" data-show-loader="true"
                                                                       data-allowed-formats="square"
                                                                       data-allowed-file-extensions="png jpg jpeg"
                                                                       class="dropify"/>
                                                            </div>

                                                        </div>
                                                        <div class="offset-md-2">
                                                            <input type="submit" class="btn btn-primary"
                                                                   value="Güncelle">
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    @foreach($kategoris as $kategori)
                        <h6 class="card-title font-size-16">{{$kategori->desc}}</h6>
                        @if(count($urunler->where('categoryID',$kategori->id)))
                            @foreach($kategori->subcategories as $altkategori)
                                <p class="card-text text-muted">{{$altkategori->desc}}
                                    : {{count($urunler->where('subCategoryID',$altkategori->id))}} ürün</p>
                            @endforeach
                        @else
                            <p class="card-text text-muted">Ürün yok</p>
                        @endif

                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        @foreach($urunler as $urun)
        $('#image' + '{{$urun->id}}').dropify();
        @endforeach
        @if (session('urunPasif'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Ürün pasif hale getirilmiştir.',
            type: "success",
        });
        @elseif(session('urunSil'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Ürün silinmiştir.',
            type: "success",
        });
        @elseif(session('urunNotActive'))
        swal.fire({
            title: 'Uyarı!',
            text: 'Ürün aktif olmadığı için düzenleyemezsiniz.',
            type: "warning",
        });
        @elseif(session('urunUp'))
        swal.fire({
            title: 'Başarılı!',
            text: 'Ürün güncellenmiştir.',
            type: "success",
        });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js') }}"></script>
@endsection
