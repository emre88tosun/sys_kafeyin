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
Route::get('/ilkbasvurutamamlandi',[KafeyinController::class,'ilkbasvurutamamlandi']);
Route::post('/ilkbasvurugonder',[KafeyinController::class,'ilkbasvurugonder']);
Route::get('/checkemail',[KafeyinController::class,'checkemail']);

Route::prefix('adminpanel')->middleware(['auth','admin','verified'])->group(function () {
    Route::get('/anasayfa',[AdminController::class,'anasayfa']);
    Route::get('/magazalar',[AdminController::class,'magazalar']);
    Route::get('/magazalar/{storeID}',[AdminController::class,'magazagetir']);
    Route::get('/magazalar/{storeID}/{subCategory}',[AdminController::class,'magazaaltkategori']);
    Route::post('/magazaguncelle',[AdminController::class,'magazaguncelle']);
    Route::post('/magazakullanicidegistir',[AdminController::class,'magazakullanicidegistir']);
    Route::post('/magazakapakguncelle',[AdminController::class,'magazakapakguncelle']);
    Route::get('/yorumsil',[AdminController::class,'yorumsil']);
    Route::get('/kfotosil',[AdminController::class,'kfotosil']);
    Route::post('/kfotoekle',[AdminController::class,'kfotoekle']);
    Route::get('/paypasif',[AdminController::class,'paypasif']);
    Route::get('/paysil',[AdminController::class,'paysil']);
    Route::get('/yazipasif',[AdminController::class,'yazipasif']);
    Route::get('/yazisil',[AdminController::class,'yazisil']);
    Route::post('/yaziguncelle',[AdminController::class,'yaziguncelle']);
    Route::get('/etkpasif',[AdminController::class,'etkpasif']);
    Route::get('/etksil',[AdminController::class,'etksil']);
    Route::post('/etkguncelle',[AdminController::class,'etkguncelle']);
    Route::get('/urunpasif',[AdminController::class,'urunpasif']);
    Route::get('/urunsil',[AdminController::class,'urunsil']);
    Route::post('/urunguncelle',[AdminController::class,'urunguncelle']);
    Route::get('/sehirler',[AdminController::class,'sehirler']);
    Route::get('/sehirler/{cityID}',[AdminController::class,'sehirgetir']);
    Route::post('/sehirguncelle',[AdminController::class,'sehirguncelle']);
    Route::get('/sehirler/{cityID}/{subCategory}',[AdminController::class,'sehiraltkategori']);
    Route::post('/lokasyonekle',[AdminController::class,'lokasyonekle']);
    Route::post('/lokaguncelle',[AdminController::class,'lokaguncelle']);
    Route::get('/lokasil',[AdminController::class,'lokasil']);
    Route::post('/khaberekle',[AdminController::class,'khaberekle']);
    Route::get('/knewssil',[AdminController::class,'knewssil']);
    Route::post('/popmagazaguncelle',[AdminController::class,'popmagazaguncelle']);
    Route::post('/popmagazaekle',[AdminController::class,'popmagazaekle']);
    Route::get('/popmagazasil',[AdminController::class,'popmagazasil']);
    Route::post('/sonmagazaguncelle',[AdminController::class,'sonmagazaguncelle']);
    Route::post('/sonmagazaekle',[AdminController::class,'sonmagazaekle']);
    Route::get('/sonmagazasil',[AdminController::class,'sonmagazasil']);
    Route::post('/edtmagazaguncelle',[AdminController::class,'edtmagazaguncelle']);
    Route::post('/edtmagazaekle',[AdminController::class,'edtmagazaekle']);
    Route::get('/edtmagazasil',[AdminController::class,'edtmagazasil']);
    Route::post('/klokasyonguncelle',[AdminController::class,'klokasyonguncelle']);
    Route::post('/klokasyonekle',[AdminController::class,'klokasyonekle']);
    Route::get('/klokasyonsil',[AdminController::class,'klokasyonsil']);
    Route::post('/duyuruguncelle',[AdminController::class,'duyuruguncelle']);
    Route::post('/duyuruekle',[AdminController::class,'duyuruekle']);
    Route::get('/duysil',[AdminController::class,'duysil']);
    Route::get('/anketler/{subCategory}',[AdminController::class,'anketlergenel']);
    Route::post('/kanketguncelle',[AdminController::class,'kanketguncelle']);
    Route::get('/kanketpasif',[AdminController::class,'kanketpasif']);
    Route::get('/kanketsil',[AdminController::class,'kanketsil']);
    Route::post('/kanketekle',[AdminController::class,'kanketekle']);
    Route::post('/manketguncelle',[AdminController::class,'manketguncelle']);
    Route::get('/manketpasif',[AdminController::class,'manketpasif']);
    Route::get('/manketsil',[AdminController::class,'manketsil']);
    Route::post('/manketekle',[AdminController::class,'manketekle']);
    Route::get('/diger/{subCategory}',[AdminController::class,'digergenel']);
    Route::get('/tskmail1',[AdminController::class,'tskmail1']);
    Route::get('/yorumsil2',[AdminController::class,'yorumsil2']);
    Route::get('/sikayetsil',[AdminController::class,'sikayetsil']);
    Route::get('/oneriokundu',[AdminController::class,'oneriokundu']);
    Route::get('/onerisil',[AdminController::class,'onerisil']);
    Route::get('/dlkokundu',[AdminController::class,'dlkokundu']);
    Route::get('/dlksil',[AdminController::class,'dlksil']);
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
    Route::get('/favartsil',[AdminController::class,'favartsil']);
    Route::get('/favactsil',[AdminController::class,'favactsil']);
    Route::get('/favstosil',[AdminController::class,'favstosil']);
    Route::get('/takipsil',[AdminController::class,'takipsil']);
    Route::get('/kartsil',[AdminController::class,'kartsil']);
    Route::get('/kkullanicisil',[AdminController::class,'kkullanicisil']);
    Route::get('/kullanicilar/magaza/{userID}',[AdminController::class,'magazakullanicigetir']);
    Route::post('/markayoneticisibilgiguncelle',[AdminController::class,'markayoneticisibilgiguncelle']);
    Route::post('/magazakullaniciguncelle',[AdminController::class,'magazakullaniciguncelle']);
    Route::get('/kullanicilar/admin/{userID}',[AdminController::class,'adminkullanicigetir']);
    Route::get('/akullanicisil',[AdminController::class,'akullanicisil']);
    Route::get('/epostagonder',[AdminController::class,'epostagonder']);
    Route::post('/tekilkullaniciyagonder',[AdminController::class,'tekilkullaniciyagonder']);
    Route::post('/coklukullaniciyagonder',[AdminController::class,'coklukullaniciyagonder']);
    Route::post('/sehregorekullaniciyagonder',[AdminController::class,'sehregorekullaniciyagonder']);
    Route::post('/sehregoremagazakullaniciyagonder',[AdminController::class,'sehregoremagazakullaniciyagonder']);
    Route::get('/basvurular/{subCategory}',[AdminController::class,'basvurulargenel']);
    Route::post('/basvuruguncellemeiste',[AdminController::class,'basvuruguncellemeiste']);
    Route::post('/basvurureddet',[AdminController::class,'basvurureddet']);
    Route::get('/dbasvurusil',[AdminController::class,'dbasvurusil']);
    Route::post('/basvuruonayla',[AdminController::class,'basvuruonayla']);
    Route::get('/yasbvurusil1',[AdminController::class,'yasbvurusil1']);
    Route::get('/yasbvurusil2',[AdminController::class,'yasbvurusil2']);
    Route::get('/hesabim',[AdminController::class,'hesabim']);
    Route::post('/sifredegistir',[AdminController::class,'sifredegistir']);
    Route::post('/markaekle',[AdminController::class,'markaekle']);
    Route::post('/magazaekle',[AdminController::class,'magazaekle']);
    Route::post('/adminkullaniciekle',[AdminController::class,'adminkullaniciekle']);
    Route::post('/magazakullaniciekle',[AdminController::class,'magazakullaniciekle']);
    Route::post('/normalkullaniciekle',[AdminController::class,'normalkullaniciekle']);
    Route::get('/configclear',[AdminController::class,'configclear']);
    Route::get('/cacheclear',[AdminController::class,'cacheclear']);
    Route::get('/configcache',[AdminController::class,'configcache']);
    Route::get('/optimizeclear',[AdminController::class,'optimizeclear']);
    Route::get('/sunucuac',[AdminController::class,'sunucuac']);
    Route::get('/sunucukapat',[AdminController::class,'sunucukapat']);
    Route::get('/kafeyinayarlar',[AdminController::class,'kafeyinayarlar']);
    Route::post('/boolayarekle',[AdminController::class,'boolayarekle']);
    Route::post('/boolayarduzenle',[AdminController::class,'boolayarduzenle']);
    Route::get('/boolayarsil',[AdminController::class,'boolayarsil']);
    Route::post('/stringayarekle',[AdminController::class,'stringayarekle']);
    Route::post('/stringayarduzenle',[AdminController::class,'stringayarduzenle']);
    Route::get('/stringayarsil',[AdminController::class,'stringayarsil']);

    Route::get('/deneme',[AdminController::class,'admindeneme'])->middleware('throttle:5,10');
});

