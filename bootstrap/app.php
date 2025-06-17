<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function(){
            Route::namespace("admin")->prefix("admin")->group(base_path('/routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->use([
            // EnsureTokenIsValid::class,
        ]);
        //  added at begin of middlewars
        $middleware->prependToGroup('web', [
            // EnsureTokenIsValid::class,
        ]);
        // added at the end of middlewars
        $middleware->appendToGroup('web', [
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
