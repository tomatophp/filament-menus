<?php

namespace TomatoPHP\FilamentMenus;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use TomatoPHP\FilamentMenus\Resources\MenuResource;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;

class FilamentMenusPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-menus';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                MenuResource::class
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static();
    }
}
