<?php

namespace App\Http\Middleware\casino;

use App\Services\ErrorService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLevelMiddleware
{
    public function __construct(protected ErrorService $errorService) {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $minLevel): Response
    {
        $casino = $request->route()->parameters()["casino"];
        if($casino === null || $casino->company->companylevel < $minLevel) {
            return $this->errorService->errorResponse("Ce casino n'est pas assez haut niveau, il doit être au niveau $minLevel");
        }

        return $next($request);
    }
}
