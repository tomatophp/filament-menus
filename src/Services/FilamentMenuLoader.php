<?php

namespace TomatoPHP\FilamentMenus\Services;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Builder;
use TomatoPHP\FilamentMenus\Models\Menu;

class FilamentMenuLoader
{
    protected mixed $menu;
    protected array $groups = [];

    public static function make(string $key): array
    {

        return (new self())->menu($key)->items();
    }

    public function menu(string $key): static
    {
        $this->menu = Menu::where('key', $key)
            ->where('activated', true)
            ->first()?->menuItems()
            ->orderBy('order', 'asc')
            ->get() ?? [];
        
        return $this;
    }

    public function items(): array
    {
        $navItems = [];

        foreach ($this->menu as $menu){
            if(class_exists(FilamentShieldPlugin::class) && count($menu->permissions)){
                if(auth()->user()->hasAnyPermission($menu->permissions)){
                    $menuItem = NavigationItem::make()
                        ->label($menu->title[app()->getLocale()])
                        ->isActiveWhen(fn (): bool => url()->current() === ($menu->is_route ? route($menu->route) : $menu->url))
                        ->icon($menu->icon)
                        ->badge($menu->badge? $menu->badge[app()->getLocale()]:null, $menu->badge_color)
                        ->url($menu->is_route ? route($menu->route) : $menu->url);
                }
            }
            else{
                $menuItem = NavigationItem::make()
                    ->label($menu->title[app()->getLocale()])
                    ->isActiveWhen(fn (): bool => url()->current() === ($menu->is_route ? route($menu->route) : $menu->url))
                    ->icon($menu->icon)
                    ->badge($menu->badge? $menu->badge[app()->getLocale()]:null, $menu->badge_color)
                    ->url($menu->is_route ? route($menu->route) : $menu->url);
            }

            if($menu->new_tab){
               $menuItem->shouldOpenUrlInNewTab();
            }

            $navItems[] = $menuItem;
        }

        return $navItems;
    }
}
