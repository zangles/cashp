<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusDownlaoder extends Model
{
    protected $fillable = [
        'script','start','pages','lastPage'
    ];
}
