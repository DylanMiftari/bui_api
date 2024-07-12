<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;

class CompanyService {

    public function createCompany(User $user, string $name, string $type) {
        return Company::create([
            "name" => $name,
            "id_player" => $user->id,
            "company_type" => $type
        ]);
    }

}