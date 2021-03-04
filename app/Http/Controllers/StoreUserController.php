<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AddressCity;
use App\Models\AddressCounty;
use App\Models\AddressDistrict;
use App\Models\AddressNeighborhood;
use App\Models\Announcement;
use App\Models\AnnouncementApplication;
use App\Models\Article;
use App\Models\BrandLog;
use App\Models\BrandNotification;
use App\Models\City;
use App\Models\FavoriteActivity;
use App\Models\FavoriteArticle;
use App\Models\FavoriteStore;
use App\Models\KafeyinBoolSetting;
use App\Models\KafeyinNews;
use App\Models\KafeyinQrCode;
use App\Models\KafeyinStory;
use App\Models\KafeyinStringSetting;
use App\Models\KnowledgeBaseItem;
use App\Models\LastSearchedStore;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyCardApproval;
use App\Models\MenuItem;
use App\Models\MenuItemCategory;
use App\Models\MenuItemSubCategory;
use App\Models\MenuItemViewLog;
use App\Models\Store;
use App\Models\StoreComment;
use App\Models\StoreCommentPhoto;
use App\Models\StoreLog;
use App\Models\StoreNotification;
use App\Models\StoreSurvey;
use App\Models\StoreSurveyAnswer;
use App\Models\StoreViewLog;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserLog;
use App\Notifications\KafeyinQrPdfEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class StoreUserController extends Controller
{
    public function anasayfa(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        if ($user->isBrandManager) {
            if (!$hasBrand && !$hasMagaza) {
                //marka yoneticisi ama ikisi de yok
                return view('store_user.yetkisiz')
                    ->with([
                        'user' => $user,
                    ]);
            }
            if ($hasMagaza) {
                // marka yöneticisi ve mağazası var
                $sod = Carbon::today()->startOfDay();
                $sto = Store::where('id', $user->magaza->id)->with('brand')->first();
                $lastFiveStoreComments = StoreComment::where('storeID', $sto->id)->with('photos')->with('commenter')->withCount('likes')->orderByDesc('created_at')->limit(5)->get();
                $tdViewCount = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdFavCount = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdComCount = StoreComment::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdSearchCount = LastSearchedStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();

                $sod2 = Carbon::today()->startOfDay();
                $eod2 = Carbon::today()->endOfDay();
                $views = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $favs = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $coms = StoreComment::where('storeID', $sto->id)->get();
                $usedqs = KafeyinQrCode::where('storeID', $sto->id)->where('status', 'used')->where('updated_at', '>', Carbon::now()->subMonth())->get();

                // start of views via city
                $viewsForCity = StoreViewLog::where('storeID', $sto->id)
                    ->with('viewer')
                    ->get()
                    ->groupBy('viewer.city')
                    ->toArray();
                $cityLabels = array_keys($viewsForCity);
                $viewsByCity = array();
                foreach ($cityLabels as $cityLabel) {
                    $push = [
                        'city' => $cityLabel,
                        'count' => count($viewsForCity[$cityLabel])
                    ];
                    array_push($viewsByCity, $push);
                }
                $count = array();
                foreach ($viewsByCity as $key => $row) {
                    $count[$key] = $row['count'];
                }
                array_multisort($count, SORT_DESC, $viewsByCity);
                $viewsByCity = array_slice($viewsByCity, 0, 5);
                // end of views via city

                // start of favs via city
                $favsForCity = FavoriteStore::where('storeID', $sto->id)
                    ->with('user')
                    ->get()
                    ->groupBy('user.city')
                    ->toArray();
                $cityLabels2 = array_keys($favsForCity);
                $favsByCity = array();
                foreach ($cityLabels2 as $cityLabel2) {
                    $push = [
                        'city' => $cityLabel2,
                        'count' => count($favsForCity[$cityLabel2])
                    ];
                    array_push($favsByCity, $push);
                }
                $count2 = array();
                foreach ($favsByCity as $key => $row) {
                    $count2[$key] = $row['count'];
                }
                array_multisort($count2, SORT_DESC, $favsByCity);
                $favsByCity = array_slice($favsByCity, 0, 3);

                $l15days = array();
                $l15dvs = array();
                $l15dfs = array();
                $l15daps = array();
                $l15duqs = array();
                $k = 0;
                while ($k < 15) {
                    $dayOfWeek = $eod2->subDays($k);
                    $dayOfWeek2 = $sod2->subDays($k);
                    $daysViewCount = $views->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                    $daysFavCount = $favs->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                    $daysUQrsCount = $usedqs->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();

                    $coms2 = $coms->where('created_at', '<=', $dayOfWeek->toDateTimeString());
                    if (count($coms2) == 0) {
                        array_push($l15daps, 0);
                    } else {
                        $tp = 0;
                        $cc = 0;
                        foreach ($coms2 as $item) {
                            $tp = $tp + $item->commentPoint;
                            $cc = $cc + 1;
                        }
                        array_push($l15daps, round(($tp / $cc), 1));
                    }


                    array_push($l15dvs, $daysViewCount);
                    array_push($l15dfs, $daysFavCount);
                    array_push($l15duqs, $daysUQrsCount);
                    array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                    $eod2 = Carbon::now()->endOfDay();
                    $sod2 = Carbon::now()->startOfDay();
                    $k++;
                }

                $cities = City::where('id', '>', 0)->get();
                $kafeyinNews = KafeyinNews::where('cityID', $sto->cityID)->orderByDesc('created_at')->get();
                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                $survey = StoreSurvey::where('type', '88')->where('isActive', true)->whereDoesntHave('answers', function ($query) use ($sto) {
                    return $query->where('brandID', $sto->brand->id);
                })->orWhere(function ($q) use ($sto) {
                    return $q->where('type', $sto->cityID)->where('isActive', true)->whereDoesntHave('answers', function ($q1) use ($sto) {
                        return $q1->where('brandID', $sto->brand->id);
                    });
                })->orderByDesc('created_at')->first();

                $mvItems = MenuItem::where('storeID', $sto->id)->withCount('views')->whereHas('views')->with('category')->with('subcategory')->orderByDesc('views_count')->limit(5)->get();
                $mquItems = MenuItem::where('storeId', $sto->id)->whereHas('u_qrcodes')->withCount('u_qrcodes')->orderByDesc('u_qrcodes_count')->limit(5)->get();
                $announces = Announcement::where('brandID', $sto->brand->id)->where('isActive', true)->with('city')->get();


                return view('store_user.anasayfa')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'tdViewCount' => $tdViewCount,
                    'tdFavCount' => $tdFavCount,
                    'tdComCount' => $tdComCount,
                    'tdSearchCount' => $tdSearchCount,
                    'l15days' => $l15days,
                    'l15dvs' => $l15dvs,
                    'l15dfs' => $l15dfs,
                    'l15daps' => $l15daps,
                    'viewsByCity' => $viewsByCity,
                    'favsByCity' => $favsByCity,
                    'cities' => $cities,
                    'kafeyinNews' => $kafeyinNews,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'isStatisticsFree' => $isStatisticsFree,
                    'survey' => $survey,
                    'mvItems' => $mvItems,
                    'lastFiveStoreComments' => $lastFiveStoreComments,
                    'l15duqs' => $l15duqs,
                    'mquItems' => $mquItems,
                    'announces' => $announces,
                ]);

            } else {

                $sod = Carbon::today()->startOfDay();
                $survey = StoreSurvey::where('type', '88')->where('isActive', true)->whereDoesntHave('answers', function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id);
                })->orWhere(function ($q) use ($user) {
                    return $q->where('type', $user->brand->stores->first()->cityID)->where('isActive', true)->whereDoesntHave('answers', function ($q1) use ($user) {
                        return $q1->where('brandID', $user->brand->id);
                    });
                })->orderByDesc('created_at')->first();
                $announces = Announcement::where('brandID', $user->brand->id)->where('isActive', true)->with('city')->get();
                $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                $tdViewCount = 0;
                $tdFavCount = 0;
                $tdComCount = 0;
                $tdSearchCount = 0;

                foreach ($user->brand->stores as $ssto) {
                    $tdViewCount = $tdViewCount + StoreViewLog::where('storeID', $ssto->id)->where('created_at', '>=', $sod)->count();
                    $tdFavCount = $tdFavCount + FavoriteStore::where('storeID', $ssto->id)->where('created_at', '>=', $sod)->count();
                    $tdComCount = $tdComCount + StoreComment::where('storeID', $ssto->id)->where('created_at', '>=', $sod)->count();
                    $tdSearchCount = $tdSearchCount + Store::where('id', $ssto->id)->first()->todaysSearchCount;
                }

                $ccoms = StoreComment::whereHas('store', function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id);
                })->with('commenter')->with('store')->with('photos')->withCount('likes')->orderByDesc('created_at')->limit(10)->get();

                $sod2 = Carbon::today()->startOfDay();
                $eod2 = Carbon::today()->endOfDay();

                $sod3 = Carbon::today()->startOfDay();
                $eod3 = Carbon::today()->endOfDay();

                $l15days = array();
                $l15daps = array();
                $l15dfs = array();
                $l15dvs = array();
                $stos = array();
                $k = 0;
                $v = 0;

                foreach ($user->brand->stores as $store) {
                    array_push($stos, $store->name . " (ID: KFYN" . $store->id . ")");
                    while ($k < 15) {
                        $dayOfWeek = $eod2->subDays($k);
                        $dayOfWeek2 = $sod2->subDays($k);
                        array_push($l15daps, $store->gunOrtalamaPuan($dayOfWeek));
                        array_push($l15dfs, $store->gunFavEklenme($dayOfWeek, $dayOfWeek2));
                        array_push($l15dvs, $store->gunGoruntulenme($dayOfWeek, $dayOfWeek2));
                        $eod2 = Carbon::now()->endOfDay();
                        $sod2 = Carbon::now()->startOfDay();
                        $k++;
                    }
                    $k = 0;
                }

                while ($v < 15) {
                    $dayOfWeek2 = $eod3->subDays($v);

                    array_push($l15days, $dayOfWeek2->subMonths(1)->format('Y,m,d'));
                    $eod3 = Carbon::now()->endOfDay();
                    $sod3 = Carbon::now()->startOfDay();
                    $v++;
                }

                $viewsForCity = StoreViewLog::whereHas('store', function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id);
                })
                    ->with('viewer')
                    ->get()
                    ->groupBy('viewer.city')
                    ->toArray();
                $cityLabels = array_keys($viewsForCity);
                $viewsByCity = array();
                foreach ($cityLabels as $cityLabel) {
                    $push = [
                        'city' => $cityLabel,
                        'count' => count($viewsForCity[$cityLabel])
                    ];
                    array_push($viewsByCity, $push);
                }
                $count = array();
                foreach ($viewsByCity as $key => $row) {
                    $count[$key] = $row['count'];
                }
                array_multisort($count, SORT_DESC, $viewsByCity);
                $viewsByCity = array_slice($viewsByCity, 0, 5);

                $favsForCity = FavoriteStore::whereHas("store", function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id);
                })
                    ->with('user')
                    ->get()
                    ->groupBy('user.city')
                    ->toArray();
                $cityLabels2 = array_keys($favsForCity);
                $favsByCity = array();
                foreach ($cityLabels2 as $cityLabel2) {
                    $push = [
                        'city' => $cityLabel2,
                        'count' => count($favsForCity[$cityLabel2])
                    ];
                    array_push($favsByCity, $push);
                }
                $count2 = array();
                foreach ($favsByCity as $key => $row) {
                    $count2[$key] = $row['count'];
                }
                array_multisort($count2, SORT_DESC, $favsByCity);
                $favsByCity = array_slice($favsByCity, 0, 4);


                $fsc = FavoriteStore::whereHas("store", function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id);
                })->count();

                return view('store_user.anasayfa')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'isStatisticsFree' => $isStatisticsFree,
                    'survey' => $survey,
                    'announces' => $announces,
                    'tdViewCount' => $tdViewCount,
                    'tdFavCount' => $tdFavCount,
                    'tdComCount' => $tdComCount,
                    'tdSearchCount' => $tdSearchCount,
                    'ccoms' => $ccoms,
                    'l15days' => $l15days,
                    'l15daps' => $l15daps,
                    'l15dfs' => $l15dfs,
                    'l15dvs' => $l15dvs,
                    'stos' => $stos,
                    'viewsByCity' => $viewsByCity,
                    'favsByCity' => $favsByCity,
                    'fsc' => $fsc,
                ]);
            }
        } else {
            if (!$hasMagaza) {
                //sadece magaza yoneticisi ama magazası yok
                return view('store_user.yetkisiz')
                    ->with([
                        'user' => $user,
                    ]);
            } else {
                $sod = Carbon::today()->startOfDay();
                $sto = Store::where('id', $user->magaza->id)->with('brand')->first();
                $lastFiveStoreComments = StoreComment::where('storeID', $sto->id)->with('photos')->with('commenter')->withCount('likes')->orderByDesc('created_at')->limit(5)->get();
                $tdViewCount = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdFavCount = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdComCount = StoreComment::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdSearchCount = LastSearchedStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();

                $sod2 = Carbon::today()->startOfDay();
                $eod2 = Carbon::today()->endOfDay();
                $views = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $favs = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $coms = StoreComment::where('storeID', $sto->id)->get();
                $usedqs = KafeyinQrCode::where('storeID', $sto->id)->where('status', 'used')->where('updated_at', '>', Carbon::now()->subMonth())->get();

                // start of views via city
                $viewsForCity = StoreViewLog::where('storeID', $sto->id)
                    ->with('viewer')
                    ->get()
                    ->groupBy('viewer.city')
                    ->toArray();
                $cityLabels = array_keys($viewsForCity);
                $viewsByCity = array();
                foreach ($cityLabels as $cityLabel) {
                    $push = [
                        'city' => $cityLabel,
                        'count' => count($viewsForCity[$cityLabel])
                    ];
                    array_push($viewsByCity, $push);
                }
                $count = array();
                foreach ($viewsByCity as $key => $row) {
                    $count[$key] = $row['count'];
                }
                array_multisort($count, SORT_DESC, $viewsByCity);
                $viewsByCity = array_slice($viewsByCity, 0, 5);
                // end of views via city

                // start of favs via city
                $favsForCity = FavoriteStore::where('storeID', $sto->id)
                    ->with('user')
                    ->get()
                    ->groupBy('user.city')
                    ->toArray();
                $cityLabels2 = array_keys($favsForCity);
                $favsByCity = array();
                foreach ($cityLabels2 as $cityLabel2) {
                    $push = [
                        'city' => $cityLabel2,
                        'count' => count($favsForCity[$cityLabel2])
                    ];
                    array_push($favsByCity, $push);
                }
                $count2 = array();
                foreach ($favsByCity as $key => $row) {
                    $count2[$key] = $row['count'];
                }
                array_multisort($count2, SORT_DESC, $favsByCity);
                $favsByCity = array_slice($favsByCity, 0, 3);

                $l15days = array();
                $l15dvs = array();
                $l15dfs = array();
                $l15daps = array();
                $l15duqs = array();
                $k = 0;
                while ($k < 15) {
                    $dayOfWeek = $eod2->subDays($k);
                    $dayOfWeek2 = $sod2->subDays($k);
                    $daysViewCount = $views->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                    $daysFavCount = $favs->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                    $daysUQrsCount = $usedqs->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();

                    $coms2 = $coms->where('created_at', '<=', $dayOfWeek->toDateTimeString());
                    if (count($coms2) == 0) {
                        array_push($l15daps, 0);
                    } else {
                        $tp = 0;
                        $cc = 0;
                        foreach ($coms2 as $item) {
                            $tp = $tp + $item->commentPoint;
                            $cc = $cc + 1;
                        }
                        array_push($l15daps, round(($tp / $cc), 1));
                    }


                    array_push($l15dvs, $daysViewCount);
                    array_push($l15dfs, $daysFavCount);
                    array_push($l15duqs, $daysUQrsCount);
                    array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                    $eod2 = Carbon::now()->endOfDay();
                    $sod2 = Carbon::now()->startOfDay();
                    $k++;
                }

                $cities = City::where('id', '>', 0)->get();
                $kafeyinNews = KafeyinNews::where('cityID', $sto->cityID)->orderByDesc('created_at')->get();
                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                $survey = StoreSurvey::where('type', '88')->where('isActive', true)->whereDoesntHave('answers', function ($query) use ($sto) {
                    return $query->where('brandID', $sto->brand->id);
                })->orWhere(function ($q) use ($sto) {
                    return $q->where('type', $sto->cityID)->where('isActive', true)->whereDoesntHave('answers', function ($q1) use ($sto) {
                        return $q1->where('brandID', $sto->brand->id);
                    });
                })->orderByDesc('created_at')->first();

                $mvItems = MenuItem::where('storeID', $sto->id)->withCount('views')->whereHas('views')->with('category')->with('subcategory')->orderByDesc('views_count')->limit(5)->get();
                $mquItems = MenuItem::where('storeId', $sto->id)->whereHas('u_qrcodes')->withCount('u_qrcodes')->orderByDesc('u_qrcodes_count')->limit(5)->get();
                $announces = Announcement::where('brandID', $sto->brand->id)->where('isActive', true)->with('city')->get();


                return view('store_user.anasayfa')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'tdViewCount' => $tdViewCount,
                    'tdFavCount' => $tdFavCount,
                    'tdComCount' => $tdComCount,
                    'tdSearchCount' => $tdSearchCount,
                    'l15days' => $l15days,
                    'l15dvs' => $l15dvs,
                    'l15dfs' => $l15dfs,
                    'l15daps' => $l15daps,
                    'viewsByCity' => $viewsByCity,
                    'favsByCity' => $favsByCity,
                    'cities' => $cities,
                    'kafeyinNews' => $kafeyinNews,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'isStatisticsFree' => $isStatisticsFree,
                    'survey' => $survey,
                    'mvItems' => $mvItems,
                    'lastFiveStoreComments' => $lastFiveStoreComments,
                    'l15duqs' => $l15duqs,
                    'mquItems' => $mquItems,
                    'announces' => $announces,
                ]);
            }
        }

    }

    public function yorumlar(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.location')->with('magaza.city')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $sort = $request->sort;
        if ($sort == null) {
            $sort = "-created_at";
        }
        switch ($sort) {
            case "-created_at":
                $yorumCount = StoreComment::where('storeID', $user->magaza->id)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $user->magaza->id)->count();
                $yorums = StoreComment::where('storeID', $user->magaza->id)
                    ->with('photos')
                    ->with('commenter')
                    ->withCount('likes')
                    ->orderByDesc('created_at')
                    ->paginate(6)->withPath('?sort=-created_at');

                return view('store_user.yorumlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'yorums' => $yorums,
                    'yorumCount' => $yorumCount,
                    'fotoCount' => $fotoCount,
                ]);
                break;
            case "created_at":
                $yorumCount = StoreComment::where('storeID', $user->magaza->id)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $user->magaza->id)->count();
                $yorums = StoreComment::where('storeID', $user->magaza->id)
                    ->with('photos')
                    ->with('commenter')
                    ->withCount('likes')
                    ->orderBy('created_at')
                    ->paginate(6)->withPath('?sort=created_at');
                return view('store_user.yorumlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'yorums' => $yorums,
                    'yorumCount' => $yorumCount,
                    'fotoCount' => $fotoCount,
                ]);
                break;
            case "-points":
                $yorumCount = StoreComment::where('storeID', $user->magaza->id)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $user->magaza->id)->count();
                $yorums = StoreComment::where('storeID', $user->magaza->id)
                    ->with('photos')
                    ->with('commenter')
                    ->withCount('likes')
                    ->orderByDesc('commentPoint')
                    ->paginate(6)->withPath('?sort=-points');
                return view('store_user.yorumlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'yorums' => $yorums,
                    'yorumCount' => $yorumCount,
                    'fotoCount' => $fotoCount,
                ]);
                break;
            case "points":
                $yorumCount = StoreComment::where('storeID', $user->magaza->id)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $user->magaza->id)->count();
                $yorums = StoreComment::where('storeID', $user->magaza->id)
                    ->with('photos')
                    ->with('commenter')
                    ->withCount('likes')
                    ->orderBy('commentPoint')
                    ->paginate(6)->withPath('?sort=points');
                return view('store_user.yorumlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'yorums' => $yorums,
                    'yorumCount' => $yorumCount,
                    'fotoCount' => $fotoCount,
                ]);
                break;
            case "likes_count":
                $yorumCount = StoreComment::where('storeID', $user->magaza->id)->count();
                $fotoCount = StoreCommentPhoto::where('storeID', $user->magaza->id)->count();
                $yorums = StoreComment::where('storeID', $user->magaza->id)
                    ->with('photos')
                    ->with('commenter')
                    ->withCount('likes')
                    ->orderByDesc('likes_count')
                    ->paginate(6)->withPath('?sort=likes_count');
                return view('store_user.yorumlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'yorums' => $yorums,
                    'yorumCount' => $yorumCount,
                    'fotoCount' => $fotoCount,
                ]);
                break;
            default:
                return redirect('/yoneticipaneli/yorumlar?sort=-created_at');
                break;
        }

    }

    public function paylasimlar()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isPremiumEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
        $canAddStory = KafeyinBoolSetting::where('code', 'canAddStory')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $aktifPaylasims = KafeyinStory::where('isActive', true)->where('storeID', $user->magaza->id)->get();
        $pasifPaylasims = KafeyinStory::where('isActive', false)->where('storeID', $user->magaza->id)->get();
        return view('store_user.paylasimlar')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'aktifPaylasims' => $aktifPaylasims,
            'pasifPaylasims' => $pasifPaylasims,
            'isPremiumEnabled' => $isPremiumEnabled,
            'canAddStory' => $canAddStory,
        ]);

    }

    public function paysil(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $sto = KafeyinStory::where('id', $id)->first();
        if (!$sto) {
            return redirect()->back()->withErrors([
                'paylasim' => "Silmek istediğiniz paylaşım sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($sto->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'paylasim' => "Hesabınıza bağlı olmayan bir mağazanın paylaşımını silemezsiniz."
            ]);
        }
        $stoImageLink = KafeyinStory::where('id', $id)->first()->imageLink;
        if (strpos($stoImageLink, "stories") != false) {
            $konum = strpos($stoImageLink, "stories");
            $curFilePath = substr($stoImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        KafeyinStory::where('id', $id)->first()->delete();
        $this->writeStoreLog($sto->storeID, $user->id, "PAY" . $id . " ID'li paylaşım silindi.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'stoDel' => true
        ]);
    }

    public function paypasif(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $sto = KafeyinStory::where('id', $id)->first();
        if (!$sto) {
            return redirect()->back()->withErrors([
                'paylasim' => "Pasifize etmek istediğiniz paylaşım sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($sto->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'paylasim' => "Hesabınıza bağlı olmayan bir mağazanın paylaşımını pasif hale getiremezsiniz."
            ]);
        }
        KafeyinStory::where('id', $id)->first()->update([
            'isActive' => false
        ]);
        $this->writeStoreLog($sto->storeID, $user->id, "PAY" . $id . " ID'li paylaşım pasif hale getirildi.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'stoPas' => true
        ]);
    }

    public function coklupaysil(Request $request)
    {
        $ids = $request->ids;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $newIDS = explode(',', $ids);
        $finalIDS = array();
        foreach ($newIDS as $newID) {
            $iid = substr($newID, 3);
            array_push($finalIDS, $iid);
        }

        foreach ($finalIDS as $finalID) {
            $sto = KafeyinStory::where('id', $finalID)->first();
            if (!$sto) {
                return redirect()->back()->withErrors([
                    'paylasim' => "Silmek istediğiniz paylaşım sistemlerimizde bulunmamaktadır."
                ]);
            }
            if ($sto->storeID != $user->magaza->id) {
                return redirect()->back()->withErrors([
                    'paylasim' => "Hesabınıza bağlı olmayan bir mağazanın paylaşımını silemezsiniz."
                ]);
            }
            $stoImageLink = KafeyinStory::where('id', $finalID)->first()->imageLink;
            if (strpos($stoImageLink, "stories") != false) {
                $konum = strpos($stoImageLink, "stories");
                $curFilePath = substr($stoImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
            KafeyinStory::where('id', $finalID)->first()->delete();
            $this->writeStoreLog($sto->storeID, $user->id, "PAY" . $finalID . " ID'li paylaşım silindi.", json_encode(['ip' => $request->ip()]));
        }
        return redirect()->back()->with([
            'multiStoDel' => true
        ]);
    }

    public function payekle(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $image = $request->file('image');
        $path = Storage::disk('public')->put('stories', $image);
        $imageLink = url(Storage::url($path));
        $data = [
            'cityID' => $user->magaza->cityID,
            'storeID' => $user->magaza->id,
            'imageLink' => $imageLink,
            'isActive' => true,
            'viewCount' => 0
        ];
        $created = KafeyinStory::create($data);
        $this->writeStoreLog($user->magaza->id, $user->id, "PAY" . $created->id . " ID'li paylaşım eklendi.", json_encode(['ip' => $request->ip()]));
        Store::where('id', $user->magaza->id)->first()->decrement('leftDailyStoryCount');
        return redirect()->back()->with([
            'stoAdd' => true
        ]);

    }

    public function yazilar()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isVideoUploadEnabled = KafeyinBoolSetting::where('code', 'isVideoUploadEnabled')->first()->value;
        $canPublishArticle = KafeyinBoolSetting::where('code', 'canPublishArticle')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $aktifYazis = Article::where('isActive', true)->where('storeID', $user->magaza->id)->withCount('favorites')->get();
        $pasifYazis = Article::where('isActive', false)->where('storeID', $user->magaza->id)->withCount('favorites')->get();
        return view('store_user.yazilar')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'aktifYazis' => $aktifYazis,
            'pasifYazis' => $pasifYazis,
            'isVideoUploadEnabled' => $isVideoUploadEnabled,
            'canPublishArticle' => $canPublishArticle,
        ]);
    }

    public function yazipasif(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $art = Article::where('id', $id)->first();
        if (!$art) {
            return redirect()->back()->withErrors([
                'yazi' => "Pasifize etmek istediğiniz yazı sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($art->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'yazi' => "Hesabınıza bağlı olmayan bir mağazanın yazısını pasif hale getiremezsiniz."
            ]);
        }
        Article::where('id', $id)->first()->update([
            'isActive' => false
        ]);
        $this->writeStoreLog($user->magaza->id, $user->id, "YAZ" . $id . " ID'li yazı pasif hale getirildi.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'artPas' => true
        ]);
    }

    public function yazisil(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $art = Article::where('id', $id)->first();
        if (!$art) {
            return redirect()->back()->withErrors([
                'yazi' => "Silmek istediğiniz yazı sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($art->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'yazi' => "Hesabınıza bağlı olmayan bir mağazanın yazısını silemezsiniz."
            ]);
        }
        $yaziImageLink = Article::where('id', $id)->first()->imageLink;
        if (strpos($yaziImageLink, "article_images") != false) {
            $konum = strpos($yaziImageLink, "article_images");
            $curFilePath = substr($yaziImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        if (Article::where('id', $id)->first()->hasVideo) {
            $yaziVideoLink = Article::where('id', $id)->first()->videoLink;
            if (strpos($yaziVideoLink, "article_videos") != false) {
                $konum = strpos($yaziVideoLink, "article_videos");
                $curFilePath = substr($yaziVideoLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
        }
        Article::where('id', $id)->first()->delete();
        $this->writeStoreLog($user->magaza->id, $user->id, "YAZ" . $id . " ID'li yazı silindi.", json_encode(['ip' => $request->ip()]));
        FavoriteArticle::where('articleID', $id)->delete();
        return redirect()->back()->with([
            'artDel' => true
        ]);
    }

    public function cokluyazisil(Request $request)
    {
        $ids = $request->ids;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $newIDS = explode(',', $ids);
        $finalIDS = array();
        foreach ($newIDS as $newID) {
            $iid = substr($newID, 3);
            array_push($finalIDS, $iid);
        }

        foreach ($finalIDS as $finalID) {
            $art = Article::where('id', $finalID)->first();
            if (!$art) {
                return redirect()->back()->withErrors([
                    'yazi' => "Silmek istediğiniz yazı sistemlerimizde bulunmamaktadır."
                ]);
            }
            if ($art->storeID != $user->magaza->id) {
                return redirect()->back()->withErrors([
                    'yazi' => "Hesabınıza bağlı olmayan bir mağazanın yazısnı silemezsiniz."
                ]);
            }
            $yaziImageLink = Article::where('id', $finalID)->first()->imageLink;
            if (strpos($yaziImageLink, "article_images") != false) {
                $konum = strpos($yaziImageLink, "article_images");
                $curFilePath = substr($yaziImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
            if (Article::where('id', $finalID)->first()->hasVideo) {
                $yaziVideoLink = Article::where('id', $finalID)->first()->videoLink;
                if (strpos($yaziVideoLink, "article_videos") != false) {
                    $konum = strpos($yaziVideoLink, "article_videos");
                    $curFilePath = substr($yaziVideoLink, $konum);
                    Storage::disk('public')->delete($curFilePath);
                }
            }
            Article::where('id', $finalID)->first()->delete();
            $this->writeStoreLog($user->magaza->id, $user->id, "YAZ" . $finalID . " ID'li yazı silindi.", json_encode(['ip' => $request->ip()]));
            FavoriteArticle::where('articleID', $finalID)->delete();
        }
        return redirect()->back()->with([
            'multiArtDel' => true
        ]);
    }

    public function yaziekle(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        if (Article::where('storeID', $user->magaza->id)->where('isActive', true)->count() > 1) {
            return redirect()->back()->withErrors([
                'yazi' => 'Maksimum sayıda aktif yazınız olduğu için yeni bir yazı ekleyemezsiniz.'
            ]);
        }
        if ($request->hasFile('video')) {
            //vidyolu

            $image = $request->file('image');
            $path = Storage::disk('public')->put('article_images', $image);
            $imageLink = url(Storage::url($path));


            $video = $request->file('video');
            $path2 = Storage::disk('public')->put('article_videos', $video);
            $videoLink = url(Storage::url($path2));

            $data = [
                'cityID' => $user->magaza->cityID,
                'storeID' => $user->magaza->id,
                'isActive' => true,
                'title' => $request->title,
                'desc' => $request->desc,
                'imageLink' => $imageLink,
                'hasVideo' => true,
                'videoLink' => $videoLink,
                'viewCount' => 0,
            ];

            $created = Article::create($data);
            $this->writeStoreLog($user->magaza->id, $user->id, "YAZ" . $created->id . " ID'li yazı eklendi.", json_encode(['ip' => $request->ip()]));
            return redirect()->back()->with([
                'artAdd' => true
            ]);

        } else {
            //vidyosuz

            $image = $request->file('image');
            $path = Storage::disk('public')->put('article_images', $image);
            $imageLink = url(Storage::url($path));

            $data = [
                'cityID' => $user->magaza->cityID,
                'storeID' => $user->magaza->id,
                'isActive' => true,
                'title' => $request->title,
                'desc' => $request->desc,
                'imageLink' => $imageLink,
                'hasVideo' => false,
                'viewCount' => 0,
            ];

            $created1 = Article::create($data);
            $this->writeStoreLog($user->magaza->id, $user->id, "YAZ" . $created1->id . " ID'li yazı eklendi.", json_encode(['ip' => $request->ip()]));
            return redirect()->back()->with([
                'artAdd' => true
            ]);
        }
    }

    public function yazidetay(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isVideoUploadEnabled = KafeyinBoolSetting::where('code', 'isVideoUploadEnabled')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $rawID = $request->id;
        $id = substr($rawID, 3);
        $art = Article::where('id', $id)->with('store')->withCount('favorites')->first();
        if (!is_numeric($id) || !$art || $art->store->id != $user->magaza->id) {
            return redirect('/yoneticipaneli/yazilar');
        } else {
            return view('store_user.yazidetay')
                ->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'yazi' => $art,
                    'isVideoUploadEnabled' => $isVideoUploadEnabled,
                ]);
        }

    }

    public function yaziguncelle(Request $request)
    {
        $rawID = $request->artID;
        $id = substr($rawID, 3);
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $art = Article::where('id', $id)->first();
        if (!is_numeric($id) || !$art || $art->store->id != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Bir hata gerçekleşti."
            ]);
        } else {
            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $yaziImageLink = Article::where('id', $id)->first()->imageLink;
                if (strpos($yaziImageLink, "article_images") != false) {
                    $konum = strpos($yaziImageLink, "article_images");
                    $curFilePath = substr($yaziImageLink, $konum);
                    Storage::disk('public')->delete($curFilePath);
                }

                $path = Storage::disk('public')->put('article_images', $image);
                $imageLink = url(Storage::url($path));

                Article::where('id', $id)->first()->update([
                    'imageLink' => $imageLink,
                ]);

            }
            Article::where('id', $id)->first()->update([
                'title' => $request->title,
                'desc' => $request->desc
            ]);
            $this->writeStoreLog($user->magaza->id, $user->id, "YAZ" . $id . " ID'li yazı güncellendi.", json_encode(['ip' => $request->ip()]));
            return redirect()->back()->with([
                'artUp' => true
            ]);
        }
    }

    public function etkinlikler()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isTicketingEnabled = KafeyinBoolSetting::where('code', 'isTicketingEnabled')->first()->value;
        $canAddActivity = KafeyinBoolSetting::where('code', 'canAddActivity')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $aktifEtkinliks = Activity::where('isActive', true)->where('storeID', $user->magaza->id)->withCount('favorites')->get();
        $pasifEtkinliks = Activity::where('isActive', false)->where('storeID', $user->magaza->id)->withCount('favorites')->get();
        return view('store_user.etkinlikler')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'aktifEtkinliks' => $aktifEtkinliks,
            'pasifEtkinliks' => $pasifEtkinliks,
            'isTicketingEnabled' => $isTicketingEnabled,
            'canAddActivity' => $canAddActivity,
        ]);
    }

    public function etksil(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!$act) {
            return redirect()->back()->withErrors([
                'etk' => "Silmek istediğiniz etkinlik sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($act->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'etk' => "Hesabınıza bağlı olmayan bir mağazanın etkinliğini silemezsiniz."
            ]);
        }
        $etkImageLink = Activity::where('id', $id)->first()->imageLink;
        if (strpos($etkImageLink, "activity_images") != false) {
            $konum = strpos($etkImageLink, "activity_images");
            $curFilePath = substr($etkImageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        Activity::where('id', $id)->first()->delete();
        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinlik silindi.", json_encode(['ip' => $request->ip()]));
        FavoriteActivity::where('activityID', $id)->delete();
        return redirect()->back()->with([
            'actDel' => true
        ]);
    }

    public function etkpasif(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!$act) {
            return redirect()->back()->withErrors([
                'etk' => "Pasifize etmek istediğiniz etkinlik sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($act->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'etk' => "Hesabınıza bağlı olmayan bir mağazanın etkinliğini pasif hale getiremezsiniz."
            ]);
        }
        Activity::where('id', $id)->first()->update([
            'isActive' => false
        ]);
        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinlik pasif hale getirildi.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'actPas' => true
        ]);
    }

    public function etkekle(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->with('magaza.brand')->first();
        if (Activity::where('storeID', $user->magaza->id)->where('isActive', true)->count() > 1) {
            return redirect()->back()->withErrors([
                'etk' => 'Maksimum sayıda aktif etkinliğiniz olduğu için yeni bir etkinlik ekleyemezsiniz.'
            ]);
        }
        $d = $request->date;
        $ds = substr($d, 6, 4) . "-" . substr($d, 3, 2) . '-' . substr($d, 0, 2);
        $request->date = $ds;
        $isTicketingEnabled = KafeyinBoolSetting::where('code', 'isTicketingEnabled')->first()->value;
        if ($isTicketingEnabled) {
            if ($request->has('canTicketing')) {
                if ($user->magaza->brand->isPremium) {
                    if ($request->canTicketing) {
                        $image = $request->file('image');
                        $path = Storage::disk('public')->put('activity_images', $image);
                        $imageLink = url(Storage::url($path));
                        $data = [
                            'cityID' => $user->magaza->cityID,
                            'locationID' => $user->magaza->locationID,
                            'storeID' => $user->magaza->id,
                            'title' => $request->title,
                            'desc' => $request->desc,
                            'date' => $request->date,
                            'time' => $request->time,
                            'imageLink' => $imageLink,
                            'canTicketing' => $request->canTicketing,
                            'availableTicketCount' => $request->availableTicketCount,
                            'ticketFee' => $request->ticketFee
                        ];
                        $created = Activity::create($data);
                        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $created->id . " ID'li etkinlik eklendi.", json_encode(['ip' => $request->ip()]));
                        return redirect()->back()->with([
                            'etkAdd' => true
                        ]);
                    } else {
                        $image = $request->file('image');
                        $path = Storage::disk('public')->put('activity_images', $image);
                        $imageLink = url(Storage::url($path));
                        $data = [
                            'cityID' => $user->magaza->cityID,
                            'locationID' => $user->magaza->locationID,
                            'storeID' => $user->magaza->id,
                            'title' => $request->title,
                            'desc' => $request->desc,
                            'date' => $request->date,
                            'time' => $request->time,
                            'imageLink' => $imageLink
                        ];
                        $created = Activity::create($data);
                        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $created->id . " ID'li etkinlik eklendi.", json_encode(['ip' => $request->ip()]));
                        return redirect()->back()->with([
                            'etkAdd' => true
                        ]);
                    }
                } else {
                    $image = $request->file('image');
                    $path = Storage::disk('public')->put('activity_images', $image);
                    $imageLink = url(Storage::url($path));
                    $data = [
                        'cityID' => $user->magaza->cityID,
                        'locationID' => $user->magaza->locationID,
                        'storeID' => $user->magaza->id,
                        'title' => $request->title,
                        'desc' => $request->desc,
                        'date' => $request->date,
                        'time' => $request->time,
                        'imageLink' => $imageLink
                    ];
                    $created = Activity::create($data);
                    $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $created->id . " ID'li etkinlik eklendi.", json_encode(['ip' => $request->ip()]));
                    return redirect()->back()->with([
                        'etkAdd' => true
                    ]);
                }
            } else {
                $image = $request->file('image');
                $path = Storage::disk('public')->put('activity_images', $image);
                $imageLink = url(Storage::url($path));
                $data = [
                    'cityID' => $user->magaza->cityID,
                    'locationID' => $user->magaza->locationID,
                    'storeID' => $user->magaza->id,
                    'title' => $request->title,
                    'desc' => $request->desc,
                    'date' => $request->date,
                    'time' => $request->time,
                    'imageLink' => $imageLink
                ];
                $created = Activity::create($data);
                $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $created->id . " ID'li etkinlik eklendi.", json_encode(['ip' => $request->ip()]));
                return redirect()->back()->with([
                    'etkAdd' => true
                ]);
            }
        } else {
            $image = $request->file('image');
            $path = Storage::disk('public')->put('activity_images', $image);
            $imageLink = url(Storage::url($path));
            $data = [
                'cityID' => $user->magaza->cityID,
                'locationID' => $user->magaza->locationID,
                'storeID' => $user->magaza->id,
                'title' => $request->title,
                'desc' => $request->desc,
                'date' => $request->date,
                'time' => $request->time,
                'imageLink' => $imageLink
            ];
            $created = Activity::create($data);
            $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $created->id . " ID'li etkinlik eklendi.", json_encode(['ip' => $request->ip()]));
            return redirect()->back()->with([
                'etkAdd' => true
            ]);
        }
    }

    public function etkinlikdetay(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isTicketingEnabled = KafeyinBoolSetting::where('code', 'isTicketingEnabled')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $rawID = $request->id;
        $id = substr($rawID, 3);
        $act = Activity::where('id', $id)->with('store')->with('sold_tickets')->with('sold_tickets.buyer')->withCount('favorites')->first();
        if (!is_numeric($id) || !$act || $act->store->id != $user->magaza->id) {
            return redirect('/yoneticipaneli/etkinlikler');
        } else {
            return view('store_user.etkinlikdetay')
                ->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'etkinlik' => $act,
                    'isTicketingEnabled' => $isTicketingEnabled,
                ]);
        }
    }

    public function etkguncelle(Request $request)
    {
        $rawID = $request->actID;
        $id = substr($rawID, 3);
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!is_numeric($id) || !$act || $act->store->id != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Bir hata gerçekleşti."
            ]);
        } else {
            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $etkImageLink = Activity::where('id', $id)->first()->imageLink;
                if (strpos($etkImageLink, "activity_images") != false) {
                    $konum = strpos($etkImageLink, "activity_images");
                    $curFilePath = substr($etkImageLink, $konum);
                    Storage::disk('public')->delete($curFilePath);
                }

                $path = Storage::disk('public')->put('activity_images', $image);
                $imageLink = url(Storage::url($path));

                Activity::where('id', $id)->first()->update([
                    'imageLink' => $imageLink,
                ]);

            }
            Activity::where('id', $id)->first()->update([
                'title' => $request->title,
                'desc' => $request->desc
            ]);
            $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinlik güncellendi.", json_encode(['ip' => $request->ip()]));
            return redirect()->back()->with([
                'actUp' => true
            ]);
        }
    }

    public function etkbilsatkapat(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!$act) {
            return redirect()->back()->withErrors([
                'hata' => "İşlem yapmak istediğiniz etkinlik sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($act->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Hesabınıza bağlı olmayan bir mağazanın etkinliğini düzenleyemezsiniz."
            ]);
        }
        Activity::where('id', $id)->first()->update([
            'canTicketing' => false
        ]);
        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinlik için bilet satışı durduruldu.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'actBilSatDur' => true
        ]);
    }

    public function etkbilsatac(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!$act) {
            return redirect()->back()->withErrors([
                'hata' => "İşlem yapmak istediğiniz etkinlik sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($act->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Hesabınıza bağlı olmayan bir mağazanın etkinliğini düzenleyemezsiniz."
            ]);
        }
        if (is_null($act->ticketFee)) {
            return redirect()->back()->withErrors([
                'hata' => "Bilet fiyatı belirtmeden eklediğiniz etkinliğinizi daha sonrasında bilet satışına açamazsınız."
            ]);
        }
        Activity::where('id', $id)->first()->update([
            'canTicketing' => true
        ]);
        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinlik için bilet satışı açıldı.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'actBilSatAc' => true
        ]);
    }

    public function biletekle(Request $request)
    {
        $rawID = $request->id;
        $id = substr($rawID, 3);
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!is_numeric($id)) {
            return redirect()->back()->withErrors([
                'hata' => "Bir hata gerçekleşti."
            ]);
        }
        if (!$act) {
            return redirect()->back()->withErrors([
                'hata' => "İşlem yapmak istediğiniz etkinlik sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($act->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Hesabınıza bağlı olmayan bir mağazanın etkinliğini düzenleyemezsiniz."
            ]);
        }
        Activity::where('id', $id)->first()->increment('availableTicketCount', $request->count);
        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinlik için " . $request->count . " adet satılabilir bilet eklendi.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'actBilInc' => true
        ]);
    }

    public function biletazalt(Request $request)
    {
        $rawID = $request->id;
        $id = substr($rawID, 3);
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $act = Activity::where('id', $id)->first();
        if (!is_numeric($id)) {
            return redirect()->back()->withErrors([
                'hata' => "Bir hata gerçekleşti."
            ]);
        }
        if (!$act) {
            return redirect()->back()->withErrors([
                'hata' => "İşlem yapmak istediğiniz etkinlik sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($act->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Hesabınıza bağlı olmayan bir mağazanın etkinliğini düzenleyemezsiniz."
            ]);
        }
        if ($act->availableTicketCount < $request->count) {
            $request->count = $act->availableTicketCount;
        }
        Activity::where('id', $id)->first()->decrement('availableTicketCount', $request->count);
        $this->writeStoreLog($user->magaza->id, $user->id, "ETK" . $id . " ID'li etkinliğin satılabilir bilet sayısı " . $request->count . " adet azaltıldı.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'actBilDec' => true
        ]);
    }

    public function urunler()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $kategoris = MenuItemCategory::
            with(['subcategories.items' => function ($query) use ($user) {
                return $query->where('storeID', $user->magaza->id);
            }])
            ->with(['subcategories' => function ($query1) use ($user) {
                return $query1->where('brandID', $user->magaza->brand->id);
            }])
            ->get();
        $uruns = MenuItem::where('storeID', $user->magaza->id)
            ->with('category')
            ->with('subcategory')
            ->get();

        return view('store_user.urunler')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'kategoris' => $kategoris,
            'uruns' => $uruns
        ]);
    }

    public function urunaltkateori(Request $request)
    {
        $sub = $request->sub;
        $kategoris = MenuItemCategory::where('id', '>', 0)->get();
        $catID = null;
        foreach ($kategoris as $kategori) {
            if ($sub == strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $kategori->desc)))) {
                $catID = $kategori->id;
            }
        }
        if (is_null($catID)) {
            return redirect('/yoneticipaneli/urunler');
        }
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $canAddMenuItem = KafeyinBoolSetting::where('code', 'canAddMenuItem')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $uruns = MenuItem::where('storeID', $user->magaza->id)
            ->where('categoryID', $catID)
            ->with('category')
            ->with('subcategory')
            ->withCount('views')
            ->get();
        $altKategoris = MenuItemSubCategory::where('brandID', $user->magaza->brand->id)->where('categoryID', $catID)->get();
        $kategori1 = MenuItemCategory::where('id', $catID)->first();
        return view('store_user.kategoriurunleri')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'kategoris' => $kategoris,
            'uruns' => $uruns,
            'altKategoris' => $altKategoris,
            'kategori1' => $kategori1,
            'canAddMenuItem' => $canAddMenuItem,
        ]);
    }

    public function urnpasif(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $urn = MenuItem::where('id', $id)->first();
        if (!$urn) {
            return redirect()->back()->withErrors([
                'urn' => "Pasifize etmek istediğiniz ürün sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($urn->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'urn' => "Hesabınıza bağlı olmayan bir mağazanın ürününü pasif hale getiremezsiniz."
            ]);
        }
        MenuItem::where('id', $id)->first()->update([
            'isActive' => false
        ]);
        $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $id . " ID'li ürün pasif hale getirildi.", json_encode(['ip' => $request->ip()]));
        KafeyinQrCode::where('menuItemID', $id)->where('status', 'active')->update([
            'status' => 'deleted'
        ]);
        return redirect()->back()->with([
            'urnPas' => true
        ]);
    }

    public function urnaktif(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $urn = MenuItem::where('id', $id)->first();
        if (!$urn) {
            return redirect()->back()->withErrors([
                'urn' => "Aktive etmek istediğiniz ürün sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($urn->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'urn' => "Hesabınıza bağlı olmayan bir mağazanın ürününü aktif hale getiremezsiniz."
            ]);
        }
        MenuItem::where('id', $id)->first()->update([
            'isActive' => true
        ]);
        $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $id . " ID'li ürün aktif hale getirildi.", json_encode(['ip' => $request->ip()]));

        return redirect()->back()->with([
            'urnAkt' => true
        ]);
    }

    public function urnekle(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->with('magaza.brand')->first();
        $subCatID = $request->subCatID;
        $subCat = MenuItemSubCategory::where('id', $subCatID)->first();
        if (!$subCat) {
            return redirect()->back()->withErrors([
                'urn' => "Seçtiğinz alt kategori sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($subCat->brandID != $user->magaza->brand->id) {
            return redirect()->back()->withErrors([
                'urn' => "Markanıza ait olmayan bir alt kategori ile ürün ekleyemezsiniz."
            ]);
        }
        $fakeUrn = MenuItem::where('storeID', $user->magaza->id)
            ->where('categoryID', $request->catID)
            ->where('subCategoryID', $request->subCatID)
            ->where('title', $request->title)
            ->where('desc', $request->desc)
            ->where('isActive', true)
            ->first();
        if (!is_null($fakeUrn)) {
            return redirect()->back()->withErrors([
                'urn' => "Oluşturmak istediğiniz ürün zaten mağazanıza tanımlı."
            ]);
        }
        $data = [
            'cityID' => $user->magaza->cityID,
            'storeID' => $user->magaza->id,
            'categoryID' => $request->catID,
            'subCategoryID' => $request->subCatID,
            'title' => $request->title,
            'desc' => $request->desc,
            'imageLink' => "Image",
            'isActive' => true,
            'tag1' => $request->tag1,
            'tag2' => $request->tag2,
            'tag3' => $request->tag3,
            'fee' => $request->fee,
        ];

        $c = MenuItem::create($data);
        $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $c->id . " ID'li ürün eklendi.", json_encode(['ip' => $request->ip()]));

        $image = $request->file('image');
        $path = Storage::disk('public')->put('menu_item_images', $image);
        $imageLink = url(Storage::url($path));
        MenuItem::where('id', $c->id)->first()->update([
            'imageLink' => $imageLink
        ]);

        return redirect()->back()->with([
            'urnAdd' => true
        ]);
    }

    public function cokluurunpasif(Request $request)
    {
        $ids = $request->ids;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $newIDS = explode(',', $ids);
        $finalIDS = array();
        foreach ($newIDS as $newID) {
            $iid = substr($newID, 3);
            array_push($finalIDS, $iid);
        }
        foreach ($finalIDS as $finalID) {
            $urn = MenuItem::where('id', $finalID)->first();
            if (!$urn) {
                return redirect()->back()->withErrors([
                    'urn' => "Pasifize etmek istediğiniz ürünlerden biri sistemlerimizde bulunmamaktadır."
                ]);
            }
            if ($urn->storeID != $user->magaza->id) {
                return redirect()->back()->withErrors([
                    'urn' => "Hesabınıza bağlı olmayan bir mağazanın ürününü pasifize edemezsiniz."
                ]);
            }
            MenuItem::where('id', $finalID)->first()->update([
                'isActive' => false
            ]);
            $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $finalID . " ID'li ürün pasif hale getirildi.", json_encode(['ip' => $request->ip()]));
            KafeyinQrCode::where('menuItemID', $finalID)->where('status', 'active')->update([
                'status' => 'deleted'
            ]);
        }
        return redirect()->back()->with([
            'multiUrnPas' => true
        ]);
    }

    public function urundetay(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        $rawID = $request->id;
        $id = substr($rawID, 3);
        $urn = MenuItem::where('id', $id)->with('store')->with('subcategory')->withCount('views')->with('qrcodes')->first();

        if (!is_numeric($id) || !$urn || $urn->storeID != $user->magaza->id) {
            return redirect('/yoneticipaneli/urunler');
        } else {
            $now = Carbon::now()->endOfDay();
            $now2 = Carbon::now()->startOfDay();
            $views = MenuItemViewLog::where('menuItemID', $urn->id)->get();
            $allQrs = KafeyinQrCode::where('menuItemID', $urn->id)->where('created_at', '<=', $now->toDateTimeString())->get();
            $l15days = array();
            $l15dvs = array();
            $l15daqs = array();
            $l15dauqs = array();
            $l15duqs = array();
            $k = 0;
            while ($k < 15) {
                $dayOfWeek = $now->subDays($k);
                $dayOfWeek2 = $now2->subDays($k);
                $daysViewCount = $views->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                $daysAllQrCount = $allQrs->where('created_at', '<=', $dayOfWeek->toDateTimeString())->count();
                $daysAllUsedQrCount = $allQrs->where('status', 'used')->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->count();
                $daysUsedQrCount = $allQrs->where('status', 'used')->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                array_push($l15dvs, $daysViewCount);
                array_push($l15daqs, $daysAllQrCount);
                array_push($l15dauqs, $daysAllUsedQrCount);
                array_push($l15duqs, $daysUsedQrCount);
                array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                $now = Carbon::now()->endOfDay();
                $now2 = Carbon::now()->startOfDay();
                $k++;
            }
            $kategori = MenuItemCategory::where('id', $urn->categoryID)->first();
            $altKategoris = MenuItemSubCategory::where('categoryID', $kategori->id)->where('brandID', $user->magaza->brand->id)->get();
            return view('store_user.urundetay')
                ->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'urun' => $urn,
                    'kategori' => $kategori,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'l15days' => $l15days,
                    'l15dvs' => $l15dvs,
                    'l15daqs' => $l15daqs,
                    'l15duqs' => $l15duqs,
                    'l15dauqs' => $l15dauqs,
                    'altKategoris' => $altKategoris,
                ]);
        }
    }

    public function urnguncelle(Request $request)
    {
        $rawID = $request->urnID;
        $id = substr($rawID, 3);
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $urn = MenuItem::where('id', $id)->first();
        if (!is_numeric($id) || !$urn || $urn->store->id != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Bir hata gerçekleşti."
            ]);
        } else {
            if ($request->hasFile('image')) {

                $image = $request->file('image');

                $urnImageLink = MenuItem::where('id', $id)->first()->imageLink;
                if (strpos($urnImageLink, "menu_item_images") != false) {
                    $konum = strpos($urnImageLink, "menu_item_images");
                    $curFilePath = substr($urnImageLink, $konum);
                    Storage::disk('public')->delete($curFilePath);
                }

                $path = Storage::disk('public')->put('menu_item_images', $image);
                $imageLink = url(Storage::url($path));

                MenuItem::where('id', $id)->first()->update([
                    'imageLink' => $imageLink,
                ]);

            }
            MenuItem::where('id', $id)->first()->update($request->except(["_token", "urnID"]));
            $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $id . " ID'li ürün güncellendi.", json_encode(['ip' => $request->ip()]));
            return redirect()->back()->with([
                'urnUp' => true
            ]);
        }
    }

    public function urndelqrs(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $qr = KafeyinQrCode::where('menuItemID', $id)->where('status', 'active')->first();
        $urn = MenuItem::where('id', $id)->first();
        if (!$qr) {
            return redirect()->back()->withErrors([
                'hata' => "Ürününüze ait aktif QR kod bulunmamaktadır."
            ]);
        }
        if (!$urn) {
            return redirect()->back()->withErrors([
                'hata' => "İşlem yapmak istediğiniz ürün sistemlerimizde bulunmamaktadır."
            ]);
        }
        if ($urn->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'hata' => "Hesabınıza bağlı olmayan bir mağazanın ürününün QR kodlarını silemezsiniz."
            ]);
        }

        KafeyinQrCode::where('menuItemID', $id)->where('status', 'active')->update([
            'status' => 'deleted'
        ]);

        $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $id . " ID'li ürüne ait aktif QR kodları silindi.", json_encode(['ip' => $request->ip()]));

        return redirect()->back()->with([
            'qrsDel' => true
        ]);
    }

    public function qrolustur(Request $request)
    {
        $id = $request->id;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $urn = MenuItem::where('id', $id)->with('category')->first();
        $canGenerateQRCode = KafeyinBoolSetting::where('code', 'canGenerateQRCode')->first()->value;
        if (!$urn) {
            return redirect()->back()->withErrors([
                'urn' => "QR kod oluşturmak istediğiniz ürün sistemlerimizde bulunmamaktadır."
            ]);
        }
        if (!$canGenerateQRCode) {
            return redirect()->back()->withErrors([
                'urn' => "Bu özellik kısa süreliğine devre dışı bırakıldı."
            ]);
        }
        if (!$urn->category->canGenerateQrCode) {
            return redirect()->back()->withErrors([
                'urn' => "QR kod oluşturmak istediğiniz ürünün kategorisi bu işleme uygun değil."
            ]);
        }
        if (!$urn->isActive) {
            return redirect()->back()->withErrors([
                'urn' => "Pasif durumdaki ürün için QR kod oluşturamazsınız."
            ]);
        }
        if ($urn->storeID != $user->magaza->id) {
            return redirect()->back()->withErrors([
                'urn' => "Mağazanıza ait olmayan bir ürün için QR kod oluşturamazsınız."
            ]);
        }
        if (Storage::disk('public')->exists('qrs/' . $urn->id)) {
            Storage::disk('public')->delete('qrs/' . $urn->id);
        } else {
            Storage::disk('public')->makeDirectory('qrs/' . $urn->id);
        }

        for ($i = 0; $i < 150; $i++) {
            $random = Str::random(24);
            $string = "qr88-URN" . $urn->id . "-" . $random;
            $qr = QrCode::format('svg')
                ->size(100)
                ->backgroundColor(255, 144, 0)
                ->margin(2)
                ->style("round", 0.4)
                ->generate($string, "../storage/app/public/qrs/" . $urn->id . "/" . $string . ".svg");
            $svgLink = url(Storage::url('qrs/' . $urn->id . '/' . $string . '.svg'));
            $data = [
                'storeID' => $user->magaza->id,
                'menuItemID' => $id,
                'code' => $string,
                'qrImageLink' => $svgLink,
                'status' => 'will_print'
            ];
            KafeyinQrCode::create($data);
        }
        $prQrs = KafeyinQrCode::where('storeID', $user->magaza->id)->where('menuItemID', $id)->where('status', 'will_print')->get();
        $data88 = [
            'prQrs' => $prQrs,
            'urun' => $urn,
            'store' => $user->magaza
        ];
        $pdf = PDF::loadView('store_user.qr_pdf', $data88)
            ->setOrientation("landscape")
            ->setOption('margin-top', 2)
            ->setOption('margin-bottom', 2)
            ->setOption('margin-right', 2)
            ->setOption('margin-left', 2)
            ->setPaper('a4')->output();
        $nowts = Carbon::now()->timestamp;
        $path88 = Storage::disk('public')->put('pdfs/' . $user->magaza->id . '/' . $nowts . '.pdf', $pdf);
        $pdfLink = url(Storage::url('pdfs/' . $user->magaza->id . '/' . $nowts . '.pdf'));

        $details = [
            'subject' => $urn->title . " için QR kodlar - " . Carbon::now()->format('d/m/Y H:i'),
            'user' => $user,
            'bodyText' => $urn->title . ' için oluşturulmuş 150 adet aktif QR kodu ekteki belgede mevcuttur.',
            'bodyText2' => "Herhangi bir sorun için 'destek@kafeyinapp.com' e-posta adresi üzerinden bizimle iletişime geçebilirsiniz.",
            'fileName' => $nowts,
            'filePath' => $pdfLink,
        ];

        User::find($user->id)->notify(new KafeyinQrPdfEmail($details));

        foreach ($prQrs as $qr) {
            if (strpos($qr->qrImageLink, "qrs") != false) {
                $konum = strpos($qr->qrImageLink, "qrs");
                $curFilePath = substr($qr->qrImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }
            KafeyinQrCode::where('id', $qr->id)->first()->update(['status' => 'active']);
        }
        Storage::disk('public')->delete('pdfs/' . $user->magaza->id . '/' . $nowts . '.pdf');

        $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $id . " ID'li ürün için 150 adet QR kod oluşturuldu.", json_encode(['ip' => $request->ip()]));

        return redirect()->back()->with([
            'qrSent' => true
        ]);

    }

    public function cokluqrolustur(Request $request)
    {
        $ids = $request->ids;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->first();
        $newIDS = explode(',', $ids);
        $finalIDS = array();
        foreach ($newIDS as $newID) {
            $iid = substr($newID, 3);
            array_push($finalIDS, $iid);
        }
        $canGenerateQRCode = KafeyinBoolSetting::where('code', 'canGenerateQRCode')->first()->value;
        if (!$canGenerateQRCode) {
            return redirect()->back()->withErrors([
                'urn' => "Bu özellik kısa süreliğine devre dışı bırakıldı."
            ]);
        }
        foreach ($finalIDS as $finalID) {
            $uurn = MenuItem::where('id', $finalID)->with('category')->first();
            if (!$uurn) {
                return redirect()->back()->withErrors([
                    'urn' => "URN" . $uurn->id . " ID'li ürün sistemlerimizde bulunmamaktadır."
                ]);
            }
            if (!$uurn->category->canGenerateQrCode) {
                return redirect()->back()->withErrors([
                    'urn' => "URN" . $uurn->id . " ID'li ürünün kategorisi bu işleme uygun değil."
                ]);
            }
            if (!$uurn->isActive) {
                return redirect()->back()->withErrors([
                        'urn' => "URN" . $uurn->id . " ID'li ürün pasif durumda olduğu için bu işleme uygun değil."]
                );
            }
            if ($uurn->storeID != $user->magaza->id) {
                return redirect()->back()->withErrors([
                        'urn' => "URN" . $uurn->id . " ID'li ürün mağazanıza ait olmadığı için QR kod oluşturamazsınız."]
                );
            }
        }
        foreach ($finalIDS as $idd) {
            $urn = MenuItem::where('id', $idd)->first();
            if (Storage::disk('public')->exists('qrs/' . $urn->id)) {
                Storage::disk('public')->delete('qrs/' . $urn->id);
            } else {
                Storage::disk('public')->makeDirectory('qrs/' . $urn->id);
            }

            for ($i = 0; $i < 150; $i++) {
                $random = Str::random(24);
                $string = "qr88-URN" . $urn->id . "-" . $random;
                $qr = QrCode::format('svg')
                    ->size(100)
                    ->backgroundColor(255, 144, 0)
                    ->margin(2)
                    ->style("round", 0.4)
                    ->generate($string, "../storage/app/public/qrs/" . $urn->id . "/" . $string . ".svg");
                $svgLink = url(Storage::url('qrs/' . $urn->id . '/' . $string . '.svg'));
                $data = [
                    'storeID' => $user->magaza->id,
                    'menuItemID' => $idd,
                    'code' => $string,
                    'qrImageLink' => $svgLink,
                    'status' => 'will_print'
                ];
                KafeyinQrCode::create($data);
            }
            $prQrs = KafeyinQrCode::where('storeID', $user->magaza->id)->where('menuItemID', $idd)->where('status', 'will_print')->get();
            $data88 = [
                'prQrs' => $prQrs,
                'urun' => $urn,
                'store' => $user->magaza
            ];
            $pdf = PDF::loadView('store_user.qr_pdf', $data88)
                ->setOrientation("landscape")
                ->setOption('margin-top', 2)
                ->setOption('margin-bottom', 2)
                ->setOption('margin-right', 2)
                ->setOption('margin-left', 2)
                ->setPaper('a4')->output();
            $nowts = Carbon::now()->timestamp . $idd;
            $path88 = Storage::disk('public')->put('pdfs/' . $user->magaza->id . '/' . $nowts . '.pdf', $pdf);
            $pdfLink = url(Storage::url('pdfs/' . $user->magaza->id . '/' . $nowts . '.pdf'));

            $details = [
                'subject' => $urn->title . " için QR kodlar - " . Carbon::now()->format('d/m/Y H:i'),
                'user' => $user,
                'bodyText' => $urn->title . ' için oluşturulmuş 150 adet aktif QR kodu ekteki belgede mevcuttur.',
                'bodyText2' => "Herhangi bir sorun için 'destek@kafeyinapp.com' e-posta adresi üzerinden bizimle iletişime geçebilirsiniz.",
                'fileName' => $nowts,
                'filePath' => $pdfLink,
            ];

            User::find($user->id)->notify(new KafeyinQrPdfEmail($details));

            foreach ($prQrs as $qr) {
                if (strpos($qr->qrImageLink, "qrs") != false) {
                    $konum = strpos($qr->qrImageLink, "qrs");
                    $curFilePath = substr($qr->qrImageLink, $konum);
                    Storage::disk('public')->delete($curFilePath);
                }
                KafeyinQrCode::where('id', $qr->id)->first()->update(['status' => 'active']);
            }
            Storage::disk('public')->delete('pdfs/' . $user->magaza->id . '/' . $nowts . '.pdf');
            $this->writeStoreLog($user->magaza->id, $user->id, "URN" . $idd . " ID'li ürün için 150 adet QR kod oluşturuldu.", json_encode(['ip' => $request->ip()]));
        }

        return redirect()->back()->with([
            'multiQrSent' => true
        ]);
    }

    public function subcatadd(Request $request)
    {
        $cat = $request->catID;
        $kategoris = MenuItemCategory::where('id', '>', 0)->get();
        $catID = null;
        $catName = null;
        foreach ($kategoris as $kategori) {
            if ($cat == strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $kategori->desc)))) {
                $catID = $kategori->id;
                $catName = $kategori->desc;
            }
        }
        if (is_null($catID)) {
            return redirect('/yoneticipaneli/urunler');
        }
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->with('brand')->first();
        if (MenuItemSubCategory::where('brandID', $user->brand->id)->where('categoryID', $catID)->where('desc', $request->subCatName)->exists()) {
            return redirect()->back()->withErrors([
                'urn' => $request->subCatName . ", zaten " . $catName . " kategorisi için tanımlı."
            ]);
        }
        $data = [
            'brandID' => $user->brand->id,
            'categoryID' => $catID,
            'desc' => $request->subCatName
        ];
        MenuItemSubCategory::create($data);
        $this->writeBrandLog($user->magaza->id, $user->id, $request->subCatName . ", " . $catName . " kategorisine alt kategori olarak eklendi.", json_encode(['ip' => $request->ip()]));
        return redirect()->back()->with([
            'subCatAdd' => true
        ]);

    }

    public function magazam(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $isOnlineOrderEnabled = KafeyinBoolSetting::where('code', 'isOnlineOrderEnabled')->first()->value;
        $isTakeAwayOrderEnabled = KafeyinBoolSetting::where('code', 'isTakeAwayOrderEnabled')->first()->value;
        $isLocalDeliveryOrderEnabled = KafeyinBoolSetting::where('code', 'isLocalDeliveryOrderEnabled')->first()->value;
        $isLocalCargoOrderEnabled = KafeyinBoolSetting::where('code', 'isLocalCargoOrderEnabled')->first()->value;
        $isUpstateCargoOrderEnabled = KafeyinBoolSetting::where('code', 'isUpstateCargoOrderEnabled')->first()->value;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        return view('store_user.magazam')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'isOnlineOrderEnabled' => $isOnlineOrderEnabled,
            'isTakeAwayOrderEnabled' => $isTakeAwayOrderEnabled,
            'isLocalDeliveryOrderEnabled' => $isLocalDeliveryOrderEnabled,
            'isLocalCargoOrderEnabled' => $isLocalCargoOrderEnabled,
            'isUpstateCargoOrderEnabled' => $isUpstateCargoOrderEnabled,
        ]);
    }

    public function anketcevapla(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->first();
        $surID = $request->id;
        $ans = $request->answer;

        if (StoreSurveyAnswer::where('surveyID', $surID)->where('brandID', $user->brand->id)->doesntExist()) {
            $data = [
                'surveyID' => $surID,
                'brandID' => $user->brand->id,
                'answer' => $ans
            ];
            StoreSurveyAnswer::create($data);
        }
        return redirect()->back()->with([
            'surAns' => true
        ]);
    }

    public function bildirimlerokundu()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->first();
        if ($user->brand) {

            BrandNotification::where('brandID', $user->brand->id)->where('isSeen', false)->update([
                'isSeen' => true
            ]);
        }
        if ($user->magaza) {

            StoreNotification::where('storeID', $user->magaza->id)->where('isSeen', false)->update([
                'isSeen' => true
            ]);
        }
        return redirect()->back();
    }

    public function markamtekalt(Request $request)
    {
        $sub1 = $request->sub1;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        if ($hasBrand && !$hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        /*switch ($sub1){
            case "markabilgileri":
                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code','isPremiumPlanEnabled')->first()->value;
                return view('store_user.markabilgileri')->with([
                    'user'=>$user,
                    'hasBrand'=>$hasBrand,
                    'hasMagaza'=>$hasMagaza,
                    'isPremiumPlanEnabled'=>$isPremiumPlanEnabled,
                ]);
                break;
            default: return redirect('/yoneticipaneli/anasayfa');
        }*/
        return back();
    }

    public function markamciftalt(Request $request)
    {
        $sub1 = $request->sub1;
        $sub2 = $request->sub2;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        if ($hasBrand && !$hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        switch ($sub1) {
            case "basvuru":
                switch ($sub2) {
                    case "duyurubasvurulari":
                        $isAnnouncementApplicationEnabled = KafeyinBoolSetting::where('code', 'isAnnouncementApplicationEnabled')->first()->value;
                        $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                        $basvurus = AnnouncementApplication::where('brandID', $user->brand->id)->get();
                        $fBasvurus = AnnouncementApplication::where('brandID', $user->brand->id)->where('status', 'rejected')->orWhere(function ($query) use ($user) {
                            return $query->where('brandID', $user->brand->id)->where('status', 'approved');
                        })->get();
                        $ogBasvurus = AnnouncementApplication::where('brandID', $user->brand->id)->where('status', 'need_approval')->orWhere(function ($query) use ($user) {
                            return $query->where('brandID', $user->brand->id)->where('status', 'need_update');
                        })->get();
                        return view('store_user.duyurubasvurulari')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'isAnnouncementApplicationEnabled' => $isAnnouncementApplicationEnabled,
                            'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                            'basvurus' => $basvurus,
                            'fBasvurus' => $fBasvurus,
                            'ogBasvurus' => $ogBasvurus,
                        ]);
                        break;
                    default:
                        return redirect('/yoneticipaneli/anasayfa');
                }
                break;
            case "sadakatkartlari":
                switch ($sub2) {
                    case "aktif":
                        $cards = LoyaltyCard::where('brandID', $user->brand->id)->where('isDeleted', false)->where('status', 'active')->with('owner')->get();

                        $sod2 = Carbon::today()->startOfDay();
                        $eod2 = Carbon::today()->endOfDay();
                        $allCards = LoyaltyCard::where('brandID', $user->brand->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                        $l15days = array();
                        $l15dccs = array();
                        $k = 0;

                        while ($k < 15) {
                            $dayOfWeek = $eod2->subDays($k);
                            $dayOfWeek2 = $sod2->subDays($k);
                            $daysCreatedCardCount = $allCards->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();


                            array_push($l15dccs, $daysCreatedCardCount);
                            array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                            $eod2 = Carbon::now()->endOfDay();
                            $sod2 = Carbon::now()->startOfDay();
                            $k++;
                        }

                        $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                        $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                        return view('store_user.kartlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'type' => "aktif",
                            'cards' => $cards,
                            'l15dccs' => $l15dccs,
                            'l15days' => $l15days,
                            'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                            'isStatisticsFree' => $isStatisticsFree,
                        ]);
                        break;
                    case "kullanilabilir":
                        $cards = LoyaltyCard::where('brandID', $user->brand->id)->where('isDeleted', false)->where('status', 'available')->with('owner')->get();
                        return view('store_user.kartlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'type' => "kullanilabilir",
                            'cards' => $cards,
                        ]);
                        break;
                    case "kullanilan":
                        $cards = LoyaltyCard::where('brandID', $user->brand->id)->where('isDeleted', false)->where('status', 'used')->with('owner')->with('approver_store')->get();

                        $sod2 = Carbon::today()->startOfDay();
                        $eod2 = Carbon::today()->endOfDay();
                        $allCards = LoyaltyCard::where('brandID', $user->brand->id)->where('status', 'used')->where('updated_at', '>', Carbon::now()->subMonth())->get();
                        $l15days = array();
                        $l15ducs = array();
                        $k = 0;

                        while ($k < 15) {
                            $dayOfWeek = $eod2->subDays($k);
                            $dayOfWeek2 = $sod2->subDays($k);
                            $daysUsedCardCount = $allCards->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();

                            array_push($l15ducs, $daysUsedCardCount);
                            array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                            $eod2 = Carbon::now()->endOfDay();
                            $sod2 = Carbon::now()->startOfDay();
                            $k++;
                        }

                        $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                        $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                        return view('store_user.kartlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'type' => "kullanilan",
                            'cards' => $cards,
                            'l15days' => $l15days,
                            'l15ducs' => $l15ducs,
                            'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                            'isStatisticsFree' => $isStatisticsFree,
                        ]);
                        break;
                    default:
                        return redirect('/yoneticipaneli/anasayfa');
                }
                break;
            case "magazalar":
                $sub = $request->sub2;
                $aUser = Auth::user();
                $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
                $hasBrand = false;
                $hasMagaza = false;
                if ($user->brand) {
                    $hasBrand = true;
                }
                if ($user->magaza) {
                    $hasMagaza = true;
                }

                $sid = substr($sub, 4);
                if (!is_numeric($sid)) {
                    return redirect('/yoneticipaneli/anasayfa');
                }
                if (Store::where('id', $sid)->doesntExist()) {
                    return redirect('/yoneticipaneli/anasayfa');
                }
                if (Store::where('id', $sid)->first()->brandID != $user->brand->id) {
                    return redirect('/yoneticipaneli/anasayfa');
                }
                if ($sid == $user->magaza->id) {
                    return redirect('/yoneticipaneli/anasayfa');
                }
                $store = Store::where('id', $sid)->first();

                $sod = Carbon::today()->startOfDay();
                $sto = $store;
                $lastFiveStoreComments = StoreComment::where('storeID', $sto->id)->with('photos')->with('commenter')->withCount('likes')->orderByDesc('created_at')->limit(5)->get();
                $tdViewCount = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdFavCount = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdComCount = StoreComment::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
                $tdSearchCount = LastSearchedStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();

                $sod2 = Carbon::today()->startOfDay();
                $eod2 = Carbon::today()->endOfDay();
                $views = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $favs = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $coms = StoreComment::where('storeID', $sto->id)->get();
                $usedqs = KafeyinQrCode::where('storeID', $sto->id)->where('status', 'used')->where('updated_at', '>', Carbon::now()->subMonth())->get();

                // start of views via city
                $viewsForCity = StoreViewLog::where('storeID', $sto->id)
                    ->with('viewer')
                    ->get()
                    ->groupBy('viewer.city')
                    ->toArray();
                $cityLabels = array_keys($viewsForCity);
                $viewsByCity = array();
                foreach ($cityLabels as $cityLabel) {
                    $push = [
                        'city' => $cityLabel,
                        'count' => count($viewsForCity[$cityLabel])
                    ];
                    array_push($viewsByCity, $push);
                }
                $count = array();
                foreach ($viewsByCity as $key => $row) {
                    $count[$key] = $row['count'];
                }
                array_multisort($count, SORT_DESC, $viewsByCity);
                $viewsByCity = array_slice($viewsByCity, 0, 5);
                // end of views via city

                // start of favs via city
                $favsForCity = FavoriteStore::where('storeID', $sto->id)
                    ->with('user')
                    ->get()
                    ->groupBy('user.city')
                    ->toArray();
                $cityLabels2 = array_keys($favsForCity);
                $favsByCity = array();
                foreach ($cityLabels2 as $cityLabel2) {
                    $push = [
                        'city' => $cityLabel2,
                        'count' => count($favsForCity[$cityLabel2])
                    ];
                    array_push($favsByCity, $push);
                }
                $count2 = array();
                foreach ($favsByCity as $key => $row) {
                    $count2[$key] = $row['count'];
                }
                array_multisort($count2, SORT_DESC, $favsByCity);
                $favsByCity = array_slice($favsByCity, 0, 3);

                $l15days = array();
                $l15dvs = array();
                $l15dfs = array();
                $l15daps = array();
                $l15duqs = array();
                $k = 0;
                while ($k < 15) {
                    $dayOfWeek = $eod2->subDays($k);
                    $dayOfWeek2 = $sod2->subDays($k);
                    $daysViewCount = $views->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                    $daysFavCount = $favs->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
                    $daysUQrsCount = $usedqs->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();

                    $coms2 = $coms->where('created_at', '<=', $dayOfWeek->toDateTimeString());
                    if (count($coms2) == 0) {
                        array_push($l15daps, 0);
                    } else {
                        $tp = 0;
                        $cc = 0;
                        foreach ($coms2 as $item) {
                            $tp = $tp + $item->commentPoint;
                            $cc = $cc + 1;
                        }
                        array_push($l15daps, round(($tp / $cc), 1));
                    }


                    array_push($l15dvs, $daysViewCount);
                    array_push($l15dfs, $daysFavCount);
                    array_push($l15duqs, $daysUQrsCount);
                    array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                    $eod2 = Carbon::now()->endOfDay();
                    $sod2 = Carbon::now()->startOfDay();
                    $k++;
                }

                $cities = City::where('id', '>', 0)->get();
                $kafeyinNews = KafeyinNews::where('cityID', $sto->cityID)->orderByDesc('created_at')->get();
                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                $survey = StoreSurvey::where('type', '88')->where('isActive', true)->whereDoesntHave('answers', function ($query) use ($sto) {
                    return $query->where('brandID', $sto->brand->id);
                })->orWhere(function ($q) use ($sto) {
                    return $q->where('type', $sto->cityID)->where('isActive', true)->whereDoesntHave('answers', function ($q1) use ($sto) {
                        return $q1->where('brandID', $sto->brand->id);
                    });
                })->orderByDesc('created_at')->first();

                $mvItems = MenuItem::where('storeID', $sto->id)->withCount('views')->whereHas('views')->with('category')->with('subcategory')->orderByDesc('views_count')->limit(5)->get();
                $mquItems = MenuItem::where('storeId', $sto->id)->whereHas('u_qrcodes')->withCount('u_qrcodes')->orderByDesc('u_qrcodes_count')->limit(5)->get();
                $announces = Announcement::where('brandID', $sto->brand->id)->where('isActive', true)->with('city')->get();

                return view('store_user.magazadetay2')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'tdViewCount' => $tdViewCount,
                    'tdFavCount' => $tdFavCount,
                    'tdComCount' => $tdComCount,
                    'tdSearchCount' => $tdSearchCount,
                    'l15days' => $l15days,
                    'l15dvs' => $l15dvs,
                    'l15dfs' => $l15dfs,
                    'l15daps' => $l15daps,
                    'viewsByCity' => $viewsByCity,
                    'favsByCity' => $favsByCity,
                    'cities' => $cities,
                    'kafeyinNews' => $kafeyinNews,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'isStatisticsFree' => $isStatisticsFree,
                    'survey' => $survey,
                    'mvItems' => $mvItems,
                    'lastFiveStoreComments' => $lastFiveStoreComments,
                    'l15duqs' => $l15duqs,
                    'mquItems' => $mquItems,
                    'announces' => $announces,
                    'store' => $store
                ]);
                break;
            default:
                return redirect('/yoneticipaneli/anasayfa');
        }


    }

    public function dbasvuruguncelle(Request $request)
    {
        $dbID = $request->dbID;
        $crID = substr($dbID, 6);
        $id = $crID - KafeyinStringSetting::where('code', 'announcementApplicationIDAddition')->first()->value;
        $bas = AnnouncementApplication::where('id', $id)->first();
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $curImageLink = $bas->imageLink;

            if (strpos($curImageLink, "announcement_application_images") != false) {
                $konum = strpos($curImageLink, "announcement_application_images");
                $curFilePath = substr($curImageLink, $konum);
                Storage::disk('public')->delete($curFilePath);
            }

            $path = Storage::disk('public')->put('announcement_application_images', $image);
            $imageLink = url(Storage::url($path));

            AnnouncementApplication::where('id', $id)->first()->update([
                'imageLink' => $imageLink
            ]);

        }
        AnnouncementApplication::where('id', $id)->first()->update([
            'title' => $request->title,
            'desc' => $request->desc,
            'status' => 'need_approval'
        ]);

        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->with('brand')->first();

        $this->writeBrandLog($user->magaza->id, $user->id, $dbID . " ID'li duyuru başvurusu güncellendi.", json_encode(['ip' => $request->ip()]));

        return redirect()->back()->with([
            'applUp' => true
        ]);
    }

    public function canceldbasvuru(Request $request)
    {
        $id = $request->id;
        $imageLink = AnnouncementApplication::where('id', $id)->first()->imageLink;
        if (strpos($imageLink, "announcement_application_images") != false) {
            $konum = strpos($imageLink, "announcement_application_images");
            $curFilePath = substr($imageLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        AnnouncementApplication::where('id', $id)->first()->delete();

        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('magaza')->with('brand')->first();

        $addition = KafeyinStringSetting::where('code', 'announcementApplicationIDAddition')->first()->value;
        $dbID = $addition + $id;

        $this->writeBrandLog($user->magaza->id, $user->id, "DYRBSVR" . $dbID . " ID'li duyuru başvurusu iptal edildi.", json_encode(['ip' => $request->ip()]));

        return redirect()->back()->with([
            'dBasDel' => true
        ]);
    }

    public function dbasvuruekle(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->first();
        $image = $request->file('image');
        $path = Storage::disk('public')->put('announcement_application_images', $image);
        $imageLink = url(Storage::url($path));
        $data = [
            'brandID' => $user->brand->id,
            'title' => $request->title,
            'desc' => $request->desc,
            'imageLink' => $imageLink,
            'status' => 'need_approval'
        ];
        $created = AnnouncementApplication::create($data);

        $addition = KafeyinStringSetting::where('code', 'announcementApplicationIDAddition')->first()->value;
        $dbID = $addition + $created->id;

        $this->writeBrandLog($user->magaza->id, $user->id, "DYRBSVR" . $dbID . " ID'li duyuru başvurusu gönderildi.", json_encode(['ip' => $request->ip()]));

        return redirect()->back()->with([
            'addAppl' => true
        ]);
    }

    public function kartonayla(Request $request)
    {
        if (strlen($request->referralCode) != 8) {
            return redirect()->back()->withErrors([
                'hata' => "Girdiğiniz referans kodu 8 karakterli olmalıdır."
            ]);
        }
        if (LoyaltyCardApproval::where('referralCode', $request->referralCode)->doesntExist()) {
            return redirect()->back()->withErrors([
                'hata' => 'Girdiğiniz referans kodu sistemlerimizde kayıtlı değil.',
            ]);
        }
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->first();
        $approval = LoyaltyCardApproval::where('referralCode', $request->referralCode)->first();
        if ($approval->card->brandID != $user->magaza->brand->id) {
            return redirect()->back()->withErrors([
                'hata' => 'Girdiğiniz referans kodu, markanıza ait olmayan bir kart için tanımlı.',
            ]);
        }
        LoyaltyCard::where('id', $approval->cardID)->first()->update([
            'status' => 'used',
            'approverStoreID' => $user->magaza->id
        ]);
        LoyaltyCardApproval::where('referralCode', $request->referralCode)->first()->delete();
        //TODO:: fcm push message to card owner
        $fav = FavoriteStore::where('userID', $approval->userID)->exists() ? true : false;
        return redirect()->back()->with([
            'appr' => true,
            'cardownerfav' => $fav
        ]);
    }

    public function hesabim()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        $storeLogs = array();
        $brandLogs = array();
        if ($user->brand) {
            $hasBrand = true;
            $brandLogs = BrandLog::where('brandID', $user->brand->id)->get();
        }
        if ($user->magaza) {
            $hasMagaza = true;
            $storeLogs = StoreLog::where('storeID', $user->magaza->id)->get();
        }

        $logs = UserLog::where('userID', $user->id)->where('created_at', '>=', Carbon::now()->subMonth())->orderByDesc('created_at')->get();


        return view('store_user.hesabim')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'logs' => $logs,
            'storeLogs' => $storeLogs,
            'brandLogs' => $brandLogs,
        ]);

    }

    public function getcounties(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = AddressCounty::where('cityID', $search)->get();
        }
        return response()->json($data);
    }

    public function getdistricts(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = AddressDistrict::where('countyID', $search)->get();
        }
        return response()->json($data);
    }

    public function getneighborhoods(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = AddressNeighborhood::where('districtID', $search)->get();
        }
        return response()->json($data);
    }

    public function addresschange(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->first();
        $data = [
            'userID' => $user->id,
            'name' => "Sistem",
            'gsmNumber' => $user->gsmNumber,
            'cityID' => $request->cityID,
            'countyID' => $request->countyID,
            'districtID' => $request->districtID,
            'neighborhoodID' => $request->neighborhoodID,
            'avenueStreet' => $request->avenueStreet,
            'buildingApartmentNo' => $request->buildingNo . "/" . $request->apartmentNo,
        ];

        if (UserAddress::where('userID', $user->id)->exists()) {
            UserAddress::where('userID', $user->id)->delete();
        }

        UserAddress::create($data);
        return redirect()->back()->with([
            'addrUp' => true
        ]);
    }

    public function ppchange(Request $request)
    {
        if (!$request->hasFile('image')) {
            return redirect()->back()->withErrors([
                'hata' => "Lütfen yeni profil fotoğrafınızı seçerek tekrar deneyiniz."
            ]);
        }
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->first();
        $image = $request->file('image');
        $curAvatarLink = User::where('id', $user->id)->first()->avatar;
        if (strpos($curAvatarLink, "user_avatars") != false) {
            $konum = strpos($curAvatarLink, "user_avatars");
            $curFilePath = substr($curAvatarLink, $konum);
            Storage::disk('public')->delete($curFilePath);
        }
        $path = Storage::disk('public')->put('user_avatars/' . $user->id, $image);
        $imageLink = url(Storage::url($path));

        User::where('id', $user->id)->first()->update([
            'avatar' => $imageLink
        ]);

        $detail = [
            'ip' => $request->ip(),
        ];
        $data = [
            'userID' => $user->id,
            'desc' => "Profil fotoğrafınız başarıyla güncellendi.",
            'detail' => json_encode($detail)
        ];
        UserLog::create($data);
        return redirect()->back()->with([
            'ppUp' => true
        ]);

    }

    public function passchange(Request $request)
    {


        $request->validate([
            'password' => 'required|confirmed|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
        ]);

        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->first();
        if (Hash::check($request->curpass, User::where('id', $user->id)->first()->password)) {
            User::where('id', $user->id)->first()->update([
                'password' => Hash::make($request->password)
            ]);
            $detail = [
                'ip' => $request->ip()
            ];
            $data = [
                'userID' => $user->id,
                'desc' => "Şifreniz başarıyla güncellendi.",
                'detail' => json_encode($detail)
            ];
            UserLog::create($data);
            return redirect()->back()->with([
                'passUp' => true
            ]);
        } else {
            return redirect()->back()->withErrors([
                'hata' => "Girdiğiniz güncel şifre bilgisi sistemlerimizdeki kayıtlar ile uyuşmuyor."
            ]);
        }
    }

    public function gsmchange(Request $request)
    {
        $inpGsm = str_replace(['_', ' '], '', $request->gsm);
        if (Str::length($inpGsm) != 10) {
            return redirect()->back()->withErrors([
                'hata' => 'Lütfen geçerli bir GSM numarası girerek tekrar deneyiniz.'
            ]);
        }
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->first();
        $oldGSM = User::where('id', $user->id)->first()->gsmNumber;
        User::where('id', $user->id)->first()->update([
            'gsmNumber' => $inpGsm
        ]);

        $detail = [
            'ip' => $request->ip(),
            'oldGSM' => $oldGSM
        ];

        $data = [
            'userID' => $user->id,
            'desc' => "GSM numaranız başarıyla güncellendi.",
            'detail' => json_encode($detail)
        ];

        UserLog::create($data);


        return redirect()->back()->with([
            'gsmUp' => true
        ]);
    }

    public function basvurualt(Request $request)
    {
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if ($hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }

        switch ($sub) {
            case "duyurubasvurulari":
                $isAnnouncementApplicationEnabled = KafeyinBoolSetting::where('code', 'isAnnouncementApplicationEnabled')->first()->value;
                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $basvurus = AnnouncementApplication::where('brandID', $user->brand->id)->get();
                $fBasvurus = AnnouncementApplication::where('brandID', $user->brand->id)->where('status', 'rejected')->orWhere(function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id)->where('status', 'approved');
                })->get();
                $ogBasvurus = AnnouncementApplication::where('brandID', $user->brand->id)->where('status', 'need_approval')->orWhere(function ($query) use ($user) {
                    return $query->where('brandID', $user->brand->id)->where('status', 'need_update');
                })->get();
                return view('store_user.duyurubasvurulari')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'isAnnouncementApplicationEnabled' => $isAnnouncementApplicationEnabled,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'basvurus' => $basvurus,
                    'fBasvurus' => $fBasvurus,
                    'ogBasvurus' => $ogBasvurus,
                ]);
                break;
            default:
                return redirect('/yoneticipaneli/anasayfa');
        }

    }

    public function kartlaralt(Request $request)
    {
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if ($hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }

        switch ($sub) {
            case "aktif":
                $cards = LoyaltyCard::where('brandID', $user->brand->id)->where('isDeleted', false)->where('status', 'active')->with('owner')->get();

                $sod2 = Carbon::today()->startOfDay();
                $eod2 = Carbon::today()->endOfDay();
                $allCards = LoyaltyCard::where('brandID', $user->brand->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
                $l15days = array();
                $l15dccs = array();
                $k = 0;

                while ($k < 15) {
                    $dayOfWeek = $eod2->subDays($k);
                    $dayOfWeek2 = $sod2->subDays($k);
                    $daysCreatedCardCount = $allCards->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();


                    array_push($l15dccs, $daysCreatedCardCount);
                    array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                    $eod2 = Carbon::now()->endOfDay();
                    $sod2 = Carbon::now()->startOfDay();
                    $k++;
                }

                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                return view('store_user.kartlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'type' => "aktif",
                    'cards' => $cards,
                    'l15dccs' => $l15dccs,
                    'l15days' => $l15days,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'isStatisticsFree' => $isStatisticsFree,
                ]);
                break;
            case "kullanilabilir":
                $cards = LoyaltyCard::where('brandID', $user->brand->id)->where('isDeleted', false)->where('status', 'available')->with('owner')->get();
                return view('store_user.kartlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'type' => "kullanilabilir",
                    'cards' => $cards,
                ]);
                break;
            case "kullanilan":
                $cards = LoyaltyCard::where('brandID', $user->brand->id)->where('isDeleted', false)->where('status', 'used')->with('owner')->with('approver_store')->get();

                $sod2 = Carbon::today()->startOfDay();
                $eod2 = Carbon::today()->endOfDay();
                $allCards = LoyaltyCard::where('brandID', $user->brand->id)->where('status', 'used')->where('updated_at', '>', Carbon::now()->subMonth())->get();
                $l15days = array();
                $l15ducs = array();
                $k = 0;

                while ($k < 15) {
                    $dayOfWeek = $eod2->subDays($k);
                    $dayOfWeek2 = $sod2->subDays($k);
                    $daysUsedCardCount = $allCards->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();

                    array_push($l15ducs, $daysUsedCardCount);
                    array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
                    $eod2 = Carbon::now()->endOfDay();
                    $sod2 = Carbon::now()->startOfDay();
                    $k++;
                }

                $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

                return view('store_user.kartlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'type' => "kullanilan",
                    'cards' => $cards,
                    'l15days' => $l15days,
                    'l15ducs' => $l15ducs,
                    'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
                    'isStatisticsFree' => $isStatisticsFree,
                ]);
                break;
            default:
                return redirect('/yoneticipaneli/anasayfa');
        }
    }

    public function magazalaralt(Request $request)
    {
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if ($hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }

        $sid = substr($sub, 4);
        if (!is_numeric($sid)) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->doesntExist()) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->first()->brandID != $user->brand->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        $store = Store::where('id', $sid)->first();


        $sod = Carbon::today()->startOfDay();
        $sto = $store;
        $lastFiveStoreComments = StoreComment::where('storeID', $sto->id)->with('photos')->with('commenter')->withCount('likes')->orderByDesc('created_at')->limit(5)->get();
        $tdViewCount = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
        $tdFavCount = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
        $tdComCount = StoreComment::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();
        $tdSearchCount = LastSearchedStore::where('storeID', $sto->id)->where('created_at', '>=', $sod)->count();

        $sod2 = Carbon::today()->startOfDay();
        $eod2 = Carbon::today()->endOfDay();
        $views = StoreViewLog::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
        $favs = FavoriteStore::where('storeID', $sto->id)->where('created_at', '>', Carbon::now()->subMonth())->get();
        $coms = StoreComment::where('storeID', $sto->id)->get();
        $usedqs = KafeyinQrCode::where('storeID', $sto->id)->where('status', 'used')->where('updated_at', '>', Carbon::now()->subMonth())->get();

        // start of views via city
        $viewsForCity = StoreViewLog::where('storeID', $sto->id)
            ->with('viewer')
            ->get()
            ->groupBy('viewer.city')
            ->toArray();
        $cityLabels = array_keys($viewsForCity);
        $viewsByCity = array();
        foreach ($cityLabels as $cityLabel) {
            $push = [
                'city' => $cityLabel,
                'count' => count($viewsForCity[$cityLabel])
            ];
            array_push($viewsByCity, $push);
        }
        $count = array();
        foreach ($viewsByCity as $key => $row) {
            $count[$key] = $row['count'];
        }
        array_multisort($count, SORT_DESC, $viewsByCity);
        $viewsByCity = array_slice($viewsByCity, 0, 5);
        // end of views via city

        // start of favs via city
        $favsForCity = FavoriteStore::where('storeID', $sto->id)
            ->with('user')
            ->get()
            ->groupBy('user.city')
            ->toArray();
        $cityLabels2 = array_keys($favsForCity);
        $favsByCity = array();
        foreach ($cityLabels2 as $cityLabel2) {
            $push = [
                'city' => $cityLabel2,
                'count' => count($favsForCity[$cityLabel2])
            ];
            array_push($favsByCity, $push);
        }
        $count2 = array();
        foreach ($favsByCity as $key => $row) {
            $count2[$key] = $row['count'];
        }
        array_multisort($count2, SORT_DESC, $favsByCity);
        $favsByCity = array_slice($favsByCity, 0, 3);

        $l15days = array();
        $l15dvs = array();
        $l15dfs = array();
        $l15daps = array();
        $l15duqs = array();
        $k = 0;
        while ($k < 15) {
            $dayOfWeek = $eod2->subDays($k);
            $dayOfWeek2 = $sod2->subDays($k);
            $daysViewCount = $views->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
            $daysFavCount = $favs->where('created_at', '<=', $dayOfWeek->toDateTimeString())->where('created_at', '>=', $dayOfWeek2->toDateTimeString())->count();
            $daysUQrsCount = $usedqs->where('updated_at', '<=', $dayOfWeek->toDateTimeString())->where('updated_at', '>=', $dayOfWeek2->toDateTimeString())->count();

            $coms2 = $coms->where('created_at', '<=', $dayOfWeek->toDateTimeString());
            if (count($coms2) == 0) {
                array_push($l15daps, 0);
            } else {
                $tp = 0;
                $cc = 0;
                foreach ($coms2 as $item) {
                    $tp = $tp + $item->commentPoint;
                    $cc = $cc + 1;
                }
                array_push($l15daps, round(($tp / $cc), 1));
            }


            array_push($l15dvs, $daysViewCount);
            array_push($l15dfs, $daysFavCount);
            array_push($l15duqs, $daysUQrsCount);
            array_push($l15days, $dayOfWeek->subMonths(1)->format('Y,m,d'));
            $eod2 = Carbon::now()->endOfDay();
            $sod2 = Carbon::now()->startOfDay();
            $k++;
        }

        $cities = City::where('id', '>', 0)->get();
        $kafeyinNews = KafeyinNews::where('cityID', $sto->cityID)->orderByDesc('created_at')->get();
        $isPremiumPlanEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
        $isStatisticsFree = KafeyinBoolSetting::where('code', 'isStatisticsFree')->first()->value;

        $survey = StoreSurvey::where('type', '88')->where('isActive', true)->whereDoesntHave('answers', function ($query) use ($sto) {
            return $query->where('brandID', $sto->brand->id);
        })->orWhere(function ($q) use ($sto) {
            return $q->where('type', $sto->cityID)->where('isActive', true)->whereDoesntHave('answers', function ($q1) use ($sto) {
                return $q1->where('brandID', $sto->brand->id);
            });
        })->orderByDesc('created_at')->first();

        $mvItems = MenuItem::where('storeID', $sto->id)->withCount('views')->whereHas('views')->with('category')->with('subcategory')->orderByDesc('views_count')->limit(5)->get();
        $mquItems = MenuItem::where('storeId', $sto->id)->whereHas('u_qrcodes')->withCount('u_qrcodes')->orderByDesc('u_qrcodes_count')->limit(5)->get();
        $announces = Announcement::where('brandID', $sto->brand->id)->where('isActive', true)->with('city')->get();

        return view('store_user.magazadetay')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'tdViewCount' => $tdViewCount,
            'tdFavCount' => $tdFavCount,
            'tdComCount' => $tdComCount,
            'tdSearchCount' => $tdSearchCount,
            'l15days' => $l15days,
            'l15dvs' => $l15dvs,
            'l15dfs' => $l15dfs,
            'l15daps' => $l15daps,
            'viewsByCity' => $viewsByCity,
            'favsByCity' => $favsByCity,
            'cities' => $cities,
            'kafeyinNews' => $kafeyinNews,
            'isPremiumPlanEnabled' => $isPremiumPlanEnabled,
            'isStatisticsFree' => $isStatisticsFree,
            'survey' => $survey,
            'mvItems' => $mvItems,
            'lastFiveStoreComments' => $lastFiveStoreComments,
            'l15duqs' => $l15duqs,
            'mquItems' => $mquItems,
            'announces' => $announces,
            'store' => $store
        ]);
    }

    public function magazaalt(Request $request)
    {
        $id = $request->id;
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }


        $sid = substr($id, 4);
        if (!is_numeric($sid)) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->doesntExist()) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->first()->brandID != $user->brand->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if ($sid == $user->magaza->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        $store = Store::where('id', $sid)->first();
        switch ($sub) {
            case "yorumlar":
                $sort = $request->sort;
                if ($sort == null) {
                    $sort = "-created_at";
                }
                switch ($sort) {
                    case "-created_at":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderByDesc('created_at')
                            ->paginate(6)->withPath('?sort=-created_at');
                        return view('store_user.buser_yorumlar2')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "created_at":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderBy('created_at')
                            ->paginate(6)->withPath('?sort=created_at');
                        return view('store_user.buser_yorumlar2')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "-points":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderByDesc('commentPoint')
                            ->paginate(6)->withPath('?sort=-points');
                        return view('store_user.buser_yorumlar2')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "points":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderBy('commentPoint')
                            ->paginate(6)->withPath('?sort=points');
                        return view('store_user.buser_yorumlar2')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "likes_count":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderByDesc('likes_count')
                            ->paginate(6)->withPath('?sort=likes_count');
                        return view('store_user.buser_yorumlar2')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    default:
                        return redirect('/yoneticipaneli/markam/magazalar/KFYN' . $sid . '/yorumlar?sort=-created_at');
                        break;
                }
                break;
            case "paylasimlar":
                $isPremiumEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $aktifPaylasims = KafeyinStory::where('isActive', true)->where('storeID', $sid)->get();
                $pasifPaylasims = KafeyinStory::where('isActive', false)->where('storeID', $sid)->get();
                return view('store_user.buser_paylasimlar2')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'aktifPaylasims' => $aktifPaylasims,
                    'pasifPaylasims' => $pasifPaylasims,
                    'isPremiumEnabled' => $isPremiumEnabled,
                    'store' => $store,
                ]);
                break;
            case "yazilar":
                $aktifYazis = Article::where('isActive', true)->where('storeID', $sid)->withCount('favorites')->get();
                $pasifYazis = Article::where('isActive', false)->where('storeID', $sid)->withCount('favorites')->get();
                return view('store_user.buser_yazilar2')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'aktifYazis' => $aktifYazis,
                    'pasifYazis' => $pasifYazis,
                    'store' => $store,
                ]);
                break;
            case "etkinlikler":
                $aktifEtkinliks = Activity::where('isActive', true)->where('storeID', $sid)->withCount('favorites')->get();
                $pasifEtkinliks = Activity::where('isActive', false)->where('storeID', $sid)->withCount('favorites')->get();
                return view('store_user.buser_etkinlikler2')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'aktifEtkinliks' => $aktifEtkinliks,
                    'pasifEtkinliks' => $pasifEtkinliks,
                    'store' => $store,
                ]);
                break;
            case "urunler":
                $kategoris = MenuItemCategory::with(['subcategories' => function ($query) use ($store) {
                    return $query->where('brandID', $store->brand->id);
                }])
                    ->with(['subcategories.items' => function ($query) use ($store) {
                        return $query->where('storeID', $store->id);
                    }])
                    ->get();
                $uruns = MenuItem::where('storeID', $store->id)
                    ->with('category')
                    ->with('subcategory')
                    ->get();
                return view('store_user.buser_urunler2')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'kategoris' => $kategoris,
                    'uruns' => $uruns,
                    'store' => $store,
                ]);
                break;
            default:
                return redirect('/yoneticipaneli/anasayfa');
                break;
        }
    }

    public function magazaurunalt(Request $request)
    {
        $id = $request->id;
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        $sid = substr($id, 4);
        if (!is_numeric($sid)) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->doesntExist()) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->first()->brandID != $user->brand->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if ($sid == $user->magaza->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        $store = Store::where('id', $sid)->first();

        $kategoris = MenuItemCategory::where('id', '>', 0)->get();
        $catID = null;
        foreach ($kategoris as $kategori) {
            if ($sub == strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $kategori->desc)))) {
                $catID = $kategori->id;
            }
        }
        if (is_null($catID)) {
            return redirect('/yoneticipaneli/markam/magazalar/KFYN' . $store->id . "/urunler");
        }
        $uruns = MenuItem::where('storeID', $store->id)
            ->where('categoryID', $catID)
            ->with('category')
            ->with('subcategory')
            ->withCount('views')
            ->get();
        $altKategoris = MenuItemSubCategory::where('brandID', $user->brand->id)->where('categoryID', $catID)->get();
        $kategori1 = MenuItemCategory::where('id', $catID)->first();
        return view('store_user.buser_kategoriurunleri2')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'kategoris' => $kategoris,
            'uruns' => $uruns,
            'altKategoris' => $altKategoris,
            'kategori1' => $kategori1,
            'store' => $store,
        ]);
    }

    public function magazalarciftalt(Request $request)
    {
        $id = $request->id;
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if ($hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }

        $sid = substr($id, 4);
        if (!is_numeric($sid)) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->doesntExist()) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->first()->brandID != $user->brand->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        $store = Store::where('id', $sid)->first();

        switch ($sub) {
            case "yorumlar":
                $sort = $request->sort;
                if ($sort == null) {
                    $sort = "-created_at";
                }
                switch ($sort) {
                    case "-created_at":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderByDesc('created_at')
                            ->paginate(6)->withPath('?sort=-created_at');
                        return view('store_user.buser_yorumlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "created_at":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderBy('created_at')
                            ->paginate(6)->withPath('?sort=created_at');
                        return view('store_user.buser_yorumlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "-points":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderByDesc('commentPoint')
                            ->paginate(6)->withPath('?sort=-points');
                        return view('store_user.buser_yorumlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "points":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderBy('commentPoint')
                            ->paginate(6)->withPath('?sort=points');
                        return view('store_user.buser_yorumlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    case "likes_count":
                        $yorumCount = StoreComment::where('storeID', $sid)->count();
                        $fotoCount = StoreCommentPhoto::where('storeID', $sid)->count();
                        $yorums = StoreComment::where('storeID', $sid)
                            ->with('photos')
                            ->with('commenter')
                            ->withCount('likes')
                            ->orderByDesc('likes_count')
                            ->paginate(6)->withPath('?sort=likes_count');
                        return view('store_user.buser_yorumlar')->with([
                            'user' => $user,
                            'hasBrand' => $hasBrand,
                            'hasMagaza' => $hasMagaza,
                            'yorums' => $yorums,
                            'yorumCount' => $yorumCount,
                            'fotoCount' => $fotoCount,
                            'store' => $store,
                        ]);
                        break;
                    default:
                        return redirect('/yoneticipaneli/magazalar/KFYN' . $sid . '/yorumlar?sort=-created_at');
                        break;
                }
                break;
            case "paylasimlar":
                $isPremiumEnabled = KafeyinBoolSetting::where('code', 'isPremiumPlanEnabled')->first()->value;
                $aktifPaylasims = KafeyinStory::where('isActive', true)->where('storeID', $sid)->get();
                $pasifPaylasims = KafeyinStory::where('isActive', false)->where('storeID', $sid)->get();
                return view('store_user.buser_paylasimlar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'aktifPaylasims' => $aktifPaylasims,
                    'pasifPaylasims' => $pasifPaylasims,
                    'isPremiumEnabled' => $isPremiumEnabled,
                    'store' => $store,
                ]);
                break;
            case "yazilar":
                $aktifYazis = Article::where('isActive', true)->where('storeID', $sid)->withCount('favorites')->get();
                $pasifYazis = Article::where('isActive', false)->where('storeID', $sid)->withCount('favorites')->get();
                return view('store_user.buser_yazilar')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'aktifYazis' => $aktifYazis,
                    'pasifYazis' => $pasifYazis,
                    'store' => $store,
                ]);
                break;
            case "etkinlikler":
                $aktifEtkinliks = Activity::where('isActive', true)->where('storeID', $sid)->withCount('favorites')->get();
                $pasifEtkinliks = Activity::where('isActive', false)->where('storeID', $sid)->withCount('favorites')->get();
                return view('store_user.buser_etkinlikler')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'aktifEtkinliks' => $aktifEtkinliks,
                    'pasifEtkinliks' => $pasifEtkinliks,
                    'store' => $store,
                ]);
                break;
            case "urunler":
                $kategoris = MenuItemCategory::with(['subcategories' => function ($query) use ($store) {
                    return $query->where('brandID', $store->brand->id);
                }])
                    ->with(['subcategories.items' => function ($query) use ($store) {
                        return $query->where('storeID', $store->id);
                    }])
                    ->get();
                $uruns = MenuItem::where('storeID', $store->id)
                    ->with('category')
                    ->with('subcategory')
                    ->get();
                return view('store_user.buser_urunler')->with([
                    'user' => $user,
                    'hasBrand' => $hasBrand,
                    'hasMagaza' => $hasMagaza,
                    'kategoris' => $kategoris,
                    'uruns' => $uruns,
                    'store' => $store,
                ]);
                break;
            default:
                return redirect('/yoneticipaneli/anasayfa');
                break;
        }
    }

    public function magazaurunleri(Request $request)
    {
        $id = $request->id;
        $sub = $request->sub;
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if ($hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }

        $sid = substr($id, 4);
        if (!is_numeric($sid)) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->doesntExist()) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        if (Store::where('id', $sid)->first()->brandID != $user->brand->id) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        $store = Store::where('id', $sid)->first();

        $kategoris = MenuItemCategory::where('id', '>', 0)->get();
        $catID = null;
        foreach ($kategoris as $kategori) {
            if ($sub == strtolower(transliterator_transliterate('Any-Latin; Latin-ASCII', str_replace(' ', '', $kategori->desc)))) {
                $catID = $kategori->id;
            }
        }
        if (is_null($catID)) {
            return redirect('/yoneticipaneli/magazalar/KFYN' . $store->id . "/urunler");
        }
        $uruns = MenuItem::where('storeID', $store->id)
            ->where('categoryID', $catID)
            ->with('category')
            ->with('subcategory')
            ->withCount('views')
            ->get();
        $altKategoris = MenuItemSubCategory::where('brandID', $user->brand->id)->where('categoryID', $catID)->get();
        $kategori1 = MenuItemCategory::where('id', $catID)->first();
        return view('store_user.buser_kategoriurunleri')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'kategoris' => $kategoris,
            'uruns' => $uruns,
            'altKategoris' => $altKategoris,
            'kategori1' => $kategori1,
            'store' => $store,
        ]);
    }

    public function urunaltkategorileri(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if ($hasMagaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }

        $categories = MenuItemCategory::where('id', '>', 0)->with('subcategories', function ($query) use ($user) {
            return $query->where('brandID', $user->brand->id);
        })->orderBy('position')->get();


        return view('store_user.buser_kategoriler')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'categories' => $categories,
        ]);

    }

    public function altkategoriekle(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();

        $catID = $request->catID;
        $subCatName = $request->subCatName;
        $cat = MenuItemCategory::where('id', $catID)->first();

        $data = [
            'brandID' => $user->brand->id,
            'categoryID' => $catID,
            'desc' => $subCatName
        ];

        MenuItemSubCategory::create($data);
        return redirect()->back()->with([
            'subCatAdd' => true,
            'catName' => $cat->desc,
            'newSCatName' => $subCatName
        ]);
    }

    public function bilgibankasi(Request $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->with('magaza.kafeyin_photos')->first();
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        $items = KnowledgeBaseItem::where('isActive', true)->get()->groupBy('category');

        return view('store_user.bilgi_bankasi')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'items' => $items
        ]);
    }

    public function destek()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();
        $hasBrand = false;
        $hasMagaza = false;

        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }

        if (!$user->brand && !$user->magaza) {
            return redirect('/gateway');
        }

        $tickets = SupportTicket::where('userID', $user->id)->orderByDesc('created_at')->paginate(6);

        return view('store_user.destek')->with([
            'user' => $user,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'tickets' => $tickets,
        ]);

    }

    public function destektalebigonder(Request  $request)
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->with('magaza.brand')->first();

        $data = [
            'userID'=>$user->id,
            'topic'=>$request->topic,
            'userMessage'=>$request->userMessage
        ];

        SupportTicket::create($data);
        return redirect()->back()->with([
            'ticketSent'=>true
        ]);
    }

    public function answerseen(Request  $request)
    {
        $id = $request->id;
        SupportTicket::where('id',$id)->first()->update([
            'isAnswerSeen'=>true
        ]);
        return null;
    }

    public function writeStoreLog($storeID, $userID, $desc, $detail)
    {
        $data = [
            'storeID' => $storeID,
            'userID' => $userID,
            'desc' => $desc,
            'detail' => $detail
        ];

        StoreLog::create($data);
    }

    public function writeBrandLog($brandID, $userID, $desc, $detail)
    {
        $data = [
            'brandID' => $brandID,
            'userID' => $userID,
            'desc' => $desc,
            'detail' => $detail
        ];

        BrandLog::create($data);
    }

    public function getsuser()
    {
        $aUser = Auth::user();
        $user = User::where('id', $aUser->id)->with('brand')->with('magaza')->first();
        $isBrandManager = false;
        $hasBrand = false;
        $hasMagaza = false;
        if ($user->isBrandManager) {
            $isBrandManager = true;
        }
        if ($user->brand) {
            $hasBrand = true;
        }
        if ($user->magaza) {
            $hasMagaza = true;
        }
        return response()->json([
            'isBrandManager' => $isBrandManager,
            'hasBrand' => $hasBrand,
            'hasMagaza' => $hasMagaza,
            'user' => $user
        ]);
    }
}
