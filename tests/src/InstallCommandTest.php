<?php

use Illuminate\Support\Facades\Artisan;
use TomatoPHP\FilamentMenus\Console\FilamentMenusInstall;

use function Pest\Laravel\artisan;

it('registers the install command', function () {
    expect(Artisan::all())->toHaveKey('filament-menus:install')
        ->and(Artisan::all()['filament-menus:install'])->toBeInstanceOf(FilamentMenusInstall::class);
});

it('runs the install command', function () {
    artisan('filament-menus:install')
        ->expectsOutputToContain('Filament Menus installed successfully.')
        ->assertSuccessful();
});
