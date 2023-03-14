<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContactQuery extends Eloquent
{
     use HasFactory;
    protected $guarded = [];
    protected $table = 'contact_queries';
}
