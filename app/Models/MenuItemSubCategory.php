<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemSubCategory extends Model
{
    protected $fillable = [
        'brandID',
        'categoryID',
        'desc',
    ];

    public function maincategory()
    {
        return $this->belongsTo(MenuItemCategory::class,'categoryID','id');
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class,'subCategoryID','id');
    }
}
