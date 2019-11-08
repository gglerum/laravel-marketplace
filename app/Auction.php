<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
	use SoftDeletes;
    
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['path'];

    private function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
       $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.

       return strtolower($string);
    }

    public function getPathAttribute(){
        return "a{$this->id}/{$this->clean($this->title)}";
    }

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
