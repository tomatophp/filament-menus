<?php

if(!function_exists('menu')){
    function menu($key){
        $menu = \TomatoPHP\FilamentMenus\Models\Menu::where('key', $key)->where('activated', 1)->first();

        if($menu){
            return collect($menu->menuItems);

        }
        else {
            return collect([]);
        }
    }
}
