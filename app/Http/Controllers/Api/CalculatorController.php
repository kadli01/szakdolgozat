<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;
use \JWTAuth;

use App\Category;
use App\Food;

class CalculatorController extends ResponseController
{
    public function index()
    {
    	$categories = Category::with('foods')->get();

    	$user = JWTAuth::parseToken()->authenticate();
    	$userFoods = $user->foods;

    	return $this->respondWithSuccess(['categories' => $categories, 'userFoods' => $userFoods]);
    }

    public function add(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'date' 		=> 'required|date',
			'itemId' 	=> 'required|integer',
			'quantity' 	=> 'required|integer',
		]);

		if ($validator->fails()) {
			return $this->respondValidationError($validator->messages());
		}

		$user = JWTAuth::parseToken()->authenticate();

		$user->foods()->attach($request->itemId, ['quantity' => $request->quantity, 'date' => $request->date]);
		$userFood = $user->foods->last()->pivot->id;
		$food = Food::where('id', $request->itemId)->first();

		$returnData = ['userFood' => $userFood, 'food' => $food];

    	return $this->respondWithSuccess($returnData, 'success');
    }
}
