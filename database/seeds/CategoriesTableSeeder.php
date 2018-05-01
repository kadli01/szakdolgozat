<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
        	[
        		'name' => 'Uncategorized',
        		'image' => '',
        	],
        	[
        		'name' => 'Grain products',
        		'image' => '',
        	],
        	[
        		'name' => 'Vegetables',
        		'image' => '',
        	],
        	[
        		'name' => 'Fishes',
        		'image' => '',
        	],
        	[
        		'name' => 'Seeds',
        		'image' => '',
        	],
        	[
        		'name' => 'Fruits',
        		'image' => '',
        	],
        	[
        		'name' => 'Dairy products',
        		'image' => '',
        	],
        	[
        		'name' => 'Meats',
        		'image' => '',
        	],
        	[
        		'name' => 'Other products',
        		'image' => '',
        	],
        ];

        foreach ($categories as $category) {
        	App\Category::insert($category);
        }
    }
}
