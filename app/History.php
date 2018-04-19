<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'id', 'status', 'quantity' ,'id_user', 'id_book'
    ];
    
    public function book()
    {
        return $this->belongsTo('App\Book' , 'id_book');
    }
    public function user()
    {
        return $this->belongsTo('App\User' , 'id_user');
    }
}
