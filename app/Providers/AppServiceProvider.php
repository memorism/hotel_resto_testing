<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SharedCustomer;
use App\Policies\SharedCustomerPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
    protected $policies = [
        SharedCustomer::class => SharedCustomerPolicy::class,
    ];
}
