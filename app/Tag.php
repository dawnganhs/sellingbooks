<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'id', 'name', 'slug', 'id_book'
    ];
    public function books()
    {
        return $this->belongsToMany('App\Book', 'book_tags', 'id_tag', 'id_book');
    }
}
