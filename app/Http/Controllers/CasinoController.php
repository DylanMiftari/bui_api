<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCasinoRequest;
use App\Models\Casino;
use App\Models\Company;
use App\Models\User;
use App\Services\CasinoService;
use App\Services\ErrorService;
use App\Services\WithService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasinoController extends Controller
{
    protected ErrorService $errorService;
    protected WithService $withService;

    protected CasinoService $casinoService;

    public function __construct(ErrorService $errorService, WithService $withService, CasinoService $casinoService) {
        $this->errorService = $errorService;
        $this->withService = $withService;
        $this->casinoService = $casinoService;
    }

    public function show(Request $request, Company $company) {
        if($company->company_type !== "casino") {
            return $this->errorService->errorResponse("L'entreprise n'est pas un casino", 422);
        }
        return $this->withService->with(Casino::where("companyId", $company->id), $request->input("with"))->first();
    }

    public function showClient(Request $request, Company $company) {
        if($company->company_type !== "casino") {
            return $this->errorService->errorResponse("L'entreprise n'est pas un casino", 422);
        }
        $user = User::find(Auth::id());
        $res = [
            "casino" => $company->casino->with("casinolevel")->first(),
            "ticket" => $user->casinoTicket($company->casino)
        ];
        $res["casino"]["ticketCount"] = $company->casino->tickets()->where("isVIP", false)->count();
        $res["casino"]["VIPTicketCount"] = $company->casino->tickets()->where("isVIP", true)->count();
        return $res;
    }

    public function update(UpdateCasinoRequest $request, Casino $casino) {
        $casinoLevel = $casino->casinolevel;
        $ticketPrice = $request->input("ticketPrice");
        $VIPTicketPrice = $request->input("VIPTicketPrice");

        if($ticketPrice !== null && $ticketPrice > $casinoLevel->maxTicketPrice) {
            return $this->errorService->errorResponse("Pour un casino de niveau ".$casinoLevel->level." le prix maximal du ticket est de ".$casinoLevel->maxTicketPrice, 422);
        }
        if($ticketPrice !== null && $VIPTicketPrice > $casinoLevel->maxVIPTicketPrice) {
            return $this->errorService->errorResponse("Pour un casino de niveau ".$casinoLevel->level." le prix maximal du ticket VIP est de ".$casinoLevel->maxVIPTicketPrice, 422);
        }

        $this->casinoService->updateTicketPrice($casino, $ticketPrice, $VIPTicketPrice);

        return response()->json([
            "status" => "success"
        ]);
    }
}
