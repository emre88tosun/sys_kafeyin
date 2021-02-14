<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8"/>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Kafeyin, kahve aşkına!" name="description"/>
    <meta content="Kafeyin" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>

    @include('layouts.shared.head')
    <style>
        .danger {
            color: red;
        }
    </style>
</head>
<body>
<div class="jumbotron" style=" min-height: 90vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-auto">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="align-self-center">
                                    <a href="/">
                                        <img src="assets/images/white-bg-only-cup.png" alt="logo" height="72"/>
                                    </a>
                                </div>
                                <div class="ml-3 align-self-center">
                                    <h6 class="h5 mb-0">@yield('code')</h6>
                                    <p class="text-muted mt-1 mb-2">@yield('message')</p>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-2">
                                <a class="btn btn-primary btn-sm " href="{{url()->previous()}}">Geri dön</a>
                                <a class="btn btn-outline-primary btn-sm ml-2" href="/">Anasayfa</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
<script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
<script>
    @if (session('passUp'))
    swal.fire({
        title: 'Başarılı!',
        text: 'Yeni şifreniz ile giriş yapabilirsiniz.',
        type: "success",
    });
    @endif
</script>
</body>

</html>
