<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Offer extends Eloquent
{
    use HasFactory;
    protected $guarded = [];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function categories(){

        return $this->hasMany(Category::class)->select('name');

    }
}
