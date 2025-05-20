<?php

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
        /**
         * Global middleware can be registered here if needed:
         *
         * $middleware->append([
         *     \App\Http\Middleware\YourGlobalMiddleware::class,
         * ]);
         */

        /**
         * Register route middleware aliases here.
         */
        $middleware->alias([
            'auth'      => \App\Http\Middleware\Authenticate::class,
            'guest'     => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'verified'  => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'role'      => \App\Http\Middleware\RoleMiddleware::class,     // Custom role middleware
            'is_admin'  => \App\Http\Middleware\IsAdmin::class,            // Custom admin middleware
        ]);

        /**
         * You can also append middleware to specific middleware groups if needed:
         *
         * $middleware->appendToGroup('web', [
         *     // Add any middleware that should apply to all web routes
         * ]);
         *
         * $middleware->appendToGroup('api', [
         *     // Add middleware for API routes if needed
         * ]);
         */
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions here if needed:
        // $exceptions->renderable(function (Throwable $e) {
        //     return response()->view('errors.custom', [], 500);
        // });
    })
    ->create();
