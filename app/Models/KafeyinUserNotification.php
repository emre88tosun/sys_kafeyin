<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KafeyinUserNotification extends Model
{
    protected $fillable = [
        'receiverID',
        'senderID',
        'commentID',
        'type',
        'desc',
        'isSeen',
    ];
}
