<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\InteractsWithDatabase;
use Tests\TestCase;
use App\User;
use App\Rubric;
use App\Auction;

class AuctionTest extends TestCase
{
    use WithFaker;
    //use InteractsWithDatabase;

    private function _testAuctionFormRequest($user = null, $method = 'POST', $url = '/api/advertenties'){
        $data = [
            'title' => $this->faker->sentence($this->faker->numberBetween(2,6), true),
            'description' => $this->faker->paragraph($this->faker->numberBetween(1,2), true),
            'text' => $this->faker->paragraphs($this->faker->numberBetween(1,4), true), 
            'address' => $this->faker->boolean() ? $this->faker->streetAddress() : null,
            'postal_code' => $this->faker->boolean() ? $this->faker->postcode(): null,
            'price' => $this->faker->randomFloat(2, 2, 4)
        ];
        if($user){
            $data['user_id'] = $user->id;
        }

        $response = $this->json($method, $url, $data);

        return $response;
    }

    private function _testPostAuction($user){
        $response = $this->_testAuctionFormRequest( $user );

        $response->dumpHeaders();
        $response->dump();  

        $response->assertCreated()
            ->assertJson([
                'created' => true,
            ]);
    }

    private function __testUpdateAuction($auction){
        $response = $this->_testAuctionFormRequest( null, 'PUT',  '/api/advertenties/' . $auction->id);

        $response->dumpHeaders();
        $response->dump();  

        return $response->assertCreated()
            ->assertJson([
                'updated' => true,
            ]);
    }

    private function __testDestroyAuction($auction){
        $response = $this->json('DELETE', '/api/advertenties/' . $auction->id);
        $response->assertSuccessful()->assertJson([
            'deleted' => true,
        ]);
        $this->assertSoftDeleted($auction);
    }

    /**
     * Testing Resource methods
     *
     * @return void
     */
    public function testListingPageExists()
    {
        $response = $this->get('/api/advertenties');
        $response->assertStatus(200);
    }

    public function testCreateAuction(){        
        $user = User::all()->random(); 

        $this->_testPostAuction($user);
    }

    public function testUpdateAuction(){
        $auction = Auction::all()->random();

        $this->__testUpdateAuction($auction);
    }

    public function testDeleteAuction(){
        $auction = Auction::all()->random();

        $response = $this->get('/api/advertenties/verwijder');

        if($response->assertStatus(200)){
            $this->__testDestroyAuction($auction);
        }
    }

    public function testRestoreAuction(){
        $trashed = Auction::onlyTrashed()->get();
        $this->assertFalse(empty($trashed->all()), 'No trashed auctions');
        
        $auction = $trashed->random();
        $auction->restore();
        $this->assertFalse($auction->trashed(), 'Item is still trashed');
    }

    public function testAddToRubric(){
        $rubrics = Rubric::all();
        $this->assertFalse($rubrics->isEmpty(), 'No rubrics available');

        $auctions = Auction::all();
        $this->assertFalse($auctions->isEmpty(), 'No auctions available');        

        $rubric = $rubrics->random();
        $rubric ->auctions()->save(  $auctions->random() );
        $this->assertFalse($rubric->auctions->isEmpty(), 'Auction not saved to Rubric');

        $auction = Auction::all()->random();
        $auction->rubrics()->save( Rubric::all()->random() );
        $this->assertFalse($auction->rubrics->isEmpty(), 'Rubric not saved to Auction');
    }
}