<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PopUp extends Eloquent
{
    use HasFactory;
    protected $table = 'pop_ups';


    protected $primaryKey = '_id';

    protected $guarded = [];


}
