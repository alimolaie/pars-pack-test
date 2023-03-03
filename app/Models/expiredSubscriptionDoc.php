<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expiredSubscriptionDoc extends Model
{
    public function sub()
    {
        return $this->belongsTo(Subscription::class,'subscription_id');
    }
    use HasFactory;
}
