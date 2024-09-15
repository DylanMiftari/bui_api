<?php

namespace App\Http\Middleware;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckHaveBankAccountMiddleware
{
    protected ErrorService $errorService;

    public function __construct(ErrorService $errorService) {
        $this->errorService = $errorService;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bank = $request->route("bank");
        if($bank === null) {
            return $this->errorService->errorResponse("Aucun id de banque n'a été renseigné", 422);
        }
        if(!$bank->bankAccounts()->where("playerId", Auth::id())->exists()) {
            return $this->errorService->errorResponse("Vous ne possédez pas de compte dans cette banque");
        }
        return $next($request);
    }
}