<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BalancesTableSeeder::class
        ]);

        $this->call([
            BaseSeeder::class
        ]);

        $this->call([
            LifeOfLuxury2Seeder::class
        ]);

    }
}
