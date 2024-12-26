<?php

namespace App\Http\Middleware\casino;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CasinoClientMiddleware
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
        $casino = $request->route("casino");
        if($casino === null) {
            return $this->errorService->errorResponse("Aucun id de banque n'a été renseigné", 422);
        }
        if($casino->company->id_player === Auth::id()) {
            return $this->errorService->errorResponse("L'interface client n'est pas disbonible pour le propriétaire", 403);
        }
        return $next($request);
    }
}
