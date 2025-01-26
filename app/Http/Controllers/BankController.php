<?php

namespace App\Http\Controllers;

use App\Http\Requests\bank\EditCreditRequestRequest;
use App\Http\Requests\DebitOrCreditBankAccountRequest;
use App\Http\Requests\EditBankRequest;
use App\Http\Requests\MakeCreditRequestRequest;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BankLevel;
use App\Models\Company;
use App\Models\CreditRequest;
use App\Models\User;
use App\Services\BankAccountService;
use App\Services\BankCreditService;
use App\Services\BankService;
use App\Services\ErrorService;
use App\Services\MoneyService;
use App\Services\WithService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{

    public function __construct(protected ErrorService $errorService, protected BankService $bankService, 
    protected BankAccountService $bankAccountService, protected MoneyService $moneyService, protected BankCreditService $bankCreditService) {
    }

    public function show(Company $company) {
        if($company->company_type !== "bank") {
            return $this->errorService->errorResponse("Cette entreprise n'est pas une banque", 422);
        }

        return $company->bank()->with(["banklevel"])->first();
    }

    public function showClient(Company $company) {
        $bankAccount = $company->bank->bankAccounts()->where("playerId", Auth::id())->first();
        return response()->json([
            "bank" => $company->bank->getDataForClient(),
            "account" => $bankAccount === null ? null : $bankAccount->load("bankResourceAccount"),
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
        if($bank->bankAccounts()->where("playerId", Auth::id())->exists()) {
            return $this->errorService->errorResponse("Vous possédez déjà un compte dans cette banque", 422);
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

        if(!$bankAccount->isEnable) {
            return $this->errorService->errorResponse("Votre compte est désactiver vous ne pouvez pas faire de retrait");
        }
        if($player->playerMoney+$money > config("player.max_money")) {
            return $this->errorService->errorResponse("Vous ne pourrez pas stocker tout cette argent sur vous");
        }
        if($bankAccount->costWithTransfertCost($money) < $money) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent sur le compte");
        }

        $this->bankAccountService->debitAccount($bankAccount, $player, $money);

        return response()->json([
            "status" => "success"
        ]);
    }

    public function creditAccount(DebitOrCreditBankAccountRequest $request, Bank $bank) {
        $bankAccount = $bank->bankAccounts()->where("playerId", Auth::id())->first();
        $player = User::find(Auth::id());
        $money = $request->input("money");

        if($bankAccount->storableMoney(true) < $money) {
            return $this->errorService->errorResponse("Votre compte ne pourra pas stocker cet argent");
        }
        if($player->playerMoney < $money) {
            return $this->errorService->errorResponse("Vous n'avez pas cet argent sur vous");
        }

        $this->bankAccountService->creditAccount($bankAccount, $player, $money);

        return response()->json([
            "status" => "success"
        ]);
    }

    public function getCreditRequest(Bank $bank) {
        return $bank->creditRequests()->where("playerId", Auth::id())->get();
    }

    public function getAllCreditRequests(Bank $bank) {
        $creditRequests = $bank->creditRequests()->with('player')->get();
        $creditRequests->each(function($creditRequest) {
            $creditRequest->player->makeHidden('playerMoney');
        });

        return $creditRequests->makeHidden(['player.id']);
    }

    public function createCreditRequest(MakeCreditRequestRequest $request, Bank $bank, BankCreditService $bankCreditService) {
        $player = User::find(Auth::id());
        $money = $request->input("money");

        $creditRequest = $bankCreditService->createCreditRequest($money, $player, $bank, $request->input("description"), $request->input("weeklypayment"));

        return response()->json([
            "status" => "success",
            "data" => $creditRequest
        ]);
    }

    public function updateCreditRequest(EditCreditRequestRequest $request, Bank $bank, CreditRequest $creditRequest) {
        if(!in_array($creditRequest->status, ["wait on bank"])) {
            return $this->errorService->errorResponse("Vous ne pouvez pas modifier cette demande de prêt pour le moment", 403);
        }
        if($creditRequest->rate === null && $request->input("rate") === null) {
            return $this->errorService->errorResponse("Vous devez définir un taux pour le prêt", 422);
        }

        try {
            $this->bankCreditService->updateCreditRequest($creditRequest, $request->input("rate"), $request->input("money"), 
            $request->input("weeklyPayments"), $request->input("description"), $request->input("status"));
            return response()->json(["status" => "success"]);
        } catch(Exception $e) {
            return response()->json(["status" => "error"]);
        }
    }

    public function rejectCreditRequest(EditCreditRequestRequest $request, Bank $bank, CreditRequest $creditRequest) {
        if(!in_array($creditRequest->status, ["wait on bank"])) {
            return $this->errorService->errorResponse("Vous ne pouvez pas rejeter cette demande de prêt pour le moment", 403);
        }
        try {
            $this->bankCreditService->updateCreditRequest($creditRequest, status: "reject", description: $request->input("description"));
            return response()->json(["status" => "success"]);
        } catch(Exception $e) {
            return response()->json(["status" => "error"]);
        }
    }

    public function updateCreditRequestFromClient(EditCreditRequestRequest $request, Bank $bank, CreditRequest $creditRequest) {
        if(!in_array($creditRequest->status, ["wait on client"])) {
            return $this->errorService->errorResponse("Vous ne pouvez pas modifier cette demande de prêt pour le moment", 403);
        }
        if($creditRequest->playerId != Auth::id()) {
            return $this->errorService->errorResponse("Vous ne pouvez modifier que votre propre demande de prêt", 403);
        }

        try {
            $this->bankCreditService->updateCreditRequest($creditRequest, $request->input("rate"), $request->input("money"), 
            $request->input("weeklyPayments"), $request->input("description"), $request->input("status"));
            return response()->json(["status" => "success"]);
        } catch(Exception $e) {
            return response()->json(["status" => "error"]);
        }
    }
}
