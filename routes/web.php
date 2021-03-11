<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KafeyinController;
use App\Http\Controllers\StoreUserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if(Auth::user()){
        return redirect('/gateway');
    }
    return view('welcome');
});

Route::get('/gateway',[KafeyinController::class,'gateway'])->middleware('auth');
Route::post('/resendverif',[KafeyinController::class,'resendverif'])->name('resend.verif');
Route::get('/cikisyap',[KafeyinController::class,'cikisyap'])->middleware('auth')->name('cikis.yap');
Route::get('/ilkbasvuru',[KafeyinController::class,'ilkbasvuru'])/*->middleware('throttle:5,1')*/;
Route::get('/ilkbasvurutamamlandi',[KafeyinController::class,'ilkbasvurutamamlandi'])/*->middleware('throttle:5,1')*/;
Route::post('/ilkbasvurugonder',[KafeyinController::class,'ilkbasvurugonder'])/*->middleware('throttle:5,1')*/;
Route::get('/checkemail',[KafeyinController::class,'checkemail']);
Route::get('/ilkbasvurutakip',[KafeyinController::class,'ilkbasvurutakip'])/*->middleware('throttle:5,1')*/;
Route::get('/yoneticihesabiolustur',[KafeyinController::class,'yoneticihesabiolustur'])/*->middleware('throttle:5,1')*/;
Route::post('/yoneticihesabigonder',[KafeyinController::class,'yoneticihesabigonder'])/*->middleware('throttle:5,1')*/;

