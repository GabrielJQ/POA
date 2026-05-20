<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Domain\Services\POADomainService;
use App\Domain\Services\ERDomainService;
use App\Application\UseCases\POA\ObtenerDatosPOA;
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

        $this->app->singleton(
            \App\Domain\Contracts\ICacheStore::class,
            \App\Infrastructure\Cache\LaravelCacheStore::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\Repositories\IAlmacenRepository::class,
            \App\Infrastructure\Persistence\Eloquent\AlmacenRepository::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\Repositories\IConceptoMaestroRepository::class,
            \App\Infrastructure\Persistence\Eloquent\ConceptoMaestroRepository::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\Repositories\IRegistroFinancieroRepository::class,
            \App\Infrastructure\Persistence\Eloquent\RegistroFinancieroRepository::class
        );

        $this->app->singleton(
            \App\Domain\Contracts\Repositories\IPoaNotaRepository::class,
            \App\Infrastructure\Persistence\Eloquent\PoaNotaRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('view-dashboard', fn ($user) => $user->isAdmin() || $user->isSupervisor());
        Gate::define('view-mialmacen', fn ($user) => $user->isCapturista());
        Gate::define('manage-users', fn ($user) => $user->isAdmin());
        Gate::define('edit-notas', fn ($user) => $user->isAdmin() || $user->isSupervisor());
    }
}