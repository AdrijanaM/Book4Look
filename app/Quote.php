<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'quotes';

    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }

}
