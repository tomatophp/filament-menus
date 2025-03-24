<?php

namespace TomatoPHP\FilamentMenus;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Nwidart\Modules\Module;
use TomatoPHP\FilamentMenus\Resources\MenuResource;

class FilamentMenusPlugin implements Plugin
{
    private bool $isActive = false;

    public function getId(): string
    {
        return 'filament-menus';
    }

    public static bool $allowRoute = true;

    public function allowRoute(bool $condition = true): static
    {
        self::$allowRoute = $condition;

        return $this;
    }

    public function register(Panel $panel): void
    {
        if (class_exists(Module::class) && \Nwidart\Modules\Facades\Module::find('FilamentMenus')?->isEnabled()) {
            $this->isActive = true;
        } else {
            $this->isActive = true;
        }

        if ($this->isActive) {
            $panel
                ->resources([
                    MenuResource::class,
                ]);
        }
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static;
    }
}