Route::prefix('adminpanel')->middleware(['auth','admin','verified'])->group(function () {
    Route::get('/anasayfa',[AdminController::class,'anasayfa']);
    Route::get('/magazalar',[AdminController::class,'magazalar']);
    Route::get('/magazalar/{storeID}',[AdminController::class,'magazagetir']);
    Route::get('/magazalar/{storeID}/{subCategory}',[AdminController::class,'magazaaltkategori']);
    Route::post('/magazaguncelle',[AdminController::class,'magazaguncelle']);
    Route::post('/magazakullanicidegistir',[AdminController::class,'magazakullanicidegistir']);
    Route::post('/magazakapakguncelle',[AdminController::class,'magazakapakguncelle']);
    Route::post('/yorumsil',[AdminController::class,'yorumsil']);
    Route::post('/kfotosil',[AdminController::class,'kfotosil']);
    Route::post('/kfotoekle',[AdminController::class,'kfotoekle']);
    Route::post('/paypasif',[AdminController::class,'paypasif']);
    Route::post('/paysil',[AdminController::class,'paysil']);
    Route::post('/yazipasif',[AdminController::class,'yazipasif']);
    Route::post('/yazisil',[AdminController::class,'yazisil']);
    Route::post('/yaziguncelle',[AdminController::class,'yaziguncelle']);
    Route::post('/etkpasif',[AdminController::class,'etkpasif']);
    Route::post('/etksil',[AdminController::class,'etksil']);
    Route::post('/etkguncelle',[AdminController::class,'etkguncelle']);
    Route::post('/urunpasif',[AdminController::class,'urunpasif']);
    Route::post('/urunsil',[AdminController::class,'urunsil']);
    Route::post('/urunguncelle',[AdminController::class,'urunguncelle']);
    Route::get('/sehirler',[AdminController::class,'sehirler']);
    Route::get('/sehirler/{cityID}',[AdminController::class,'sehirgetir']);
    Route::post('/sehirguncelle',[AdminController::class,'sehirguncelle']);
    Route::get('/sehirler/{cityID}/{subCategory}',[AdminController::class,'sehiraltkategori']);
    Route::post('/lokasyonekle',[AdminController::class,'lokasyonekle']);
    Route::post('/lokaguncelle',[AdminController::class,'lokaguncelle']);
    Route::post('/lokasil',[AdminController::class,'lokasil']);
    Route::post('/khaberekle',[AdminController::class,'khaberekle']);
    Route::post('/knewssil',[AdminController::class,'knewssil']);
    Route::post('/popmagazaguncelle',[AdminController::class,'popmagazaguncelle']);
    Route::post('/popmagazaekle',[AdminController::class,'popmagazaekle']);
    Route::post('/popmagazasil',[AdminController::class,'popmagazasil']);
    Route::post('/sonmagazaguncelle',[AdminController::class,'sonmagazaguncelle']);
    Route::post('/sonmagazaekle',[AdminController::class,'sonmagazaekle']);
    Route::post('/sonmagazasil',[AdminController::class,'sonmagazasil']);
    Route::post('/edtmagazaguncelle',[AdminController::class,'edtmagazaguncelle']);
    Route::post('/edtmagazaekle',[AdminController::class,'edtmagazaekle']);
    Route::post('/edtmagazasil',[AdminController::class,'edtmagazasil']);
    Route::post('/klokasyonguncelle',[AdminController::class,'klokasyonguncelle']);
    Route::post('/klokasyonekle',[AdminController::class,'klokasyonekle']);
    Route::post('/klokasyonsil',[AdminController::class,'klokasyonsil']);
    Route::post('/duyuruguncelle',[AdminController::class,'duyuruguncelle']);
    Route::post('/duyuruekle',[AdminController::class,'duyuruekle']);
    Route::post('/duysil',[AdminController::class,'duysil']);
    Route::get('/anketler/{subCategory}',[AdminController::class,'anketlergenel']);
    Route::post('/kanketguncelle',[AdminController::class,'kanketguncelle']);
    Route::post('/kanketpasif',[AdminController::class,'kanketpasif']);
    Route::post('/kanketsil',[AdminController::class,'kanketsil']);
    Route::post('/kanketekle',[AdminController::class,'kanketekle']);
    Route::post('/manketguncelle',[AdminController::class,'manketguncelle']);
    Route::post('/manketpasif',[AdminController::class,'manketpasif']);
    Route::post('/manketsil',[AdminController::class,'manketsil']);
    Route::post('/manketekle',[AdminController::class,'manketekle']);
    Route::get('/diger/{subCategory}',[AdminController::class,'digergenel']);
    Route::post('/tskmail1',[AdminController::class,'tskmail1']);
    Route::post('/yorumsil2',[AdminController::class,'yorumsil2']);
    Route::post('/sikayetsil',[AdminController::class,'sikayetsil']);
    Route::post('/oneriokundu',[AdminController::class,'oneriokundu']);
    Route::post('/onerisil',[AdminController::class,'onerisil']);
    Route::post('/dlkokundu',[AdminController::class,'dlkokundu']);
    Route::post('/dlksil',[AdminController::class,'dlksil']);
    Route::get('/markalar',[AdminController::class,'markalar']);
    Route::post('/markaguncelle',[AdminController::class,'markaguncelle']);
    Route::post('/markalogoguncelle',[AdminController::class,'markalogoguncelle']);
    Route::post('/markayoneticiguncelle',[AdminController::class,'markayoneticiguncelle']);
    Route::post('/mrkyntcekstblgguncelle',[AdminController::class,'mrkyntcekstblgguncelle']);
    Route::get('/markalar/{brandID}',[AdminController::class,'markagetir']);
    Route::get('/kullanicilar/{subCategory}',[AdminController::class,'kullanicilargenel']);
    Route::get('/kullanicilar/normal/{userID}',[AdminController::class,'normalkullanicigetir']);
    Route::post('/kullaniciguncelle',[AdminController::class,'kullaniciguncelle']);
    Route::post('/kullaniciavatarguncelle',[AdminController::class,'kullaniciavatarguncelle']);
    Route::get('/kullanicilar/normal/{userID}/{subCategory}',[AdminController::class,'normalkullanicialtkategori']);
    Route::post('/favartsil',[AdminController::class,'favartsil']);
    Route::post('/favactsil',[AdminController::class,'favactsil']);
    Route::post('/favstosil',[AdminController::class,'favstosil']);
    Route::post('/takipsil',[AdminController::class,'takipsil']);
    Route::post('/kartsil',[AdminController::class,'kartsil']);
    Route::post('/kkullanicisil',[AdminController::class,'kkullanicisil']);
    Route::get('/kullanicilar/magaza/{userID}',[AdminController::class,'magazakullanicigetir']);
    Route::post('/markayoneticisibilgiguncelle',[AdminController::class,'markayoneticisibilgiguncelle']);
    Route::post('/magazakullaniciguncelle',[AdminController::class,'magazakullaniciguncelle']);
    Route::get('/kullanicilar/admin/{userID}',[AdminController::class,'adminkullanicigetir']);
    Route::post('/akullanicisil',[AdminController::class,'akullanicisil']);
    Route::get('/epostagonder',[AdminController::class,'epostagonder']);
    Route::post('/tekilkullaniciyagonder',[AdminController::class,'tekilkullaniciyagonder']);
    Route::post('/coklukullaniciyagonder',[AdminController::class,'coklukullaniciyagonder']);
    Route::post('/sehregorekullaniciyagonder',[AdminController::class,'sehregorekullaniciyagonder']);
    Route::post('/sehregoremagazakullaniciyagonder',[AdminController::class,'sehregoremagazakullaniciyagonder']);
    Route::get('/basvurular/{subCategory}',[AdminController::class,'basvurulargenel']);
    Route::get('/basvurular/yonetici/{id}',[AdminController::class,'yoneticibasvurualt']);
    Route::post('/basvuruguncellemeiste',[AdminController::class,'basvuruguncellemeiste']);
    Route::post('/basvurureddet',[AdminController::class,'basvurureddet']);
    Route::post('/preregisteredstoreuserolustur',[AdminController::class,'preregisteredstoreuserolustur']);
    Route::post('/dbasvurusil',[AdminController::class,'dbasvurusil']);
    Route::post('/basvuruonayla',[AdminController::class,'basvuruonayla']);
    Route::post('/yasbvurusil1',[AdminController::class,'yasbvurusil1']);
    Route::post('/yasbvurusil2',[AdminController::class,'yasbvurusil2']);
    Route::get('/hesabim',[AdminController::class,'hesabim']);
    Route::post('/sifredegistir',[AdminController::class,'sifredegistir']);
    Route::post('/markaekle',[AdminController::class,'markaekle']);
    Route::post('/magazaekle',[AdminController::class,'magazaekle']);
    Route::post('/adminkullaniciekle',[AdminController::class,'adminkullaniciekle']);
    Route::post('/magazakullaniciekle',[AdminController::class,'magazakullaniciekle']);
    Route::post('/normalkullaniciekle',[AdminController::class,'normalkullaniciekle']);
    Route::post('/configclear',[AdminController::class,'configclear']);
    Route::post('/cacheclear',[AdminController::class,'cacheclear']);
    Route::post('/configcache',[AdminController::class,'configcache']);
    Route::post('/optimizeclear',[AdminController::class,'optimizeclear']);
    Route::post('/sunucuac',[AdminController::class,'sunucuac']);
    Route::post('/sunucukapat',[AdminController::class,'sunucukapat']);
    Route::get('/kafeyinayarlar',[AdminController::class,'kafeyinayarlar']);
    Route::post('/boolayarekle',[AdminController::class,'boolayarekle']);
    Route::post('/boolayarduzenle',[AdminController::class,'boolayarduzenle']);
    Route::post('/boolayarsil',[AdminController::class,'boolayarsil']);
    Route::post('/stringayarekle',[AdminController::class,'stringayarekle']);
    Route::post('/stringayarduzenle',[AdminController::class,'stringayarduzenle']);
    Route::post('/stringayarsil',[AdminController::class,'stringayarsil']);
    Route::post('/ybasvuruapprove',[AdminController::class,'ybasvuruapprove']);
    Route::post('/ybasvurupending',[AdminController::class,'ybasvurupending']);
    Route::post('/ybasvurureject',[AdminController::class,'ybasvurureject']);
    Route::post('/ilkbasvuruduzenle',[AdminController::class,'ilkbasvuruduzenle']);
    Route::post('/pusersil',[AdminController::class,'pusersil']);
    Route::get('/ownershipapplicationreferrals',[AdminController::class,'ownershipapplicationreferrals']);
    Route::post('/oreferralduzenle',[AdminController::class,'oreferralduzenle']);
    Route::post('/oreferralcodeyenile',[AdminController::class,'oreferralcodeyenile']);
    Route::post('/referralekle',[AdminController::class,'referralekle']);
    Route::get('/preregisteredstoreusers',[AdminController::class,'preregisteredstoreusers']);
    Route::post('/puserekle',[AdminController::class,'puserekle']);
    Route::post('/puserdel',[AdminController::class,'puserdel']);

    Route::get('/deneme',[AdminController::class,'admindeneme'])->middleware('throttle:5,10');
});

