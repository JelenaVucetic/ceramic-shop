<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'order';

    public function user()
    {
        return $this->belongsTo('App\User');

    }
    public function order_product()
    {
        return $this->hasMany('App\OrderProduct');
    }

}