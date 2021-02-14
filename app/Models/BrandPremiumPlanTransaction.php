<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandPremiumPlanTransaction extends Model
{
    protected $fillable = [
        'brandID',
        'userID',
        'brandManagerExtraInfoID',
        'fee',
        'isPaid',
        'paymentID',
        'paymentTransactionID',
        'paidPrice',
        'isInvoiceSent',
        'isFailed',
        'failDesc',
        'systemTime'
    ];
}