Route::prefix('yoneticipaneli')->middleware(['auth','store','verified'])->group(function () {
    Route::get('/anasayfa',[StoreUserController::class,'anasayfa']);
    Route::get('/yorumlar',[StoreUserController::class,'yorumlar'])->middleware('has.magaza');

    Route::get('/paylasimlar',[StoreUserController::class,'paylasimlar'])->middleware('has.magaza');
    Route::post('/paysil',[StoreUserController::class,'paysil'])->middleware('has.magaza');
    Route::post('/coklupaysil',[StoreUserController::class,'coklupaysil'])->middleware('has.magaza');
    Route::post('/paypasif',[StoreUserController::class,'paypasif'])->middleware('has.magaza');
    Route::post('/payekle',[StoreUserController::class,'payekle'])->middleware('has.magaza');

    Route::get('/yazilar',[StoreUserController::class,'yazilar'])->middleware('has.magaza');
    Route::post('/yazipasif',[StoreUserController::class,'yazipasif'])->middleware('has.magaza');
    Route::post('/yazisil',[StoreUserController::class,'yazisil'])->middleware('has.magaza');
    Route::post('/cokluyazisil',[StoreUserController::class,'cokluyazisil'])->middleware('has.magaza');
    Route::post('/yaziekle',[StoreUserController::class,'yaziekle'])->middleware('has.magaza');
    Route::get('/yazilar/{id}',[StoreUserController::class,'yazidetay'])->middleware('has.magaza');
    Route::post('/yaziguncelle',[StoreUserController::class,'yaziguncelle'])->middleware('has.magaza');

    Route::get('/etkinlikler',[StoreUserController::class,'etkinlikler'])->middleware('has.magaza');
    Route::post('/etksil',[StoreUserController::class,'etksil'])->middleware('has.magaza');
    Route::post('/etkpasif',[StoreUserController::class,'etkpasif'])->middleware('has.magaza');
    Route::post('/etkekle',[StoreUserController::class,'etkekle'])->middleware('has.magaza');
    Route::get('/etkinlikler/{id}',[StoreUserController::class,'etkinlikdetay'])->middleware('has.magaza');
    Route::post('/etkbilsatkapat',[StoreUserController::class,'etkbilsatkapat'])->middleware('has.magaza');
    Route::post('/etkbilsatac',[StoreUserController::class,'etkbilsatac'])->middleware('has.magaza');
    Route::post('/biletekle',[StoreUserController::class,'biletekle'])->middleware('has.magaza');
    Route::post('/biletazalt',[StoreUserController::class,'biletazalt'])->middleware('has.magaza');
    Route::post('/etkguncelle',[StoreUserController::class,'etkguncelle'])->middleware('has.magaza');

    Route::get('/urunler',[StoreUserController::class,'urunler'])->middleware('has.magaza');
    Route::get('/urunler/kategoriler/{sub}',[StoreUserController::class,'urunaltkateori'])->middleware('has.magaza');
    Route::post('/urnpasif',[StoreUserController::class,'urnpasif'])->middleware('has.magaza');
    Route::post('/urnaktif',[StoreUserController::class,'urnaktif'])->middleware('has.magaza');
    Route::post('/urnekle',[StoreUserController::class,'urnekle'])->middleware('has.magaza');
    Route::post('/cokluurunpasif',[StoreUserController::class,'cokluurunpasif'])->middleware('has.magaza');
    Route::get('/urunler/{id}',[StoreUserController::class,'urundetay'])->middleware('has.magaza');
    Route::post('/urnguncelle',[StoreUserController::class,'urnguncelle'])->middleware('has.magaza');
    Route::post('/urndelqrs',[StoreUserController::class,'urndelqrs'])->middleware('has.magaza');
    Route::post('/qrolustur',[StoreUserController::class,'qrolustur'])->middleware('has.magaza');
    Route::post('/cokluqrolustur',[StoreUserController::class,'cokluqrolustur'])->middleware('has.magaza');
    Route::post('/subcatadd',[StoreUserController::class,'subcatadd'])->middleware('has.brand');
    Route::post('/anketcevapla',[StoreUserController::class,'anketcevapla'])->middleware('has.brand');
    Route::post('/dbasvuruguncelle',[StoreUserController::class,'dbasvuruguncelle'])->middleware('has.brand');
    Route::post('/dbasvuruekle',[StoreUserController::class,'dbasvuruekle'])->middleware('has.brand');
    Route::post('/bildirimlerokundu',[StoreUserController::class,'bildirimlerokundu']);
    Route::post('/canceldbasvuru',[StoreUserController::class,'canceldbasvuru'])->middleware('has.brand');
    Route::get('/markam/{sub1}',[StoreUserController::class,'markamtekalt'])->middleware('has.brand');
    Route::get('/markam/{sub1}/{sub2}',[StoreUserController::class,'markamciftalt'])->middleware('has.brand');
    Route::post('/kartonayla',[StoreUserController::class,'kartonayla'])->middleware('has.magaza');
    Route::get('/markam/magazalar/{id}/{sub}',[StoreUserController::class,'magazaalt'])->middleware('has.brand');
    Route::get('/markam/magazalar/{id}/urunler/{sub}',[StoreUserController::class,'magazaurunalt'])->middleware('has.brand');

    Route::get('/basvuru/{sub}',[StoreUserController::class,'basvurualt'])->middleware('has.brand');
    Route::get('/sadakatkartlari/{sub}',[StoreUserController::class,'kartlaralt'])->middleware('has.brand');
    Route::get('/magazalar/{sub}',[StoreUserController::class,'magazalaralt'])->middleware('has.brand');
    Route::get('/magazalar/{id}/{sub}',[StoreUserController::class,'magazalarciftalt'])->middleware('has.brand');
    Route::get('/magazalar/{id}/urunler/{sub}',[StoreUserController::class,'magazaurunleri'])->middleware('has.brand');
    Route::get('/urunaltkategorileri',[StoreUserController::class,'urunaltkategorileri'])->middleware('has.brand');
    Route::post('/altkategoriekle',[StoreUserController::class,'altkategoriekle'])->middleware('has.brand');

    Route::get('/bilgibankasi',[StoreUserController::class,'bilgibankasi']);
    Route::get('/hesabim',[StoreUserController::class,'hesabim']);
    Route::post('/ppchange',[StoreUserController::class,'ppchange']);
    Route::post('/passchange',[StoreUserController::class,'passchange']);
    Route::post('/gsmchange',[StoreUserController::class,'gsmchange']);
    Route::post('/addresschange',[StoreUserController::class,'addresschange']);

    Route::get('/getcounties',[StoreUserController::class,'getcounties']);
    Route::get('/getdistricts',[StoreUserController::class,'getdistricts']);
    Route::get('/getneighborhoods',[StoreUserController::class,'getneighborhoods']);

    Route::get('/magazam',[StoreUserController::class,'magazam'])->middleware('has.magaza');
    Route::get('/destek',[StoreUserController::class,'destek']);
    Route::post('/destektalebigonder',[StoreUserController::class,'destektalebigonder']);
    Route::post('/answerseen',[StoreUserController::class,'answerseen']);

    Route::get('/qrkodlar',[StoreUserController::class,'qrkodlar'])->middleware('has.magaza');

    Route::get('/deneme',function (){
        return "okey";
    })->middleware('throttle');
});

Route::get('/deneme', function (){
    $today = Carbon::now();
    $oneMonthEarlier = Carbon::now()->subMonths(4);
    return response()->json([
        'today'=>$today,
        'oneMonthEarlier'=>$oneMonthEarlier,
        'diff'=>date_diff($today,$oneMonthEarlier)->days,
        'ip'=>request()->ip()
    ]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

require __DIR__.'/auth.php';
