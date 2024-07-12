<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBankRequest;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Services\BankService;
use App\Services\CasinoService;
use App\Services\EstateService;
use App\Services\FactoryService;
use App\Services\MafiaService;
use App\Services\SecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index() {
        return Auth::user()->companies;
    }

    public function createCompany(CreateCompanyRequest $request, BankService $bankService, CasinoService $casinoService, 
    EstateService $estateService, FactoryService $factoryService, MafiaService $mafiaService, SecurityService $securityService) {
        if(count(Auth::user()->companies) >= config("player.max_companies")) { 
            return response()->json([
                "status" => "error",
                "message" => "Vous avez déjà construit le nombre maximum d'entreprises : ".config("player.max_companies")
            ]);
        }

        $user = User::find(Auth::id());

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
}
