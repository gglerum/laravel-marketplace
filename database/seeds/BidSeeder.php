<?php

use Illuminate\Database\Seeder;

class BidSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Bid::class, 10)->create();
    }
}