Route::prefix('yoneticipaneli')->middleware(['auth','store'])->group(function () {
    Route::get('/anasayfa',[StoreUserController::class,'anasayfa']);
    Route::get('/yorumlar',[StoreUserController::class,'yorumlar'])->middleware('has.magaza');

    Route::get('/paylasimlar',[StoreUserController::class,'paylasimlar'])->middleware('has.magaza');
    Route::get('/paysil',[StoreUserController::class,'paysil'])->middleware('has.magaza');
    Route::get('/coklupaysil',[StoreUserController::class,'coklupaysil'])->middleware('has.magaza');
    Route::get('/paypasif',[StoreUserController::class,'paypasif'])->middleware('has.magaza');
    Route::post('/payekle',[StoreUserController::class,'payekle'])->middleware('has.magaza');

    Route::get('/yazilar',[StoreUserController::class,'yazilar'])->middleware('has.magaza');
    Route::get('/yazipasif',[StoreUserController::class,'yazipasif'])->middleware('has.magaza');
    Route::get('/yazisil',[StoreUserController::class,'yazisil'])->middleware('has.magaza');
    Route::get('/cokluyazisil',[StoreUserController::class,'cokluyazisil'])->middleware('has.magaza');
    Route::post('/yaziekle',[StoreUserController::class,'yaziekle'])->middleware('has.magaza');
    Route::get('/yazilar/{id}',[StoreUserController::class,'yazidetay'])->middleware('has.magaza');
    Route::post('/yaziguncelle',[StoreUserController::class,'yaziguncelle'])->middleware('has.magaza');

    Route::get('/etkinlikler',[StoreUserController::class,'etkinlikler'])->middleware('has.magaza');
    Route::get('/etksil',[StoreUserController::class,'etksil'])->middleware('has.magaza');
    Route::get('/etkpasif',[StoreUserController::class,'etkpasif'])->middleware('has.magaza');
    Route::post('/etkekle',[StoreUserController::class,'etkekle'])->middleware('has.magaza');
    Route::get('/etkinlikler/{id}',[StoreUserController::class,'etkinlikdetay'])->middleware('has.magaza');
    Route::get('/etkbilsatkapat',[StoreUserController::class,'etkbilsatkapat'])->middleware('has.magaza');
    Route::get('/etkbilsatac',[StoreUserController::class,'etkbilsatac'])->middleware('has.magaza');
    Route::post('/biletekle',[StoreUserController::class,'biletekle'])->middleware('has.magaza');
    Route::post('/biletazalt',[StoreUserController::class,'biletazalt'])->middleware('has.magaza');
    Route::post('/etkguncelle',[StoreUserController::class,'etkguncelle'])->middleware('has.magaza');

    Route::get('/urunler',[StoreUserController::class,'urunler'])->middleware('has.magaza');
    Route::get('/urunler/kategoriler/{sub}',[StoreUserController::class,'urunaltkateori'])->middleware('has.magaza');
    Route::get('/urnpasif',[StoreUserController::class,'urnpasif'])->middleware('has.magaza');
    Route::get('/urnaktif',[StoreUserController::class,'urnaktif'])->middleware('has.magaza');
    Route::post('/urnekle',[StoreUserController::class,'urnekle'])->middleware('has.magaza');
    Route::get('/cokluurunpasif',[StoreUserController::class,'cokluurunpasif'])->middleware('has.magaza');
    Route::get('/urunler/{id}',[StoreUserController::class,'urundetay'])->middleware('has.magaza');
    Route::post('/urnguncelle',[StoreUserController::class,'urnguncelle'])->middleware('has.magaza');
    Route::get('/urndelqrs',[StoreUserController::class,'urndelqrs'])->middleware('has.magaza');
    Route::get('/qrolustur',[StoreUserController::class,'qrolustur'])->middleware('has.magaza');
    Route::get('/cokluqrolustur',[StoreUserController::class,'cokluqrolustur'])->middleware('has.magaza');
    Route::post('/subcatadd',[StoreUserController::class,'subcatadd'])->middleware('has.brand');
    Route::post('/anketcevapla',[StoreUserController::class,'anketcevapla'])->middleware('has.brand');
    Route::post('/dbasvuruguncelle',[StoreUserController::class,'dbasvuruguncelle'])->middleware('has.brand');
    Route::post('/dbasvuruekle',[StoreUserController::class,'dbasvuruekle'])->middleware('has.brand');
    Route::get('/bildirimlerokundu',[StoreUserController::class,'bildirimlerokundu']);
    Route::get('/canceldbasvuru',[StoreUserController::class,'canceldbasvuru'])->middleware('has.brand');
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
