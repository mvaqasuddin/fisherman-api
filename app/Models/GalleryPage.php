<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class GalleryPage extends Eloquent
{
    use HasFactory;
    protected $table = 'gallery_pages';
    protected $guarded = [];
}
