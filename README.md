![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-menus/master/arts/3x1io-tomato-menus.jpg)

# Filament Menus

[![Dependabot Updates](https://github.com/tomatophp/filament-menus/actions/workflows/dependabot/dependabot-updates/badge.svg)](https://github.com/tomatophp/filament-menus/actions/workflows/dependabot/dependabot-updates)
[![PHP Code Styling](https://github.com/tomatophp/filament-menus/actions/workflows/fix-php-code-styling.yml/badge.svg)](https://github.com/tomatophp/filament-menus/actions/workflows/fix-php-code-styling.yml)
[![Tests](https://github.com/tomatophp/filament-menus/actions/workflows/tests.yml/badge.svg)](https://github.com/tomatophp/filament-menus/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-menus/version.svg)](https://packagist.org/packages/tomatophp/filament-menus)
[![License](https://poser.pugx.org/tomatophp/filament-menus/license.svg)](https://packagist.org/packages/tomatophp/filament-menus)
[![Downloads](https://poser.pugx.org/tomatophp/filament-menus/d/total.svg)](https://packagist.org/packages/tomatophp/filament-menus)

Menu Database builder to use it as a navigation on Filament Panel or as a Livewire Component

## Screenshots

![Menus List](https://raw.githubusercontent.com/tomatophp/filament-menus/master/arts/resource.png)
![Edit Menu](https://raw.githubusercontent.com/tomatophp/filament-menus/master/arts/edit.png)
![Menu Items](https://raw.githubusercontent.com/tomatophp/filament-menus/master/arts/create-item.png)

## Installation

```bash
composer require tomatophp/filament-menus
```
after install your package please run this command

```bash
php artisan filament-menus:install
```

finally register the plugin on `/app/Providers/Filament/AdminPanelProvider.php`

```php
->plugins(
    \Filament\SpatieLaravelTranslatablePlugin::make()->defaultLocales(['en', 'ar'])
    \TomatoPHP\FilamentMenus\FilamentMenusPlugin::make()
)
```

## Use as Filament Navigation

you can use this package as a navigation on Filament Admin Panel

```php
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use TomatoPHP\FilamentMenus\FilamentMenuLoader;

$panel->navigation(function (NavigationBuilder $builder){
    return $builder
        // Use Inside Group
        ->groups([
            NavigationGroup::make()
                ->label('Dashboard')
                ->items(FilamentMenuLoader::make('dashboard')),
        ])
        // Use Directly
        ->items(FilamentMenuLoader::make('dashboard'));
})
```

where `dashboard` is a key of menu.

## Use as a Livewire Component

go to route `admin/menus` and create a new menu and you will get the code of livewire component

you can build a menu just by using this command as a livewire component

```blade 
<x-filament-menu menu="header" />
```

where `header` is a key of menu and you will get the code ready on the Table list of menus

you can use custom view ex:

```blade 
<x-filament-menu menu="header" view="menu-item" />
```

by default we use Tailwind as a main view with this code

```blade
@foreach ($menuItems as $item)
<a class="text-gray-500" href="{{ $item['url'] }}" @if($item['blank']) target="_blank" @endif>
    <span class="flex justify-between">
        @if(isset($item['icon']) && !empty($item['icon']))
        <x-icon class="w-4 h-4 mx-2" name="{{ $item['icon'] }}"></x-icon>
        @endif
        {{ $item['title'] }}
    </span>
</a>
@endforeach
```

or you can use direct helper `menu($key)` to get the menu items

```blade
@foreach (menu('header') as $item)
<a class="text-gray-500" href="{{ $item['url'] }}" @if($item['blank']) target="_blank" @endif>
    <span class="flex justify-between">
        @if(isset($item['icon']) && !empty($item['icon']))
        <x-icon class="w-4 h-4 mx-2" name="{{ $item['icon'] }}"></x-icon>
        @endif
        {{ $item['title'] }}
    </span>
</a>
@endforeach
```

## Publish Assets

you can publish config file by use this command

```bash
php artisan vendor:publish --tag="filament-menus-config"
```

you can publish views file by use this command

```bash
php artisan vendor:publish --tag="filament-menus-views"
```

you can publish languages file by use this command

```bash
php artisan vendor:publish --tag="filament-menus-lang"
```

you can publish migrations file by use this command

```bash
php artisan vendor:publish --tag="filament-menus-migrations"
```

## Other Filament Packages

Checkout our [Awesome TomatoPHP](https://github.com/tomatophp/awesome)
