<?php

namespace App\Models;

use App\Notifications\ResetPassEmail;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'userType',
        'name',
        'surname',
        'email',
        'password',
        'favDrink',
        'identityNumber',
        'gsmNumber',
        'avatar',
        'userPoint',
        'beansCount',
        'city',
        'lastLatitude',
        'lastLongitude',
        'lastLogin',
        'fcmToken',
        'isBrandManager',
        'brandID',
        'locationVisibility',
        'canPushNotif',
        'canEmailNotif',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(StoreComment::class,'userID','id');
    }

    public function photos()
    {
        return $this->hasMany(StoreCommentPhoto::class,'userID','id');
    }

    public function favorite_articles()
    {
        return $this->hasMany(FavoriteArticle::class,'userID','id');
    }

    public function favorite_activities()
    {
        return $this->hasMany(FavoriteActivity::class,'userID','id');
    }

    public function favorite_stores()
    {
        return $this->hasMany(FavoriteStore::class,'userID','id');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class,'followerID','id');
    }

    public function followers()
    {
        return $this->hasMany(Follow::class,'followingID','id');
    }

    public function makina_searches()
    {
        return $this->hasMany(MakinaSearch::class,'userID','id');
    }

    public function user_logs()
    {
        return $this->hasMany(UserLog::class,'userID','id');
    }

    public function loyalty_cards()
    {
        return $this->hasMany(LoyaltyCard::class,'userID','id');
    }

    public function device_info()
    {
        return $this->hasOne(UserDeviceInfo::class,'userID','id');
    }

    public function magaza()
    {
        return $this->hasOne(Store::class,'email','email');
    }

    public function brand_notifs()
    {
        return $this->hasMany(BrandNotification::class,'brandID','brandID');
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class,'userID','id');
    }

    public function magaza_logs()
    {
        return $this->hasMany(StoreLog::class,'userID','id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brandID');
    }

    public function marka_yoneticisi_bilgileri()
    {
        return $this->hasOne(BrandManagerExtraInfo::class,'userID','id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassEmail($token));
    }
}
