![Screenshot](https://raw.githubusercontent.com/tomatophp/filament-menus/master/arts/3x1io-tomato-menus.jpg)

# Filament Menus

[![Latest Stable Version](https://poser.pugx.org/tomatophp/filament-menus/version.svg)](https://packagist.org/packages/tomatophp/filament-menus)
[![PHP Version Require](http://poser.pugx.org/tomatophp/filament-menus/require/php)](https://packagist.org/packages/tomatophp/filament-menus)
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

- [Filament Users](https://www.github.com/tomatophp/filament-users)
- [Filament Translations](https://www.github.com/tomatophp/filament-translations)
- [Filament Settings Hub](https://www.github.com/tomatophp/filament-settings-hub)
- [Filament Alerts Sender](https://www.github.com/tomatophp/filament-alerts)
- [Filament Accounts Builder](https://www.github.com/tomatophp/filament-accounts)
- [Filament Wallet Manager](https://www.github.com/tomatophp/filament-wallet)
- [Filament Artisan Runner](https://www.github.com/tomatophp/filament-artisan)
- [Filament File Browser](https://www.github.com/tomatophp/filament-browser)
- [Filament Developer Gate](https://www.github.com/tomatophp/filament-developer-gate)
- [Filament Locations Seeder](https://www.github.com/tomatophp/filament-locations)
- [Filament Plugins Manager](https://www.github.com/tomatophp/filament-plugins)
- [Filament Splade Integration](https://www.github.com/tomatophp/filament-splade)
- [Filament Types Manager](https://www.github.com/tomatophp/filament-types)
- [Filament Icons Picker](https://www.github.com/tomatophp/filament-icons)
- [Filament Helpers Classes](https://www.github.com/tomatophp/filament-helpers)

## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/filament/filament-menus)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Fady Mondy](https://wa.me/+201207860084)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
