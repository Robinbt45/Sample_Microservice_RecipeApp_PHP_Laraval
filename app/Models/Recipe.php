<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'title', 'description', 'user_id'
	];
	
	
	/**
	 * Go get all ingredients of current recipe
	 *
	 */
	public function ingredients()
	{
		return $this->hasMany('App\Models\Ingredient','recipe_id','id');
	}
	
	/**
	 * Go get all steps of current recipe
	 *
	 */
	public function steps()
	{
		return $this->hasMany('App\Models\Step','recipe_id','id');
	}
	
	/**
	 * Go get all steps of current recipe
	 *
	 */
	public function user()
	{
		return $this->hasOne('App\Models\User','id','user_id');
	}
}
