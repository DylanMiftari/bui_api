<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;

class CompanyService {

    protected MoneyService $moneyService;

    public function __construct(MoneyService $moneyService) {
        $this->moneyService = $moneyService;
    }

    public function createCompany(User $user, string $name, string $type): Company {
        $company = Company::create([
            "name" => $name,
            "id_player" => $user->id,
            "company_type" => $type,
            "city_id" => $user->city_id
        ]);
        $this->moneyService->pay($user, config("company.creationPrice"));
        return $company;
    }

}