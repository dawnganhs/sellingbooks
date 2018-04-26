<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'id', 'cost', 'qty', 'id_order', 'id_book'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order' , 'id_order');
    }
    public function book()
    {
        return $this->belongsTo('App\Book' , 'id_book');
    }
}
