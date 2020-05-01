<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\RecipeCollection as RecipeResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Http\Controllers\Controller;
use App\Models\Step;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    
    /**
     * To create a new recipe in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
	    $input = $request->all();
	    $validator = Validator::make($input, [
		    'title' => 'required|unique:recipes|string|min:3|max:100',
		    'description' => 'required|string|min:15',
	    ]);
	    
	    if ($validator->fails()) {
		    return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
	    }
	    $input['user_id'] = Auth::user()->id;
	
	    return new RecipeResource(Recipe::create($input));
    }

    /**
     * Display the specified recipe.
     *
     * @param  \App\Models\Recipe\id  $recipeId
     * @return \Illuminate\Http\Response
     */
    public function show($recipeId)
    {
	    $validator = Validator::make(['recipe_id' => $recipeId], [
		    'recipe_id' => 'exists:recipes,id',
	    ]);
	
	    if ($validator->fails()) {
		    return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
	    }
	
	    return new RecipeResource(Recipe::find($recipeId));
    }
	
	/**
	 * Update the specified recipe in storage.
	 *
	 * @param  \App\Models\Recipe\id  $recipeId
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update($recipeId, Request $request)
	{
		$validator = Validator::make(['recipe_id' => $recipeId], [
			'recipe_id' => 'exists:recipes,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		//get respective recipe
		$recipe = Recipe::find($recipeId);
		
		$input = $request->all();
		
		if(isset($input['title']) && $input['title'] !== $recipe->title) {
			$validator = Validator::make($input, [
				'title' => 'unique:recipes|string|min:3|max:100',
				'description' => 'string|min:15',
			]);
			$recipe->title = $input['title'];
		} else {
			$validator = Validator::make($input, [
				'title' => 'string|min:3|max:100',
				'description' => 'string|min:15',
			]);
		}
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		
		if($recipe->user_id !== Auth::user()->id) {
			return response()->json(['success' => false, 'error'=>'You can\'t update Recipe as it doesn\'t belongs to you.'], 401);
		}
		if(isset($input['description'])) {
			$recipe->description = $input['description'];
		}
		$recipe->save();
		
		return new RecipeResource($recipe);
	}
	
	/**
	 * Display all recipes.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showAll()
	{
		$recipes = Recipe::all();
		foreach ($recipes as &$recipe) {
			$recipe->user;
			$recipe->ingredients;
			$recipe->steps;
		}
		return response()->json(['data' => $recipes], 200);
	}

    /**
     * Remove the recipe resource from storage.
     *
     * @param  \App\Models\Recipe\id $recipeId
     * @return \Illuminate\Http\Response
     */
    public function destroy($recipeId)
    {
	    $validator = Validator::make(['recipe_id' => $recipeId], [
		    'recipe_id' => 'exists:recipes,id',
	    ]);
	
	    if ($validator->fails()) {
		    return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
	    }
	    
	    Step::where('recipe_id', $recipeId)->delete();
	    Ingredient::where('recipe_id', $recipeId)->delete();
	    Recipe::find($recipeId)->delete();
	    return response()->json(['data' => 'Recipe has been Deleted.'], 200);
    }
}
