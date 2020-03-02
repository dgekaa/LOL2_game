<?php

use Illuminate\Database\Seeder;

class BalancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('v2_balances')->insert([
            'user_id' => 1,
            'mode' => 'demo',
            'value' => 10000
        ]);
    }
}
