<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'userID',
        'name',
        'gsmNumber',
        'cityID',
        'countyID',
        'districtID',
        'neighborhoodID',
        'avenueStreet',
        'buildingApartmentNo',
        'desc',
        'isDeleted',
    ];

    public function city()
    {
        return $this->hasOne(AddressCity::class,'id','cityID');
    }

    public function county()
    {
        return $this->hasOne(AddressCounty::class,'id','countyID');
    }

    public function district()
    {
        return $this->hasOne(AddressDistrict::class,'id','districtID');
    }

    public function neighborhood()
    {
        return $this->hasOne(AddressNeighborhood::class,'id','neighborhoodID');
    }
}
