<?php

namespace Magentix\Cms\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/cms-routes.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'cms');
        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'cms');
    }

    /**
     * Register configuration.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/acl.php', 'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/api-acl.php', 'api-acl'
        );

        Route::prefix('api')->middleware('api')->group(__DIR__.'/../Routes/admin-api.php');
    }
}
