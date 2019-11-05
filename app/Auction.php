<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
	use SoftDeletes;
    
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    public function rubrics(){
    	return $this->belongsToMany('App\Rubric');
    }

    public function promoted(){
    	return $this->hasOne('App\Promotion');
    }
}
