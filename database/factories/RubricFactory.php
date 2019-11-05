<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rubric;
use Faker\Generator as Faker;

$factory->define(Rubric::class, function (Faker $faker) {
    return [
        'parent_id' => function(){
        	if($this->faker->boolean()){
        		if(!Rubric::all()->isEmpty()){
        			return Rubric::all()->random()->id;
        		}
        	}
        	return null;
    	},
        'title' => $faker->sentence($faker->numberBetween(2,6), true),
        'description' => $faker->paragraph($faker->numberBetween(1,1), true),
    ];
});
