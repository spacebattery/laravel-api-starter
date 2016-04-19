<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

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
        $faker = Faker::create();

        // admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => bcrypt($faker->name),
        ]);
    }
}
