<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors';
    public $timestamps = false;

    public function books(){
        return $this->belongsToMany('App\Book', 'authors_books');
    }
}
