<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'is_verified',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	 /**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	 /**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	public function foods()
	{
		return $this->belongsToMany(Food::class, 'user_foods', 'user_id', 'food_id')->withPivot('date', 'quantity', 'id')
			->selectRaw(
				'foods.id,
				foods.name,
				foods.energy*user_foods.quantity/100 as energy,
				foods.protein*user_foods.quantity/100 as protein,
				foods.fat*user_foods.quantity/100 as fat,
				foods.carbohydrate*user_foods.quantity/100 as carbohydrate,
				foods.sugar*user_foods.quantity/100 as sugar,
				foods.salt*user_foods.quantity/100 as salt,
				foods.fiber*user_foods.quantity/100 as fiber,
				foods.category_id'
				// user_foods.*'
			);
	}
}
