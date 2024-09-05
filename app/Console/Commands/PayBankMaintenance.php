<?php

namespace App\Console\Commands;

use App\Models\BankAccount;
use App\Services\BankAccountService;
use App\Services\MoneyService;
use Illuminate\Console\Command;

class PayBankMaintenance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bank-account-maintenance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pay weekly maintenance cost of accounts';

    public function __construct(protected MoneyService $moneyService, protected BankAccountService $bankAccountService) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(BankAccount::lazy() as $bankAccount) {
            if($bankAccount->isEnable) {
                if($this->moneyService->checkMoney($bankAccount->player, $bankAccount->accountMaintenanceCost)) {
                    $this->moneyService->pay($bankAccount->player, $bankAccount->accountMaintenanceCost, "Frais de tenu de compte");
                    $bankAccount->bank->company->money_in_safe = round($bankAccount->bank->company->money_in_safe + $bankAccount->accountMaintenanceCost, 2);
                    $bankAccount->bank->company->save();
                } else {
                    $bankAccount->isEnable = false;
                    $bankAccount->save();
                }
            } else {
                // Check if player + this disable account can pay
                $totalPlayerMoney = round($this->moneyService->getTotalMoneyOfPlayer($bankAccount->player) + $bankAccount->money, 2);
                $mostExpensiteTransfertCost = $bankAccount->player->bankAccounts()->orderByDesc("transferCost")->first();
                $totalToPay = $mostExpensiteTransfertCost->costWithTransfertCost($bankAccount->accountMaintenanceCost);

                if($totalPlayerMoney >= $totalToPay) {
                    // Use this disable account to pay
                    $disableAccountCanPay = min([$this->bankAccountService->maxCanPay($bankAccount), $bankAccount->accountMaintenanceCost]);
                    $this->bankAccountService->makeTransaction($bankAccount, $disableAccountCanPay, "Frais de tenu de compte");
                    // Pay the rest
                    if($disableAccountCanPay < $bankAccount->accountMaintenanceCost) {
                        $this->moneyService->pay($bankAccount->player, round($bankAccount->accountMaintenanceCost - $disableAccountCanPay, 2));
                    }
                    // Updqte data
                    $bankAccount->bank->company->money_in_safe = round($bankAccount->bank->company->money_in_safe + $bankAccount->accountMaintenanceCost, 2);
                    $bankAccount->bank->company->save();
                    $bankAccount->isEnable = true;
                    $bankAccount->save();
                }
            }
        }
    }
}
