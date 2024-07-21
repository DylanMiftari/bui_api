<?php

namespace App\Http\Controllers;

use App\Models\BankLevel;
use App\Models\CasinoLevel;
use App\Models\Company;
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
