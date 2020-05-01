<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class IngredientTest extends TestCase
{
	/**
	 * create new Ingredient test.
	 *
	 * @return void
	 */
	public function testIngredientCreate()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->post('/api/recipe/1/ingredient', [
			'recipe_id' => 1,
			'name' => 'olive oil',
			'quantity' => '1 tablespoon'
		]);
		
		$response->assertStatus(201)
			->assertJson(['data' => ['name' => 'olive oil']]);
	}
	
	/**
	 * create new ingredient no name test.
	 *
	 * @return void
	 */
	public function testIngredientNoNameCreate()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->post('/api/recipe/1/ingredient', [
			'quantity' => '50 grams'
		]);
		
		$response->assertStatus(401)
			->assertJson(['error' => ['name' => ['The name field is required.']]]);
	}
	
	/**
	 * Get all Ingredients for recipe test.
	 *
	 * @return void
	 */
	public function testIngredientGetAll()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->get('/api/recipe/1/ingredient');
		
		$response->assertStatus(200)
			->assertJson(['data' => [['name' => 'capsicum']]]);
	}
	
	/**
	 * Get one Ingredient test.
	 *
	 * @return void
	 */
	public function testIngredientGetOne()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->get('/api/recipe/1/ingredient/2');
		
		$response->assertStatus(200)
			->assertJson(['data' => ['name' => 'cabbage']]);
	}
	
	/**
	 * update one Ingredient from another user test.
	 *
	 * @return void
	 */
	public function testIngredientUpdateAnotherUser()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->put('/api/recipe/1/ingredient/1', [
			'title' => 'Penne Pasta!'
		]);
		$response->assertStatus(401);
	}
	
	
	
	/**
	 * delete one Ingredient test.
	 *
	 * @return void
	 */
	public function testIngredientDelete()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->delete('/api/recipe/1/ingredient/5');
		
		$response->assertStatus(200);
	}
}
