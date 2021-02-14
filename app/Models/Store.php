<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $appends = ['averagePoint',];
    protected $fillable = [
        'cityID',
        'locationID',
        'brandID',
        'isCafe',
        'isActive',
        'tag',
        'featured',
        'name',
        'address',
        'latitude',
        'longitude',
        'email',
        'landPhoneNumber',
        'coverImageLink',
        'todaysSearchCount',
        'leftDailyStoryCount',
        'monOpen',
        'tueOpen',
        'wedOpen',
        'thuOpen',
        'friOpen',
        'satOpen',
        'sunOpen',
        'monClose',
        'tueClose',
        'wedClose',
        'thuClose',
        'friClose',
        'satClose',
        'sunClose',
        'isStudy',
        'isDate',
        'isLatteArt',
        'isPetFriendly',
        'isDessert',
        'isMeeting',
        'isAlcohol',
        'isOutside',
        'isMeal',
        'isBreakfast',
        'isChocolate',
        'isTakePhoto',
        'isSelfService',
        'isTea',
        'isLiveMusic',
        'canTakeTakeAwayOrder',
        'canTakeLocalDeliveryOrder',
        'canTakeLocalCargoOrder',
        'canTakeUpstateCargoOrder',
    ];

    public function comments()
    {
        return $this->hasMany(StoreComment::class,'storeID','id');
    }

    public function getAveragePointAttribute()
    {
        return $this->comments()->avg('commentPoint') ? : 0;
    }


    public function photos()
    {
        return $this->hasMany(StoreCommentPhoto::class,'storeID','id');
    }

    public function gunOrtalamaPuan($datetime)
    {
        $coms = StoreComment::where('storeID',$this->id)->where('created_at','>',Carbon::now()->subMonth())->get();
        $coms2 = $coms->where('created_at','<=',$datetime->toDateTimeString());
        if(count($coms2) == 0){
            return 0;
        }else{
            $tp = 0;
            $cc = 0;
            foreach ($coms2 as $item) {
                $tp = $tp + $item->commentPoint;
                $cc = $cc + 1;
            }
            return round(($tp/$cc),1);
        }
    }

    public function gunFavEklenme($datetime,$datetime2)
    {
        $favs = FavoriteStore::where('storeID',$this->id)->where('created_at','>',Carbon::now()->subMonth())->get();
        $daysFavCount = $favs->where('created_at', '<=', $datetime->toDateTimeString())->where('created_at', '>=', $datetime2->toDateTimeString())->count();
        return $daysFavCount;
    }

    public function gunGoruntulenme($datetime,$datetime2)
    {
        $views = StoreViewLog::where('storeID',$this->id)->where('created_at','>',Carbon::now()->subMonth())->get();
        $daysViewCount = $views->where('created_at', '<=', $datetime->toDateTimeString())->where('created_at', '>=', $datetime2->toDateTimeString())->count();
        return $daysViewCount;
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteStore::class,'storeID','id');
    }

    public function kafeyin_photos()
    {
        return $this->hasMany(StoreKafeyinPhoto::class,'storeID','id');
    }

    public function todayssearches()
    {
        return $this->hasMany(LastSearchedStore::class,'storeID','id')->where('created_at','>=',Carbon::today()->startOfDay());
    }

    public function views()
    {
        return $this->hasMany(StoreViewLog::class,'storeID','id');
    }

    public function logs()
    {
        return $this->hasMany(StoreLog::class,'storeID','id');
    }

    public function paylasims()
    {
        return $this->hasMany(KafeyinStory::class,'storeID','id');
    }

    public function menu_items()
    {
        return $this->hasMany(MenuItem::class,'storeID','id');
    }

    public function notifs()
    {
        return $this->hasMany(StoreNotification::class,'storeID','id');
    }

    public function city()
    {
        return $this->hasOne(City::class,'id','cityID');
    }

    public function location()
    {
        return $this->hasOne(Location::class,'id','locationID');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }

    public function yonetici()
    {
        return $this->hasOne(User::class,'email','email');
    }
}
