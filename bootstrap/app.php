<?php

use App\Http\Middleware\FinanceMiddleware;
use App\Http\Middleware\FrontOfficeMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\HotelMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RestoMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'userMiddleware' => UserMiddleware::class,
            'adminMiddleware' => AdminMiddleware::class,
            'restoMiddleware' => RestoMiddleware::class,
            'hotelMiddleware' => HotelMiddleware::class,
            'frontoffice' => FrontOfficeMiddleware::class,
            'financeMiddleware'  => FinanceMiddleware::class, 
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
