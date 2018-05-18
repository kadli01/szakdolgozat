<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	public function foods()
	{
		return $this->hasMany(Food::class, 'category_id');
	}
}
