<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('states')->insert([
            // United States
            ['country_id' => 1, 'name' => 'California'],
            ['country_id' => 1, 'name' => 'Texas'],
            ['country_id' => 1, 'name' => 'Florida'],
            
            // Canada
            ['country_id' => 2, 'name' => 'Ontario'],
            ['country_id' => 2, 'name' => 'Quebec'],
            
            // India
            ['country_id' => 3, 'name' => 'Maharashtra'],
            ['country_id' => 3, 'name' => 'Karnataka'],
            
            // Australia
            ['country_id' => 4, 'name' => 'New South Wales'],
            ['country_id' => 4, 'name' => 'Victoria'],
            
            // United Kingdom
            ['country_id' => 5, 'name' => 'England'],
            ['country_id' => 5, 'name' => 'Scotland'],
        ]);
    }
}
