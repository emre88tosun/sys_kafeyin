<div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
    <div class="container-fluid">
        <a href="/yoneticipaneli/anasayfa" class="navbar-brand mr-0 mr-md-2 logo">
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/logo.png') }}" alt="logo" height="32"/>
            </span>
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/logo.png') }}" alt="logo" height="24">
            </span>
        </a>
        <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
            <li class="">
                <button class="button-menu-mobile open-left disable-btn">
                    <i data-feather="menu" class="menu-icon"></i>
                    <i data-feather="x" class="close-icon"></i>
                </button>
            </li>
        </ul>
        <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">
            @if(!is_null($user->magaza) && !is_null($user->brand))
                <li class="dropdown notification-list" @if(count($user->brand->notifs->where('isSeen',false)->concat($user->magaza->notifs->where('isSeen',false)))>0) data-toggle="tooltip" data-placement="left" title="{{count($user->brand->notifs->where('isSeen',false)->concat($user->magaza->notifs->where('isSeen',false)))}} okunmamış bildirim" @endif >
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                       aria-expanded="false">
                        <i data-feather="bell"></i>
                        @if(count($user->brand->notifs->where('isSeen',false)->concat($user->magaza->notifs->where('isSeen',false)))>0)
                            <span class="noti-icon-badge"></span>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <div class="dropdown-item noti-title border-bottom">
                            <h5 class="m-0 font-size-16">
                            <span class="float-right">
                                @if(count($user->brand->notifs->where('isSeen',false)->concat($user->magaza->notifs->where('isSeen',false)))>0)
                                    <a href="javascript:void(0);"  class="btn-okundu text-primary">
                                    <i class="uil-check" data-toggle="tooltip" data-placement="left" title="Tümünü okundu olarak işaretle"></i>
                                    </a>
                                @endif
                            </span>Okunmamış bildirimler
                            </h5>
                        </div>
                        @if(count($user->brand->notifs->where('isSeen',false)->concat($user->magaza->notifs->where('isSeen',false))) > 0)
                            <div class="slimscroll noti-scroll">
                                @foreach($user->brand->notifs->where('isSeen',false)->concat($user->magaza->notifs->where('isSeen',false))->sortByDesc('created_at') as $notif)
                                    <div class="dropdown-item notify-item border-bottom">
                                        <div class="notify-icon">
                                            <img src="{{ URL::asset('assets/images/white-bg-only-cup.png') }}" class="img-fluid rounded-circle" alt="" />
                                        </div>
                                        <p class="user-msg text-muted mb-1">{{$notif->desc}}</p>
                                        <p class="text-primary mb-0 user-msg">
                                            @if(\Carbon\Carbon::now()->diffInMinutes($notif->created_at) < 60)
                                               <small> {{\Carbon\Carbon::now()->diffInMinutes($notif->created_at)}} dakika önce</small>
                                            @elseif(\Carbon\Carbon::now()->diffInHours($notif->created_at) < 24)
                                                <small> {{\Carbon\Carbon::now()->diffInHours($notif->created_at)}} saat önce</small>
                                            @elseif(\Carbon\Carbon::now()->diffInDays($notif->created_at) < 14)
                                                <small> {{\Carbon\Carbon::now()->diffInDays($notif->created_at)}} gün önce</small>
                                            @else
                                                <small>{{\Carbon\Carbon::createFromTimeString($notif->created_at)->format('d/m/Y H:i')}}</small>
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mt-4 text-center">Burası tertemiz!</p>

                        @endif

                        <a href="javascript:void(0);" data-toggle="modal" data-target="#notificationsDialog"
                           class="dropdown-item text-center text-primary font-weight-bold notify-item notify-all border-top">
                            Tümünü görüntüle
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>

            @elseif(!is_null($user->magaza) && is_null($user->brand))
                <li class="dropdown notification-list" @if(count($user->magaza->notifs->where('isSeen',false))>0) data-toggle="tooltip" data-placement="left" title="{{count($user->magaza->notifs->where('isSeen',false))}} okunmamış bildirim" @endif >
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                       aria-expanded="false">
                        <i data-feather="bell"></i>
                        @if(count($user->magaza->notifs->where('isSeen',false))>0)
                            <span class="noti-icon-badge"></span>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <div class="dropdown-item noti-title border-bottom">
                            <h5 class="m-0 font-size-16">
                            <span class="float-right">
                                @if(count($user->magaza->notifs->where('isSeen',false))>0)
                                    <a href="javascript:void(0);"  class="btn-okundu text-primary">
                                    <i class="uil-check" data-toggle="tooltip" data-placement="left" title="Tümünü okundu olarak işaretle"></i>
                                    </a>
                                @endif
                            </span>Okunmamış bildirimler
                            </h5>
                        </div>
                        @if(count($user->magaza->notifs->where('isSeen',false)) > 0)
                            <div class="slimscroll noti-scroll">
                                @foreach($user->magaza->notifs->where('isSeen',false)->sortByDesc('created_at') as $notif)
                                    <div class="dropdown-item notify-item border-bottom">
                                        <div class="notify-icon">
                                            <img src="{{ URL::asset('assets/images/white-bg-only-cup.png') }}" class="img-fluid rounded-circle" alt="" />
                                        </div>
                                        <p class="user-msg text-muted mb-1">{{$notif->desc}}</p>
                                        <p class="text-primary mb-0 user-msg">
                                            @if(\Carbon\Carbon::now()->diffInMinutes($notif->created_at) < 60)
                                                <small> {{\Carbon\Carbon::now()->diffInMinutes($notif->created_at)}} dakika önce</small>
                                            @elseif(\Carbon\Carbon::now()->diffInHours($notif->created_at) < 24)
                                                <small> {{\Carbon\Carbon::now()->diffInHours($notif->created_at)}} saat önce</small>
                                            @elseif(\Carbon\Carbon::now()->diffInDays($notif->created_at) < 14)
                                                <small> {{\Carbon\Carbon::now()->diffInDays($notif->created_at)}} gün önce</small>
                                            @else
                                                <small>{{\Carbon\Carbon::createFromTimeString($notif->created_at)->format('d/m/Y H:i')}}</small>
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mt-4 text-center">Burası tertemiz!</p>

                        @endif

                        <a href="javascript:void(0);" data-toggle="modal" data-target="#notificationsDialog"
                           class="dropdown-item text-center text-primary font-weight-bold notify-item notify-all border-top">
                            Tümünü görüntüle
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>
            @elseif(is_null($user->magaza) && !is_null($user->brand))
                <li class="dropdown notification-list" @if(count($user->brand->notifs->where('isSeen',false))>0) data-toggle="tooltip" data-placement="left" title="{{count($user->brand->notifs->where('isSeen',false))}} okunmamış bildirim" @endif >
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                       aria-expanded="false">
                        <i data-feather="bell"></i>
                        @if(count($user->brand->notifs->where('isSeen',false))>0)
                            <span class="noti-icon-badge"></span>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <div class="dropdown-item noti-title border-bottom">
                            <h5 class="m-0 font-size-16">
                            <span class="float-right">
                                @if(count($user->brand->notifs->where('isSeen',false))>0)
                                    <a href="javascript:void(0);"  class="btn-okundu text-primary">
                                    <i class="uil-check" data-toggle="tooltip" data-placement="left" title="Tümünü okundu olarak işaretle"></i>
                                    </a>
                                @endif
                            </span>Okunmamış bildirimler
                            </h5>
                        </div>
                        @if(count($user->brand->notifs->where('isSeen',false)) > 0)
                            <div class="slimscroll noti-scroll">
                                @foreach($user->brand->notifs->where('isSeen',false)->sortByDesc('created_at') as $notif)
                                    <div class="dropdown-item notify-item border-bottom">
                                        <div class="notify-icon">
                                            <img src="{{ URL::asset('assets/images/white-bg-only-cup.png') }}" class="img-fluid rounded-circle" alt="" />
                                        </div>
                                        <p class="user-msg text-muted mb-1">{{$notif->desc}}</p>
                                        <p class="text-primary mb-0 user-msg">
                                            @if(\Carbon\Carbon::now()->diffInMinutes($notif->created_at) < 60)
                                                <small> {{\Carbon\Carbon::now()->diffInMinutes($notif->created_at)}} dakika önce</small>
                                            @elseif(\Carbon\Carbon::now()->diffInHours($notif->created_at) < 24)
                                                <small> {{\Carbon\Carbon::now()->diffInHours($notif->created_at)}} saat önce</small>
                                            @elseif(\Carbon\Carbon::now()->diffInDays($notif->created_at) < 14)
                                                <small> {{\Carbon\Carbon::now()->diffInDays($notif->created_at)}} gün önce</small>
                                            @else
                                                <small>{{\Carbon\Carbon::createFromTimeString($notif->created_at)->format('d/m/Y H:i')}}</small>
                                            @endif
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="mt-4 text-center">Burası tertemiz!</p>

                        @endif

                        <a href="javascript:void(0);" data-toggle="modal" data-target="#notificationsDialog"
                           class="dropdown-item text-center text-primary font-weight-bold notify-item notify-all border-top">
                            Tümünü görüntüle
                            <i class="fi-arrow-right"></i>
                        </a>

                    </div>
                </li>
            @endif

            <li class="dropdown notification-list align-self-center profile-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <div class="media user-profile ">
                        <img src="{{\Illuminate\Support\Facades\Auth::user()->avatar}}" alt="user-image"
                             class="rounded-circle align-self-center"/>
                        <div class="media-body text-left">
                            <h6 class="pro-user-name ml-2 my-0">
                                <span>{{\Illuminate\Support\Facades\Auth::user()->name}} {{\Illuminate\Support\Facades\Auth::user()->surname}}</span>
                                @if(\Illuminate\Support\Facades\Auth::user()->isBrandManager && $hasBrand && !$hasMagaza)
                                    <span class="pro-user-desc text-muted d-block mt-1">Marka Yöneticisi</span>
                                @elseif($hasBrand && $hasMagaza)
                                    <span class="pro-user-desc text-muted d-block mt-1">Marka & Mağaza Yöneticisi</span>
                                @else
                                    <span class="pro-user-desc text-muted d-block mt-1">Mağaza Yöneticisi</span>
                                @endif
                            </h6>
                        </div>
                        <span data-feather="chevron-down" class="ml-2 align-self-center"></span>
                    </div>
                </a>
                <div class="dropdown-menu profile-dropdown-items dropdown-menu-right">
                    <a href="/yoneticipaneli/hesabim" class="dropdown-item notify-item">
                        <i data-feather="user" class="icon-dual icon-xs mr-2"></i>
                        <span class="text-muted">Hesabım</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link class="dropdown-item notify-item text-danger" :href="route('logout')"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                            <span class="text-muted">Çıkış yap</span>
                        </x-dropdown-link>
                    </form>
                    @if($user->lastLogin)
                        <div class="dropdown-divider"></div>
                    <div class="col-12">
                        <small class="text-primary font-weight-bold text-center ml-2">Son giriş: {{\Carbon\Carbon::createFromTimeString($user->lastLogin)->format('d/m/Y H:i')}}</small>
                    </div>
                    @endif
                </div>
            </li>
        </ul>
    </div>
</div>

