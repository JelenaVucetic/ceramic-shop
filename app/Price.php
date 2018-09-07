<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model{

    protected $table = 'price';

    public function product()
    {
        return $this->belongsTo('App\Product');
    }


}
