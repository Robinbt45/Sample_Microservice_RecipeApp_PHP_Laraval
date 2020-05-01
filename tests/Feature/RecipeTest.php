<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;


class RecipeTest extends TestCase
{
 
	/**
     * create new Recipe test.
     *
     * @return void
     */
    public function testRecipeCreate()
    {
	
	    Passport::actingAs(
		    factory(User::class)->create()
	    );
	    
	    $response = $this->post('/api/recipe', [
	    	'title' => 'Penne Pasta',
	        'description' => 'This healthy, budget-friendly pasta dinner is inspired by pricey antipasti platters. We love the spicy-garlicky flavor the soppressata brings-lots of bang for your buck!'
	    ]);

        $response->assertStatus(201)
        ->assertJson(['data' => ['title' => 'Penne Pasta']]);
    }
	
	/**
	 * create new Recipe no title test.
	 *
	 * @return void
	 */
	public function testRecipeNoTitleCreate()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->post('/api/recipe', [
			'description' => 'This healthy, budget-friendly pasta dinner is inspired by pricey antipasti platters. We love the spicy-garlicky flavor the soppressata brings-lots of bang for your buck!'
		]);
		
		$response->assertStatus(401)
			->assertJson(['error' => ['title' => ['The title field is required.']]]);
	}
    
    /**
     * Get all Recipe test.
     *
     * @return void
     */
    public function testRecipeGetAll()
    {
	
	    Passport::actingAs(
		    factory(User::class)->create()
	    );
	    
	    $response = $this->get('/api/recipe');

        $response->assertStatus(200)
        ->assertJson(['data' => [['title' => 'American Chopsuey']]]);
    }
	
	/**
	 * Get one Recipe test.
	 *
	 * @return void
	 */
	public function testRecipeGetOne()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->get('/api/recipe/1');
		
		$response->assertStatus(200)
			->assertJson(['data' => ['title' => 'American Chopsuey']]);
	}
	
	/**
	 * update one Recipe from another user test.
	 *
	 * @return void
	 */
	public function testRecipeUpdateAnotherUser()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->put('/api/recipe/1', [
			'title' => 'Penne Pasta!'
		]);
		$response->assertStatus(401);
	}
	
	/**
	 * update one Recipe from same user test.
	 *
	 * @return void
	 */
	public function testRecipeUpdateSameUser()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		
		$this->post('/api/recipe', [
			'title' => 'Penne Pasta',
			'description' => 'This healthy, budget-friendly pasta dinner is inspired by pricey antipasti platters. We love the spicy-garlicky flavor the soppressata brings-lots of bang for your buck!'
		]);
		
		$response = $this->put('/api/recipe/2', [
			'title' => 'Penne Pasta!'
		]);
		
		$response->assertStatus(200)
			->assertJson(['data' => ['title' => 'Penne Pasta!']]);
	}
	
	
	
	/**
	 * delete one Recipe test.
	 *
	 * @return void
	 */
	public function testRecipeDelete()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->delete('/api/recipe/1');
		
		$response->assertStatus(200);
	}
}
