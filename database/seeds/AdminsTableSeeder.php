<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
			[
				'name' 		=> 'Kadlicskó Krisztián',
				'email' 	=> 'krisztian.kadlicsko@gmail.com',
				'password'	=> bcrypt('admin1')
			],
            [
                'name'      => 'Varga Péter',
                'email'     => 'vargapety97@gmail.com',
                'password'  => bcrypt('admin1')
            ],
		];

		Admin::insert($admins);
    }
}
