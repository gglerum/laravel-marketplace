<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\InteractsWithDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\User;
use App\Auction;
use App\Bid;

class BidTest extends TestCase
{
    use WithFaker;

    private function __testAuctionsAvailable(){
        $this->assertFalse(Auction::all()->isEmpty(), 'No auctions available');
    }

    private function __testTableExists(){
         $this->assertTrue( DB::getSchemaBuilder()->hasTable('bids'), 'Table bids does not exits' );
    }

    private function __testBidRandomAuction(){
        $auction = Auction::all()->random();
        $user = User::all()->random();

        $auction->bids()->create([
            'user_id' => $user->id,
            'amount' => $this->faker->randomFloat(2, 2, 4)
        ]);

        //$this->assertTrue( $auction->promoted->exists, 'Auction could not be promoted');
    }

    public function testPromoteAuction(){

        $this->__testAuctionsAvailable();
        $this->__testTableExists();
        $this->__testBidRandomAuction();

    }
}