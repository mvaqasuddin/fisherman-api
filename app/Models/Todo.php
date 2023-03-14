<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Todo extends Eloquent
{
    protected $table = 'todos';
    protected $guarded = [];
}
