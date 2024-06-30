<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ids must not be changed
        DB::table("resource")->insert([
            [
                "id" => 1,
                "name" => "Terre",
                "marketPrice" => 0.25,
                "levelToMine" => 1,
            ],
            [
                "id" => 2,
                "name" => "Pierre",
                "marketPrice" => 0.75,
                "levelToMine" => 1,
            ],
            [
                "id" => 3,
                "name" => "Sable",
                "marketPrice" => 2.15,
                "levelToMine" => 1,
            ],
            [
                "id" => 4,
                "name" => "Gravier",
                "marketPrice" => 2.15,
                "levelToMine" => 1,
            ],
            [
                "id" => 5,
                "name" => "Bois",
                "marketPrice" => 4,
                "levelToMine" => 1,
            ],
            [
                "id" => 6,
                "name" => "Eau",
                "marketPrice" => 0.15,
                "levelToMine" => 1,
            ],
            [
                "id" => 7,
                "name" => "Charbon",
                "marketPrice" => 50,
                "levelToMine" => 2,
            ],
            [
                "id" => 8,
                "name" => "Fer",
                "marketPrice" => 130,
                "levelToMine" => 2,
            ],
            [
                "id" => 9,
                "name" => "Marbre",
                "marketPrice" => 90,
                "levelToMine" => 2,
            ],
            [
                "id" => 10,
                "name" => "Magma",
                "marketPrice" => 90,
                "levelToMine" => 3,
            ],
            [
                "id" => 11,
                "name" => "Or",
                "marketPrice" => 155,
                "levelToMine" => 3,
            ],
            [
                "id" => 12,
                "name" => "Diamant",
                "marketPrice" => 500,
                "levelToMine" => 4,
            ],
            [
                "id" => 13,
                "name" => "Uranium",
                "marketPrice" => 525,
                "levelToMine" => 4,
            ],
            [
                "id" => 14,
                "name" => "Pétrole",
                "marketPrice" => 320,
                "levelToMine" => 3,
            ],
            [
                "id" => 15,
                "name" => "Emeraude",
                "marketPrice" => 900,
                "levelToMine" => 5,
            ],
            [
                "id" => 16,
                "name" => "Nickel",
                "marketPrice" => 450,
                "levelToMine" => 4,
            ],
            [
                "id" => 17,
                "name" => "Antimatière",
                "marketPrice" => 2500000,
                "levelToMine" => 6,
            ],
            [
                "id" => 18,
                "name" => "Verre",
                "marketPrice" => 3,
                "levelToMine" => null,
            ],
            [
                "id" => 19,
                "name" => "Plastique",
                "marketPrice" => 95,
                "levelToMine" => null,
            ],
            [
                "id" => 20,
                "name" => "Acier",
                "marketPrice" => 100,
                "levelToMine" => null,
            ],
            [
                "id" => 21,
                "name" => "Gaz",
                "marketPrice" => 12.5,
                "levelToMine" => null,
            ],
            [
                "id" => 22,
                "name" => "Cuivre",
                "marketPrice" => 40,
                "levelToMine" => null,
            ],
            [
                "id" => 23,
                "name" => "Tissu",
                "marketPrice" => 1.5,
                "levelToMine" => null,
            ],
            [
                "id" => 24,
                "name" => "Titane",
                "marketPrice" => 120,
                "levelToMine" => null,
            ],
            [
                "id" => 25,
                "name" => "Béton",
                "marketPrice" => 2,
                "levelToMine" => null,
            ],
            [
                "id" => 26,
                "name" => "Bois traité",
                "marketPrice" => 7,
                "levelToMine" => null,
            ],
            [
                "id" => 27,
                "name" => "Lapis-Lazuli",
                "marketPrice" => 450,
                "levelToMine" => null,
            ],
            [
                "id" => 28,
                "name" => "Plutonium",
                "marketPrice" => 500,
                "levelToMine" => null,
            ],
            [
                "id" => 29,
                "name" => "Osmium",
                "marketPrice" => 350,
                "levelToMine" => null,
            ],
            [
                "id" => 30,
                "name" => "Béton armé",
                "marketPrice" => 65,
                "levelToMine" => null,
            ],
            [
                "id" => 31,
                "name" => "Anti-atome stable",
                "marketPrice" => 3500000,
                "levelToMine" => null,
            ]
        ]);
    }
}
