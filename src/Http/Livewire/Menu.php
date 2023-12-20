<?php

namespace TomatoPHP\FilamentMenus\Http\Livewire;

use Livewire\Component;
use TomatoPHP\FilamentMenus\Models\Menu as MenuModel;

class Menu extends Component
{
    public $key;
    public $view = null;

    public function render()
    {
        $menu = MenuModel::where('key', $this->key)->first();
        if ($menu) {
            $items = $menu->items;
        } else {
            $items = [];
        }

        if (!empty($this->view)) {
            return view($this->view, [
                "menu" => $items
            ]);
        } else {
            return view('filament-menus::menu', [
                "menu" => $items
            ]);
        }
    }
}
