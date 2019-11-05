<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\InteractsWithDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Auction;
use App\Promotion;

class PromotionTest extends TestCase
{
    use WithFaker;

    private function __testAuctionsAvailable(){
        $this->assertFalse(Auction::all()->isEmpty(), 'No auctions available');
    }

    private function __testTableExists(){
         $this->assertTrue( DB::getSchemaBuilder()->hasTable('promotions'), 'Table promotions does not exits' );
    }

    private function __testPromoteRandomAuction(){
        $auction = Auction::all()->random();

        $auction->promoted()->create(['ends_at' => $this->faker->dateTimeThisYear()]);

        $this->assertTrue( $auction->promoted->exists, 'Auction could not be promoted');
    }

    public function testPromoteAuction(){

        $this->__testAuctionsAvailable();
        $this->__testTableExists();
        $this->__testPromoteRandomAuction();

    }
}