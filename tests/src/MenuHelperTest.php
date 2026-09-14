<?php

use TomatoPHP\FilamentMenus\Tests\Models\Menu;
use TomatoPHP\FilamentMenus\Tests\Models\MenuItem;

use function PHPUnit\Framework\assertTrue;

it('can use helper function', function () {
    $generateMenu = Menu::factory()->create();
    $menuItems = MenuItem::factory()->count(5)->withMenu($generateMenu->id)->create();

    $menu = menu($generateMenu->key);

    assertTrue(count($menu) === 5);
});
