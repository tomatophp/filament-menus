<?php

namespace TomatoPHP\FilamentMenus\Views;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Menu extends Component
{
    public Collection $menuItems;

    public function __construct(
        public string $menu,
        public ?string $view = 'filament-menus::menu',
    )
    {
        $menu = \TomatoPHP\FilamentMenus\Models\Menu::where('key', $menu)->first();
        $this->menuItems = collect($menu->menuItems ?? []);
    }

    public function render()
    {
        if(view()->exists($this->view)) {
            return view($this->view);
        }
        else {
            return view('filament-menus::menu');
        }
    }
}
