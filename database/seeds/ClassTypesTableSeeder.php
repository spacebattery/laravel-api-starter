<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\ClassType;

class ClassTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $faker = Faker::create();

        $types = [
            ['name' => 'Regular Class'],
            ['name' => 'Adults Class'],
            ['name' => 'Group Class'],
        ];

        foreach ($types as $type) {
            ClassType::create($type);
        }
         */

        factory(ClassType::class, 50)->create();
    }
}
