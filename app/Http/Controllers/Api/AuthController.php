<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;
use \DB;
use \Mail;
use \JWTAuth;
use Carbon\Carbon;

use \App\Mail\ResetPasswordMail;
use \App\Mail\UserVerifyMail;
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
			// 'phone'			=> 'nullable|string|max:15',
			'gender'		=> 'required|integer',
			//google autocomplete?
			// 'country'		=> 'nullable',
			// 'city'			=> 'nullable',
			// 'street'		=> 'nullable',
			// 'house_numer' 	=> 'nullable',

			'birth_year'	=> 'required|integer|min:1900|max:' . Carbon::today()->format('Y'),
			'birth_month'	=> 'required|integer|min:1|max:12',
			'birth_day'		=> 'required|integer|min:1|max:31',
		]);

		if ($validator->fails()) {
			return $this->respondValidationError($validator->messages());
		}

		$validator->after(function ($validator) use($request)
		{
			$date = Carbon::parse($request->birth_year . '-' . $request->birth_month . '-' . $request->birth_day);

			if ($date->day != $request->birth_day || $date->month != $request->birth_month) 
			{
				$validator->errors()->add('birth_year', 'Invalid date');
			}

		});

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

		$birth_date = $request->birth_year . '-' . $request->birth_month . '-' . $request->birth_day;
		$user->birth_date = $birth_date;

		if ($user->save())
		{
			DB::table('user_verifications')->insert([
				'user_id' => $user->id,
				'verification_code' => $verificationCode
			]);

		try {
			Mail::to($user->email)->queue(new UserVerifyMail($verificationCode, $request->url));

		} catch (Exception $e) {
			return $this->respondInternalError('Error while sendig email.');
		}

			return $this->respondWithSuccess($user, 'Successful registration! Please check your e-mails and click the verification link.');
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
		$user = User::where('email', $request->email)->first();
		if ($user->is_verified == 0) 
		{
			return $this->respondWithError('You have to verify your e-mail address befor logging in. Pleas check your e-mails');
		}
		// all good so return the token
		return $this->respondWithSuccess(['token' => $token], 'Successful login!');
    }

    public function logout(Request $request)
    {
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

		$user = User::where('email', $request->email)->first();

		if (!$user) {
			return $this->respondWithError('Email not found!');
		}

		$token = str_random(60);

		$url = $request->url . '/' . $token;

		try {
		 	Mail::to($request->email)->queue(new ResetPasswordMail($token, $url));

		} catch (Exception $e) {

			return $this->respondInternalError(trans('messages.email_error'));
		} 

		\DB::table('password_resets')->where('email', $request->email)->delete();
		\DB::table('password_resets')->insert(['email' => $request->email, 'token' => $token, 'created_at' => \Carbon\Carbon::now()]);

		return $this->respondWithSuccess([], 'Password reset email sent.');

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

		$email = \DB::table('password_resets')->where('token', $request->token)->value('email');
		
		if(!$email)
		{
			return $this->respondWithError('This link is invalid!');
		}

		$user = User::where('email', $email)->first();
		
		if (!$user) 
		{
			return $this->respondWithError('Email not found!');
		}

		$user->password = bcrypt($request->password);
		
		if ($user->save()) 
		{
			\DB::table('password_resets')->where('email', $email)->delete();
			
			return $this->respondWithSuccess([], 'Password successfully changed!');
		}
	}

	public function verifyEmail($token)
	{
		$record = DB::table('user_verifications')->where('verification_code', $token)->first();

		if(!is_null($record))
		{
			$userId = $record->user_id;
			
			$user = User::find($userId);

			if($user->is_verified == 1)
			{
				return $this->respondWithSuccess([], 'Account already verified.');
			}

			$user->update(['is_verified' => 1]);

			DB::table('user_verifications')->where('verification_code',$token)->delete();

			return $this->respondWithSuccess([], 'You have successfully verified your email address.');
		}

		return $this->respondWithError('Verification code is invalid.');
	}

}
