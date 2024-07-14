<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Get all constants
     * @return void
     */
    public function index() {
        return response()->json([
            "maxCompaniesPerPlayer" => config("player.max_companies", 3),
            "companyCreationPrice" => config("company.creationPrice", 2500),
            "companyTypes" => [
                Company::COMPANY_TYPE[0] => Company::FRENCH_COMPANY_TYPE[0],
                Company::COMPANY_TYPE[1] => Company::FRENCH_COMPANY_TYPE[1],
                Company::COMPANY_TYPE[2] => Company::FRENCH_COMPANY_TYPE[2],
                Company::COMPANY_TYPE[3] => Company::FRENCH_COMPANY_TYPE[3],
                Company::COMPANY_TYPE[4] => Company::FRENCH_COMPANY_TYPE[4],
                Company::COMPANY_TYPE[5] => Company::FRENCH_COMPANY_TYPE[5],
            ]
        ]);
    }
}
