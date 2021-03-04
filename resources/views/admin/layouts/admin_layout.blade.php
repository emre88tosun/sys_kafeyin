<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <title>Kafeyin Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Kafeyin, kahve aşkına!" name="description" />
    <meta content="Kafeyin" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @include('layouts.shared.head')
</head>
<body data-layout="topnav">
    <div id="wrapper">
        @include('admin.layouts.admin_navbar')
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('breadcrumb')
                    @yield('content')
                </div>
            </div>

            @include('layouts.shared.footer')
        </div>
    </div>

    @include('layouts.shared.footer-script')
</body>

</html>
