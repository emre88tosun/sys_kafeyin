@extends('layouts.non-auth')

@section('content')

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-5 col-8">
                    <div class="text-center">

                        <div>
                            <img src="/assets/images/server-down.png" alt="" class="img-fluid" />
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center align-self-center">
                    <h3 class="mt-3">Bakımdayız!</h3>
                    <p class="text-muted mb-5">Kafeyin kısa süreliğine bakımda. <br /> Hizmetlerimizi geliştirirken çok kısa beklemenizi istiyoruz.</p>
                    <form method="GET" action="{{ route('cikis.yap') }}">
                        @csrf
                        <button class="btn btn-primary btn-sm" type="submit">Çıkış yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
