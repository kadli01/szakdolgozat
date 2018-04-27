<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;
use \DB;
use \JWTAuth;
use Carbon\Carbon;

use App\User;

class AuthController extends ResponseController
{
	public function register(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' 		=> 'required|email|unique:users,email|max:255',
			'password'		=> 'required|min:6|confirmed|string|max:255',
			'first_name'	=> 'required|string|max:255',
			'last_name'		=> 'required|string|max:255',
			'phone'			=> 'nullable|string|max:15',
			'gender'		=> 'required|integer',
			//google autocomplete?
			'country'		=> 'nullable',
			'city'			=> 'nullable',
			'street'		=> 'nullable',
			'house_numer' 	=> 'nullable',

			'birth_year'	=> 'required|integer|min:1900|max:' . Carbon::today()->format('Y'),
			'birth_month'	=> 'required|integer|min:1|max:12',
			'birth_day'		=> 'required|integer|min:1|max:31',
		]);

		if ($validator->fails()) {
			return $this->respondValidationError($validator->messages());
		}

		//Generate verification code
		$verificationCode = str_random(30);

		$user = new User;
		$user->email 		= $request->email;
		$user->password 	= bcrypt($request->password);
		$user->first_name 	= $request->first_name;
		$user->last_name 	= $request->last_name;
		$user->gender 		= $request->gender;
		$user->phone 		= $request->phone;

		$birth_date = $request->birth_year . '-' . $request->birth_month . '-' . $request->birth_day;
		$user->birth_date = $birth_date;

		if ($user->save())
		{
			DB::table('user_verifications')->insert([
				'user_id' => $user->id,
				'verification_code' => $verificationCode
			]);

			// TODO: send welcome/ email verification mail
			// try {
				
			// } catch (Exception $e) {
				
			// }

			return $this->respondWithSuccess($user, 'Successful registration!');
		}

		return $this->respondWithError('Error while registering.');
	}

    public function login(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'email' 		=> 'required|email',
			'password'		=> 'required',
		]);

		if($validator->fails())
		{
			return $this->respondValidationError($validator->messages());
		}

		$credentials = $request->only('email', 'password');

		try
		{
			// attempt to verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials))
			{
				return $this->respondWithError('We cant find an account with theese credentials. Please make sure you entered the right information.');
			}
		}
		catch (JWTException $e)
		{
			// something went wrong whilst attempting to encode the token
			return $this->respondWithError('Failed to login, please try again.');
		}

		// all good so return the token
		return $this->respondWithSuccess(['token' => $token], 'Successful login!');
    }

    public function logout(Request $request)
    {	\Log::info(print_r($request->all(), true));
    	if (! $user = JWTAuth::parseToken()->authenticate()) 
    	{
    		return $this->respondWithError('User not found!');
    	}

    	$token = JWTAuth::getToken();
		JWTAuth::invalidate($token);

		return $this->respondWithSuccess([], 'Successful logout!');
    }

    public function password(Request $request)
    {
		$validator = Validator::make($request->all(), [
			'email' => 'required|email|max:255',
		]);

		if($validator->fails())
		{
			return $this->respondValidationError($validator->messages());
		}

		//send password reset email
	}

	public function passwordReset(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'token' => 'required',
			'password' => 'required|confirmed|string|min:6|max:255',
		]);

			if($validator->fails())
		{
			return $this->respondValidationError($validator->messages());
		}

		//reset password
	}


}
