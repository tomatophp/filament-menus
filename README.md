# Filament Menus

Menu View Generator Using Livewire

## Installation

```bash
composer require tomatophp/filament-menus
```
after install your package please run this command

```bash
php artisan filament-menus:install
```

## Usage

go to route `admin/menus` and create a new menu and you will get the code of livewire component

you can build a menu just by using this command as a livewire component

```blade 
@livewire('menu', ['key' => "header"])
```

where `header` is a key of menu and you will get the code ready on the Table list of menus

you can use custom view ex:

```blade 
@livewire('menu', ['key' => "header", 'view'=> "livewire.menu"])
```

by default we use Tailwind as a main view with this code

```blade
@foreach ($menu as $item)
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



## Support

you can join our discord server to get support [TomatoPHP](https://discord.gg/Xqmt35Uh)

## Docs

you can check docs of this package on [Docs](https://docs.tomatophp.com/plugins/laravel-package-generator)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

Please see [SECURITY](SECURITY.md) for more information about security.

## Credits

- [Tomatophp](mailto:info@3x1.io)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
