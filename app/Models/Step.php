<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'recipe_id', 'step_order', 'description'
	];
	
	/**
	 * Go get recipe for this step
	 *
	 */
	public function recipe()
	{
		return $this->hasOne('App\Models\Recipe','id','recipe_id');
	}
}
