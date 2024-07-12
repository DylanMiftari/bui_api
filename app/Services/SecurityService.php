<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Security;
use App\Models\User;

class SecurityService extends CompanyService {
    
    public function createSecurity(User $user, string $name): Company {
        $company = parent::createCompany($user, $name, "security");
        $security = Security::create([
            "companyId" => $company->id,
        ]);

        return $company;
    }

}