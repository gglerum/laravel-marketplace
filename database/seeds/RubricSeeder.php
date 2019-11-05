<?php

use Illuminate\Database\Seeder;

class RubricSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       factory(App\Rubric::class, 10)->create();
    }
}
