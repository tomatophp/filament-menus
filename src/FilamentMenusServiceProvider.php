<?php

namespace TomatoPHP\FilamentMenus;

use Illuminate\Support\ServiceProvider;

require_once __DIR__ . '/helpers.php';

class FilamentMenusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register generate command
        $this->commands([
            \TomatoPHP\FilamentMenus\Console\FilamentMenusInstall::class,
        ]);

        // Register Config file
        $this->mergeConfigFrom(__DIR__ . '/../config/filament-menus.php', 'filament-menus');

        // Publish Config
        $this->publishes([
            __DIR__ . '/../config/filament-menus.php' => config_path('filament-menus.php'),
        ], 'filament-menus-config');

        // Register Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Publish Migrations
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'filament-menus-migrations');
        // Register views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-menus');

        // Publish Views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/filament-menus'),
        ], 'filament-menus-views');

        // Register Langs
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filament-menus');

        // Publish Lang
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('lang/vendor/filament-menus'),
        ], 'filament-menus-lang');

        // Register Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadViewComponentsAs('filament', [
            \TomatoPHP\FilamentMenus\Views\Menu::class,
        ]);

    }

    public function boot(): void
    {
        // you boot methods here
    }
}
