<?php

if(!function_exists('menu')){
    function menu($key){
        $menu = \TomatoPHP\FilamentMenus\Models\Menu::where('key', $key)->first();

        if($menu){
            return collect($menu->items);

        }
        else {
            return collect([]);
        }
    }
}
