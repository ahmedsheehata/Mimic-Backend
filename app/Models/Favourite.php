<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    protected $guarded=[];

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function challenge()
    {
        return $this->belongsTo('App\Models\Challenge');
    }
}
