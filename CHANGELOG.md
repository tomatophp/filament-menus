# V5.0.0

- support Filament v5 and Laravel 12/13 (Pest 4/5, Testbench 10/11)
- replace `filament/spatie-laravel-translatable-plugin` with `lara-zeus/spatie-translatable` ^2.0
- skip navigation items the user has no permission for when filament-shield is installed (#12, thanks @vgocoder)
- ship `Menu` and `MenuItem` model factories with the package
- fix the menu items relation manager, the `<x-filament-menu>` component and `FilamentMenuLoader` crashing on items without a badge or without a translation for the current locale
- size menu item icons inline so they render correctly with any Filament v5 theme
- drop the `livewire:discover` call from the install command (removed in Livewire 4)
- fix the plugin registration snippet and the `FilamentMenuLoader` namespace in the README
- add install command, factory and permission tests; run the test matrix on Laravel 12/13 and PHP 8.3/8.4

