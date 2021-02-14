<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityTicket;
use App\Models\AddressCity;
use App\Models\AddressCounty;
use App\Models\Announcement;
use App\Models\AnnouncementApplication;
use App\Models\Article;
use App\Models\Brand;
use App\Models\BrandManagerExtraInfo;
use App\Models\BrandNotification;
use App\Models\City;
use App\Models\EditorChoiceStore;
use App\Models\FavoriteActivity;
use App\Models\FavoriteArticle;
use App\Models\FavoriteStore;
use App\Models\Follow;
use App\Models\KafeyinBoolSetting;
use App\Models\KafeyinLocation;
use App\Models\KafeyinNews;
use App\Models\KafeyinQrCode;
use App\Models\KafeyinStory;
use App\Models\KafeyinStringSetting;
use App\Models\KafeyinSuggestion;
use App\Models\KafeyinUserNotification;
use App\Models\LastAddedStore;
use App\Models\LastSearchedStore;
use App\Models\Location;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyCardApproval;
use App\Models\MakinaSearch;
use App\Models\MenuItem;
use App\Models\MenuItemCategory;
use App\Models\MenuItemSubCategory;
use App\Models\MenuItemViewLog;
use App\Models\OwnershipApplication;
use App\Models\OwnershipApplicationReferral;
use App\Models\PopularStore;
use App\Models\ProfileViewLog;
use App\Models\Store;
use App\Models\StoreComment;
use App\Models\StoreCommentLike;
use App\Models\StoreCommentPhoto;
use App\Models\StoreCommentReport;
use App\Models\StoreKafeyinPhoto;
use App\Models\StoreSuggestion;
use App\Models\StoreSurvey;
use App\Models\StoreSurveyAnswer;
use App\Models\User;
use App\Models\UserDeviceInfo;
use App\Models\UserLocationChange;
use App\Models\UserLog;
use App\Models\UsersBadge;
use App\Models\UserSurvey;
use App\Models\UserSurveyAnswer;
use App\Notifications\KafeyinBaseEmail;
use App\Notifications\KafeyinBaseEmail2;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Sodium\add;

class AdminController extends Controller
{
    public function anasayfa()
    {
        $startOfDay = Carbon::today()->startOfDay()->toDateTimeString();
        $nuc = User::where('userType', 'user')->where('created_at', '>=', $startOfDay)->count();
        $ulc = User::where('userType', 'user')->where('lastLogin', '>=', $startOfDay)->count();
        $muc = MakinaSearch::where('created_at', '>=', $startOfDay)->count();
        $lru = User::where('userType', 'user')->orderByDesc('created_at')->limit(5)->get();
        $cuc = City::withCount('users')->orderByDesc('users_count')->limit(6)->get();
        $tuc = User::where('userType', 'user')->count();
        $tsc = Store::where('isActive', true)->count();
        $tbc = Brand::count();
        $tcc = StoreComment::count();
        $tpc = StoreCommentPhoto::count();

        $tarc = Article::count();
        $toarc = Article::where('isActive', true)->where('created_at', '>=', $startOfDay)->count();
        $toarfc = FavoriteArticle::where('created_at', '>=', $startOfDay)->with('article', function ($query) {
            return $query->where('isActive', true);
        })->count();
        $mfarts = Article::where('isActive',true)->with('store')->withCount('favorites')->orderByDesc('favorites_count')->limit(5)->get();

        $tactc = Activity::count();
        $toactc = Activity::where('isActive', true)->where('created_at', '>=', $startOfDay)->count();
        $toactfc = FavoriteActivity::where('created_at', '>=', $startOfDay)->with('activity', function ($query) {
            return $query->where('isActive', true);
        })->count();
        $mfacsts = Activity::where('isActive',true)->with('store')->withCount('favorites')->orderByDesc('favorites_count')->limit(5)->get();

        $tstoc = KafeyinStory::count();
        $tostoc = KafeyinStory::where('isActive', true)->where('created_at', '>=', $startOfDay)->count();
        $mvstos = KafeyinStory::where('isActive',true)->with('store')->orderByDesc('viewCount')->limit(5)->get();

        $lbrs = Brand::withCount('stores')->orderByDesc('created_at')->limit(5)->get();
        $lstores = Store::with('brand')->orderByDesc('created_at')->limit(5)->get();

        $tdclc = LoyaltyCard::where('status','active')->where('isDeleted',false)->where('created_at', '>=', $startOfDay)->count();
        $tdavlc = LoyaltyCard::where('status','available')->where('isDeleted',false)->where('updated_at', '>=', $startOfDay)->count();
        $tdudlc = LoyaltyCard::where('status','used')->where('isDeleted',false)->where('updated_at', '>=', $startOfDay)->count();
        $tddellc = LoyaltyCard::where('isDeleted',true)->where('updated_at', '>=', $startOfDay)->count();

        $atclc = LoyaltyCard::where('status','active')->where('isDeleted',false)->count();
        $atavlc = LoyaltyCard::where('status','available')->where('isDeleted',false)->count();
        $atudlc = LoyaltyCard::where('status','used')->where('isDeleted',false)->count();
        $atdellc = LoyaltyCard::where('isDeleted',true)->count();

        $atkqrCount = KafeyinQrCode::count();
        $atUsedkqrCount = KafeyinQrCode::where('status','used')->count();
        $atDeletedkqrCount = KafeyinQrCode::where('status','deleted')->count();
        $tdUsedkqrCount = KafeyinQrCode::where('status','used')->where('updated_at','>=',$startOfDay)->count();
        $tdCdkqrCount = KafeyinQrCode::where('status','active')->where('created_at','>=',$startOfDay)->count();
        $tdDeletedkqrCount = KafeyinQrCode::where('status','deleted')->where('updated_at','>=',$startOfDay)->count();

        $locbs = Brand::where('id','>',0)
            ->withCount('today_created_cards')
            ->orderByDesc('today_created_cards_count')
            ->limit(7)
            ->get();

        $locusedbs = Brand::where('id','>',0)
            ->withCount('today_approved_cards')
            ->orderByDesc('today_approved_cards_count')
            ->limit(7)
            ->get();

        $items1 = MenuItem::withCount('today_created_qrcodes')
            ->withCount('active_qrcodes')
            ->with('store')
            ->orderByDesc('today_created_qrcodes_count')
            ->limit(6)
            ->get();

        $items2 = MenuItem::withCount('today_used_qrcodes')
            ->withCount('active_qrcodes')
            ->withCount('used_qrcodes')
            ->with('store')
            ->orderByDesc('today_used_qrcodes_count')
            ->limit(6)
            ->get();

        $items3 = MenuItem::withCount('qrcodes')
            ->withCount('active_qrcodes')
            ->withCount('used_qrcodes')
            ->with('store')
            ->orderByDesc('qrcodes_count')
            ->limit(6)
            ->get();

        $items4 = MenuItem::withCount('qrcodes')
            ->withCount('active_qrcodes')
            ->withCount('used_qrcodes')
            ->with('store')
            ->orderByDesc('used_qrcodes_count')
            ->limit(6)
            ->get();

        $ccities = City::where('id','>=',0)->with('locations')->get();
        $bbrands = Brand::where('id','>=',0)->get();
        $llocations = Location::where('id','>=',0)->with('city')->get();

        $itemCats = MenuItemCategory::withCount('items')->get();
        $itemC = MenuItem::count();
        $itemAcC = MenuItem::where('isActive',true)->count();
        $itemTdC = MenuItem::where('created_at','>=',$startOfDay)->count();

        $mvItems = MenuItem::withCount('views')->with('store')->orderByDesc('views_count')->limit(7)->get();


        $now = Carbon::now()->endOfDay();
        $now2 = Carbon::now()->startOfDay();

        $users = User::where('userType', 'user')->where('created_at', '<=', $now->toDateTimeString())->get();
        $comments = StoreComment::where('created_at', '<=', $now->toDateTimeString())->get();
        $photos = StoreCommentPhoto::where('created_at', '<=', $now->toDateTimeString())->get();
        $stores = Store::where('created_at', '<=', $now->toDateTimeString())->get();
        $iitems = MenuItem::where('created_at', '<=', $now->toDateTimeString())->get();
        $l7du = array();
        $l7dc = array();
        $l7dp = array();
        $l15ds = array();
        $l15is = array();
        $l15days = array();
        $i = 0;
        $k = 0;

        while ($i < 7) {
            $dayOfWeek = $now->subDays($i);
            $dayOfWeek2 = $now2->subDays($i);
            $daysUserCount = $users->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
            $daysCommentCount = $comments->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
            $daysPhotoCount = $photos->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
            array_push($l7du, $daysUserCount);
            array_push($l7dc, $daysCommentCount);
            array_push($l7dp, $daysPhotoCount);
            $now = Carbon::now()->endOfDay();
            $now2 = Carbon::now()->startOfDay();
            $i++;
        }

        while ($k < 15) {
            $dayOfWeek = $now->subDays($k);
            $daysStoreCount = $stores->where('created_at', '<=', $dayOfWeek->toDateTimeString())->count();
            $daysItemCount = $iitems->where('created_at', '<=', $dayOfWeek->toDateTimeString())->count();
            array_push($l15ds, $daysStoreCount);
            array_push($l15is, $daysItemCount);
            array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
            $now = Carbon::now()->endOfDay();
            $k++;
        }


        return view('admin.anasayfa')->with([
            'nuc' => $nuc,
            'ulc' => $ulc,
            'muc' => $muc,
            'lru' => $lru,
            'cuc' => $cuc,
            'tuc' => $tuc,
            'tcc' => $tcc,
            'tpc' => $tpc,
            'tsc' => $tsc,
            'tdclc' => $tdclc,
            'tdavlc' => $tdavlc,
            'tdudlc' => $tdudlc,
            'tddellc' => $tddellc,
            'atclc' => $atclc,
            'atavlc' => $atavlc,
            'atudlc' => $atudlc,
            'atdellc' => $atdellc,
            'atkqrCount' => $atkqrCount,
            'atUsedkqrCount' => $atUsedkqrCount,
            'atDeletedkqrCount' => $atDeletedkqrCount,
            'tdUsedkqrCount' => $tdUsedkqrCount,
            'tdCdkqrCount' => $tdCdkqrCount,
            'tdDeletedkqrCount' => $tdDeletedkqrCount,
            'items1' => $items1,
            'items2' => $items2,
            'items3' => $items3,
            'items4' => $items4,
            'itemCats' => $itemCats,
            'itemAcC' => $itemAcC,
            'itemC' => $itemC,
            'itemTdC' => $itemTdC,
            'mvItems' => $mvItems,
            'locbs' => $locbs,
            'locusedbs' => $locusedbs,
            'ccities' => $ccities,
            'bbrands' => $bbrands,
            'llocations' => $llocations,
            'tbc' => $tbc,
            'tarc' => $tarc,
            'toarc' => $toarc,
            'toarfc' => $toarfc,
            'mfarts' => $mfarts,
            'tactc' => $tactc,
            'toactc' => $toactc,
            'toactfc' => $toactfc,
            'mfacsts' => $mfacsts,
            'tstoc' => $tstoc,
            'tostoc' => $tostoc,
            'mvstos' => $mvstos,
            'lbrs' => $lbrs,
            'lstores' => $lstores,
            'l7du' => $l7du,
            'l7dc' => $l7dc,
            'l7dp' => $l7dp,
            'l15ds' => $l15ds,
            'l15is' => $l15is,
            'l15days' => $l15days,
        ]);
    }

