<ul class="metismenu" id="menu-bar">
    <li class="menu-title">Navigasyon</li>
    <li>
        <a href="/adminpanel/anasayfa">
            <i data-feather="home"></i>
            <span class="badge badge-success float-right">1</span>
            <span> Anasayfa </span>
        </a>
    </li>
    <li>
        <a href="/adminpanel/magazalar">
            <i data-feather="list"></i>
            <span> Mağazalar </span>
        </a>
    </li>
    <li>
        <a href="/adminpanel/markalar">
            <i data-feather="award"></i>
            <span> Markalar </span>
        </a>
    </li>
    <li>
        <a href="/adminpanel/sehirler">
            <i data-feather="at-sign"></i>
            <span> Şehirler </span>
        </a>
    </li>
    <li>
        <a href="javascript: void(0);">
            <i data-feather="users"></i>
            <span> Kullanıcılar</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/adminpanel/kullanicilar/normal">Normal kullanıcılar</a>
            </li>
            <li>
                <a href="/adminpanel/kullanicilar/magaza">Mağaza kullanıcılar</a>
            </li>
            @if(Auth::user()->email == 'admin@kafeyinapp.com')
                <li>
                    <a href="/adminpanel/kullanicilar/admin">Admin kullanıcılar</a>
                </li>
            @endif
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);">
            <i data-feather="file-text"></i>
            <span> Anketler</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/adminpanel/anketler/kullanici">Kullanıcı anketleri</a>
            </li>
            <li>
                <a href="/adminpanel/anketler/magaza">Mağaza anketleri</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript: void(0);">
            <i data-feather="copy"></i>
            <span> Başvurular</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/adminpanel/basvurular/duyuru">Duyuru başvuruları</a>
            </li>
            <li>
                <a href="/adminpanel/basvurular/yonetici">Yönetici başvuruları</a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i data-feather="inbox"></i>
            <span class="badge badge-soft-success">Okundu</span>
            <span> Diğer</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="/adminpanel/diger/yorumsikayetleri">Yorum şikayetleri</a>
            </li>
            <li>
                <a href="/adminpanel/diger/magazaonerileri">Mağaza önerileri</a>
            </li>
            <li>
                <a href="/adminpanel/diger/dileksikayet">Dilek ve şikayetler</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="/adminpanel/epostagonder">
            <i data-feather="mail"></i>
            <span>  E-posta gönder</span>
        </a>
    </li>

</ul>
