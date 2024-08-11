<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            Route::middleware('api')
                ->prefix('auth')
                ->group(base_path('routes/auth.php'));
            Route::middleware('api')
                ->prefix('company')
                ->group(base_path('routes/company.php'));
            Route::middleware("api")
                ->prefix("mine")
                ->group(base_path("routes/mine.php"));
            Route::middleware("api")
                ->prefix("resource")
                ->group(base_path("routes/resource.php"));
            Route::middleware("api")
                ->prefix("city")
                ->group(base_path("routes/city.php"));
            Route::middleware("api")
                ->prefix("bank")
                ->group(base_path("routes/bank.php"));   
            Route::middleware("api")
                ->prefix("casino")
                ->group(base_path("routes/casino.php"));
            Route::middleware("api")
                ->prefix("home")
                ->group(base_path("routes/home.php"));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
