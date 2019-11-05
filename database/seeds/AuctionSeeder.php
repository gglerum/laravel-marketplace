<?php

use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Auction::class, 10)->create()->each(function($auction){
       		$auction->rubrics()->attach( App\Rubric::all()->random()->id );
       });
    }
}
