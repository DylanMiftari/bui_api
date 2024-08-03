<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditBankRequest;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BankLevel;
use App\Models\Company;
use App\Services\BankService;
use App\Services\ErrorService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    protected ErrorService $errorService;
    protected BankService $bankService;

    public function __construct(ErrorService $errorService, BankService $bankService) {
        $this->errorService = $errorService;
        $this->bankService = $bankService;
    }

    public function show(Company $company) {
        if($company->company_type !== "bank") {
            return $this->errorService->errorResponse("Cette entreprise n'est pas une banque", 422);
        }

        return $company->bank()->with("banklevel")->first();
    }

    public function getAccounts(Bank $bank) {
        return $bank->bankAccounts()->with(["player", "bankResourceAccount"])->get();
    }

    public function getAccountTransaction(Request $request, BankAccount $bankAccount) {
        $query = BankAccount::where("id", $bankAccount->id);
        $with = $request->input("with");

        if($with !== null) {
            $withArray = explode(",", $with);

            if(in_array("transactions", $withArray)) {
                $query = $query->with("transactions");
            }
            if(in_array("player", $withArray)) {
                $query = $query->with("player");
            }
        }

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
}
