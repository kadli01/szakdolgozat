<?php

use Faker\Generator as Faker;

$factory->define(App\Food::class, function (Faker $faker) {
    return [
        'name' 			=> $faker->word,
        'energy'		=> rand(1, 600),
        'protein'		=> rand(1, 50),
        'fat'			=> rand(1, 50),
        'carbohydrate' 	=> rand(1, 50),
        'sugar' 		=> rand(1, 50),
        'salt' 			=> rand(1, 50),
        'fiber'			=> rand(1, 50),
        // 'category_id'	=> rand(0, App\Category::max('id')),
    ];
});
