<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
        'id', 'quantity', 'id_book'
    ];
    
    public function book()
    {
        return $this->belongsTo('App\Book' , 'id_book');
    }
}
