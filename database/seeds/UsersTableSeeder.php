<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create(['email' => 'krisztian.kadlicsko@gmail.com', 'is_verified' => 1]);
        
        $foods = App\Food::get();

        factory(User::class, 20)->create()
            ->each(function ($user) use ($foods)
            {
                $startDate = Carbon::today()->subMonth();
                $endDate = Carbon::today();
                while ($endDate >= $startDate) 
                {
                    for ($i=0; $i < 5; $i++) 
                    { 
                        $user->foods()->attach($foods->random()->id,
                            ['date' => $startDate->toDateString(), 'quantity' => rand(50, 250)]);  
                    }
                    $startDate->addDay();
                }
            });
    }
}
