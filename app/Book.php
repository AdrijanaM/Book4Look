<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    public $timestamps = false;

    public function authors(){
        return $this->belongsToMany('App\Author', 'authors_books');
    }
}
