<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class GalleryCategory extends Eloquent
{
    use HasFactory;

    protected $table = 'gallery_categories';
    protected $guarded = [];
}
