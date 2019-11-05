<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{   
    protected $guarded = ['created_at', 'updated_at'];

    public function auction(){
    	return $this->belongsTo('App\Auction');
    }
}
