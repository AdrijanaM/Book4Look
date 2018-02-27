<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    public $timestamps = false;

    public function users(){
        return $this->belongsToMany('App\User', 'users_books');
    }

}
