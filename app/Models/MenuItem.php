<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'categoryID',
        'subCategoryID',
        'title',
        'desc',
        'imageLink',
        'isActive',
        'tag1',
        'tag2',
        'tag3',
        'fee',
    ];

    public function category()
    {
        return $this->belongsTo(MenuItemCategory::class,'categoryID','id');
    }

    public function subcategory()
    {
        return $this->belongsTo(MenuItemSubCategory::class,'subCategoryID','id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }

    public function views()
    {
        return $this->hasMany(MenuItemViewLog::class,'menuItemID','id');
    }

    public function qrcodes()
    {
        return $this->hasMany(KafeyinQrCode::class,'menuItemID','id');
    }

    public function u_qrcodes()
    {
        return $this->hasMany(KafeyinQrCode::class,'menuItemID','id')->where('status','used');
    }

    public function active_qrcodes()
    {
        return $this->hasMany(KafeyinQrCode::class,'menuItemID','id')->where('status','active')->where('created_at','>=',Carbon::today()->startOfDay()->toDateTimeString());
    }

    public function used_qrcodes()
    {
        return $this->hasMany(KafeyinQrCode::class,'menuItemID','id')->where('status','used')->where('created_at','>=',Carbon::today()->startOfDay()->toDateTimeString());
    }

    public function today_created_qrcodes()
    {
        return $this->hasMany(KafeyinQrCode::class,'menuItemID','id')->where('kafeyin_qr_codes.created_at','>=',Carbon::today()->startOfDay()->toDateTimeString());
    }

    public function today_used_qrcodes()
    {
        return $this->hasMany(KafeyinQrCode::class,'menuItemID','id')->where('status','used')->where('kafeyin_qr_codes.updated_at','>=',Carbon::today()->startOfDay()->toDateTimeString());
    }
}
