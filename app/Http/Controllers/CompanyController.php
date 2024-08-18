<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankRequest;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Company;
use App\Models\CompanyLevel;
use App\Models\User;
use App\Services\BankService;
use App\Services\CasinoService;
use App\Services\CompanyService;
use App\Services\ErrorService;
use App\Services\EstateService;
use App\Services\FactoryService;
use App\Services\MafiaService;
use App\Services\MoneyService;
use App\Services\SecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    protected ErrorService $errorService;
    protected CompanyService $companyService;

    public function __construct(ErrorService $errorService, CompanyService $companyService) {
        $this->errorService = $errorService;
        $this->companyService = $companyService;
    }

    public function index() {
        return Auth::user()->companies;
    }

    public function show(Company $company) {
        if($company->id_player !== Auth::id()) {
            return $this->errorService->errorResponse("Cette entreprise ne vous appartient pas", 403);
        }
        return $company;
    }

    public function showClient(Company $company) {
        return $company->getDataForClient();
    }

    public function createCompany(CreateCompanyRequest $request, BankService $bankService, CasinoService $casinoService, 
    EstateService $estateService, FactoryService $factoryService, MafiaService $mafiaService, SecurityService $securityService,
    MoneyService $moneyService) {

        $user = User::find(Auth::id());

        if(count(Auth::user()->companies) >= config("player.max_companies")) { 
            return $this->errorService->errorResponse("Vous avez déjà construit le nombre maximum d'entreprises : ".config("player.max_companies"));
        }
        if(!$moneyService->checkMoney($user, config("company.creationPrice"))) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour créer votre entreprises, si vous payer avec un compte bancaire, il faut prendre en comtpe les frais de transaction");
        }

        switch($request->get("company_type")) {
            case "bank":
                $company = $bankService->createBank($user, $request->name, $request->accountMaintenanceCost, $request->transferCost, 
                    $request->maxAccountMoney, $request->maxAccountResource);
                break;
            case "casino":
                $company = $casinoService->createCasino($user, $request->name, $request->ticketPrice, $request->rouletteSequenceMultiplicator, 
                $request->rouletteTripletMultiplicator, $request->rouletteTripleSeventMultiplicator, $request->rouletteMaxBet);
                break;
            case "estate_agency":
                $company = $estateService->createEstate($user, $request->name);
                break;
            case "mafia":
                $company = $mafiaService->createMafia($user, $request->name);
                break;
            case "factory":
                $company = $factoryService->createFactory($user, $request->name);
                break;
            case "security":
                $company = $securityService->createSecurity($user, $request->name);
                break;
        }

        return response()->json([
            "result" => "success",
            "company" => $company
        ]);
    }

    public function upgrade(Company $company, MoneyService $moneyService) {
        $companyLevel = CompanyLevel::find($company->companylevel);
        $user = User::find(Auth::id());

        if($companyLevel->priceForNextLevel === null) {
            return $this->errorService->errorResponse("Votre entreprise est déjà au niveau maximum", 422);
        }
        if(!$moneyService->checkMoney($user, $companyLevel->priceForNextLevel)) {
            return $this->errorService->errorResponse("Vous n'avez pas assez d'argent pour améliorer votre entreprises, si vous payer avec un compte bancaire, il faut prendre en comtpe les frais de transaction", 422);
        }

        $this->companyService->upgradeCompany($company);
        $moneyService->pay($user, $companyLevel->priceForNextLevel, "Améliorer l'entreprise ".$company->name." au niveau ".(($company->level)+1));

        return response()->json([
            "status" => "success"
        ]);
    }
}
