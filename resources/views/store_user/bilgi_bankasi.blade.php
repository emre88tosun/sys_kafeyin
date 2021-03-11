@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet"/>
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Bilgi Bankası</li>
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">Bilgi Bankası</h4>

        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column navtab-bg nav-justified">
                        @foreach($items as $item)
                            @if($item->first()->category == "kafeyin")
                                <li class="nav-item">
                                    <a href="#kafeyin" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                        <span class="d-block d-sm-none">Kafeyin</span>
                                        <span class="d-none d-sm-block">Kafeyin</span>
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="#{{$item->first()->category}}" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        @switch($item->first()->category)
                                            @case("magaza")
                                            <span class="d-block d-sm-none">Mağaza</span>
                                            <span class="d-none d-sm-block">Mağaza</span>
                                            @break
                                            @case("yazi")
                                            <span class="d-block d-sm-none">Yazılar</span>
                                            <span class="d-none d-sm-block">Yazılar</span>
                                            @break
                                            @case("marka")
                                            <span class="d-block d-sm-none">Marka</span>
                                            <span class="d-none d-sm-block">Marka</span>
                                            @break
                                            @case("etkinlik")
                                            <span class="d-block d-sm-none">Etkinlikler</span>
                                            <span class="d-none d-sm-block">Etkinlikler</span>
                                            @break
                                            @case("paylasim")
                                            <span class="d-block d-sm-none">Paylaşımlar</span>
                                            <span class="d-none d-sm-block">Paylaşımlar</span>
                                            @break
                                            @case("urun")
                                            <span class="d-block d-sm-none">Ürünler</span>
                                            <span class="d-none d-sm-block">Ürünler</span>
                                            @break
                                            @case("loyalty_qr")
                                            <span class="d-block d-sm-none">Sadakat Kartları & QR Kodlar</span>
                                            <span class="d-none d-sm-block">Sadakat Kartları & QR Kodlar</span>
                                            @break
                                            @case("destek")
                                            <span class="d-block d-sm-none">Destek & İletişim</span>
                                            <span class="d-none d-sm-block">Destek & İletişim</span>
                                            @break
                                        @endswitch
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            {{--<div class="row">
                @foreach($items->chunk(3) as $trid)
                    <div class="col-xl-4">
                        @foreach($trid as $item)
                            <div class="accordion custom-accordionwitharrow" id="akordiyon{{$item->first()->category}}">
                                <div class="card mb-1 shadow-sm border">
                                    <a href="" class="text-dark" data-toggle="collapse" data-target="#col{{$item->first()->category}}"
                                       aria-expanded="false" aria-controls="col{{$item->first()->category}}">
                                        <div class="card-header" id="head{{$item->first()->category}}">
                                            <h5 class="m-0 font-size-16">
                                                @if($item->first()->category == "marka")
                                                    Marka
                                                @elseif($item->first()->category == "magaza")
                                                    Mağaza
                                                @elseif($item->first()->category == "yazi")
                                                    Yazılar
                                                @elseif($item->first()->category == "kafeyin")
                                                    Kafeyin
                                                @elseif($item->first()->category == "etkinlik")
                                                    Etkinlikler
                                                @elseif($item->first()->category == "paylasim")
                                                    Paylaşımlar
                                                @elseif($item->first()->category == "urun")
                                                    Ürünler
                                                @elseif($item->first()->category == "loyalty_qr")
                                                    Sadakat Kartları & QR Kodlar
                                                @elseif($item->first()->category == "destek")
                                                    Destek & İletişim
                                                @endif
                                                <i class="uil uil-angle-up float-right accordion-arrow"></i>
                                            </h5>
                                        </div>
                                    </a>
                                    <div id="col{{$item->first()->category}}" class="collapse" aria-labelledby="head{{$item->first()->category}}"
                                         data-parent="#akordiyon{{$item->first()->category}}">
                                        <div class="card-body text-muted">
                                            <div class="custom-accordion accordion ml-3" id="aa{{$item->first()->category}}">
                                                @foreach($item->sortBy('position') as $item2)
                                                    <div class="card mb-1">
                                                        <a href="" class="text-dark mb-0" data-toggle="collapse" data-target="#ca{{$item2->category}}{{$item2->id}}"
                                                           aria-expanded="false" aria-controls="ca{{$item2->category}}{{$item2->id}}">
                                                            <div class="card-header mb-0" id="ch{{$item2->category}}{{$item2->id}}">
                                                                <h5 class="m-0 font-size-14">
                                                                    <i class="uil uil-info-circle bg-white h3 text-primary icon"></i>
                                                                    {{$item2->title}}
                                                                </h5>
                                                            </div>
                                                        </a>

                                                        <div id="ca{{$item2->category}}{{$item2->id}}" class="collapse mt-0" aria-labelledby="ch{{$item2->category}}{{$item2->id}}"
                                                             data-parent="#aa{{$item->first()->category}}">
                                                            <div class="card-body text-muted text-justify">
                                                                {{$item2->desc}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>--}}
            <div class="card">
                <div class="card-body">
                    <div class="tab-content p-0  text-muted">
                        @foreach($items as $item)
                            @if($item->first()->category == "kafeyin")
                                <div class="tab-pane show active" id="kafeyin">
                                    <div class="custom-accordion accordion ml-3" id="aa{{$item->first()->category}}">
                                        @foreach($item->sortBy('position') as $item2)
                                            <div class="card mb-1">
                                                <a href="" class="text-dark mb-0" data-toggle="collapse" data-target="#ca{{$item2->category}}{{$item2->id}}"
                                                   aria-expanded="false" aria-controls="ca{{$item2->category}}{{$item2->id}}">
                                                    <div class="card-header mb-0" id="ch{{$item2->category}}{{$item2->id}}">
                                                        <h5 class="m-0 font-size-14">
                                                            <i class="uil uil-info-circle bg-white h3 text-primary icon"></i>
                                                            {{$item2->title}}
                                                        </h5>
                                                    </div>
                                                </a>

                                                <div id="ca{{$item2->category}}{{$item2->id}}" class="collapse mt-0" aria-labelledby="ch{{$item2->category}}{{$item2->id}}"
                                                     data-parent="#aa{{$item->first()->category}}">
                                                    <div class="card-body text-muted text-justify">
                                                        {{$item2->desc}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="tab-pane" id="{{$item->first()->category}}">
                                    <div class="custom-accordion accordion ml-3" id="aa{{$item->first()->category}}">
                                        @foreach($item->sortBy('position') as $item2)
                                            <div class="card mb-1">
                                                <a href="" class="text-dark mb-0" data-toggle="collapse" data-target="#ca{{$item2->category}}{{$item2->id}}"
                                                   aria-expanded="false" aria-controls="ca{{$item2->category}}{{$item2->id}}">
                                                    <div class="card-header mb-0" id="ch{{$item2->category}}{{$item2->id}}">
                                                        <h5 class="m-0 font-size-14">
                                                            <i class="uil uil-info-circle bg-white h3 text-primary icon"></i>
                                                            {{$item2->title}}
                                                        </h5>
                                                    </div>
                                                </a>

                                                <div id="ca{{$item2->category}}{{$item2->id}}" class="collapse mt-0" aria-labelledby="ch{{$item2->category}}{{$item2->id}}"
                                                     data-parent="#aa{{$item->first()->category}}">
                                                    <div class="card-body text-muted text-justify">
                                                        {{$item2->desc}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
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
