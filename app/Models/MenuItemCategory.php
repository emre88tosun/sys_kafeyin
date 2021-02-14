<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemCategory extends Model
{
    protected $fillable = [
        'code',
        'desc',
        'position',
        'canGenerateQrCode'
    ];

    public function subcategories()
    {
        return $this->hasMany(MenuItemSubCategory::class,'categoryID','id');
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class,'categoryID','id');
    }
}
