<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinQrCode extends Model
{
    protected $fillable = [
        'storeID',
        'menuItemID',
        'batch',
        'code',
        'qrImageLink',
        'status',
    ];
}
