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
        $this->app->singleton(
            \App\Domain\Contracts\IPOADomainService::class,
            \App\Domain\Services\POADomainService::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\IERDomainService::class,
            \App\Domain\Services\ERDomainService::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\IDashboardService::class,
            \App\Domain\Services\DashboardService::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\IPDFERExtractorService::class,
            \App\Domain\Services\PDFERExtractorService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}