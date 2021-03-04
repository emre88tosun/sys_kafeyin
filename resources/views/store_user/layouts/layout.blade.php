<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8"/>
    <title>Kafeyin Yönetici Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Kafeyin, kahve aşkına!" name="description"/>
    <meta content="Kafeyin" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    @include('layouts.shared.head')
</head>
<body data-layout="topnav">
<div id="wrapper">
    @include('store_user.layouts.navbar')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid" style="padding-top: 128px;">
                @yield('breadcrumb')
                @yield('content')
            </div>
        </div>
        <button onclick="topFunction()" id="myBtn" class="shadow-sm" title="Yukarı"><i data-feather="chevrons-up" class="mb-1"></i></button>

        <div class="modal fade" id="notificationsDialog" tabindex="-1" role="dialog"
             aria-labelledby="notificationsDialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notificationsDialog">Bütün bildirimler</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body notification-list">
                        @if($hasBrand && $hasMagaza)
                            @if(count($user->brand->notifs->concat($user->magaza->notifs)) > 0)
                                <div class="slimscroll noti-scroll2" style="min-height: 650px">
                                    @foreach($user->brand->notifs->concat($user->magaza->notifs)->sortByDesc('created_at') as $notif)
                                        <div
                                            class="notify-item border-bottom @if(!$notif->isSeen) bg-soft-primary rounded-lg @endif "
                                            style="padding: 12px">
                                            <div class="notify-icon">
                                                <img src="{{ URL::asset('assets/images/white-bg-only-cup.png') }}"
                                                     height="36" width="36" class="img-fluid rounded-circle" alt=""/>
                                            </div>
                                            <p class="user-msg mb-1 font-weight-bold @if(!$notif->isSeen) text-dark @else text-muted @endif ">{{$notif->desc}}</p>
                                            <p class=" mb-0 user-msg font-weight-bolder @if(!$notif->isSeen) text-dark @else text-primary @endif ">
                                                @if(\Carbon\Carbon::now()->diffInMinutes($notif->created_at) < 60)
                                                    <small> {{\Carbon\Carbon::now()->diffInMinutes($notif->created_at)}}
                                                        dakika önce</small>
                                                @elseif(\Carbon\Carbon::now()->diffInHours($notif->created_at) < 24)
                                                    <small> {{\Carbon\Carbon::now()->diffInHours($notif->created_at)}}
                                                        saat önce</small>
                                                @elseif(\Carbon\Carbon::now()->diffInDays($notif->created_at) < 14)
                                                    <small> {{\Carbon\Carbon::now()->diffInDays($notif->created_at)}}
                                                        gün önce</small>
                                                @else
                                                    <small>{{\Carbon\Carbon::createFromTimeString($notif->created_at)->format('d/m/Y H:i')}}</small>
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                Burası tertemiz!
                            @endif
                        @elseif(!$hasBrand && $hasMagaza)
                            @if(count($user->magaza->notifs) > 0)
                                <div class="slimscroll noti-scroll2" style="min-height: 650px">
                                    @foreach($user->magaza->notifs->sortByDesc('created_at') as $notif)
                                        <div
                                            class="notify-item border-bottom @if(!$notif->isSeen) bg-soft-primary rounded-lg @endif "
                                            style="padding: 12px">
                                            <div class="notify-icon">
                                                <img src="{{ URL::asset('assets/images/white-bg-only-cup.png') }}"
                                                     height="36" width="36" class="img-fluid rounded-circle" alt=""/>
                                            </div>
                                            <p class="user-msg mb-1 font-weight-bold @if(!$notif->isSeen) text-dark @else text-muted @endif ">{{$notif->desc}}</p>
                                            <p class=" mb-0 user-msg font-weight-bolder @if(!$notif->isSeen) text-dark @else text-primary @endif ">
                                                @if(\Carbon\Carbon::now()->diffInMinutes($notif->created_at) < 60)
                                                    <small> {{\Carbon\Carbon::now()->diffInMinutes($notif->created_at)}}
                                                        dakika önce</small>
                                                @elseif(\Carbon\Carbon::now()->diffInHours($notif->created_at) < 24)
                                                    <small> {{\Carbon\Carbon::now()->diffInHours($notif->created_at)}}
                                                        saat önce</small>
                                                @elseif(\Carbon\Carbon::now()->diffInDays($notif->created_at) < 14)
                                                    <small> {{\Carbon\Carbon::now()->diffInDays($notif->created_at)}}
                                                        gün önce</small>
                                                @else
                                                    <small>{{\Carbon\Carbon::createFromTimeString($notif->created_at)->format('d/m/Y H:i')}}</small>
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                Burası tertemiz!
                            @endif
                        @elseif($hasBrand && !$hasMagaza)
                            @if(count($user->brand->notifs) > 0)
                                <div class="slimscroll noti-scroll2" style="min-height: 650px">
                                    @foreach($user->brand->notifs->sortByDesc('created_at') as $notif)
                                        <div
                                            class="notify-item border-bottom @if(!$notif->isSeen) bg-soft-primary rounded-lg @endif "
                                            style="padding: 12px">
                                            <div class="notify-icon">
                                                <img src="{{ URL::asset('assets/images/white-bg-only-cup.png') }}"
                                                     height="36" width="36" class="img-fluid rounded-circle" alt=""/>
                                            </div>
                                            <p class="user-msg mb-1 font-weight-bold @if(!$notif->isSeen) text-dark @else text-muted @endif ">{{$notif->desc}}</p>
                                            <p class=" mb-0 user-msg font-weight-bolder @if(!$notif->isSeen) text-dark @else text-primary @endif ">
                                                @if(\Carbon\Carbon::now()->diffInMinutes($notif->created_at) < 60)
                                                    <small> {{\Carbon\Carbon::now()->diffInMinutes($notif->created_at)}}
                                                        dakika önce</small>
                                                @elseif(\Carbon\Carbon::now()->diffInHours($notif->created_at) < 24)
                                                    <small> {{\Carbon\Carbon::now()->diffInHours($notif->created_at)}}
                                                        saat önce</small>
                                                @elseif(\Carbon\Carbon::now()->diffInDays($notif->created_at) < 14)
                                                    <small> {{\Carbon\Carbon::now()->diffInDays($notif->created_at)}}
                                                        gün önce</small>
                                                @else
                                                    <small>{{\Carbon\Carbon::createFromTimeString($notif->created_at)->format('d/m/Y H:i')}}</small>
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                Burası tertemiz!
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.shared.footer')
    </div>
</div>

@include('layouts.shared.footer-script')
<script type="text/javascript">
    $('#notifButton').click(function () {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('#notiAlert').remove();
        $.ajax({
            url: "/yoneticipaneli/bildirimlerokundu",
            type: "POST",
            data: {
                _token: CSRF_TOKEN
            },
        });
    });

    mybutton = document.getElementById("myBtn");

    window.onscroll = function () {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 488 || document.documentElement.scrollTop > 488) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
</body>

</html>
