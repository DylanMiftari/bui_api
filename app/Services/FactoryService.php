<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Factory;
use App\Models\FactoryMachine;
use App\Models\User;

class FactoryService extends CompanyService {

    public function createFactory(User $user, string $name): Company {
        $company = parent::createCompany($user, $name, "factory");
        $factory = Factory::create([
            "companyId" => $company->id,
        ]);
        $factoryMachine = FactoryMachine::create([
            "factoryId" => $factory->id,
        ]);

        return $company;
    }

}