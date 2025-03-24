<?php

use Filament\Facades\Filament;
use Filament\SpatieLaravelTranslatablePlugin;
use TomatoPHP\FilamentMenus\FilamentMenusPlugin;

it('registers spatie laravel translatable plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        SpatieLaravelTranslatablePlugin::make(),
    ]);

    expect($panel->getPlugin('spatie-laravel-translatable'))
        ->not()
        ->toThrow(Exception::class);
});

it('registers plugin', function () {
    $panel = Filament::getCurrentPanel();

    $panel->plugins([
        FilamentMenusPlugin::make(),
    ]);

    expect($panel->getPlugin('filament-menus'))
        ->not()
        ->toThrow(Exception::class);
});