    public function magazalar()
    {
        $stores = Store::where('id', '>', 0)
            ->with('city')
            ->with('location')
            ->with('brand')
            ->with('yonetici')
            ->withCount('comments')
            ->withCount('photos')
            ->withCount('favorites')
            ->get();

        return view('admin.magazalar')->with([
            'stores' => $stores
        ]);
    }

    public function magazagetir(Request $request)
    {
        $storeID = $request->storeID;
        $store = Store::where('id', $storeID)
            ->with('city')
            ->with('location')
            ->with('brand')
            ->with('yonetici')
            ->with('logs')
            ->with('logs.user')
            ->withCount('comments')
            ->withCount('photos')
            ->withCount('favorites')
            ->first();

        $locations = Location::where('cityID', $store->cityID)
            ->get();

        $storeUsers = User::where('userType', 'store')
            ->get();

        return view('admin.magazagetir')->with([
            'store' => $store,
            'locations' => $locations,
            'storeUsers' => $storeUsers
        ]);
    }

    public function magazaguncelle(Request $request)
    {
        Store::where('id', $request->storeID)->first()->update($request->except(['_token', 'storeID', 'city']));

        return redirect()->back()->with(['stUp' => true]);
    }

    public function magazakullanicidegistir(Request $request)
    {
        $storeID = $request->storeID;
        $userID = $request->userID;
        $store = Store::where('id', $storeID)->with('yonetici')->first();

        if ($userID == 0) {
            Store::where('id', $storeID)->first()->update([
                'canTakeTakeAwayOrder' => false,
                'canTakeLocalDeliveryOrder' => false,
                'canTakeLocalCargoOrder' => false,
                'canTakeUpstateCargoOrder' => false,
            ]);

            Store::where('id', $storeID)->first()->update([
                'email' => 'ownerless-store@kafeyinapp.com'
            ]);
            return redirect()->back()->with(['stUp' => true]);
        } else {
            $secilenKullanici = User::where('id', $userID)->first();
            if (Store::where('email', $secilenKullanici->email)->exists()) {
                return redirect()->back()->with(['alreadyStoreUser' => true]);
            }
            if ($store->yonetici) {

                $yeniYonetici = User::where('id', $userID)->first();
                Store::where('id', $storeID)->first()->update([
                    'email' => $yeniYonetici->email
                ]);
                //TODO:: yeni yöneticiye mail gönder
                return redirect()->back()->with(['stUp' => true]);
            } else {
                Store::where('id', $storeID)->first()->update([
                    'email' => $secilenKullanici->email
                ]);
                //TODO:: yeni yöneticiye mail gönder
                return redirect()->back()->with(['stUp' => true]);
            }
        }

    }

    public function magazaaltkategori(Request $request)
    {
        $storeID = $request->storeID;
        $subCategory = $request->subCategory;

        switch ($subCategory) {
            case 'yorumlar':
                $yorumlar = StoreComment::where('storeID', $storeID)
                    ->with('photos')
                    ->with('commenter')
                    ->withCount('likes')
                    ->orderByDesc('created_at')
                    ->paginate(6);

                $store = Store::where('id', $storeID)->first();

                $yorumCount = StoreComment::where('storeID', $storeID)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $storeID)->count();
                if ($yorumCount == 0) {
                    $totalPuan = 0;
                } else {
                    $totalPuan = 0;
                    $yorums = StoreComment::where('storeID', $storeID)->get();
                    foreach ($yorums as $yorum) {
                        $totalPuan = $totalPuan + $yorum->commentPoint;
                    }
                }

                return view('admin.magazayorumlar')
                    ->with([
                        'yorums' => $yorumlar,
                        'store' => $store,
                        'totalPuan' => $totalPuan,
                        'yorumCount' => $yorumCount,
                        'fotoCount' => $fotoCount,
                    ]);
                break;
            case 'fotograflar':
                $photos = StoreCommentPhoto::where('storeID', $storeID)
                    ->orderByDesc('created_at')
                    ->paginate(80);

                $store = Store::where('id', $storeID)->first();

                $yorumCount = StoreComment::where('storeID', $storeID)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $storeID)->count();
                if ($yorumCount == 0) {
                    $totalPuan = 0;
                } else {
                    $totalPuan = 0;
                    $yorums = StoreComment::where('storeID', $storeID)->get();
                    foreach ($yorums as $yorum) {
                        $totalPuan = $totalPuan + $yorum->commentPoint;
                    }
                }

                return view('admin.magazafotograflar')
                    ->with([
                        'photos' => $photos,
                        'store' => $store,
                        'totalPuan' => $totalPuan,
                        'yorumCount' => $yorumCount,
                        'fotoCount' => $fotoCount,
                    ]);
                break;
            case 'kafeyinfotograflar':
                $photos = StoreKafeyinPhoto::where('storeID', $storeID)
                    ->orderByDesc('created_at')
                    ->get();

                $store = Store::where('id', $storeID)->first();

