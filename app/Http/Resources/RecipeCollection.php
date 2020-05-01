<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserCollection as UserResource;
use App\Http\Resources\IngredientCollection as IngredientResource;
use App\Http\Resources\StepCollection as StepResource;

class RecipeCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
	    return [
		    'id' => $this->id,
		    'title' => $this->title,
		    'description' => $this->description,
		    'user' => new UserResource($this->user),
		    'ingredient' => new IngredientResource($this->ingredients),
		    'step' => new StepResource($this->steps),
		    'created_at' => $this->created_at,
		    'updated_at' => $this->updated_at,
	    ];
    }
}
