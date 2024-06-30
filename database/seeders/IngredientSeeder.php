<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredient')->insert([
            [
                "id_recipe" => 1,
                "id_resource" => 3,
                "quantity" => 2.0
            ],
            [
                "id_recipe" => 2,
                "id_resource" => 14,
                "quantity" => 0.4
            ],
            [
                "id_recipe" => 2,
                "id_resource" => 7,
                "quantity" => 0.1
            ],
            [
                "id_recipe" => 3,
                "id_resource" => 8,
                "quantity" => 0.8
            ],
            [
                "id_recipe" => 3,
                "id_resource" => 7,
                "quantity" => 0.3
            ],
            [
                "id_recipe" => 4,
                "id_resource" => 14,
                "quantity" => 0.2
            ],
            [
                "id_recipe" => 4,
                "id_resource" => 6,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 4,
                "id_resource" => 10,
                "quantity" => 0.3
            ],
            [
                "id_recipe" => 5,
                "id_resource" => 2,
                "quantity" => 0.8
            ],
            [
                "id_recipe" => 5,
                "id_resource" => 1,
                "quantity" => 0.4
            ],
            [
                "id_recipe" => 5,
                "id_resource" => 8,
                "quantity" => 0.4
            ],
            [
                "id_recipe" => 6,
                "id_resource" => 1,
                "quantity" => 1
            ],
            [
                "id_recipe" => 6,
                "id_resource" => 4,
                "quantity" => 1
            ],
            [
                "id_recipe" => 7,
                "id_resource" => 20,
                "quantity" => 1
            ],
            [
                "id_recipe" => 7,
                "id_resource" => 10,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 8,
                "id_resource" => 6,
                "quantity" => 1
            ],
            [
                "id_recipe" => 8,
                "id_resource" => 3,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 8,
                "id_resource" => 4,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 9,
                "id_resource" => 5,
                "quantity" => 1
            ],
            [
                "id_recipe" => 9,
                "id_resource" => 21,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 10,
                "id_resource" => 12,
                "quantity" => 1
            ],
            [
                "id_recipe" => 10,
                "id_resource" => 18,
                "quantity" => 1
            ],
            [
                "id_recipe" => 11,
                "id_resource" => 13,
                "quantity" => 1
            ],
            [
                "id_recipe" => 11,
                "id_resource" => 10,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 11,
                "id_resource" => 21,
                "quantity" => 1
            ],
            [
                "id_recipe" => 12,
                "id_resource" => 25,
                "quantity" => 0.8
            ],
            [
                "id_recipe" => 12,
                "id_resource" => 16,
                "quantity" => 0.8
            ],
            [
                "id_recipe" => 13,
                "id_resource" => 25,
                "quantity" => 1
            ],
            [
                "id_recipe" => 13,
                "id_resource" => 20,
                "quantity" => 0.5
            ],
            [
                "id_recipe" => 13,
                "id_resource" => 29,
                "quantity" => 0.1
            ],
            [
                "id_recipe" => 14,
                "id_resource" => 17,
                "quantity" => 0.1
            ],
        ]);
    }
}
