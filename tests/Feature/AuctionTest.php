<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Auction;

class AuctionTest extends TestCase
{
    use WithFaker;

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

    private function __testCreateFormExist() {
        $response = $this->get('/api/advertenties/maak');
        return $response->assertStatus(200);
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

    private function __testUpdateFormExist() {
        $response = $this->get('/api/advertenties/bewerk');
        return $response->assertStatus(200);
    }

    private function __testUpdateAuction($auction){
        $response = $this->_testAuctionFormRequest( null, 'PUT',  '/api/advertenties/' . $auction->id);

        $response->dumpHeaders();
        $response->dump();  

        return $response->assertCreated()
            ->assertJson([
                'created' => true,
            ]);
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

        if($this->__testCreateFormExist()){
            $this->_testPostAuction($user);
        }
    }

    public function testUpdateAuction(){
        $auction = Auction::all()->random();

        if($this->__testUpdateFormExist()){
            $this->__testUpdateAuction($auction);
        }
    }
}