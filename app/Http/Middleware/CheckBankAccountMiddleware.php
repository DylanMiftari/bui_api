<?php

namespace App\Http\Middleware;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBankAccountMiddleware
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
        $bankAccount = $request->route("bankAccount");

        if($bankAccount->playerId != Auth::id() && $bankAccount->bank->company->id_player != Auth::id()) {
            return $this->errorService->errorResponse("Vous n'êtes ni le propritaire du compte ni de la banque", 403);
        }

        return $next($request);
    }
}
