<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id', 'total', 'id_user'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
}
