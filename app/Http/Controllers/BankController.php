<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebitOrCreditBankAccountRequest;
use App\Http\Requests\EditBankRequest;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BankLevel;
use App\Models\Company;
use App\Models\User;
use App\Services\BankAccountService;
use App\Services\BankService;
use App\Services\ErrorService;
use App\Services\WithService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    protected ErrorService $errorService;
    protected BankService $bankService;
    protected BankAccountService $bankAccountService;

    public function __construct(ErrorService $errorService, BankService $bankService, BankAccountService $bankAccountService) {
        $this->errorService = $errorService;
        $this->bankService = $bankService;
        $this->bankAccountService = $bankAccountService;
    }

    public function show(Company $company) {
        if($company->company_type !== "bank") {
            return $this->errorService->errorResponse("Cette entreprise n'est pas une banque", 422);
        }

        return $company->bank()->with("banklevel")->first();
    }

    public function showClient(Company $company) {
        return response()->json([
            "bank" => $company->bank->getDataForClient(),
            "account" => $company->bank->bankAccounts()->where("playerId", Auth::id())->first()->load("bankResourceAccount"),
        ]);
    }

    public function getAccounts(Bank $bank) {
        return $bank->bankAccounts()->with(["player", "bankResourceAccount"])->get();
    }

    public function getAccountTransaction(Request $request, BankAccount $bankAccount, WithService $withService) {
        $query = BankAccount::where("id", $bankAccount->id);
        $with = $request->input("with");

        $query = $withService->with($query, $with);

        return $query->first();
    }

    public function edit(EditBankRequest $request, Bank $bank) {
        $bankLevel = BankLevel::find($bank->level);
        if($request->input("maxAccountMoney") > $bankLevel->maxMoneyAccount) {
            return $this->errorService->errorResponse(
                "Pour une banque de niveau ".$bankLevel->level." la capacité maximal d'un compte en argent, ne peut dépasser : ".$bankLevel->maxMoneyAccount
                , 422);
        }
        if($request->input("maxAccountResource") > $bankLevel->maxResourceAccount) {
            return $this->errorService->errorResponse(
                "Pour une banque de niveau ".$bankLevel->level." la capacité maximal d'un compte en ressources, ne peut dépasser : ".$bankLevel->maxResourceAccount."kg",
                422
            );
        }

        $this->bankService->editBank($bank, $request->input("accountMaintenanceCost"), $request->input("transferCost"),
        $request->input("maxAccountMoney"), $request->input("maxAccountResource"));

        return response()->json([
            "status" => "success"
        ]);
    }

    public function openAccount(Bank $bank) {
        $bankAccountCount = $bank->bankAccounts()->count();
        if($bankAccountCount+1 > $bank->banklevel->maxNbAccount) {
            return $this->errorService->errorResponse("Cette banque n'a plus de place", 422);
        }
        $this->bankService->openAccount($bank, User::find(Auth::id()));

        return response()->json([
            "status" => "success"
        ]);
    }

    public function debitAccount(DebitOrCreditBankAccountRequest $request, Bank $bank) {
        $bankAccount = $bank->bankAccounts()->where("playerId", Auth::id())->first();
        $player = User::find(Auth::id());
        $money = $request->input("money");

        if($bankAccount === null) {
            return $this->errorService->errorResponse("Vous ne possédez pas de compte dans cette banque");
        }
        if($player->playerMoney+$money > config("player.max_money")) {
            return $this->errorService->errorResponse("Vous ne pourrez pas stocker tout cette argent sur vous");
        }
        if($bankAccount->money < $money) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent sur le compte");
        }

        $this->bankAccountService->debitAccount($bankAccount, $player, $money);

        return response()->json([
            "status" => "success"
        ]);
    }
}
