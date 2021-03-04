<ul class="metismenu" id="menu-bar">
    <li class="menu-title">Navigasyon</li>
    <li>
        <a href="/yoneticipaneli/anasayfa">
            <i data-feather="home"></i>
            <span class="badge badge-success float-right">1</span>
            <span> Anasayfa </span>
        </a>
    </li>
    @if($hasMagaza)
        @if($hasBrand)
            <li>
                <a href="javascript: void(0);">
                    <i data-feather="award"></i>
                    <span> Markam </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level" aria-expanded="false">
                    @if(count($user->brand->stores) > 0)
                        <li>
                            <a href="javascript: void(0);" aria-expanded="false">Mağazalar
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-third-level" aria-expanded="false">
                                @foreach($user->brand->stores as $store)
                                    <li>
                                        @if($store->id == $user->magaza->id)
                                            <a href="#">{{$store->name}} (ID: KFYN{{$store->id}})</a>
                                        @else
                                            <a href="/yoneticipaneli/markam/magazalar/KFYN{{$store->id}}">{{$store->name}} (ID: KFYN{{$store->id}})</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a href="javascript: void(0);" aria-expanded="false">Sadakat kartları
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-third-level" aria-expanded="false">
                            <li>
                                <a href="/yoneticipaneli/markam/sadakatkartlari/aktif">Aktif kartlar</a>
                            </li>
                            <li>
                                <a href="/yoneticipaneli/markam/sadakatkartlari/kullanilabilir">Kullanılabilir kartlar</a>
                            </li>
                            <li>
                                <a href="/yoneticipaneli/markam/sadakatkartlari/kullanilan">Kullanılan kartlar</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" aria-expanded="false">Başvuru
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-third-level" aria-expanded="false">
                            <li>
                                <a href="/yoneticipaneli/markam/basvuru/duyurubasvurulari">Duyuru başvuruları</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </li>

        @endif
        <li>
            <a href="/yoneticipaneli/magazam">
                <i data-feather="info"></i>
                <span> Mağazam </span>
            </a>
        </li>
        <li>
            <a href="/yoneticipaneli/yorumlar">
                <i data-feather="pen-tool"></i>
                <span> Yorumlar </span>
            </a>
        </li>
        <li>
            <a href="/yoneticipaneli/paylasimlar">
                <i data-feather="image"></i>
                <span> Paylaşımlar </span>
            </a>
        </li>
        <li>
            <a href="/yoneticipaneli/yazilar">
                <i data-feather="file-text"></i>
                <span> Yazılar </span>
            </a>
        </li>
        <li>
            <a href="/yoneticipaneli/etkinlikler">
                <i data-feather="calendar"></i>
                <span> Etkinlikler </span>
            </a>
        </li>
        <li>
            <a href="/yoneticipaneli/urunler">
                <i data-feather="coffee"></i>
                <span> Ürünler </span>
            </a>
        </li>
    @endif
    @if(!$hasMagaza && $hasBrand)
        <li>
            <a href="javascript: void(0);">
                <i data-feather="list"></i>
                <span> Mağazalar </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                @foreach($user->brand->stores as $sto)
                    <li>
                        <a href="/yoneticipaneli/magazalar/KFYN{{$sto->id}}">{{$sto->name}} (ID: KFYN{{$sto->id}})</a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li>
            <a href="javascript: void(0);">
                <i data-feather="credit-card"></i>
                <span> Sadakat kartları </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="/yoneticipaneli/sadakatkartlari/aktif">Aktif kartlar</a>
                </li>
                <li>
                    <a href="/yoneticipaneli/sadakatkartlari/kullanilabilir">Kullanılabilir kartlar</a>
                </li>
                <li>
                    <a href="/yoneticipaneli/sadakatkartlari/kullanilan">Kullanılan kartlar</a>
                </li>

            </ul>
        </li>
        <li>
            <a href="javascript: void(0);">
                <i data-feather="file-text"></i>
                <span> Başvuru </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li>
                    <a href="/yoneticipaneli/basvuru/duyurubasvurulari">Duyuru başvuruları</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="/yoneticipaneli/urunaltkategorileri">
                <i data-feather="coffee"></i>
                <span> Ürün alt kategorileri </span>
            </a>
        </li>
    @endif
    <li>
        <a href="/yoneticipaneli/bilgibankasi">
            <i data-feather="archive"></i>
            <span class="badge badge-success float-right">1</span>
            <span> Bilgi Bankası </span>
        </a>
    </li>

</ul>
