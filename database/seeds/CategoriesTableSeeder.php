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
        	],
        	[
        		'name' => 'Grain products',
        	],
        	[
        		'name' => 'Vegetables',
        	],
        	[
        		'name' => 'Fishes',
        	],
        	[
        		'name' => 'Seeds',
        	],
        	[
        		'name' => 'Fruits',
        	],
        	[
        		'name' => 'Dairy products',
        	],
        	[
        		'name' => 'Meats',
        	],
        	[
        		'name' => 'Other products',
        	],
        ];

        foreach ($categories as $category) {
        	App\Category::insert($category);
        }
    }
}
