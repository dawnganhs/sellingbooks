<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'id', 'name', 'slug', 'image', 'price', 'promotion_price', 'highlights', 'description', 'quantity', 'id_category', 'id_author', 'id_tag'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'id_category');
    }
    public function author()
    {
        return $this->belongsTo('App\Author', 'id_author');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'book_tags', 'id_book', 'id_tag');
    }
}
