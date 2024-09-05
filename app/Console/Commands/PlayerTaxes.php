<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Services\MoneyService;
use App\Services\PlayerService;
use Illuminate\Console\Command;

class PlayerTaxes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'player-taxes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pay taxes for player';

    protected MoneyService $moneyService;
    protected PlayerService $playerService;

    public function __construct(MoneyService $moneyService, PlayerService $playerService) {
        parent::__construct();

        $this->moneyService = $moneyService;
        $this->playerService = $playerService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(City::all() as $city) {
            foreach($city->users()->lazy() as $user) {
                if($this->moneyService->checkMoney($user, $city->weeklyTaxes)) {
                    $this->moneyService->pay($user, $city->weeklyTaxes);
                } else {
                    $this->playerService->noPayTaxes($user);
                }
            }
        }
    }
}
