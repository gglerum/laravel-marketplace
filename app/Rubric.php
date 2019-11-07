<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rubric extends Model
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
        return ($this->parent ? "{$this->parent->path}/" : '') . "r{$this->id}/{$this->clean($this->title)}";
    }

    /* RELATIONS */

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
