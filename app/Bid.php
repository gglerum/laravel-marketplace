<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function auction(){
    	return $this->belongsTo('App\Auction');
    }
}
