<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Mafia;
use App\Models\User;

class MafiaService extends CompanyService {
    
    public function createMafia(User $user, string $name): Company {
        $company = parent::createCompany($user, $name, "mafia");
        $mafia = Mafia::create([
            "companyId" => $company->id,
        ]);

        return $company;
    }

}