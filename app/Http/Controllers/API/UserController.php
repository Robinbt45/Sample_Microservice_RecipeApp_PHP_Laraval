<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Resources\UserCollection as UserResource;

class UserController extends Controller
{
	public $successStatus = 200;
	
	/**
	 * login api
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function login(){
		if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
			$user = Auth::user();
			$success['token'] =  $user->createToken('MyApp')-> accessToken;
			return response()->json(['success' => true, 'data' =>  $success], $this-> successStatus);
		}
		else{
			return response()->json(['success' => false, 'error'=>'Unauthorised'], 401);
		}
	}
	
	/**
	 * Register api
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|email',
			'password' => 'required',
			'c_password' => 'required|same:password',
		]);
		if ($validator->fails()) {
			return response()->json(['success' => false, 'error'=>$validator->errors()], 401);
		}
		$input = $request->all();
		$input['password'] = bcrypt($input['password']);
		$user = User::create($input);
		$success['token'] =  $user->createToken('MyApp')-> accessToken;
		$success['name'] =  $user->name;
		return response()->json(['success' => true, 'data' =>  $success], 201);
	}
	
	/**
	 * details api
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function userDetails()
	{
		return new UserResource(Auth::user());
	}
}