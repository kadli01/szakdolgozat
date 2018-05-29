<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\Food;
use App\Category;

class FoodController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$foods = Food::orderBy('name', 'ASC');
		
		if ($request->keyword) 
		{
			$foods = $foods->where('name', 'LIKE', '%' . $request->keyword . '%');			
		}

		if ($request->category) 
		{
			$foods = $foods->where('category_id', $request->category);
		}
		
		$foods = $foods->paginate(10);

		$categories = Category::all();

		return view('admin.food.index', compact('foods', 'categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$food = new Food;
		$categories = Category::all();
		
		return view('admin.food.create', compact('food', 'categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(),
		[
			'name'        	=> 'required|string|max:255',
			'category_id' 	=> 'nullable|integer',
			'energy' 		=> 'required|integer',
			'protein' 		=> 'required|integer',
			'fat' 			=> 'required|integer',
			'sugar' 		=> 'required|integer',
			'carbohydrate'  => 'required|integer',
			'salt' 			=> 'required|integer',
			'fiber' 		=> 'required|integer',
		]);

		if($validator->fails())
		{
			return redirect()
						->back()
						->withErrors($validator)
						->withInput();
		}

		$food = new Food;

		$food->name = $request->name;
		if ($request->category_id) 
		{
			$food->category_id = $request->category_id;	
		}
		$food->energy = $request->energy;
		$food->protein = $request->protein;
		$food->fat = $request->fat;
		$food->sugar = $request->sugar;
		$food->carbohydrate = $request->carbohydrate;
		$food->salt = $request->salt;
		$food->fiber = $request->fiber;

		if ($food->save()) 
		{
			return redirect(route('foods.index'))->with('success', 'Item successfully added!');
		}

		return redirect()->back()->withInput()->with('error', 'Error while adding item!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$food = Food::where('id', $id)->first();
		$categories = Category::all();

		if(!$food)
		{
			return redirect()->back()->withErrors('Item not found');
		}

		return view('admin.food.show', compact('food', 'categories'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$food = Food::where('id', $id)->first();
		$categories = Category::all();

		if(!$food)
		{
			return redirect()->back()->withErrors('Item not found');
		}

		return view('admin.food.edit', compact('food', 'categories'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(),
		[
			'name'        	=> 'required|string|max:255',
			'category_id' 	=> 'nullable|integer',
			'energy' 		=> 'required|integer',
			'protein' 		=> 'required|integer',
			'fat' 			=> 'required|integer',
			'sugar' 		=> 'required|integer',
			'carbohydrate'  => 'required|integer',
			'salt' 			=> 'required|integer',
			'fiber' 		=> 'required|integer',
		]);

		if($validator->fails())
		{
			return redirect()
						->back()
						->withErrors($validator)
						->withInput();
		}

		$food = Food::where('id', $id)->first();

		$food->name = $request->name;
		if ($request->category_id) 
		{
			$food->category_id = $request->category_id;	
		}
		$food->energy = $request->energy;
		$food->protein = $request->protein;
		$food->fat = $request->fat;
		$food->sugar = $request->sugar;
		$food->carbohydrate = $request->carbohydrate;
		$food->salt = $request->salt;
		$food->fiber = $request->fiber;

		if ($food->save()) 
		{
			return redirect(route('foods.index'))->with('success', 'Item successfully updated!');
		}

		return redirect()->back()->withInput()->with('error', 'Error while updating item!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$food = Food::where('id', $id)->first();

		if(!$food)
		{
			return redirect()->back()->withErrors('Item not found');
		} 


		//detach items's 

		// $food->detach(); ????????????

		if($food->delete())
		{
			return redirect(route('foods.index'))->with('success', 'Item successfully deleted');
		}
			
		return redirect()->back()->withInput()->with('error', 'Error while deleting item'); 
	}
}
