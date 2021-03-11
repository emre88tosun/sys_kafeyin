@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">QR Kodlar</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->magaza->name}} ({{$user->magaza->location->name}}, {{$user->magaza->city->name}})</h4>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body p-0">
                    <ul class="nav nav-tabs">
                        @foreach($categories as $category)
                            @if($loop->first)
                                <li class="nav-item">
                                    <a href="#{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                        <span class="d-block d-sm-none">{{$category->desc}}</span>
                                        <span class="d-none d-sm-block">{{$category->desc}}</span>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="#{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        <span class="d-block d-sm-none">{{$category->desc}}</span>
                                        <span class="d-none d-sm-block">{{$category->desc}}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        @foreach($categories as $category)
                            @if($loop->first)
                                <div class="tab-pane show active" id="{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}">
                                    @if(count($category->items))
                                        <div class="accordion custom-accordionwitharrow" id="akordiyon{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}">
                                            <div class="row">
                                                @foreach($category->items as $item)
                                                    <div class="col-xl-4 ">
                                                        <div class="card mb-1 shadow-none border">
                                                            <a href="" class="text-dark" data-toggle="collapse" data-target="#collapse-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}"
                                                               aria-expanded="true" aria-controls="collapse-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}">
                                                                <div class="card-header" id="heading-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}">
                                                                    <h5 class="m-0 font-size-16">
                                                                        {{$item->title}} (ID: URN{{$item->id}}) <i class="uil uil-angle-down float-right accordion-arrow"></i>
                                                                    </h5>
                                                                </div>
                                                            </a>
                                                            <div id="collapse-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}" class="collapse" aria-labelledby="heading-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}"
                                                                 data-parent="#akordiyon{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}">
                                                                <div class="card-body text-muted">
                                                                    {{$item->title}} (ID: URN{{$item->id}})
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12 text-center pt-5" style="height: 23vh">
                                            <i class="uil  uil-mobey-bill-slash font-size-56 "></i>
                                            <p class="font-weight-bold">{{$category->desc}} kategorisinde hiçbir ürününüze ait QR kod bulunmamaktadır.</p>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="tab-pane" id="{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}">
                                    @if(count($category->items))
                                        <div class="accordion custom-accordionwitharrow" id="akordiyon{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}">
                                            <div class="row">
                                                @foreach($category->items as $item)
                                                    <div class="col-xl-4 ">
                                                        <div class="card mb-1 shadow-none border">
                                                            <a href="" class="text-dark" data-toggle="collapse" data-target="#collapse-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}"
                                                               aria-expanded="true" aria-controls="collapse-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}">
                                                                <div class="card-header" id="heading-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}">
                                                                    <h5 class="m-0 font-size-16">
                                                                        {{$item->title}} (ID:URN{{$item->id}}) <i class="uil uil-angle-down float-right accordion-arrow"></i>
                                                                    </h5>
                                                                </div>
                                                            </a>
                                                            <div id="collapse-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}" class="collapse" aria-labelledby="heading-{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $item->title)))}}"
                                                                 data-parent="#akordiyon{{strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $category->desc)))}}">
                                                                <div class="card-body text-muted">
                                                                    {{$item->title}} (ID:URN{{$item->id}})
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12 text-center pt-5" style="height: 23vh">
                                            <i class="uil  uil-mobey-bill-slash font-size-56 "></i>
                                            <p class="font-weight-bold">{{$category->desc}} kategorisinde hiçbir ürününüze ait QR kod bulunmamaktadır.</p>
                                        </div>
                                    @endif
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
                    <h5 class="card-title font-size-16">Bilgi</h5>

                    <hr>
                    <p class="font-weight-bold">Etkinliklerinizi <text class="text-primary">yarın ve takip eden 30 gün</text> için ekleyebilirsiniz.</p>
                    <hr>
                    <p class="font-weight-bold">Etkinlikleriniz, günü ve saati geldiğinde otomatik olarak pasif hale gelmektedir.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">Pasif haldeki etkinlikleri, daha önceden duyurmak suretiyle sistemlerimizden kaldırabiliriz.</p>
                    <hr>
                    <p class="font-weight-bold text-primary">İmla - noktalama kurallarına veya Kullanım Şartlarımıza uymayan etkinlikleri, daha önceden bildirmek suretiyle sistemlerimizden silebiliriz.</p>
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
@endsection

@section('script-bottom')
@endsection
