<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityCompanyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("securitycompanylevel")->insert([
            [
                "level" => 1,
                "resourceSafeCapacity" => 5,
                "hasAlarm" => true,
                "hasPepperSpray" => true,
                "hasGasDispenser" => false,
                "hasReinforcedDoor" => false,
                "hasBodyGuard" => false,
                "hasSecurityGuard" => false,
                "hasCyberDefense" => false,
                "hasAntiAISystem" => false,
                "hasContainmentSystem" => false,
            ],
            [
                "level" => 2,
                "resourceSafeCapacity" => 10,
                "hasAlarm" => true,
                "hasPepperSpray" => true,
                "hasGasDispenser" => true,
                "hasReinforcedDoor" => true,
                "hasBodyGuard" => false,
                "hasSecurityGuard" => false,
                "hasCyberDefense" => false,
                "hasAntiAISystem" => false,
                "hasContainmentSystem" => false,
            ],
            [
                "level" => 3,
                "resourceSafeCapacity" => 15,
                "hasAlarm" => true,
                "hasPepperSpray" => true,
                "hasGasDispenser" => true,
                "hasReinforcedDoor" => true,
                "hasBodyGuard" => true,
                "hasSecurityGuard" => true,
                "hasCyberDefense" => false,
                "hasAntiAISystem" => false,
                "hasContainmentSystem" => false,
            ],
            [
                "level" => 4,
                "resourceSafeCapacity" => 20,
                "hasAlarm" => true,
                "hasPepperSpray" => true,
                "hasGasDispenser" => true,
                "hasReinforcedDoor" => true,
                "hasBodyGuard" => true,
                "hasSecurityGuard" => true,
                "hasCyberDefense" => true,
                "hasAntiAISystem" => false,
                "hasContainmentSystem" => false,
            ],
            [
                "level" => 5,
                "resourceSafeCapacity" => 25,
                "hasAlarm" => true,
                "hasPepperSpray" => true,
                "hasGasDispenser" => true,
                "hasReinforcedDoor" => true,
                "hasBodyGuard" => true,
                "hasSecurityGuard" => true,
                "hasCyberDefense" => true,
                "hasAntiAISystem" => true,
                "hasContainmentSystem" => false,
            ],
            [
                "level" => 6,
                "resourceSafeCapacity" => 30,
                "hasAlarm" => true,
                "hasPepperSpray" => true,
                "hasGasDispenser" => true,
                "hasReinforcedDoor" => true,
                "hasBodyGuard" => true,
                "hasSecurityGuard" => true,
                "hasCyberDefense" => true,
                "hasAntiAISystem" => true,
                "hasContainmentSystem" => true,
            ],
        ]);
    }
}
