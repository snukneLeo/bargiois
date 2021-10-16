<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class qtPizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert default values on statitics table
        DB::table('statistics')
            ->insert([
                'qt_pizza' => 0,
                'qt_user' => 0,
                'qt_orders' => 0,
                'total' => 0,
                'created_at' => now()
            ]);
    }
}
