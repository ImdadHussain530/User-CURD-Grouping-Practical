<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cities')->insert([
            // California
            ['state_id' => 1, 'name' => 'Los Angeles'],
            ['state_id' => 1, 'name' => 'San Francisco'],
            
            // Texas
            ['state_id' => 2, 'name' => 'Houston'],
            ['state_id' => 2, 'name' => 'Dallas'],
            
            // Florida
            ['state_id' => 3, 'name' => 'Miami'],
            ['state_id' => 3, 'name' => 'Orlando'],
            
            // Ontario
            ['state_id' => 4, 'name' => 'Toronto'],
            ['state_id' => 4, 'name' => 'Ottawa'],
            
            // Quebec
            ['state_id' => 5, 'name' => 'Montreal'],
            ['state_id' => 5, 'name' => 'Quebec City'],
            
            // Maharashtra
            ['state_id' => 6, 'name' => 'Mumbai'],
            ['state_id' => 6, 'name' => 'Pune'],
            
            // Karnataka
            ['state_id' => 7, 'name' => 'Bangalore'],
            ['state_id' => 7, 'name' => 'Mysore'],
            
            // New South Wales
            ['state_id' => 8, 'name' => 'Sydney'],
            ['state_id' => 8, 'name' => 'Newcastle'],
            
            // Victoria
            ['state_id' => 9, 'name' => 'Melbourne'],
            ['state_id' => 9, 'name' => 'Geelong'],
            
            // England
            ['state_id' => 10, 'name' => 'London'],
            ['state_id' => 10, 'name' => 'Manchester'],
            
            // Scotland
            ['state_id' => 11, 'name' => 'Edinburgh'],
            ['state_id' => 11, 'name' => 'Glasgow'],
        ]);
    }
}
