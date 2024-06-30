<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ids must not be changed
        DB::table('city')->insert([
            [
                "id" => 1,
                "name" => "Dakar",
                "country" => "Sénégal",
                "maxLevelOfCorp" => 2,
                "weeklyTaxes" => 500,
                "rank" => 1
            ],
            [
                "id" => 2,
                "name" => "Las Vegas",
                "country" => "États-Unis",
                "maxLevelOfCorp" => 4,
                "weeklyTaxes" => 30000,
                "rank" => 3
            ],
            [
                "id" => 3,
                "name" => "Paris",
                "country" => "France",
                "maxLevelOfCorp" => 5,
                "weeklyTaxes" => 45000,
                "rank" => 4
            ],
            [
                "id" => 4,
                "name" => "New York",
                "country" => "États-Unis",
                "maxLevelOfCorp" => 6,
                "weeklyTaxes" => 50000,
                "rank" => 5
            ]
        ]);
    }
}
