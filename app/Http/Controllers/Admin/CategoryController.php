<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$categories = Category::orderBy('name', 'ASC')->paginate(10);

		return view('admin.category.index', compact('categories'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$category = new Category;

		return view('admin.category.create', compact('category'));
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
			'name'          => 'required|string|max:255',
			'image'         => 'nullable|mimes:jpeg,jpg,bmp,png|max:10240',
		]);

		if($validator->fails())
		{
			return redirect()
						->back()
						->withErrors($validator)
						->withInput();
		}

		$category = new Category;

		$category->name = $request->name;
		if ($request->image) 
		{
			$category->image = $request->image;
		} else {
			$category->image = '';
		}

		if ($category->save()) 
		{
			return redirect(route('categories.index'))->with('success', 'Category successfully added!');
		}

		return redirect()->back()->withInput()->with('error', 'Error while adding category!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$category = Category::where('id', $id)->first();

		if(!$category)
		{
			return redirect()->back()->withErrors('Category not found');
		}

		return view('admin.category.show', compact('category'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$category = Category::where('id', $id)->first();

		if(!$category)
		{
			return redirect()->back()->withErrors('Category not found');
		}

		return view('admin.category.edit', compact('category'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$validator = Validator::make($request->all(),
		[
			'name'        	=> 'required|string|max:255',
			'image'         => 'nullable|mimes:jpeg,jpg,bmp,png|max:10240',
		]);

		if($validator->fails())
		{
			return redirect()
						->back()
						->withErrors($validator)
						->withInput();
		}

		$category = Category::where('id', $id)->first();

		$category->name = $request->name;
		if ($request->image) 
		{
			$category->image = $request->image;	
		}

		if ($category->save()) 
		{
			return redirect(route('foods.index'))->with('success', 'Category successfully updated!');
		}

		return redirect()->back()->withInput()->with('error', 'Error while updating category!');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$category = Category::where('id', $id)->first();

		if ($id == 1) 
		{
			return redirect()->back()->withErrors('Uncategorized can not be deleted.');
		}

		if(!$category)
		{
			return redirect()->back()->withErrors('Category not found');
		}

		$category->foods()->update(['category_id' => 1]);

		if($category->delete())
		{
			return redirect(route('categories.index'))->with('success', 'Category successfully deleted');
		}
			
		return redirect()->back()->withInput()->with('error', 'Error while deleting category'); 
	}
}
