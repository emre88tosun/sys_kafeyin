@extends('layouts.non-auth')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.css') }}" type="text/css"/>
@endsection

@section('content')

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="col-md-12 p-5">
                                <div class="mb-4">
                                    <a href="#">
                                        <img src="/assets/images/logo.png" alt="logo" height="36"/>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h4 class="">Başarılı!</h4>
                                        <p>Başvurunuz başarıyla gönderilmiştir. İlerleyen günlerde marka ve mağaza yöneticisi olarak belirtilen e-posta hesaplarının gelen kutusunu ve spam klasörünü kontrol etmenizi tavsiye ederiz.</p>
                                        <p class="mb-0">Başvuru sürecini <a class="text-unline-dashed" href="{{url('/ilkbasvurutakip?referral=')}}{{$ref}}">bu adres</a> üzerinden takip edebilirsiniz.</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
