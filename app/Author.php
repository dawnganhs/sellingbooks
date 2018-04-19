<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'id', 'name', 'slug', 'description', 'phone', 'address', 'email', 'avatar'
    ];

    public function books()
    {
        return $this->hasMany('App\Book');
    }
}
