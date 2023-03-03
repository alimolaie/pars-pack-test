<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public $table="application";
    protected $guarded=['id'];
    public function subscription()
    {
      return $this->hasMany(Subscription::class);
    }
    public function platform()
    {
     return $this->belongsTo(Platform::class,'platform_id');
    }
    use HasFactory;
}
