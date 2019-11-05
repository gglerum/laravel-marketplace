<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\InteractsWithDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Rubric;

class RubricTest extends TestCase
{
    use WithFaker;

    private function _testRubricFormRequest($method = 'POST', $url = '/api/rubrics'){
        $data = [
            'title' => $this->faker->sentence($this->faker->numberBetween(2,6), true),
            'description' => $this->faker->paragraph($this->faker->numberBetween(1,2), true),
        ];

        if($this->faker->boolean() && !Rubric::all()->isEmpty())
        {
            $data['parent_id'] = Rubric::all()->random()->id;
        }
        else
        {
            $data['parent_id'] = null;
        }

        $response = $this->json($method, $url, $data);

        return $response;
    }

    private function _testPostRubric(){
        $response = $this->_testRubricFormRequest();

        $response->dumpHeaders();
        $response->dump();

        $response->assertCreated()
            ->assertJson([
                'created' => true,
            ]);
    }

    private function __testUpdateRubric($rubric){
        $response = $this->_testRubricFormRequest( 'PUT',  '/api/rubrics/' . $rubric->id);

        $response->dumpHeaders();
        $response->dump();  

        return $response->assertCreated()
            ->assertJson([
                'updated' => true,
            ]);
    }

    /**
     * Testing Resource methods
     *
     * @return void
     */
    public function testListingPageExists()
    {
        $response = $this->get('/api/rubrics');
        $response->assertStatus(200);
    }

    public function testIfTableExists(){
        $this->assertTrue(DB::getSchemaBuilder()->hasTable('rubrics'));
    }

    public function testCreateRubric(){        
        $this->_testPostRubric();
    }

    public function testUpdateRubric(){
        $rubric = Rubric::all()->random();

        $this->__testUpdateRubric($rubric);
    }

    public function testSoftDeleteable(){
        $this->assertTrue( $this->isSoftDeletableModel(new Rubric) );
    }

    public function testDestroyRubric(){
        $rubric = Rubric::all()->random();
        
        $response = $this->json('DELETE', '/api/rubrics/' . $rubric->id);

        $response->dump();

        $response->assertSuccessful()->assertJson([
            'deleted' => true,
        ]);
        $this->assertSoftDeleted($rubric);
    }

    public function testRestoreRubric(){
        $trashed = Rubric::onlyTrashed()->get();
        $this->assertFalse(empty($trashed->all()), 'No trashed auctions');
        
        $rubric = $trashed->random();
        $rubric->restore();
        $this->assertFalse($rubric->trashed(), 'Item is still trashed');
    }

    public function testOnToManyRubrics(){
        $rubrics = Rubric::has('children')->get();
        $this->assertFalse($rubrics->isEmpty(), 'No rubrics with children');
        $this->assertFalse($rubrics->random()->children->isEmpty(), 'Random rubric form collection has no children');
    }

    public function testManyToOneRubrics(){
        $rubrics = Rubric::has('parent')->get();
        $this->assertFalse($rubrics->isEmpty(), 'No rubrics with parent');
        $this->assertTrue($rubrics->random()->parent->exists, 'Rubric has no parent');
    }

    public function testAuctionRelationship(){
        $rubrics = Rubric::has('auctions')->get();
        $this->assertFalse($rubrics->isEmpty(), 'No rubrics with auctions');
    }
}