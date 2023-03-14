<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Common extends Eloquent
{
   use HasFactory;
    protected $guarded = [];
    protected $table = 'common';
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
