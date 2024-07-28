<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TravelMiddleware
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
        $user = User::find(Auth::id());
        if($user->inTravel) {
            return $this->errorService->errorResponse("En voyage vous ne pouvez rien faire", 403);
        }
        return $next($request);
    }
}
