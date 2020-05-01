<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class StepTest extends TestCase
{
	/**
	 * create new Step test.
	 *
	 * @return void
	 */
	public function testStepCreate()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->post('/api/recipe/1/step', [
			'recipe_id' => 1,
			'step_order' => 5,
			'description' => 'Bring a medium pot of water to a boil...'
		]);
		
		$response->assertStatus(201)
			->assertJson(['data' => ['description' => 'Bring a medium pot of water to a boil...']]);
	}
	
	/**
	 * create new step no description test.
	 *
	 * @return void
	 */
	public function testStepNoDescriptionCreate()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->post('/api/recipe/1/step', [
			'quantity' => '50 grams'
		]);
		
		$response->assertStatus(401)
			->assertJson(['error' => ['description' => ['The description field is required.']]]);
	}
	
	/**
	 * Get all Steps for recipe test.
	 *
	 * @return void
	 */
	public function testStepGetAll()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->get('/api/recipe/1/step');
		
		$response->assertStatus(200)
			->assertJson(['data' => [['description' => 'Heat oil in a pan, add cut vegetables and saute for a minute.']]]);
	}
	
	/**
	 * Get one Step test.
	 *
	 * @return void
	 */
	public function testStepGetOne()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->get('/api/recipe/1/step/1');
		
		$response->assertStatus(200)
			->assertJson(['data' => ['description' => 'Heat oil in a pan, add cut vegetables and saute for a minute.']]);
	}
	
	/**
	 * update one Step from another user test.
	 *
	 * @return void
	 */
	public function testStepUpdateAnotherUser()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->put('/api/recipe/1/step/1', [
			'title' => 'Penne Pasta!'
		]);
		$response->assertStatus(401);
	}
	
	
	
	/**
	 * delete one Step test.
	 *
	 * @return void
	 */
	public function testStepDelete()
	{
		
		Passport::actingAs(
			factory(User::class)->create()
		);
		
		$response = $this->delete('/api/recipe/1/step/1');
		
		$response->assertStatus(200);
	}
}
