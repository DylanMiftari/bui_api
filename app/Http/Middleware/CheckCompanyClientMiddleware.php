<?php

namespace App\Http\Middleware;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyClientMiddleware
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
        $company = $request->route("company");
        if($company === null) {
            return $this->errorService->errorResponse("Aucun id d'entreprise n'a été renseigné", 422);
        }
        if($company->id_player === Auth::id()) {
            return $this->errorService->errorResponse("L'interface client n'est pas disponible pour le propriétaire", 403);
        }
        return $next($request);
    }
}
