<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public $table="subscription";
    protected $guarded=['id'];
    public function app()
    {
       return $this->belongsTo(Application::class,'app_id');
    }
    public function platform()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }
    public function user()
    {
       return $this->belongsTo(User::class,'user_id');
    }
    use HasFactory;
}
