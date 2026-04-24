<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Services\POADomainService;
use App\Application\UseCases\POA\ObtenerDatosPOA;
use App\Application\UseCases\POA\SincronizarPOA;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(POADomainService::class, function ($app) {
            return new POADomainService();
        });

        $this->app->when(ObtenerDatosPOA::class)
            ->needs('$domainService')
            ->give(POADomainService::class);

        $this->app->when(SincronizarPOA::class)
            ->needs('$domainService')
            ->give(POADomainService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}