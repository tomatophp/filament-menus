<?php

use TomatoPHP\FilamentMenus\Models\Menu;

if (! function_exists('menu')) {
    function menu($key)
    {
        $menu = Menu::where('key', $key)->where('activated', 1)->first();

        if ($menu) {
            return collect($menu->menuItems);

        } else {
            return collect([]);
        }
    }
}
