<?php

namespace App\Http\Middleware;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCasinoMiddleware
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
            return $this->errorService->errorResponse("Aucun id de casino n'a été renseigné", 422);
        }
        if($casino->company->id_player !== Auth::id()) {
            return $this->errorService->errorResponse("Ce n'est pas votre casino", 403);
        }
        return $next($request);
    }
}
