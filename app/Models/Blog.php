<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Blog extends Eloquent
{
    use HasFactory;

    protected $table = 'blogs';

    protected $primaryKey = '_id';

    protected $guarded = [];
    public function getRouteKeyName()
    {
        return 'slug';
    }

}
