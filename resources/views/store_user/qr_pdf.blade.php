<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$urun->title}}</title>
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css"/>

</head>
<body>
    <div class="body ml-5">
        <div class="card alert-light">
            <div class="card-title align-items-center">
                <p class="mb-3 mt-5 align-self-center"><text class="font-weight-bold text-primary">{{$urun->title}} (Ürün ID: URN{{$urun->id}})</text>   <text class="text-muted font-weight-bold">{{$store->name}} (Mağaza ID: KFYN{{$store->id}}) / İşlem Tarihi ve Saati: {{\Carbon\Carbon::now()->format('d/m/Y H:i')}} / Parti: {{$batch}}</text></p>
            </div>
        </div>
        @foreach($prQrs as $qr)
            <img class="img-fluid mb-2 mr-2" width="75" src="{{$qr->qrImageLink}}">
        @endforeach
        <img class="img-fluid mt-3 align-self-center" width="100" src="{{URL::asset('/assets/images/logo.png')}}">
    </div>
</body>
</html>
