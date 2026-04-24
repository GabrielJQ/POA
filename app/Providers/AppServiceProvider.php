<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Services\POADomainService;
use App\Domain\Services\ERDomainService;
use App\Application\UseCases\POA\ObtenerDatosPOA;
use App\Application\UseCases\POA\SincronizarPOA;
use App\Application\UseCases\ER\ObtenerDatosER;
use App\Application\UseCases\ER\ImportarER;
use App\Application\UseCases\ER\GuardarRegistroER;

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

        $this->app->singleton(ERDomainService::class, function ($app) {
            return new ERDomainService();
        });

        $this->app->when(ObtenerDatosPOA::class)
            ->needs('$domainService')
            ->give(POADomainService::class);

        $this->app->when(SincronizarPOA::class)
            ->needs('$domainService')
            ->give(POADomainService::class);

        $this->app->when(ObtenerDatosER::class)
            ->needs('$domainService')
            ->give(ERDomainService::class);

        $this->app->when(ImportarER::class)
            ->needs('$erDomainService')
            ->give(ERDomainService::class);

        $this->app->when(ImportarER::class)
            ->needs('$poaDomainService')
            ->give(POADomainService::class);

        $this->app->when(GuardarRegistroER::class)
            ->needs('$domainService')
            ->give(ERDomainService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}