<?php

use App\Http\Middleware\CheckCookieConsent;
use App\Http\Middleware\HaveLoggedInMiddleware;
use App\Http\Middleware\NotLoggedInMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'cookieconsent' => CheckCookieConsent::class,
            'notloggedin' => NotLoggedInMiddleware::class,
            'haveloggedin' => HaveLoggedInMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'accept-cookies',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
