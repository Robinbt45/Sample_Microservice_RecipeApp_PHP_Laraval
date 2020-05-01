<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function(){
	//user
	Route::get('user', 'API\UserController@userDetails');
	
	Route::prefix('recipe')->group(function () {
		
		//recipes
		Route::post('/', 'API\RecipeController@create');
		Route::get('/{recipeId}', 'API\RecipeController@show');
		Route::get('/', 'API\RecipeController@showAll');
		Route::put('/{recipeId}', 'API\RecipeController@update');
		Route::delete('/{recipeId}', 'API\RecipeController@destroy');
		
		//ingredients e.g. /api/recipe/{recipeId}/ingredient/***
		Route::prefix('{recipeId}/ingredient')->group(function () {
			Route::post('/', 'API\IngredientController@create');
			Route::get('{ingredientId}', 'API\IngredientController@show');
			Route::get('/', 'API\IngredientController@showAll');
			Route::put('{ingredientId}', 'API\IngredientController@update');
			Route::delete('{ingredientId}', 'API\IngredientController@destroy');
		});
		
		//steps e.g. /api/recipe/{recipeId}/step/***
		Route::prefix('{recipeId}/step')->group(function () {
			Route::post('/', 'API\StepController@create');
			Route::get('/{stepId}', 'API\StepController@show');
			Route::get('/', 'API\StepController@showAll');
			Route::put('/{stepId}', 'API\StepController@update');
			Route::delete('/{stepId}', 'API\StepController@destroy');
		});
	});
});
