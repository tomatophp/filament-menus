<?php

namespace TomatoPHP\FilamentMenus;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\View\View;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentMenus\Resources\MenuResource;
use TomatoPHP\FilamentTranslations\Http\Middleware\LanguageMiddleware;
use TomatoPHP\FilamentTranslations\Resources\TranslationResource;

class FilamentMenusPlugin implements Plugin
{
    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-menus';
    }

    public function register(Panel $panel): void
    {
        if(class_exists(Module::class)){
            if(\Nwidart\Modules\Facades\Module::find('FilamentMenus')?->isEnabled()){
                $this->isActive = true;
            }
        }
        else {
            $this->isActive = true;
        }

        if($this->isActive) {
            $panel
                ->resources([
                    MenuResource::class
                ]);
        }
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
