<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\StepCollection as StepResource;
use App\Http\Controllers\Controller;
use App\Models\Step;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class StepController extends Controller
{
	
	/**
	 * To add a new step for recipe in storage.
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
			'step_order' => 'required|integer|min:1',
			'description' => 'required|string|min:15',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		return new StepResource(Step::create($input));
	}
	
	/**
	 * Display the specified step by stepId.
	 *
	 * @param  \App\Models\Step\id  $stepId
	 * @return \Illuminate\Http\Response
	 */
	public function show($recipeId, $stepId)
	{
		$validator = Validator::make(['step_id' => $stepId], [
			'step_id' => 'exists:steps,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		return new StepResource(Step::find($stepId));
	}
	
	/**
	 * Update the specified step in storage as per given step id.
	 *
	 * @param  \App\Models\Step\id  $stepId
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update($recipeId, $stepId, Request $request)
	{
		$validator = Validator::make(['step_id' => $stepId], [
			'step_id' => 'exists:steps,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		//get respective step by id
		$step = Step::find($stepId);
		
		$input = $request->all();
		
		$validator = Validator::make($input, [
			'step_order' => 'integer|min:1',
			'description' => 'string|min:15',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		
		if($step->recipe->user_id !== Auth::user()->id) {
			return response()->json(['success' => false, 'error'=>'You can\'t update Step as Recipe doesn\'t belongs to you.'], 401);
		}
		if(isset($input['step_order'])) {
			$step->step_order = $input['step_order'];
		}
		
		if(isset($input['description'])) {
			$step->description = $input['description'];
		}
		
		$step->save();
		
		return new StepResource($step);
	}
	
	/**
	 * Display all steps for given recipes.
	 *
	 * @param  \App\Models\Recipe\id $recipeId
	 * @return \Illuminate\Http\Response
	 */
	public function showAll($recipeId)
	{
		return new StepResource(Step::where('recipe_id', $recipeId)->orderBy('step_order')->get());
	}
	
	/**
	 * Remove the step resource from storage.
	 *
	 * @param  \App\Models\Step\id $stepId
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($recipeId, $stepId)
	{
		$validator = Validator::make(['step_id' => $stepId], [
			'step_id' => 'exists:steps,id',
		]);
		
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		
		$step = Step::find($stepId);
		
		$recipeId = $step->recipe_id;
		$step->delete();
		
		//correction in step_order
		$steps = Step::where('recipe_id', $recipeId)->orderBy('step_order')->get();
		$prevStep = 0;
		foreach ($steps as &$step) {
			if(($prevStep + 1) != $step->step_order){
				Step::where('id', $step->id)->update(['step_order' => $prevStep+1]);
			}
			$prevStep++;
		}
		
		return response()->json(['data' => 'Step has been Deleted.'], 200);
	}
}
