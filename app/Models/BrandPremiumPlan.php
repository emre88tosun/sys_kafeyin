<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandPremiumPlan extends Model
{
    protected $fillable = [
        'brandID',
        'premiumPlanStartDate',
        'currentPremiumPlanStartDate',
        'nextRenewalDate',
        'daysPassedAfterRenewalDate',
        'isPlanActive',
    ];
}
