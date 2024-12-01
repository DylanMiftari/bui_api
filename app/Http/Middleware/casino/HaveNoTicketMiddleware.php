<?php

namespace App\Http\Middleware\casino;

use App\Models\Casino;
use App\Models\User;
use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HaveNoTicketMiddleware
{
    public function __construct(private ErrorService $errorService) {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $casino = $request->route()->parameters()["casino"];
        $user = User::find(Auth::id());
        if($user->casinoTicket($casino) !== null) {
            return $this->errorService->errorResponse("Vous possédez déjà un ticket", 422);
        }
        return $next($request);
    }
}