                $yorumCount = StoreComment::where('storeID', $storeID)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $storeID)->count();
                if ($yorumCount == 0) {
                    $totalPuan = 0;
                } else {
                    $totalPuan = 0;
                    $yorums = StoreComment::where('storeID', $storeID)->get();
                    foreach ($yorums as $yorum) {
                        $totalPuan = $totalPuan + $yorum->commentPoint;
                    }
                }

                return view('admin.magazakafeyinfotograflar')
                    ->with([
                        'photos' => $photos,
                        'store' => $store,
                        'totalPuan' => $totalPuan,
                        'yorumCount' => $yorumCount,
                        'fotoCount' => $fotoCount,
                    ]);
                break;
            case 'paylasimlar':

                $store = Store::where('id', $storeID)->first();
                $aktifPaylasimlar = KafeyinStory::where('storeID', $storeID)->where('isActive', true)->get();
                $pasifPaylasimlar = KafeyinStory::where('storeID', $storeID)->where('isActive', false)->get();

                return view('admin.magazapaylasimlar')
                    ->with([
                        'store' => $store,
                        'aktifPaylasimlar' => $aktifPaylasimlar,
                        'pasifPaylasimlar' => $pasifPaylasimlar,
                    ]);

                break;
            case 'yazilar':

                $store = Store::where('id', $storeID)->first();
                $aktifYazilar = Article::where('storeID', $storeID)->where('isActive', true)->get();
                $pasifYazilar = Article::where('storeID', $storeID)->where('isActive', false)->get();

                return view('admin.magazayazilar')
                    ->with([
                        'store' => $store,
                        'aktifYazilar' => $aktifYazilar,
                        'pasifYazilar' => $pasifYazilar,
                    ]);
                break;
            case 'etkinlikler':

                $store = Store::where('id', $storeID)->first();
                $aktifEtkinlikler = Activity::where('storeID', $storeID)->where('isActive', true)->get();
                $pasifEtkinlikler = Activity::where('storeID', $storeID)->where('isActive', false)->get();

                return view('admin.magazaetkinlikler')
                    ->with([
                        'store' => $store,
                        'aktifEtkinlikler' => $aktifEtkinlikler,
                        'pasifEtkinlikler' => $pasifEtkinlikler,
                    ]);
                break;
            case 'urunler':
                $store = Store::where('id', $storeID)->first();
                $kategoris = MenuItemCategory::with(['subcategories' => function ($query) use ($store) {
                    return $query->where('brandID', $store->brandID);
                }])->get();
                $urunler = MenuItem::where('storeID', $storeID)
                    ->with('category')
                    ->with('subcategory')
                    ->withCount('views')
                    ->get();

                $subCategories = MenuItemSubCategory::where('brandID', $store->brandID)->with('maincategory')->get();

                return view('admin.magazaurunler')
                    ->with([
                        'kategoris' => $kategoris,
                        'urunler' => $urunler,
                        'store' => $store,
                        'altkategoris' => $subCategories
                    ]);
                break;

            default:
                return redirect('/adminpanel/magazalar/' . $storeID);
                break;
        }
    }

    public function yorumsil(Request $request)
    {
        $yorumID = $request->yorumID;
        $commentPhotos = StoreCommentPhoto::where('commentID', $yorumID)->get();
        foreach ($commentPhotos as $commentPhoto) {
            if (strpos($commentPhoto->imageLink, "comment_images") != false) {
                $konum = strpos($commentPhoto->imageLink, "comment_images");
                $curFilePath = substr($commentPhoto->imageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
        }
        StoreComment::where('id', $yorumID)->delete();
        StoreCommentLike::where('storeCommentID', $yorumID)->delete();
        StoreCommentPhoto::where('commentID', $yorumID)->delete();
        return redirect()->back()->with([
            'yorumDel' => true
        ]);
    }

    public function sehirler(Request $request)
    {
        $sehirs = City::withCount('locations')
            ->withCount('stores')
            ->withCount('users')
            ->get();
        return view('admin.sehirler')->with([
            'sehirs' => $sehirs
        ]);
    }

    public function sehirgetir(Request $request)
    {
        $cityID = $request->cityID;
        $city = City::where('id', $cityID)
            ->with('locations')
            ->with('users')
            ->with('popularstores')
            ->with('popularstores.store')
            ->with('lastaddedstores')
            ->with('lastaddedstores.store')
            ->with('editorsstores')
            ->with('editorsstores.store')
            ->with('kafeyinlocations')
            ->with('announcements')
            ->with('announcements.brand')
            ->first();

        $userCount = User::where('city', $city->name)->where('userType', 'user')->count();
        $storeCount = Store::where('cityID', $cityID)->count();

        $yaziCount = Article::where('cityID', $cityID)->where('isActive', true)->count();
        $etkinlikCount = Activity::where('cityID', $cityID)->where('isActive', true)->count();
        $paylasimCount = KafeyinStory::where('cityID', $cityID)->where('isActive', true)->count();
        $kullaniciCount = User::where('city', $city->name)->where('userType', 'user')->count();
        $urunCount = MenuItem::where('cityID', $cityID)->where('isActive', true)->count();

        $tdyRegUserCount = User::where('city', $city->name)->where('userType', 'user')->where('created_at', '>', Carbon::today()->startOfDay())->count();
        $tdyLogUserCount = User::where('city', $city->name)->where('userType', 'user')->where('lastLogin', '>', Carbon::today()->startOfDay())->count();
        $tdyLoyCount = LoyaltyCard::where('created_at', '>', Carbon::today()->startOfDay())
            ->where('status', 'active')
            ->where('isDeleted',false)
            ->whereHas('owner', function ($query) use ($city) {
                return $query->where('city', $city->name);
            })
            ->count();
        $tdyUsedLoyCount = LoyaltyCard::where('updated_at', '>', Carbon::today()->startOfDay())
            ->where('status', 'used')
            ->where('isDeleted',false)
            ->whereHas('owner', function ($query) use ($city) {
                return $query->where('city', $city->name);
            })
            ->count();

        $tdyArtCount = Article::where('cityID', $cityID)->where('created_at', '>', Carbon::today()->startOfDay())->count();
        $tdyActCount = Activity::where('cityID', $cityID)->where('created_at', '>', Carbon::today()->startOfDay())->count();
        $tdyStoCount = KafeyinStory::where('cityID', $cityID)->where('created_at', '>', Carbon::today()->startOfDay())->count();

        $tdyMakUsageCount = MakinaSearch::where('created_at', '>', Carbon::today()->startOfDay())
            ->whereHas('user', function ($query) use ($city) {
                return $query->where('city', $city->name);
            })
            ->count();

        $tdyCommentCount = StoreComment::where('created_at', '>', Carbon::today()->startOfDay())
            ->whereHas('store', function ($query) use ($city) {
                return $query->where('cityID', $city->id);
            })
            ->count();
        $tdyPhotoCount = StoreCommentPhoto::where('created_at', '>', Carbon::today()->startOfDay())
            ->whereHas('store', function ($query) use ($city) {
                return $query->where('cityID', $city->id);
            })
            ->count();

        return view('admin.sehirgetir')
            ->with([
                'city' => $city,
                'storeCount' => $storeCount,
                'userCount' => $userCount,
                'yaziCount' => $yaziCount,
                'etkinlikCount' => $etkinlikCount,
                'paylasimCount' => $paylasimCount,
                'kullaniciCount' => $kullaniciCount,
                'urunCount' => $urunCount,
                'tdyRegUserCount' => $tdyRegUserCount,
                'tdyLogUserCount' => $tdyLogUserCount,
                'tdyLoyCount' => $tdyLoyCount,
                'tdyUsedLoyCount' => $tdyUsedLoyCount,
                'tdyArtCount' => $tdyArtCount,
                'tdyActCount' => $tdyActCount,
                'tdyStoCount' => $tdyStoCount,
                'tdyMakUsageCount' => $tdyMakUsageCount,
                'tdyCommentCount' => $tdyCommentCount,
                'tdyPhotoCount' => $tdyPhotoCount,
            ]);
    }

    public function sehirguncelle(Request $request)
    {
        City::where('id', $request->cityID)->first()->update($request->except(['_token', 'cityID']));

        return redirect()->back()->with(['cityUp' => true]);
    }

    public function sehiraltkategori(Request $request)
    {
        $cityID = $request->cityID;
        $city = City::where('id', $cityID)->first();
        $subCategory = $request->subCategory;

        switch ($subCategory) {
            case 'yazilar':

                $yazis = Article::where('cityID', $cityID)
                    ->with('store')
                    ->withCount('favorites')
                    ->get();

                return view('admin.sehiryazilar')
                    ->with([
                        'city' => $city,
                        'yazis' => $yazis
                    ]);

                break;
            case 'etkinlikler':

                $etkinliks = Activity::where('cityID', $cityID)
                    ->with('store')
                    ->withCount('favorites')
                    ->get();

                return view('admin.sehiretkinlikler')
                    ->with([
                        'city' => $city,
                        'etkinliks' => $etkinliks
                    ]);

                break;
            case 'paylasimlar':

                $paylasims = KafeyinStory::where('cityID', $cityID)
                    ->with('store')
                    ->get();

                return view('admin.sehirpaylasimlar')
                    ->with([
                        'city' => $city,
                        'paylasims' => $paylasims
                    ]);

                break;
            case 'lokasyonlar':

                $lokasyons = Location::where('cityID', $cityID)
                    ->withCount('stores')
                    ->get();

                return view('admin.sehirlokasyonlar')
                    ->with([
                        'city' => $city,
                        'lokasyons' => $lokasyons
                    ]);

                break;
            case 'kafeyindenhaberler':

                $khaberlers = KafeyinNews::where('cityID', $cityID)
                    ->get();

                return view('admin.sehirkafeyindenhaberler')
                    ->with([
                        'city' => $city,
                        'khaberlers' => $khaberlers
                    ]);

                break;
            case 'populermagazalar':
                $populerMagazas = PopularStore::where('cityID', $cityID)->with('store')->with('store.brand')->orderBy('position')->get();
                $sehirMagazas = Store::where('cityID', $cityID)->where('isActive', true)->where('isCafe', true)->get();
                return view('admin.sehirpopulermagazalar')
                    ->with([
                        'city' => $city,
                        'populermagazas' => $populerMagazas,
                        'sehirmagazas' => $sehirMagazas,
                    ]);
                break;
            case 'ensoneklenenmagazalar':
                $enSonMagazas = LastAddedStore::where('cityID', $cityID)->with('store')->with('store.brand')->orderBy('position')->get();
                $sehirMagazas = Store::where('cityID', $cityID)->where('isActive', true)->where('isCafe', true)->get();
                return view('admin.sehirensonmagazalar')
                    ->with([
                        'city' => $city,
                        'ensonmagazas' => $enSonMagazas,
                        'sehirmagazas' => $sehirMagazas,
                    ]);
                break;
            case 'etercihimagazalar':
                $edtMagazas = EditorChoiceStore::where('cityID', $cityID)->with('store')->with('store.brand')->orderBy('position')->get();
                $sehirMagazas = Store::where('cityID', $cityID)->where('isActive', true)->where('isCafe', true)->get();
                return view('admin.sehiredtmagazalar')
                    ->with([
                        'city' => $city,
                        'edtmagazas' => $edtMagazas,
                        'sehirmagazas' => $sehirMagazas,
                    ]);
                break;
            case 'kafeyinlokasyonlar':
                $klokasyons = KafeyinLocation::where('cityID', $cityID)->withCount('usage')->get();
                return view('admin.sehirklokasyonlar')
                    ->with([
                        'city' => $city,
                        'klokasyons' => $klokasyons,
                    ]);
                break;
            case 'duyurular':
                $duyurus = Announcement::where('cityID', $cityID)->with('brand')->orderBy('position')->get();
                $markas = Brand::all();
                return view('admin.sehirduyurular')
                    ->with([
                        'city' => $city,
                        'duyurus' => $duyurus,
                        'markas' => $markas
                    ]);
                break;
            default:
                return redirect('/adminpanel/sehirler/' . $cityID);
                break;
        }
    }

    public function lokasyonekle(Request $request)
    {
        $cityID = $request->cityID;
        $name = $request->name;
        $data = [
            'cityID' => $cityID,
            'name' => $name
        ];
        Location::create($data);
        return redirect()->back()->with([
            'locaAdd' => true
        ]);
    }

    public function magazakapakguncelle(Request $request)
    {
        if ($request->hasFile('image')) {

            $storeID = $request->storeID;
            $image = $request->file('image');
            $curCoverLink = Store::where('id', $storeID)->first()->coverImageLink;

            if (strpos($curCoverLink, "cover_photos") != false) {
                $konum = strpos($curCoverLink, "cover_photos");
                $curFilePath = substr($curCoverLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('cover_photos/' . $storeID, $image);
            $imageLink = url(Storage::url($path));

            Store::where('id', $storeID)->first()->update([
                'coverImageLink' => $imageLink
            ]);

            return redirect()->back()->with([
                'coverUp' => true
            ]);
        } else {
            return redirect()->back()->with([
                'fileErr' => true
            ]);
        }
    }

    public function kfotosil(Request $request)
    {
        $kFotoID = $request->id;
        $kFotoLink = StoreKafeyinPhoto::where('id', $kFotoID)->first()->imageLink;
        if (strpos($kFotoLink, "kafeyin_photos") != false) {
            $konum = strpos($kFotoLink, "kafeyin_photos");
            $curFilePath = substr($kFotoLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        StoreKafeyinPhoto::where('id', $kFotoID)->delete();
        return redirect()->back()->with([
            'kFotoDel' => true
        ]);
    }

    public function kfotoekle(Request $request)
    {
        if ($request->hasFile('image')) {
            $storeID = $request->storeID;
            $image = $request->file('image');
            $path = Storage::disk('public')->put('kafeyin_photos/' . $storeID, $image);
            $imageLink = url(Storage::url($path));
            $data = [
                'storeID' => $storeID,
                'imageLink' => $imageLink
            ];
            StoreKafeyinPhoto::create($data);
            return redirect()->back()->with([
                'kFotoUp' => true
            ]);
        } else {
            return redirect()->back()->with([
                'fileErr' => true
            ]);
        }
    }

    public function paypasif(Request $request)
    {
        $storyID = $request->id;
        KafeyinStory::where('id', $storyID)->first()->update([
            'isActive' => false
        ]);
        return redirect()->back()->with([
            'payPasif' => true
        ]);
    }

    public function paysil(Request $request)
    {
        $storyID = $request->id;
        $stoImageLink = KafeyinStory::where('id', $storyID)->first()->imageLink;
        if (strpos($stoImageLink, "stories") != false) {
            $konum = strpos($stoImageLink, "stories");
            $curFilePath = substr($stoImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        KafeyinStory::where('id', $storyID)->delete();
        return redirect()->back()->with([
            'paySil' => true
        ]);
    }

    public function yazipasif(Request $request)
    {
        $articleID = $request->id;
        Article::where('id', $articleID)->first()->update([
            'isActive' => false
        ]);
        return redirect()->back()->with([
            'yaziPasif' => true
        ]);
    }

    public function yazisil(Request $request)
    {
        $yaziID = $request->id;
        $yaziImageLink = Article::where('id', $yaziID)->first()->imageLink;
        if (strpos($yaziImageLink, "article_images") != false) {
            $konum = strpos($yaziImageLink, "article_images");
            $curFilePath = substr($yaziImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        if (Article::where('id', $yaziID)->first()->hasVideo) {
            $yaziVideoLink = Article::where('id', $yaziID)->first()->videoLink;
            if (strpos($yaziVideoLink, "article_videos") != false) {
                $konum = strpos($yaziVideoLink, "article_videos");
                $curFilePath = substr($yaziVideoLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
        }
        Article::where('id', $yaziID)->delete();
        FavoriteArticle::where('articleID', $yaziID)->delete();

        return redirect()->back()->with([
            'yaziSil' => true
        ]);
    }

    public function etkpasif(Request $request)
    {
        $activityID = $request->id;
        Activity::where('id', $activityID)->first()->update([
            'isActive' => false
        ]);
        return redirect()->back()->with([
            'etkPasif' => true
        ]);
    }

    public function etksil(Request $request)
    {
        $etkinlikID = $request->id;
        $etkImageLink = Activity::where('id', $etkinlikID)->first()->imageLink;
        if (strpos($etkImageLink, "activity_images") != false) {
            $konum = strpos($etkImageLink, "activity_images");
            $curFilePath = substr($etkImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        Activity::where('id', $etkinlikID)->delete();
        FavoriteActivity::where('activityID', $etkinlikID)->delete();

        return redirect()->back()->with([
            'etkSil' => true
        ]);
    }

    public function urunpasif(Request $request)
    {
        $urunID = $request->id;
        MenuItem::where('id', $urunID)->first()->update([
            'isActive' => false
        ]);
        KafeyinQrCode::where('menuItemID', $urunID)->update([
            'status' => 'inactive'
        ]);
        return redirect()->back()->with([
            'urunPasif' => true
        ]);
    }

    public function urunsil(Request $request)
    {
        $urunID = $request->id;
        $urunImageLink = MenuItem::where('id', $urunID)->first()->imageLink;
        if (strpos($urunImageLink, "menu_item_images") != false) {
            $konum = strpos($urunImageLink, "menu_item_images");
            $curFilePath = substr($urunImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        MenuItem::where('id', $urunID)->delete();
        MenuItemViewLog::where('menuItemID', $urunID)->delete();
        KafeyinQrCode::where('menuItemID', $urunID)->update([
            'status' => 'deleted'
        ]);

        return redirect()->back()->with([
            'urunSil' => true
        ]);
    }

    public function lokasil(Request $request)
    {
        $lokasyonID = $request->id;
        if (Store::where('locationID', $lokasyonID)->exists()) {
            return redirect()->back()->with([
                'lokaHasStore' => true
            ]);
        } else {
            Location::where('id', $lokasyonID)->delete();
            return redirect()->back()->with([
                'lokaDel' => true
            ]);
        }
    }

    public function lokaguncelle(Request $request)
    {
        $lokasyonID = $request->locationID;
        $name = $request->name;

        Location::where('id', $lokasyonID)->first()->update([
            'name' => $name
        ]);

        return redirect()->back()->with([
            'lokaUp' => true
        ]);
    }

    public function khaberekle(Request $request)
    {
        if (!$request->hasFile('image')) {
            return redirect()->back()->with([
                'noImg' => true
            ]);
        } else {
            $cityID = $request->cityID;
            $title = $request->title;
            $desc = $request->desc;
            $image = $request->file('image');

            $path = Storage::disk('public')->put('news_images/' . $cityID, $image);
            $imageLink = url(Storage::url($path));

            $data = [
                'cityID' => $cityID,
                'title' => $title,
                'desc' => $desc,
                'imageLink' => $imageLink
            ];

            KafeyinNews::create($data);
            return redirect()->back()->with([
                'kNewsAdd' => true
            ]);
        }
    }

    public function knewssil(Request $request)
    {
        $kHaberID = $request->id;
        $khaberImageLink = KafeyinNews::where('id', $kHaberID)->first()->imageLink;

        if (strpos($khaberImageLink, "news_images") != false) {
            $konum = strpos($khaberImageLink, "news_images");
            $curFilePath = substr($khaberImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }

        KafeyinNews::where('id', $kHaberID)->first()->delete();
        return redirect()->back()->with([
            'kNewsDel' => true
        ]);
    }

    public function yaziguncelle(Request $request)
    {
        $yaziID = $request->articleID;

        if (!Article::where('id', $yaziID)->first()->isActive) {
            return redirect()->back()->with([
                'yaziNotActive' => true
            ]);
        }

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $yaziImageLink = Article::where('id', $yaziID)->first()->imageLink;
            if (strpos($yaziImageLink, "article_images") != false) {
                $konum = strpos($yaziImageLink, "article_images");
                $curFilePath = substr($yaziImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('article_images', $image);
            $imageLink = url(Storage::url($path));

            Article::where('id', $yaziID)->first()->update([
                'imageLink' => $imageLink,
            ]);

        }
        Article::where('id', $yaziID)->first()->update([
            'title' => $request->title,
            'desc' => $request->desc
        ]);
        return redirect()->back()->with([
            'yaziUp' => true
        ]);
    }

    public function etkguncelle(Request $request)
    {
        $etkID = $request->activityID;

        if (!Activity::where('id', $etkID)->first()->isActive) {
            return redirect()->back()->with([
                'etkNotActive' => true
            ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $etkImageLink = Activity::where('id', $etkID)->first()->imageLink;
            if (strpos($etkImageLink, "activity_images") != false) {
                $konum = strpos($etkImageLink, "activity_images");
                $curFilePath = substr($etkImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('activity_images', $image);
            $imageLink = url(Storage::url($path));

            Activity::where('id', $etkID)->first()->update([
                'imageLink' => $imageLink,
            ]);
        }
        Activity::where('id', $etkID)->first()->update([
            'title' => $request->title,
            'desc' => $request->desc,
            'date' => $request->date,
            'time' => $request->time
        ]);
        return redirect()->back()->with([
            'etkUp' => true
        ]);

    }

    public function urunguncelle(Request $request)
    {
        $urunID = $request->urunID;

        if (!MenuItem::where('id', $urunID)->first()->isActive) {
            return redirect()->back()->with([
                'urunNotActive' => true
            ]);
        }
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $urunImageLink = MenuItem::where('id', $urunID)->first()->imageLink;
            if (strpos($urunImageLink, "menu_item_images") != false) {
                $konum = strpos($urunImageLink, "menu_item_images");
                $curFilePath = substr($urunImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('menu_item_images', $image);
            $imageLink = url(Storage::url($path));

            MenuItem::where('id', $urunID)->first()->update([
                'imageLink' => $imageLink,
            ]);
        }

        MenuItem::where('id', $urunID)->first()->update($request->except(['_token', 'urunID', 'image']));
        return redirect()->back()->with([
            'urunUp' => true
        ]);
    }

    public function popmagazaguncelle(Request $request)
    {
        $populerMagazaID = $request->populerStoreID;
        $storeID = $request->storeID;
        $isPaid = $request->isPaid;
        $position = $request->position;
        $popMagaza = PopularStore::where('id', $populerMagazaID)->with('store')->first();

        if (LastAddedStore::where('storeID', $storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEnSon' => true
            ]);
        }

        if (EditorChoiceStore::where('storeID', $storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEdt' => true
            ]);
        }

        if ($popMagaza->store->id == $storeID) {
            PopularStore::where('id', $populerMagazaID)->first()->update([
                'isPaid' => $isPaid,
                'position' => $position
            ]);
            Store::where('id', $storeID)->first()->update([
                'tag' => 'Popüler Mekan'
            ]);
        } else {
            PopularStore::where('id', $populerMagazaID)->first()->update([
                'isPaid' => $isPaid,
                'position' => $position,
                'storeID' => $storeID,
                'viewCount' => 0
            ]);
            Store::where('id', $popMagaza->store->id)->first()->update([
                'tag' => null
            ]);
            Store::where('id', $storeID)->first()->update([
                'tag' => 'Popüler Mekan'
            ]);
        }

        return redirect()->back()->with([
            'popMagazaUp' => true
        ]);
    }

    public function popmagazaekle(Request $request)
    {
        if (LastAddedStore::where('storeID', $request->storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEnSon' => true
            ]);
        }

        if (EditorChoiceStore::where('storeID', $request->storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEdt' => true
            ]);
        }

        if (PopularStore::where('storeID', $request->storeID)->where('cityID', $request->cityID)->exists()) {
            return redirect()->back()->with([
                'popMagazaExists' => true
            ]);
        } else {
            PopularStore::create($request->except(['_token']));
            Store::where('id', $request->storeID)->first()->update([
                'tag' => 'Popüler Mekan'
            ]);
            return redirect()->back()->with([
                'popMagazaAdd' => true
            ]);
        }
    }

    public function popmagazasil(Request $request)
    {
        $popMagazaID = $request->id;

        $popMagaza = PopularStore::where('id', $popMagazaID)->with('store')->first();

        Store::where('id', $popMagaza->store->id)->first()->update([
            'tag' => null
        ]);

        PopularStore::where('id', $popMagazaID)->first()->delete();

        return redirect()->back()->with([
            'popMagazaDel' => true
        ]);
    }

    public function sonmagazaguncelle(Request $request)
    {
        $enSonMagazaID = $request->lastAddedStoreID;
        $storeID = $request->storeID;
        $position = $request->position;
        $sonMagaza = LastAddedStore::where('id', $enSonMagazaID)->with('store')->first();

        if (PopularStore::where('storeID', $storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyPop' => true
            ]);
        }

        if (EditorChoiceStore::where('storeID', $storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEdt' => true
            ]);
        }

        if ($sonMagaza->store->id == $storeID) {
            LastAddedStore::where('id', $enSonMagazaID)->first()->update([
                'position' => $position
            ]);
            Store::where('id', $storeID)->first()->update([
                'tag' => 'Yeni Mekan'
            ]);
        } else {
            LastAddedStore::where('id', $enSonMagazaID)->first()->update([
                'position' => $position,
                'storeID' => $storeID,
                'viewCount' => 0
            ]);
            Store::where('id', $sonMagaza->store->id)->first()->update([
                'tag' => null
            ]);
            Store::where('id', $storeID)->first()->update([
                'tag' => 'Yeni Mekan'
            ]);
        }

        return redirect()->back()->with([
            'sonMagazaUp' => true
        ]);
    }

    public function sonmagazaekle(Request $request)
    {

        if (PopularStore::where('storeID', $request->storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyPop' => true
            ]);
        }

        if (EditorChoiceStore::where('storeID', $request->storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEdt' => true
            ]);
        }

        if (LastAddedStore::where('storeID', $request->storeID)->where('cityID', $request->cityID)->exists()) {
            return redirect()->back()->with([
                'sonMagazaExists' => true
            ]);
        } else {
            LastAddedStore::create($request->except(['_token']));
            Store::where('id', $request->storeID)->first()->update([
                'tag' => 'Yeni Mekan'
            ]);
            return redirect()->back()->with([
                'sonMagazaAdd' => true
            ]);
        }
    }

    public function sonmagazasil(Request $request)
    {
        $sonMagazaID = $request->id;

        $sonMagaza = LastAddedStore::where('id', $sonMagazaID)->with('store')->first();

        Store::where('id', $sonMagaza->store->id)->first()->update([
            'tag' => null
        ]);

        LastAddedStore::where('id', $sonMagazaID)->first()->delete();

        return redirect()->back()->with([
            'sonMagazaDel' => true
        ]);
    }

    public function edtmagazaguncelle(Request $request)
    {
        $edtMagazaID = $request->edtStoreID;
        $storeID = $request->storeID;
        $position = $request->position;
        $edtMagaza = EditorChoiceStore::where('id', $edtMagazaID)->with('store')->first();

        if (PopularStore::where('storeID', $storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyPop' => true
            ]);
        }

        if (LastAddedStore::where('storeID', $storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEnSon' => true
            ]);
        }

        if ($edtMagaza->store->id == $storeID) {
            EditorChoiceStore::where('id', $edtMagazaID)->first()->update([
                'position' => $position
            ]);
            Store::where('id', $storeID)->first()->update([
                'tag' => 'Edt. Tercihi Mekan'
            ]);
        } else {
            EditorChoiceStore::where('id', $edtMagazaID)->first()->update([
                'position' => $position,
                'storeID' => $storeID,
                'viewCount' => 0
            ]);
            Store::where('id', $edtMagaza->store->id)->first()->update([
                'tag' => null
            ]);
            Store::where('id', $storeID)->first()->update([
                'tag' => 'Edt. Tercihi Mekan'
            ]);
        }

        return redirect()->back()->with([
            'edtMagazaUp' => true
        ]);
    }

    public function edtmagazaekle(Request $request)
    {

        if (PopularStore::where('storeID', $request->storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyPop' => true
            ]);
        }

        if (LastAddedStore::where('storeID', $request->storeID)->exists()) {
            return redirect()->back()->with([
                'alreadyEnSon' => true
            ]);
        }

        if (EditorChoiceStore::where('storeID', $request->storeID)->where('cityID', $request->cityID)->exists()) {
            return redirect()->back()->with([
                'edtMagazaExists' => true
            ]);
        } else {
            EditorChoiceStore::create($request->except(['_token']));
            Store::where('id', $request->storeID)->first()->update([
                'tag' => 'Edt. Tercihi Mekan'
            ]);
            return redirect()->back()->with([
                'edtMagazaAdd' => true
            ]);
        }
    }

    public function edtmagazasil(Request $request)
    {
        $edtMagazaID = $request->id;

        $edtMagaza = EditorChoiceStore::where('id', $edtMagazaID)->with('store')->first();

        Store::where('id', $edtMagaza->store->id)->first()->update([
            'tag' => null
        ]);

        EditorChoiceStore::where('id', $edtMagazaID)->first()->delete();

        return redirect()->back()->with([
            'edtMagazaDel' => true
        ]);
    }

    public function klokasyonguncelle(Request $request)
    {
        $kLokasyonID = $request->kLokasyonID;

        KafeyinLocation::where('id', $kLokasyonID)->first()->update($request->except(['_token', 'kLokasyonID']));

        return redirect()->back()->with([
            'kLokUp' => true
        ]);
    }

    public function klokasyonekle(Request $request)
    {
        KafeyinLocation::create($request->except(['_token',]));

        return redirect()->back()->with([
            'kLokAdd' => true
        ]);
    }

    public function klokasyonsil(Request $request)
    {
        $lokID = $request->id;

        KafeyinLocation::where('id', $lokID)->delete();
        UserLocationChange::where('kafeyinLocationID', $lokID)->delete();

        return redirect()->back()->with([
            'kLokDel' => true
        ]);
    }

    public function duyuruguncelle(Request $request)
    {
        $announcementID = $request->announcementID;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $duyuruImageLink = Announcement::where('id', $announcementID)->first()->imageLink;
            if (strpos($duyuruImageLink, "announcement_images") != false) {
                $konum = strpos($duyuruImageLink, "announcement_images");
                $curFilePath = substr($duyuruImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('announcement_images', $image);
            $imageLink = url(Storage::url($path));

            Announcement::where('id', $announcementID)->first()->update([
                'imageLink' => $imageLink,
            ]);

        }

        Announcement::where('id', $announcementID)->first()->update([
            'title' => $request->title,
            'desc' => $request->desc,
            'position' => $request->position,
        ]);

        return redirect()->back()->with([
            'duyUp' => true
        ]);
    }

    public function duyuruekle(Request $request)
    {
        $cityID = $request->cityID;
        $image = $request->file('image');

        $path = Storage::disk('public')->put('announcement_images', $image);
        $imageLink = url(Storage::url($path));

        $data = [
            'cityID' => $cityID,
            'brandID' => $request->brandID,
            'title' => $request->title,
            'desc' => $request->desc,
            'position' => $request->position,
            'imageLink' => $imageLink
        ];

        Announcement::create($data);

        $brandID = $request->brandID;
        $data = [
            "brandID"=>$brandID,
            'desc'=>"'".$request->title."'"." başlıklı duyurunuz yayınlandı.",
        ];
        BrandNotification::create($data);

        return redirect()->back()->with([
            'duyAdd' => true
        ]);
    }

    public function duysil(Request $request)
    {
        $announcementID = $request->id;

        Announcement::where('id', $announcementID)->first()->delete();

        return redirect()->back()->with([
            'duyDel' => true
        ]);
    }

    public function anketlergenel(Request $request)
    {
        $sub = $request->subCategory;
        switch ($sub) {
            case 'kullanici':
                $cities = City::all();
                $kAnkets = UserSurvey::with('answers')
                    ->with('answers.user')
                    ->get();
                return view('admin.kullanicianketler')
                    ->with([
                        'cities' => $cities,
                        'ankets' => $kAnkets
                    ]);
                break;
            case 'magaza':
                $cities = City::all();
                $mAnkets = StoreSurvey::with('answers')
                    ->with('answers.brand')
                    ->get();
                return view('admin.magazaanketler')
                    ->with([
                        'cities' => $cities,
                        'ankets' => $mAnkets
                    ]);
                break;
                break;
            default:
                return redirect('/adminpanel/anasayfa');
        }
    }

    public function kanketguncelle(Request $request)
    {
        $anketID = $request->surveyID;
        UserSurvey::where('id', $anketID)->first()->update($request->except(['_token', 'surveyID']));

        return redirect()->back()->with([
            'surUp' => true
        ]);
    }

    public function manketguncelle(Request $request)
    {
        $anketID = $request->surveyID;
        StoreSurvey::where('id', $anketID)->first()->update($request->except(['_token', 'surveyID']));

        return redirect()->back()->with([
            'surUp' => true
        ]);
    }

    public function kanketpasif(Request $request)
    {
        $surveyID = $request->id;

        UserSurvey::where('id', $surveyID)->first()->update([
            'isActive' => false
        ]);

        return redirect()->back()->with([
            'surPasif' => true
        ]);
    }

    public function manketpasif(Request $request)
    {
        $surveyID = $request->id;

        StoreSurvey::where('id', $surveyID)->first()->update([
            'isActive' => false
        ]);

        return redirect()->back()->with([
            'surPasif' => true
        ]);
    }

    public function kanketsil(Request $request)
    {
        $surveyID = $request->id;
        UserSurvey::where('id', $surveyID)->first()->delete();
        UserSurveyAnswer::where('surveyID', $surveyID)->delete();

        return redirect()->back()->with([
            'surDel' => true
        ]);
    }

    public function manketsil(Request $request)
    {
        $surveyID = $request->id;
        StoreSurvey::where('id', $surveyID)->first()->delete();
        StoreSurveyAnswer::where('surveyID', $surveyID)->delete();

        return redirect()->back()->with([
            'surDel' => true
        ]);
    }

    public function kanketekle(Request $request)
    {
        UserSurvey::create($request->except(['_token',]));

        return redirect()->back()->with([
            'surAdd' => true
        ]);
    }

    public function manketekle(Request $request)
    {
        StoreSurvey::create($request->except(['_token',]));

        return redirect()->back()->with([
            'surAdd' => true
        ]);
    }

    public function digergenel(Request $request)
    {
        $sub = $request->subCategory;
        switch ($sub) {
            case 'yorumsikayetleri':
                $reports = StoreCommentReport::where('id', '>', '0')
                    ->with('user')
                    ->with('comment')
                    ->with('comment.commenter')
                    ->with('comment.store')
                    ->with('comment.store.city')
                    ->with('comment.store.location')
                    ->with('comment.store.brand')
                    ->with('comment.photos')
                    ->with('comment.likes')
                    ->orderByDesc('created_at')
                    ->paginate(6);
                return view('admin.yorumsikayetleri')->with([
                    'sikayets' => $reports
                ]);
                break;
            case 'magazaonerileri':
                $suggests = StoreSuggestion::where('id', '>', 0)
                    ->with('user')
                    ->orderByDesc('created_at')
                    ->paginate(12);
                return view('admin.magazaonerileri')->with([
                    'oneris' => $suggests
                ]);
                break;
            case 'dileksikayet':
                $suggestions = KafeyinSuggestion::where('id', '>', 0)
                    ->with('user')
                    ->orderByDesc('created_at')
                    ->paginate(12);
                return view('admin.dileksikayet')->with([
                    'dileks' => $suggestions
                ]);
                break;
            default:
                return redirect('/adminpanel/anasayfa');
        }
    }

    public function tskmail1(Request $request)
    {
        $sikayetID = $request->id;
        $sikayet = StoreCommentReport::where('id', $sikayetID)
            ->with('user')
            ->first();

        $details = [
            'subject' => "Teşekkürler!",
            'user' => $sikayet->user,
            'bodyText' => 'Kafeyin platformuna gösterdiğiniz ilgi için teşekkür ederiz. Şikayetiniz ile ilgili incelemelerimiz sonrası gerekli işlemler yapılacaktır.'
        ];

        User::find($sikayet->user->id)->notify(new KafeyinBaseEmail($details));

        return redirect()->back()->with([
            'emailSent1' => true
        ]);

    }

    public function yorumsil2(Request $request)
    {
        $sikayetID = $request->id;
        $sikayet = StoreCommentReport::where('id', $sikayetID)
            ->with('comment')
            ->with('comment.commenter')
            ->with('comment.store')
            ->first();

        $yorumID = $sikayet->comment->id;
        $commentPhotos = StoreCommentPhoto::where('commentID', $yorumID)->get();
        foreach ($commentPhotos as $commentPhoto) {
            if (strpos($commentPhoto->imageLink, "comment_images") != false) {
                $konum = strpos($commentPhoto->imageLink, "comment_images");
                $curFilePath = substr($commentPhoto->imageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
        }
        StoreComment::where('id', $yorumID)->delete();
        StoreCommentLike::where('storeCommentID', $yorumID)->delete();
        StoreCommentPhoto::where('commentID', $yorumID)->delete();

        $details = [
            'subject' => "Üzgünüz!",
            'user' => $sikayet->comment->commenter,
            'bodyText' => 'Üzülerek bildiriyoruz ki ' . $sikayet->comment->store->name . " isimli mekan için yaptığınız yorumunuzu, Kullanım Şartları'mızı ihlal etmesi sebebiyle kaldırdık.",
            'bodyText2' => "Kahve aşkına diyerek çıktığımız bu yolda, kullanıcılarımızın kahve kültürüne bulundukları katkılar ile çok daha keyifli deneyimlere hep beraber ilerleyeceğiz.",
        ];

        User::find($sikayet->comment->commenter->id)->notify(new KafeyinBaseEmail2($details));

        return redirect()->back()->with([
            'yorumSil2' => true
        ]);
    }

    public function sikayetsil(Request $request)
    {
        $sikayetID = $request->id;
        StoreCommentReport::where('id', $sikayetID)->delete();

        return redirect()->back()->with([
            'sikayetDel' => true
        ]);
    }

    public function oneriokundu(Request $request)
    {
        $oneriID = $request->id;
        $oneri = StoreSuggestion::where('id', $oneriID)->first();

        $details = [
            'subject' => "Süpersiniz!",
            'user' => $oneri->user,
            'bodyText' => $oneri->storeName . " isimli mekan öneriniz için çok teşekkür ediyoruz.",
            'bodyText2' => "Ekibimiz, önerinizi inceleyip gerekli işlemleri yapmak için çoktan işe koyuldular bile.",
        ];

        User::find($oneri->user->id)->notify(new KafeyinBaseEmail2($details));

        StoreSuggestion::where('id', $oneriID)->first()->update([
            'isRead' => true
        ]);

        return redirect()->back()->with([
            'oneriRead' => true
        ]);
    }

    public function onerisil(Request $request)
    {
        $oneriID = $request->id;

        StoreSuggestion::where('id', $oneriID)->first()->delete();

        return redirect()->back()->with([
            'oneriDel' => true
        ]);
    }

    public function dlkokundu(Request $request)
    {
        $oneriID = $request->id;
        $oneri = KafeyinSuggestion::where('id', $oneriID)->first();

        $details = [
            'subject' => "Çok teşekkürler!",
            'user' => $oneri->user,
            'bodyText' => "Kafeyin'e gösterdiğiniz ilgi için çok teşekkür ediyoruz. Ekibimiz, önerinizi inceleyip gerekli işlemleri yapmak için kollarını sıvadı.",
            'bodyText2' => "Kahveseverlerin değerli fikirleri ile Kafeyin platformunu geliştirmeye devam edeceğiz. Bu sebeple, değerli fikirlerinizi ve önerilerinizi her zaman bekliyoruz.",
        ];

        User::find($oneri->user->id)->notify(new KafeyinBaseEmail2($details));

        KafeyinSuggestion::where('id', $oneriID)->first()->update([
            'isRead' => true
        ]);

        return redirect()->back()->with([
            'oneriRead' => true
        ]);
    }

    public function dlksil(Request $request)
    {
        $oneriID = $request->id;

        KafeyinSuggestion::where('id', $oneriID)->first()->delete();

        return redirect()->back()->with([
            'oneriDel' => true
        ]);
    }

    public function markalar(Request $request)
    {
        $brands = Brand::withCount('stores')
            ->with('manager')
            ->get();

        return view('admin.markalar')
            ->with([
                'brands' => $brands
            ]);
    }

    public function markagetir(Request $request)
    {
        $brandID = $request->brandID;

        $brand = Brand::where('id', $brandID)
            ->withCount('stores')
            ->with('stores')
            ->with('manager')
            ->with('manager.marka_yoneticisi_bilgileri')
            ->with('stores.city')
            ->with('stores.location')
            ->with('stores.yonetici')
            ->first();


        $brandManagers = User::where('userType', 'store')
            ->where('isBrandManager', true)
            ->whereDoesntHave('brand')
            ->orWhereHas('brand', function ($query) use ($brandID) {
                return $query->where('id', $brandID);
            })
            ->get();

        return view('admin.markagetir')->with([
            'brand' => $brand,
            'brandmanagers' => $brandManagers
        ]);
    }

    public function markaguncelle(Request $request)
    {
        $brandID = $request->brandID;
        Brand::where('id', $brandID)->first()->update($request->except(['_token', 'brandID']));
        //update on loy cards with new needstampcount
        return redirect()->back()->with([
            'branUp' => true
        ]);
    }

    public function markayoneticiguncelle(Request $request)
    {
        $brandID = $request->brandID;
        $userID = $request->userID;

        if ($userID == "0") {
            if (User::where('userType', 'store')->where('isBrandManager', true)->where('brandID', $brandID)->exists()) {
                //yöneticisi vardı ama sahipsiz hale geldi
                User::where('userType', 'store')->where('isBrandManager', true)->where('brandID', $brandID)->first()->update([
                    'isBrandManager' => true,
                    'brandID' => null
                ]);
            } else {
                //yöneticisi yoktu ve yöneticisiz hale geldi
                if (User::where('userType', 'store')->where('isBrandManager', true)->where('brandID', $brandID)->exists()) {
                    User::where('userType', 'store')->where('isBrandManager', true)->where('brandID', $brandID)->first()->update([
                        'isBrandManager' => false,
                        'brandID' => null
                    ]);
                }
            }
        } else {
            if (User::where('userType', 'store')->where('isBrandManager', true)->where('brandID', $brandID)->exists()) {
                //yöneticisi vardı ama değişti
                User::where('userType', 'store')->where('isBrandManager', true)->where('brandID', $brandID)->first()->update([
                    'isBrandManager' => true,
                    'brandID' => null
                ]);
                User::where('id', $request->userID)->first()->update([
                    'isBrandManager' => true,
                    'brandID' => $brandID
                ]);
            } else {
                //yöneticisi yoktu ama sahipli hale geldi
                User::where('id', $request->userID)->first()->update([
                    'isBrandManager' => true,
                    'brandID' => $brandID
                ]);
            }
        }
        return redirect()->back()->with([
            'stBrManUp' => true
        ]);
    }

    public function mrkyntcekstblgguncelle(Request $request)
    {
        BrandManagerExtraInfo::where('userID', $request->userID)->first()->update($request->except(['_token', 'userID']));

        return redirect()->back()->with([
            'brExUp' => true
        ]);
    }

    public function markalogoguncelle(Request $request)
    {
        if ($request->hasFile('image')) {

            $brandID = $request->brandID;
            $image = $request->file('image');
            $curLogoLink = Brand::where('id', $brandID)->first()->logo;

            if (strpos($curLogoLink, "brand_logos") != false) {
                $konum = strpos($curLogoLink, "brand_logos");
                $curFilePath = substr($curLogoLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('brand_logos/' . $brandID, $image);
            $imageLink = url(Storage::url($path));

            Brand::where('id', $brandID)->first()->update([
                'logo' => $imageLink
            ]);

            return redirect()->back()->with([
                'logoUp' => true
            ]);
        } else {
            return redirect()->back()->with([
                'fileErr' => true
            ]);
        }
    }

    public function kullanicilargenel(Request $request)
    {
        $sub = $request->subCategory;
        switch ($sub) {
            case "normal":
                $users = User::where('userType', 'user')
                    ->withCount('comments')
                    ->withCount('photos')
                    ->with('favorite_articles')
                    ->with('favorite_activities')
                    ->with('favorite_stores')
                    ->withCount('followings')
                    ->withCount('followers')
                    ->orderByDesc('created_at')
                    ->get();
                return view('admin.normalkullanicilar')
                    ->with([
                        'users' => $users
                    ]);
                break;
            case 'magaza':
                $users2 = User::where('userType', 'store')
                    ->with('magaza')
                    ->get();

                return view('admin.magazakullanicilar')
                    ->with([
                        'users' => $users2
                    ]);
                break;
            case 'admin':
                if (Auth::user()->email == "admin@kafeyinapp.com") {
                    $users3 = User::where('userType', 'admin')->get();
                    return view('admin.adminkullanicilar')->with([
                        'users' => $users3
                    ]);
                } else {
                    return redirect('/adminpanel/anasayfa');
                }

                break;
            default:
                return redirect('/adminpanel/anasayfa');
        }
    }

    public function normalkullanicigetir(Request $request)
    {
        $userID = $request->userID;
        if (User::where('id', $userID)->first()->userType != 'user') {
            return redirect('/adminpanel/kullanicilar/normal');
        }

        $user = User::where('id', $userID)
            ->with('comments', function ($query) {
                return $query->orderByDesc('created_at');
            })
            ->with('comments.photos')
            ->with('photos')
            ->with('favorite_articles')
            ->with('favorite_articles.article')
            ->with('favorite_activities')
            ->with('favorite_activities.activity')
            ->with('favorite_stores')
            ->with('favorite_stores.store')
            ->with('favorite_stores.store.city')
            ->with('favorite_stores.store.location')
            ->with('favorite_stores.store.brand')
            ->with('followings')
            ->with('followings.following_user')
            ->with('followers')
            ->with('followers.follower_user')
            ->with('makina_searches')
            ->with('user_logs')
            ->with('loyalty_cards')
            ->with('device_info')
            ->first();

        return view('admin.normalkullanicigetir')->with([
            'user' => $user
        ]);

    }

    public function kullaniciguncelle(Request $request)
    {
        $userID = $request->userID;
        if ($request->gsmNumber && User::where('id', $userID)->first()->gsmNumber != $request->gsmNumber) {
            if (User::where('gsmNumber', $request->gsmNumber)->exists()) {
                return redirect()->back()->with([
                    'gsmExists' => true
                ]);
            }
        }

        if ($request->identityNumber && User::where('id', $userID)->first()->identityNumber != $request->identityNumber) {
            if (User::where('identityNumber', $request->identityNumber)->exists()) {
                return redirect()->back()->with([
                    'tcknExists' => true
                ]);
            }
        }

        User::where('id', $userID)->first()->update($request->except(['_token', 'userID']));
        return redirect()->back()->with([
            'userUp' => true
        ]);

    }

    public function kullaniciavatarguncelle(Request $request)
    {
        if ($request->hasFile('image')) {

            $userID = $request->userID;
            $image = $request->file('image');
            $curAvatarLink = User::where('id', $userID)->first()->avatar;

            if (strpos($curAvatarLink, "user_avatars") != false) {
                $konum = strpos($curAvatarLink, "user_avatars");
                $curFilePath = substr($curAvatarLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('user_avatars/' . $userID, $image);
            $imageLink = url(Storage::url($path));

            User::where('id', $userID)->first()->update([
                'avatar' => $imageLink
            ]);

            return redirect()->back()->with([
                'avatarUp' => true
            ]);
        } else {
            return redirect()->back()->with([
                'fileErr' => true
            ]);
        }
    }

    public function normalkullanicialtkategori(Request $request)
    {
        $userID = $request->userID;
        $sub = $request->subCategory;
        if (User::where('id', $userID)->first()->userType != 'user') {
            return redirect('/adminpanel/kullanicilar/normal');
        }

        $user = User::where('id', $userID)->first();

        switch ($sub) {
            case 'yorumlar':
                $yorums = StoreComment::where('userID', $userID)
                    ->with('photos')
                    ->withCount('likes')
                    ->with('store')
                    ->with('store.brand')
                    ->with('store.city')
                    ->with('store.location')
                    ->orderByDesc('created_at')
                    ->paginate(12);

                return view('admin.kullaniciyorumlar')
                    ->with([
                        'yorums' => $yorums,
                        'user' => $user
                    ]);
                break;
            case 'fotograflar':
                $photos = StoreCommentPhoto::where('userID', $userID)
                    ->orderByDesc('created_at')
                    ->paginate(50);

                return view('admin.kullanicifotograflar')->with([
                    'photos' => $photos,
                    'user' => $user
                ]);
                break;
            case 'favoriler':
                $favArticles = FavoriteArticle::where('userID', $userID)
                    ->with('article')
                    ->with('article.store')
                    ->get();

                $favActivities = FavoriteActivity::where('userID', $userID)
                    ->with('activity')
                    ->with('activity.store')
                    ->get();

                $favStores = FavoriteStore::where('userID', $userID)
                    ->with('store')
                    ->get();
                return view('admin.kullanicifavoriler')
                    ->with([
                        'user' => $user,
                        'favArticles' => $favArticles,
                        'favActivities' => $favActivities,
                        'favStores' => $favStores,
                    ]);
                break;
            case 'takipler':
                $followers = Follow::where('followingID', $userID)
                    ->with('follower_user')
                    ->get();

                $followings = Follow::where('followerID', $userID)
                    ->with('following_user')
                    ->get();
                return view('admin.kullanicitakipler')
                    ->with([
                        'user' => $user,
                        'followers' => $followers,
                        'followings' => $followings,
                    ]);
                break;
            case 'sadakatkartlari':

                $activeCards = LoyaltyCard::where('userID', $userID)
                    ->where('status', 'active')
                    ->where('isDeleted', false)
                    ->with('brand')
                    ->get();

                $availableCards = LoyaltyCard::where('userID', $userID)
                    ->where('status', 'available')
                    ->where('isDeleted', false)
                    ->with('brand')
                    ->get();

                $usedCards = LoyaltyCard::where('userID', $userID)
                    ->where('status', 'used')
                    ->where('isDeleted', false)
                    ->with('brand')
                    ->get();

                $deletedCards = LoyaltyCard::where('userID', $userID)
                    ->where('isDeleted', true)
                    ->with('brand')
                    ->get();

                return view('admin.kullanicikartlar')
                    ->with([
                        'user' => $user,
                        'activeCards' => $activeCards,
                        'availableCards' => $availableCards,
                        'usedCards' => $usedCards,
                        'deletedCards' => $deletedCards,
                    ]);

                break;
            default:
                return redirect('/adminpanel/kullanicilar/normal/' . $userID);
                break;
        }
    }

    public function favartsil(Request $request)
    {
        $favArtID = $request->id;

        FavoriteArticle::where('id', $favArtID)->first()->delete();
        return redirect()->back()->with([
            'favArtDel' => true
        ]);
    }

    public function favactsil(Request $request)
    {
        $favActID = $request->id;

        FavoriteActivity::where('id', $favActID)->first()->delete();
        return redirect()->back()->with([
            'favActDel' => true
        ]);
    }

    public function favstosil(Request $request)
    {
        $favStoID = $request->id;

        FavoriteStore::where('id', $favStoID)->first()->delete();
        return redirect()->back()->with([
            'favStoDel' => true
        ]);
    }

    public function takipsil(Request $request)
    {
        $followID = $request->id;
        Follow::where('id', $followID)->first()->delete();

        return redirect()->back()->with([
            'followDel' => true
        ]);
    }

    public function kartsil(Request $request)
    {
        $cardID = $request->id;
        LoyaltyCard::where('id', $cardID)->first()->update([
            'isDeleted' => true
        ]);

        return redirect()->back()->with([
            'cardDel' => true
        ]);
    }

    public function kkullanicisil(Request $request)
    {
        $authUser = Auth::user();
        $deletingUser = User::where('id', $request->id)->first();
        $plainPass = $request->pass;
        if (Hash::check($plainPass, User::where('id', $authUser->id)->first()->password)) {
            ActivityTicket::where('userID', $deletingUser->id)->delete();
            FavoriteStore::where('userID', $deletingUser->id)->delete();
            FavoriteActivity::where('userID', $deletingUser->id)->delete();
            FavoriteArticle::where('userID', $deletingUser->id)->delete();
            Follow::where('followerID', $deletingUser->id)->delete();
            Follow::where('followingID', $deletingUser->id)->delete();
            KafeyinSuggestion::where('userID', $deletingUser->id)->delete();
            KafeyinUserNotification::where('receiverID', $deletingUser->id)->delete();
            KafeyinUserNotification::where('senderID', $deletingUser->id)->delete();
            LastSearchedStore::where('userID', $deletingUser->id)->delete();
            LoyaltyCard::where('userID', $deletingUser->id)->delete();
            LoyaltyCardApproval::where('userID', $deletingUser->id)->delete();
            MakinaSearch::where('userID', $deletingUser->id)->delete();
            ProfileViewLog::where('viewingUserID', $deletingUser->id)->delete();
            ProfileViewLog::where('userID', $deletingUser->id)->delete();
            $comments = StoreComment::where('userID', $deletingUser->id)->get();
            foreach ($comments as $comment) {
                $yorumID = $comment->id;
                $commentPhotos = StoreCommentPhoto::where('commentID', $yorumID)->get();
                foreach ($commentPhotos as $commentPhoto) {
                    if (strpos($commentPhoto->imageLink, "comment_images") != false) {
                        $konum = strpos($commentPhoto->imageLink, "comment_images");
                        $curFilePath = substr($commentPhoto->imageLink, $konum);
                        Storage::disk('public')->delete($curFilePath);
                    }
                }
                StoreComment::where('id', $yorumID)->delete();
                StoreCommentLike::where('storeCommentID', $yorumID)->delete();
                StoreCommentPhoto::where('commentID', $yorumID)->delete();
            }
            StoreCommentLike::where('userID', $deletingUser->id)->delete();
            StoreCommentReport::where('userID', $deletingUser->id)->delete();
            StoreSuggestion::where('userID', $deletingUser->id)->delete();
            UsersBadge::where('userID', $deletingUser->id)->delete();
            UserDeviceInfo::where('userID', $deletingUser->id)->delete();
            UserLocationChange::where('userID', $deletingUser->id)->delete();
            UserLog::where('userID', $deletingUser->id)->delete();
            UserSurveyAnswer::where('userID', $deletingUser->id)->delete();

            $userID = $deletingUser->id;
            $curAvatarLink = User::where('id', $userID)->first()->avatar;

            if (strpos($curAvatarLink, "user_avatars") != false) {
                $konum = strpos($curAvatarLink, "user_avatars");
                $curFilePath = substr($curAvatarLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
            User::where('id', $deletingUser->id)->first()->delete();

            return redirect('/adminpanel/kullanicilar/normal')->with(['userDel' => true]);
        } else {
            return redirect()->back()->with([
                'hashErr' => true
            ]);
        }
    }

    public function magazakullanicigetir(Request $request)
    {
        $userID = $request->userID;
        if (User::where('id', $userID)->first()->userType != "store") {
            return redirect('/adminpanel/kullanicilar/magaza');
        } else {
            $user = User::where('id', $userID)
                ->with('magaza')
                ->with('magaza.brand')
                ->with('magaza.city')
                ->with('magaza.location')
                ->with('magaza_logs')
                ->with('magaza_logs.magaza')
                ->with('marka_yoneticisi_bilgileri')
                ->first();

            $brands = Brand::with('manager')->get();


            return view('admin.magazakullanicigetir')->with([
                'user' => $user,
                'brands' => $brands
            ]);
        }
    }

    public function magazakullaniciguncelle(Request $request)
    {
        $userID = $request->userID;
        $ibm = $request->isBrandManager;
        if ($ibm) {
            if (!$request->brandID) {
                return redirect()->back()->with([
                    'mustChooseBrand' => true
                ]);
            }

            if (User::where('id', '!=', $userID)->where('brandID', $request->brandID)->exists()) {
                return redirect()->back()->with([
                    'brandHasManager' => true
                ]);
            }

            if (User::where('id', $userID)->where('brandID', $request->brandID)->exists()) {
                return redirect()->back()->with([
                    'alreadyOwnBrand' => true
                ]);
            }

            User::where('id', $userID)->first()->update([
                'isBrandManager' => true,
                'brandID' => $request->brandID
            ]);

            return redirect()->back()->with([
                'usBrUp' => true
            ]);

        } else {
            User::where('id', $userID)->first()->update([
                'isBrandManager' => false,
                'brandID' => null
            ]);
            return redirect()->back()->with([
                'usBrUp' => true
            ]);
        }

    }

    public function markayoneticisibilgiguncelle(Request $request)
    {
        $userID = $request->userID;

        BrandManagerExtraInfo::where('userID', $userID)->first()->update($request->except(['_token', 'userID']));
        return redirect()->back()->with([
            'brUsUp' => true
        ]);
    }

    public function adminkullanicigetir(Request $request)
    {
        $userID = $request->userID;
        if (Auth::user()->email == "admin@kafeyinapp.com") {
            if (User::where('id', $userID)->first()->userType != "admin") {
                return redirect('/adminpanel/kullanicilar/admin');
            } else {
                $user = User::where('id', $userID)
                    ->first();

                $brands = Brand::with('manager')->get();


                return view('admin.adminkullanicigetir')->with([
                    'user' => $user,
                    'brands' => $brands
                ]);
            }
        } else {
            return redirect('/adminpanel/anasayfa');
        }

    }

    public function akullanicisil(Request $request)
    {
        $authUser = Auth::user();
        $deletingUser = User::where('id', $request->id)->first();
        $plainPass = $request->pass;
        if (Hash::check($plainPass, User::where('id', $authUser->id)->first()->password)) {

            $userID = $deletingUser->id;
            $curAvatarLink = User::where('id', $userID)->first()->avatar;

            if (strpos($curAvatarLink, "user_avatars") != false) {
                $konum = strpos($curAvatarLink, "user_avatars");
                $curFilePath = substr($curAvatarLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
            User::where('id', $deletingUser->id)->first()->delete();

            return redirect('/adminpanel/kullanicilar/admin')->with(['userDel' => true]);
        } else {
            return redirect()->back()->with([
                'hashErr' => true
            ]);
        }
    }

    public function epostagonder()
    {
        $users = User::where('userType', 'user')->get();
        $stores = Store::where('id', '>', 0)->with('yonetici')->get();
        $cities = City::where('id', '>', 0)->get();

        return vieW('admin.epostagonder')
            ->with([
                'users' => $users,
                'stores' => $stores,
                'cities' => $cities,
            ]);
    }

    public function tekilkullaniciyagonder(Request $request)
    {
        $details = [
            'subject' => $request->subject,
            'user' => User::find($request->userID),
            'bodyText' => $request->para1,
            'bodyText2' => $request->para2,
        ];

        User::find($request->userID)->notify(new KafeyinBaseEmail2($details));

        return redirect()->back()->with([
            'emailSent' => true
        ]);
    }

    public function coklukullaniciyagonder(Request $request)
    {
        $userIDs = $request->userID;

        foreach ($userIDs as $userID) {
            $details = [
                'subject' => $request->subject,
                'user' => User::find($userID),
                'bodyText' => $request->para1,
                'bodyText2' => $request->para2,
            ];

            User::find($userID)->notify(new KafeyinBaseEmail2($details));
        }
        return redirect()->back()->with([
            'emailSent' => true
        ]);
    }

    public function sehregorekullaniciyagonder(Request $request)
    {
        $city = City::where('id', $request->cityID)->first();
        $cityUsers = User::where('city', $city->name)->where('userType', 'user')->get();

        foreach ($cityUsers as $cityUser) {
            $details = [
                'subject' => $request->subject,
                'user' => User::find($cityUser->id),
                'bodyText' => $request->para1,
                'bodyText2' => $request->para2,
            ];

            User::find($cityUser->id)->notify(new KafeyinBaseEmail2($details));
        }
        return redirect()->back()->with([
            'emailSent' => true
        ]);
    }

    public function sehregoremagazakullaniciyagonder(Request $request)
    {
        $cityID = $request->cityID;
        $users = User::where('userType', 'store')
            ->whereHas('magaza', function ($query) use ($cityID) {
                return $query->where('cityID', $cityID);
            })
            ->get();

        foreach ($users as $cityUser) {
            $details = [
                'subject' => $request->subject,
                'user' => User::find($cityUser->id),
                'bodyText' => $request->para1,
                'bodyText2' => $request->para2,
            ];

            User::find($cityUser->id)->notify(new KafeyinBaseEmail2($details));
        }
        return redirect()->back()->with([
            'emailSent' => true
        ]);
    }

    public function basvurulargenel(Request $request)
    {
        $sub = $request->subCategory;
        switch ($sub) {
            case "duyuru":
                $applications = AnnouncementApplication::with('brand')
                    ->with('brand.manager')
                    ->get();

                return view('admin.duyurubasvurulari')->with([
                    'applications' => $applications
                ]);
                break;
            case "yonetici":
                $applications2 = OwnershipApplication::with('brand')
                    ->with('ref')
                    ->get();
                return view('admin.yoneticibasvurulari')->with([
                    'applications' => $applications2
                ]);
                break;
            default:
                return redirect('/adminpanel/anasayfa');
                break;
        }
    }

    public function basvuruguncellemeiste(Request $request)
    {
        $applicationID = $request->duyuruBasID;
        $reason = $request->reason;

        AnnouncementApplication::where('id', $applicationID)->first()->update([
            'status' => 'need_update',
            'adminMessage' => $reason
        ]);

        $brandID = AnnouncementApplication::where('id',$applicationID)->first()->brandID;
        $addition = KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value;
        $data = [
            "brandID"=>$brandID,
            'desc'=>"Lütfen DYRBSV".($applicationID+$addition)." ID numaralı başvurunuzu güncelleyiniz.",
        ];
        BrandNotification::create($data);

        return redirect()->back()->with([
            'applUp' => true
        ]);

    }

    public function basvurureddet(Request $request)
    {
        $applicationID = $request->duyuruBasID;
        $reason = $request->reason;

        AnnouncementApplication::where('id', $applicationID)->first()->update([
            'status' => 'rejected',
            'adminMessage' => $reason
        ]);

        $brandID = AnnouncementApplication::where('id',$applicationID)->first()->brandID;
        $addition = KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value;
        $data = [
            "brandID"=>$brandID,
            'desc'=>"DYRBSV".($applicationID+$addition)." ID numaralı başvurunuz reddedilmiştir.",
        ];
        BrandNotification::create($data);

        return redirect()->back()->with([
            'applRejected' => true
        ]);
    }

    public function dbasvurusil(Request $request)
    {
        $basID = $request->id;
        $appl = AnnouncementApplication::where('id', $basID)->first();
        if (strpos($appl->imageLink, "announcement_application_images") != false) {
            $konum = strpos($appl->imageLink, "announcement_application_images");
            $curFilePath = substr($appl->imageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        AnnouncementApplication::where('id', $basID)->first()->delete();
        return redirect()->back()->with([
            'dBasDel' => true
        ]);
    }


    public function basvuruonayla(Request $request)
    {
        $basID = $request->duyuruBasID;
        $mes = $request->adminMessage;
        AnnouncementApplication::where('id', $basID)->first()->update([
            'status' => 'approved',
            'adminMessage'=>$mes
        ]);
        $brandID = AnnouncementApplication::where('id',$basID)->first()->brandID;
        $addition = KafeyinStringSetting::where('code','announcementApplicationIDAddition')->first()->value;
        $data = [
            "brandID"=>$brandID,
            'desc'=>"DYRBSV".($basID+$addition)." ID numaralı başvurunuz onaylanmıştır.",
        ];
        BrandNotification::create($data);
        return redirect()->back()->with([
            'dBasApproved' => true
        ]);
    }

    public function yasbvurusil1(Request $request)
    {
        $applID = $request->id;
        $obj1 = OwnershipApplication::where('id', $applID)->first();
        OwnershipApplicationReferral::where('id', $obj1->referralID)->first()->update([
            'isUsed' => false
        ]);
        OwnershipApplication::where('id', $applID)->first()->delete();

        return redirect()->back()->with([
            'yBasDel1' => true
        ]);

    }

    public function yasbvurusil2(Request $request)
    {
        $applID = $request->id;
        $obj1 = OwnershipApplication::where('id', $applID)->first();
        OwnershipApplicationReferral::where('id', $obj1->referralID)->first()->delete();
        OwnershipApplication::where('id', $applID)->first()->delete();

        return redirect()->back()->with([
            'yBasDel2' => true
        ]);

    }

    public function hesabim()
    {
        $aUser = Auth::user();
        return view('admin.hesabim')
            ->with([
                'user' => $aUser
            ]);
    }

    public function sifredegistir(Request $request)
    {
        $aUser = Auth::user();
        if (Hash::check($request->pass1, User::where('id', $aUser->id)->first()->password)) {
            if ($request->pass2 != $request->pass3) {
                return redirect()->back()->with([
                    'notSamePass' => true
                ]);
            } else {
                User::where('id', $aUser->id)->first()->update([
                    'password' => Hash::make($request->pass2)
                ]);
                Auth::logout();
                return redirect('/login')->with([
                    'passUp' => true
                ]);
            }
        } else {
            return redirect()->back()->with([
                'hashErr' => true
            ]);
        }

    }

    public function markaekle(Request $request)
    {
        $data = [
            'name'=>$request->name,
            'needStampCount'=>$request->needStampCount,
            'isEnabledLoyaltyCard'=>$request->isEnabledLoyaltyCard,
            'adminNote'=>$request->adminNote,
            'logo'=>$request->name
        ];

        $created = Brand::create($data);

        $image = $request->file('image');

        $path = Storage::disk('public')->put('brand_logos/' . $created->id, $image);
        $imageLink = url(Storage::url($path));

        Brand::where('id', $created->id)->first()->update([
            'logo' => $imageLink
        ]);

        return redirect()->back()->with([
            'brAdd'=>true
        ]);
    }

    public function magazaekle(Request $request)
    {
        $cover = $request->file('image2');

        $request->request->add(['coverImageLink'=>'1.png']);
        $created = Store::create($request->except(['_token','image2']));

        $path = Storage::disk('public')->put('cover_photos/' . $created->id, $cover);
        $imageLink = url(Storage::url($path));

        Store::where('id', $created->id)->first()->update([
            'coverImageLink' => $imageLink
        ]);

        return redirect()->back()->with([
            'stAdd'=>true
        ]);
    }

    public function adminkullaniciekle(Request $request)
    {
        if(User::where('email',$request->email)->exists()){
            return redirect()->back()->with([
                'emailExists'=>true
            ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'userType' => $request->userType,
                'password' => Hash::make("Kafeyin88!"),
            ]);

            event(new Registered($user));
            return redirect()->back()->with([
                'userAdd'=>true
            ]);
        }
    }

    public function magazakullaniciekle(Request $request)
    {
        if(User::where('email',$request->email)->exists()){
            return redirect()->back()->with([
                'emailExists'=>true
            ]);
        }else{
            $pass = Str::random(12);
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'userType' => $request->userType,
                'password' => Hash::make($request->password),
                'isBrandManager'=>$request->isBrandManager
            ]);

            event(new Registered($user));
            return redirect()->back()->with([
                'userAdd'=>true
            ]);
        }
    }

    public function normalkullaniciekle(Request $request)
    {
        $pass = Str::random(12);
        if(User::where('email',$request->email)->exists()){
            return redirect()->back()->with([
                'emailExists'=>true
            ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'userType' => $request->userType,
                'password' => Hash::make($pass),
            ]);

            event(new Registered($user));
            return redirect()->back()->with([
                'userAdd'=>true
            ]);
        }
    }

    public function configclear()
    {
        $status = Artisan::call('config:clear');
        return redirect()->back()->with([
            'configClean'=>true
        ]);
    }

    public function cacheclear()
    {
        $status = Artisan::call('cache:clear');
        return redirect()->back()->with([
            'cacheClean'=>true
        ]);
    }

    public function configcache()
    {
        $status = Artisan::call('config:cache');
        return redirect()->back()->with([
            'configCache'=>true
        ]);
    }

    public function optimizeclear()
    {
        $status = Artisan::call('optimize:clear');
        return redirect()->back()->with([
            'optimizeClear'=>true
        ]);
    }

    public function sunucuac()
    {
        $status =  Artisan::call('up');
        return redirect()->back()->with([
            'serverUp'=>true
        ]);
    }

    public function sunucukapat()
    {
        $status =  Artisan::call('down');
        return redirect()->back()->with([
            'serverDown'=>true
        ]);
    }

    public function kafeyinayarlar(Request $request)
    {
        $boolSettings = KafeyinBoolSetting::all();
        $stringSettings = KafeyinStringSetting::all();
        return view('admin.kafeyinayarlar')
            ->with([
                'boolSettings' => $boolSettings,
                'stringSettings' => $stringSettings,
            ]);
    }

    public function boolayarekle(Request $request)
    {
        KafeyinBoolSetting::create($request->except(['_token']));
        return redirect()->back()->with([
            'setAdd'=>true
        ]);
    }

    public function boolayarduzenle(Request $request)
    {
        KafeyinBoolSetting::where('id',$request->boolID)->first()->update([
            'value'=>$request->value
        ]);
        return redirect()->back()->with([
            'setUp'=>true
        ]);
    }

    public function boolayarsil(Request $request)
    {
        $id = $request->id;
        KafeyinBoolSetting::where('id',$id)->first()->delete();
        return redirect()->back()->with([
            'setDel'=>true
        ]);
    }

    public function stringayarekle(Request $request)
    {
        KafeyinStringSetting::create($request->except(['_token']));
        return redirect()->back()->with([
            'setAdd'=>true
        ]);
    }

    public function stringayarduzenle(Request $request)
    {
        KafeyinStringSetting::where('id',$request->stringID)->first()->update([
            'value'=>$request->value
        ]);
        return redirect()->back()->with([
            'setUp'=>true
        ]);
    }

    public function stringayarsil(Request $request)
    {
        $id = $request->id;
        KafeyinStringSetting::where('id',$id)->first()->delete();
        return redirect()->back()->with([
            'setDel'=>true
        ]);
    }

    public function admindeneme(Request $request)
    {

        $brands = Brand::all();

        foreach ($brands as $brand){

            $randomStr = strtoupper(Str::random(48));

            $data = [
                'brandID'=>$brand->id,
                'referralCode'=>$randomStr,
                'isUsed'=>false,
                'isValid'=>true,
            ];

            OwnershipApplicationReferral::create($data);
        }

        return response()->json([
            'deneme'=>true
        ]);
    }

}
