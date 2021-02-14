@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Ürün alt kategorileri</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    <h5 class="header-title mb-3 mt-0">Kategoriler</h5>
                    <div class="custom-accordion accordion ml-4" id="kategori_akordiyon">
                        @foreach($categories as $kategori)
                            <div class="card mb-1">
                                <a href="" class="text-dark" data-toggle="collapse" data-target="#akordiyonCollapse{{$kategori->id}}"
                                  @if(session('catName') && session('catName') == $kategori->desc ) aria-expanded="true" @else aria-expanded="false" @endif   aria-controls="akordiyonCollapse{{$kategori->id}}">
                                    <div class="card-header" id="akordiyonHeading{{$kategori->id}}">
                                        <h5 class="m-0 font-size-14">
                                            <i class="uil uil-arrow-circle-right bg-white h3 text-primary icon"></i>
                                            {{$kategori->desc}} alt kategorileri
                                        </h5>
                                    </div>
                                </a>
                                <div id="akordiyonCollapse{{$kategori->id}}"  @if(session('catName') && session('catName') == $kategori->desc ) class="collapse show" @else class="collapse" @endif aria-labelledby="akordiyonHeading{{$kategori->id}}"
                                     data-parent="#kategori_akordiyon">
                                    <div class="card-body text-muted">
                                        <div class="row ml-4">
                                            @foreach($kategori->subcategories as $altKat)
                                                <a class="btn btn-md btn-primary mr-3 mt-1" type="button" tabindex="0" data-toggle="popover"
                                                     data-trigger="focus" title="" data-placement="bottom"
                                                   data-html="true"
                                                     data-content="
                                                    @foreach($user->brand->stores as $store)
                                                         {{$store->name}} (ID:KFYN{{$store->id}}): {{count($store->menu_items->where('subCategoryID',$altKat->id))}} ürün<br>
                                                     @endforeach"
                                                     data-original-title="{{$altKat->desc}}">{{$altKat->desc}}</a>
                                            @endforeach
                                            <span data-toggle="modal" data-target="#kategoriEkleModal" data-katname="{{$kategori->desc}}" data-id="{{$kategori->id}}">
                                                <a class="btn btn-md align-self-center btn-outline-primary mt-1" data-toggle="tooltip" data-placement="bottom"
                                                   title="{{$kategori->desc}} kategorisi için yeni alt kategori" href="javascript:void(0);">
                                                <i class="uil-plus mt-3 font-size-12"></i> Ekle
                                            </a>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    <p class="font-weight-bold text-primary">Eklediğiniz alt kategoriyi silemez veya düzenleyemezsiniz. Konu ile ilgili yardım için "destek@kafeyinapp.com" e-posta adresi üzerinden bizimle iletişime geçebilirsiniz.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kategoriEkleModal" tabindex="-1" role="dialog"
         aria-labelledby="kategoriEkleModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kategoriEkleModal">Alt Kategori Ekle</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="/yoneticipaneli/altkategoriekle">
                        @csrf
                        <fieldset>
                            <input type="hidden" id="catID" name="catID">
                            <div class="form-group row">
                                <label for="cat" class="col-md-4 col-form-label">Kategori</label>
                                <div class="col-md-8">
                                    <input type="text" name="katname" disabled readonly class="form-control" id="katname"
                                           >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subCatName" class="col-md-4 col-form-label">Yeni alt kategori adı</label>
                                <div class="col-md-8">
                                    <input type="text" name="subCatName" minlength="2" maxlength="35" required class="form-control"
                                           id="subCatName"
                                           placeholder="Yeni alt kategori adı">
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
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#kategoriEkleModal').on('show.bs.modal', function(e) {
                var katname = $(e.relatedTarget).data('katname');
                var id = $(e.relatedTarget).data('id');
                $('#katname').val(katname);
                $('#catID').val(id);
            });
        });

    </script>
    <script>
        @if(session('subCatAdd'))
            swal.fire({
                title: 'Başarılı!',
                text: "{{session('catName')}} kategorisine {{session('newSCatName')}} alt kategorisi eklendi.",
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
