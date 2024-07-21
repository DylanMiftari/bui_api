<?php

namespace App\Http\Middleware;

use App\Models\Mine;
use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMineMiddleware
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
        $mine = $request->route()->parameter("mine");

        if($mine->player_id != Auth::id()) {
            return $this->errorService->errorResponse("Ce n'est pas votre mine", 403);
        }

        return $next($request);
    }
}
