<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
	use SoftDeletes;
    
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function rubrics(){
    	return $this->belongsToMany('App\Rubric');
    }

    public function promoted(){
    	return $this->hasOne('App\Promotion');
    }

    public function bids(){
    	return $this->hasMany('App\Bid');
    }

    public function bidders()
    {
        return $this->hasManyThrough('App\Bid', 'App\User');
    }
}
