<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bid;
use Faker\Generator as Faker;

$factory->define(Bid::class, function (Faker $faker) {
    return [
    	'user_id' => function(){
    		return App\User::all()->random()->id;
    	},
    	'auction_id' => function(){
    		return App\Auction::all()->random()->id;
    	},
        'amount' => $faker->randomFloat(2,1,2)
    ];
});
