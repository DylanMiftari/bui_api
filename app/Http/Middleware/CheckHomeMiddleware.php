<?php

namespace App\Http\Middleware;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckHomeMiddleware
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
        $home = $request->route("home");
        if($home === null) {
            return $this->errorService->errorResponse("Aucun id de maison n'a été renseigné", 422);
        }
        if($home->id_player !== Auth::id()) {
            return $this->errorService->errorResponse("Ce n'est pas votre maison", 403);
        }
        return $next($request);
    }
}
