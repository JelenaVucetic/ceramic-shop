<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

    protected $table = 'tax';

    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}