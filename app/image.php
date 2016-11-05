<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $fillable = [
        'path','size','OriginalUrl'  
    ];

    public function galleries()
    {
        return $this->belongsToMany('App\Gallery');
    }
}
