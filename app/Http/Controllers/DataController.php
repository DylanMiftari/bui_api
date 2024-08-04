<?php

namespace App\Http\Controllers;

use App\Models\BankLevel;
use App\Models\CasinoLevel;
use App\Models\Company;
use App\Models\CompanyLevel;
use App\Models\EstateLevel;
use App\Models\FactoryLevel;
use App\Models\MafiaLevel;
use App\Models\MineLevel;
use App\Models\SecurityLevel;

class DataController extends Controller
{
    /**
     * Get all constants
     * @return void
     */
    public function index() {
        $res = [
            "maxCompaniesPerPlayer" => config("player.max_companies", 3),
            "companyCreationPrice" => config("company.creationPrice", 2500),
            "companyTypes" => [
                Company::COMPANY_TYPE[0] => Company::FRENCH_COMPANY_TYPE[0],
                Company::COMPANY_TYPE[1] => Company::FRENCH_COMPANY_TYPE[1],
                Company::COMPANY_TYPE[2] => Company::FRENCH_COMPANY_TYPE[2],
                Company::COMPANY_TYPE[3] => Company::FRENCH_COMPANY_TYPE[3],
                Company::COMPANY_TYPE[4] => Company::FRENCH_COMPANY_TYPE[4],
                Company::COMPANY_TYPE[5] => Company::FRENCH_COMPANY_TYPE[5],
            ],
            "minelevel" => MineLevel::all()->toArray(),
            "casinolevel" => [],
            "banklevel" => [],
            "mafialevel" => [],
            "estatelevel" => [],
            "factorylevel" => [],
            "securitylevel" => [],
            "new_mine_prices" => config("mine.newMinePrice"),
            "max_mine_level" => config("mine.maxLevel"),
            "change_city_cost" => config("city.change_cost"),
            "default_travel_time" => config("city.default_travel_time"),
            "travel_tier_multiplicator" => config("city.travel_tier_multiplicator"),
            "companylevels" => CompanyLevel::all(),

            "cyberattack_min_target_level" => config("rob.cyberattack.min_target_level"),
            "cyberattack_cost" => config("rob.cyberattack.cost"),
            "cyberattack_chance" => config("rob.cyberattack.chance"),
            "cyberattack_money_robed" => config("rob.cyberattack.money_robed"),

            "ai_drone_house_cost" => config("rob.ai_drone.house.cost"),
            "ai_drone_house_chance" => config("rob.ai_drone.house.chance"),
            "ai_drone_house_min_robed_quantity" => config("rob.ai_drone.house.min_robed_quantity"),
            "ai_drone_house_max_robed_quantity" => config("rob.ai_drone.house.max_robed_quantity"),
            "ai_drone_house_min_target_money" => config("rob.ai_drone.house.min_target_money"),
            "ai_drone_player_cost" => config("rob.ai_drone.player.cost"),
            "ai_drone_player_chance" => config("rob.ai_drone.player.chance"),
            "ai_drone_player_min_robed_quantity" => config("rob.ai_drone.player.min_robed_quantity"),
            "ai_drone_player_max_robed_quantity" => config("rob.ai_drone.player.max_robed_quantity"),
            "ai_drone_player_min_target_money" => config("rob.ai_drone.player.min_target_money"),

            "shoplifting_cost" => config("rob.shoplifting.cost"),
            "shoplifting_chance" => config("rob.shoplifting.chance"),
            "shoplifting_base_robed_money_min" => config("rob.shoplifting.base_robed_money_min"),
            "shoplifting_base_robed_money_max" => config("rob.shoplifting.base_robed_money_max"),

            "phishing_min_target_money" => config("rob.phishing.min_target_money"),
            "phishing_cost" => config("rob.phishing.cost"),
            "phishing_chance" => config("rob.phishing.chance"),
            "phishing_robed_quantity" => config("rob.phishing.robed_quantity"),

            "estate_robot_increase_price" => config("estate.robot_construction.increase_price"),
            "estate_robot_decrease_duration" => config("estate.robot_construction.decrease_duration"),
            "estate_robot_2_increase_price" => config("estate.robot_2_construction.increase_price"),
            "estate_robot_2_decrease_duration" => config("estate.robot_2_construction.decrease_duration"),
        ];

        // company level
        for($i=1; $i<= config("company.maxLevel"); $i++) {
            $res["casinolevel"]["l".$i] = CasinoLevel::find($i)->toArray();
            $res["banklevel"]["l".$i] = BankLevel::find($i)->toArray();
            $res["mafialevel"]["l".$i] = MafiaLevel::find($i)->toArray();
            $res["estatelevel"]["l".$i] = EstateLevel::find($i)->toArray();
            $res["factorylevel"]["l".$i] = FactoryLevel::find($i)->toArray();
            $res["securitylevel"]["l".$i] = SecurityLevel::find($i)->toArray();
        }

        return response()->json($res);
    }
}
