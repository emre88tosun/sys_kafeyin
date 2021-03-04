<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8"/>
    <title>Kafeyin</title>
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


    @include('layouts.shared.head')
    <style>
        .danger {
            color: red;
        }
    </style>
</head>

<body>
@yield('content')
@include('layouts.shared.footer-script')

<script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
<script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
<script type="text/javascript">
    if("{{url()->current()}}" === "{{url('/login')}}"){
        $('#togglePass').click(function () {
            if(document.getElementById('password').type === "password"){
                document.getElementById('password').type = "text";
                $('#eyeIcon').removeClass('uil-eye');
                $('#eyeIcon').addClass('uil-eye-slash');
            }else if(document.getElementById('password').type === "text"){
                document.getElementById('password').type = "password";
                $('#eyeIcon').addClass('uil-eye');
                $('#eyeIcon').removeClass('uil-eye-slash');
            }
        });
    }
    $('#frmLogin').submit(function(e){
        swal.fire({
            html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
            showConfirmButton: false,
            allowOutsideClick: false,
            customClass:"swal2-toast"
        });
    });
    $('#frmPassEmail').submit(function(e){
        swal.fire({
            html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
            showConfirmButton: false,
            allowOutsideClick: false,
            customClass:"swal2-toast"
        });
    });
    $('#frmResPass').submit(function(e){
        swal.fire({
            html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
            showConfirmButton: false,
            allowOutsideClick: false,
            customClass:"swal2-toast"
        });
    });
</script>

</script>
<script>
    @if (session('passUp'))
    swal.fire({
        title: 'Başarılı!',
        text: 'Yeni şifreniz ile giriş yapabilirsiniz.',
        type: "success",
    });
    @elseif (session('managerAccountCreated'))
    swal.fire({
        title: 'Başarılı!',
        html: 'Yönetici hesabınız başarıyla oluşturuldu.\nE-posta adresinizi doğruladıktan sonra giriş yapabilirsiniz.',
        type: "success",
    });
    @endif
</script>
</body>

</html>
