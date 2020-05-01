<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IngredientCollection as IngredientResource;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\In;
use Validator;
use Illuminate\Support\Facades\Auth;

class IngredientController extends Controller
{
	
	/**
	 * To add a new ingredient for recipe in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function create($recipeId, Request $request)
	{
		$input = $request->all();
		$input['recipe_id'] = $recipeId;
		$validator = Validator::make($input, [
			'recipe_id' => 'required|integer|exists:recipes,id',
			'name' => 'required|string|min:3|max:150',
			'quantity' => 'required|string|min:3',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		return new IngredientResource(Ingredient::create($input));
	}
	
	/**
	 * Display the specified ingredient by ingredientId.
	 *
	 * @param  \App\Models\Ingredient\id  ingredientId
	 * @return \Illuminate\Http\Response
	 */
	public function show($recipeId, $ingredientId)
	{
		$validator = Validator::make(['ingredient_id' => $ingredientId], [
			'ingredient_id' => 'exists:ingredients,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		return new IngredientResource(Ingredient::find($ingredientId));
	}
	
	/**
	 * Update the specified ingredient in storage as per given ingredient id.
	 *
	 * @param  \App\Models\Ingredient\id  $ingredientId
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update($recipeId, $ingredientId, Request $request)
	{
		$validator = Validator::make(['ingredient_id' => $ingredientId], [
			'ingredient_id' => 'exists:ingredients,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		//get respective ingredient by id
		$ingredient = Ingredient::find($ingredientId);
		
		$input = $request->all();
		
		$validator = Validator::make($input, [
			'name' => 'string|min:3|max:150',
			'quantity' => 'string|min:3',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		
		if($ingredient->recipe->user_id !== Auth::user()->id) {
			return response()->json(['success' => false, 'error'=>'You can\'t update Ingredient as Recipe doesn\'t belongs to you.'], 401);
		}
		if(isset($input['name'])) {
			$ingredient->name = $input['name'];
		}
		
		if(isset($input['quantity'])) {
			$ingredient->quantity = $input['quantity'];
		}
		
		$ingredient->save();
		
		return new IngredientResource($ingredient);
	}
	
	/**
	 * Display all ingredients for given recipes.
	 *
	 * @param  \App\Models\Recipe\id $recipeId
	 * @return \Illuminate\Http\Response
	 */
	public function showAll($recipeId)
	{
		return new IngredientResource(Ingredient::where('recipe_id', $recipeId)->get());
	}
	
	/**
	 * Remove the ingredient resource from storage.
	 *
	 * @param  \App\Models\Ingredient\id $ingredientId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($recipeId, $ingredientId)
	{
		$validator = Validator::make(['ingredient_id' => $ingredientId], [
			'ingredient_id' => 'exists:ingredients,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		Ingredient::find($ingredientId)->delete();
		
		
		return response()->json(['data' => 'Ingredient has been Deleted.'], 200);
	}
}
