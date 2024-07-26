<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Services\CompanyService;
use App\Services\MoneyService;
use Illuminate\Console\Command;

class CompanyTaxes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company-taxes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Companies pay taxes';

    protected MoneyService $moneyService;
    protected CompanyService $companyService;

    public function __construct(MoneyService $moneyService, CompanyService $companyService) {
        parent::__construct();
        $this->moneyService = $moneyService;
        $this->companyService = $companyService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(City::all() as $city) {
            foreach($city->companies as $company) {
                if($this->moneyService->checkMoney($company->user, $city->weeklyCompanyTaxes)) {
                    $this->moneyService->pay($company->user, $city->weeklyCompanyTaxes);
                } else {
                    $this->companyService->desactivateCompany($company);
                }
            }
        }
    }
}
