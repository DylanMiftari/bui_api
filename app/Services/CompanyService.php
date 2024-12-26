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
        $this->moneyService->pay($user, config("company.creationPrice"), "Création de l'entreprise : ".$name);
        return $company;
    }

    public function storeInSafe(Company $company, float $money) {
        $company->money_in_safe = round($company->money_in_safe + $money, 2);
        $company->save();
    }

    public function removeFromSafe(Company $company, float $money) {
        $company->money_in_safe = round($company->money_in_safe - $money, 2);
        $company->save();
    }

    public function desactivateCompany(Company $company) {
        $company->activated = false;
        $company->save();
    }

    public function upgradeCompany(Company $company) {
        $company->companylevel += 1;
        $company->save();

        switch($company->company_type) {
            case "bank":
                $company->bank->level++;
                $company->bank->save();
                break;
            case "casino":
                $company->casino->level++;
                $company->casino->save();
                break;
            case "factory":
                $company->factory->level++;
                $company->factory->save();
                break;
            case "estate_agency":
                $company->estateAgency->level++;
                $company->estateAgency->save();
                break;
            case "mafia":
                $company->mafia->level++;
                $company->mafia->save();
                break;
            case "security":
                $company->security->level++;
                $company->security->save();
                break;
        }
    }

}