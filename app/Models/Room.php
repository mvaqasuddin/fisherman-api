<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Room extends Eloquent
{
    use HasFactory;
        protected $guarded = [];
    

    public function getRouteKeyName()
    {
        return 'slug';
    }

}
