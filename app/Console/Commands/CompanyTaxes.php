<?php

namespace App\Console\Commands;

use App\Models\City;
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

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(City::all() as $city) {
            foreach($city->users as $user) {
            }
        }
    }
}
