<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'recipe_id', 'name', 'quantity'
	];
	
	/**
	 * Go get recipe for this ingredient
	 *
	 */
	public function recipe()
	{
		return $this->hasOne('App\Models\Recipe','id','recipe_id');
	}
}
