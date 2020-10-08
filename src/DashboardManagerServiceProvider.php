<?php

namespace NovaBi\NovaDashboardManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;
use NovaBi\NovaDashboardManager\Http\Middleware\Authorize;

class DashboardManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = app()->make('config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-dashboard-manager');
        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        // Config
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('nova-dashboard-manager.php'),
        ], 'config');

        $this->app->booted(function () use ($config) {
            $config->set('nova-dashboard.table_name', config('nova-dashboard-manager.tables.widget_configurations'));
            $config->set('nova-dashboard.widget_model', config('nova-dashboard-manager.models.widget_configuration'));
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            //

        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('nova-vendor/nova-dashboard-manager')
            ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/config.php', 'nova-dashboard-manager');
    }
}
