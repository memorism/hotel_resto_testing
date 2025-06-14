<?php

use App\Http\Middleware\FinanceHotelMiddleware;
use App\Http\Middleware\FrontOfficeMiddleware;
use App\Http\Middleware\HotelMiddlewareNew;
use App\Http\Middleware\RestoMiddlewareNew;
use App\Http\Middleware\ScmHotelMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\HotelMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RestoMiddleware;
use App\Console\Commands\SyncCombinedReports;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SyncDailyIncomeToFinances;
use App\Http\Middleware\CashierRestoMiddleware;
use App\Http\Middleware\FinanceRestoMiddleware;
use App\Http\Middleware\ScmRestoMiddleware;


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
            'hotelMiddlewareNew' => HotelMiddlewareNew::class,
            'restoMiddlewareNew' => RestoMiddlewareNew::class,
            'financehotelMiddleware' => FinanceHotelMiddleware::class,
            'scmhotelMiddleware' => ScmHotelMiddleware::class,
            'cashierresto' => CashierRestoMiddleware::class,
            'financeresto' => FinanceRestoMiddleware::class,
            'scmresto' => ScmRestoMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('sync:income-finances')->dailyAt('23:55');
        $schedule->command('sync:combined-reports')->monthly();
    })
    
    ->withCommands([
        SyncCombinedReports::class,
        SyncDailyIncomeToFinances::class,
    ])

    ->create();

