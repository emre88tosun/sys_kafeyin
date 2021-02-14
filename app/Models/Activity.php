<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'cityID',
        'storeID',
        'isActive',
        'title',
        'desc',
        'imageLink',
        'date',
        'time',
        'canTicketing',
        'ticketFee',
        'availableTicketCount',
        'viewCount',
        'locationID',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'storeID','id');
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteActivity::class,'activityID','id');
    }

    public function sold_tickets()
    {
        return $this->hasMany(ActivityTicket::class,'activityID','id')->orderByDesc('created_at');
    }
}
