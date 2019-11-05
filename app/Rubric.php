<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubric extends Model
{
	use SoftDeletes;

    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    /* get parent rubric */
    public function parent(){
    	return $this->belongsTo('App\Rubric');
    }

    /*get rubric children*/
    public function children(){
    	return $this->hasMany('App\Rubric', 'parent_id');
    }

    public function auctions(){
    	return $this->belongsToMany('App\Auction');
    }
}
