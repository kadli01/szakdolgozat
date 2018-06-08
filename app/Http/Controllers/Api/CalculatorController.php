<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use \Validator;
use \JWTAuth;

use App\Category;
use App\Food;
use App\UserFood;

class CalculatorController extends ResponseController
{
    public function index(Request $request)
    {

        $user = JWTAuth::parseToken()->authenticate();

    	$categories = Category::with('foods')->get();
    	$userFoods = $user->foods->where('pivot.date', $request->date);
    	
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

    public function delete(Request $request)
    {
    	$userFood = UserFood::where('id', $request->id)->first();

    	if ($userFood) {
    		$userFood->delete();
    		return $this->respondWithSuccess();
    	} else {
    		return $this->respondNotFound();
    	}
    }

    public function statistics(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'startDate'   => 'nullable|date_format: "Y-m-d"',
            'endDate'     => 'nullable|date_format: "Y-m-d"|after:startDate',
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError($validator->messages());
        }
        $startDate = $request->startDate;
        $endDate = $request->endDate;

    	$user = JWTAuth::parseToken()->authenticate();
    	// $userFoods = $user->foods()
    	// 	->whereBetween('date', [Carbon::today()->subMonth(), Carbon::today()])
    	// 	->groupBy('date')
    	// 	->selectRaw('date, SUM(energy * quantity/100) as energy')
    	// 	->get();

    	$userFoods = Food::leftJoin('user_foods', 'foods.id', 'user_foods.food_id')
    		->where('user_foods.user_id', $user->id)
    		->whereBetween('date', [$startDate, $endDate])
    		->groupBy('date')
    		->selectRaw('date,
    			SUM(energy * quantity/100) as energy, 
    			SUM(protein * quantity/100) as protein,
    			SUM(fat * quantity/100) as fat,
    			SUM(carbohydrate * quantity/100) as carbohydrate,
    			SUM(sugar * quantity/100) as sugar,
    			SUM(salt * quantity/100) as salt,
    			SUM(fiber * quantity/100) as fiber, 
    			SUM(quantity) as quantity')
    		->get();
            
    	$userCategories = Food::leftJoin('user_foods', 'foods.id', 'user_foods.food_id')
    		->leftJoin('categories', 'foods.category_id', 'categories.id')
    		->where('user_foods.user_id', $user->id)
    		->whereBetween('date',  [$startDate, $endDate])
    		->groupBy('category_id')
    		->selectRaw('categories.name, SUM(user_foods.quantity) as quantity')
    		->get();

        $totalQuantity = array_sum($userCategories->pluck('quantity')->toArray());

        $userCategories->transform(function($item, $key) use($totalQuantity){
            $item->percentage = number_format($item->quantity/$totalQuantity*100, 1, '.', '');
            return $item;
        });

        $userCategories['colors'] = [
            'rgba(111, 255, 15, 0.55)', 
            'rgba(111, 255, 155, 0.55)',
            'rgba(255, 50, 15, 0.55)',
            'rgba(55, 50, 15, 0.55)',
            'rgba(155, 50, 15, 0.55)',
            'rgba(155, 150, 15, 0.55)',
            'rgba(155, 150, 115, 0.55)',
            'rgba(155, 50, 115, 0.55)',
            'rgba(155, 50, 215, 0.55)',
        ];

    	return $this->respondWithSuccess(['userFoods' => $userFoods, 'userCategories' => $userCategories]);
    }
}
