<?php

use TomatoPHP\FilamentMenus\Database\Factories\MenuFactory;
use TomatoPHP\FilamentMenus\Database\Factories\MenuItemFactory;
use TomatoPHP\FilamentMenus\Models\Menu;
use TomatoPHP\FilamentMenus\Models\MenuItem;

// Real apps do not autoload the package tests, so the model factories must ship in the package.
it('resolves the model factories shipped with the package', function () {
    expect(Menu::factory())->toBeInstanceOf(MenuFactory::class)
        ->and(MenuItem::factory())->toBeInstanceOf(MenuItemFactory::class);
});

it('creates a menu with items from the shipped factories', function () {
    $item = MenuItem::factory()->create();

    expect($item->menu)->toBeInstanceOf(Menu::class)
        ->and($item->menu->menuItems)->toHaveCount(1);
});

arch('models do not depend on the package tests')
    ->expect('TomatoPHP\FilamentMenus\Models')
    ->not->toUse('TomatoPHP\FilamentMenus\Tests');
