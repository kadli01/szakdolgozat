<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;

use App\User;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$users = User::orderBy('created_at', 'DESC')->paginate(10);

		return view('admin.user.index', compact('users'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$user = User::where('id', $id)->first();

		if(!$user)
		{
			return redirect()->back()->withErrors('User not found');
		}

		return view('admin.user.show', compact('user'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		if(!$user)
		{
			return redirect()->back()->withErrors('User not found');
		}

		return view('admin.user.edit', compact('user'));
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
			'first_name'        => 'required|string|max:255',
			'last_name'         => 'required|string|max:255',
		]);

		if($validator->fails())
		{
			return redirect()
						->back()
						->withErrors($validator)
						->withInput();
		}

		if (!$user = User::find($id)) 
		{
			return redirect()->back()->withErrors('User not found.');
		}

		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;

		if($user->save())
		{
			return redirect(route('users.show', ['id' => $user->id]))->withSuccess('User successfully updated!');
		}

		return redirect()->back()->withErrors('Error while updating the user.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$user = User::where('id', $id)->first();

		if(!$user)
		{
			return redirect()->back()->withErrors('User not found');
		} 


		//detach user's saved items

		$user->foods()->detach();

		if($user->delete())
		{
			return redirect(route('users.index'))->with('success', 'User successfully deleted');
		}
			
		return redirect()->back()->withInput()->with('error', 'Error while deleting user'); 
	}
}
