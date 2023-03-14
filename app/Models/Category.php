<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    use HasFactory;


    protected $guarded = [];
    

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function offer()
    {
        return $this->hasOne(Offer::class);
    }


    
    public function offers(){

        return $this->hasMany(Offer::class , 'category_id' ,'id');

    }

    public function getSlugAttribute($value)
    {
        $value = str_replace(' ', '_', $value);

        return $value;
    }
    public function getAllUploads()
    {
        return $this->hasManyThrough(Upload::class, Post::class,'id','post_id');
    }
}
