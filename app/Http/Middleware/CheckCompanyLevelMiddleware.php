<?php

namespace App\Http\Middleware;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyLevelMiddleware
{
    public function __construct(protected ErrorService $errorService) {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $level): Response
    {
        $bank = $request->route("bank");
        if($bank !== null && $bank->company->companylevel < $level) {
            return $this->errorService->errorResponse("Cette entreprise n'est pas de niveau suffisant");
        }
        return $next($request);
    }
}
