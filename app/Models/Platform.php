<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    public $table="platform";
    protected $guarded=['id'];
    public function app()
    {
       return $this->hasMany(Application::class);
    }
    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
    use HasFactory;
}
