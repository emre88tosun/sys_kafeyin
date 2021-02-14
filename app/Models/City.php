<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'secondaryName',
        'isActive',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class,'cityID','id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class,'cityID','id');
    }

    public function users()
    {
        return $this->hasMany(User::class,'city','name');
    }


    public function popularstores()
    {
        return $this->hasMany(PopularStore::class,'cityID','id');
    }

    public function lastaddedstores()
    {
        return $this->hasMany(LastAddedStore::class,'cityID','id');
    }

    public function editorsstores()
    {
        return $this->hasMany(EditorChoiceStore::class,'cityID','id');
    }

    public function kafeyinlocations()
    {
        return $this->hasMany(KafeyinLocation::class,'cityID','id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class,'cityID','id');
    }

}
