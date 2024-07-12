<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Estate;
use App\Models\User;

class EstateService extends CompanyService {

    public function createEstate(User $user, string $name): Company {
        $company = parent::createCompany($user, $name, "estate_agency");
        $estate = Estate::create([
            "companyId" => $company->id,
        ]);

        return $company;
    }

}