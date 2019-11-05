<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Auction;
use Faker\Generator as Faker;

$factory->define(Auction::class, function (Faker $faker) {
    return [
    	'user_id' => function(){
    		return App\User::all()->random()->id;
    	},
        'title' => $faker->sentence($faker->numberBetween(2,6), true),
        'description' => $faker->paragraph($faker->numberBetween(1,1), true),
        'text' => $faker->paragraphs($faker->numberBetween(1,4), true), 
        'address' => $faker->streetAddress(),
        'postal_code' => $faker->postcode(),
        'price' => $faker->randomFloat(2,1,2)
    ];
});
