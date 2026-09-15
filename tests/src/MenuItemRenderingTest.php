<?php

use Illuminate\Support\Facades\Blade;
use TomatoPHP\FilamentMenus\Models\Menu;
use TomatoPHP\FilamentMenus\Models\MenuItem;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages\EditMenus;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Relations\MenuItems;
use TomatoPHP\FilamentMenus\Services\FilamentMenuLoader;
use TomatoPHP\FilamentMenus\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());

    $this->menu = Menu::factory()->create(['key' => 'main']);

    // has_badge defaults to true in the database, so items created outside the form often have no badge text,
    // and a title saved in one language must still render in another.
    MenuItem::factory()->for($this->menu)->create([
        'title' => ['en' => 'Home'],
        'url' => '/home',
        'has_badge' => true,
        'badge' => null,
        'order' => 1,
    ]);
    MenuItem::factory()->for($this->menu)->create([
        'title' => ['en' => 'Docs', 'ar' => 'Dalil'],
        'url' => '/docs',
        'has_badge' => true,
        'badge' => ['en' => 'New'],
        'badge_color' => 'success',
        'order' => 2,
    ]);

    app()->setLocale('ar');
});

it('renders the menu items relation manager', function () {
    livewire(MenuItems::class, ['ownerRecord' => $this->menu, 'pageClass' => EditMenus::class])
        ->assertSuccessful()
        ->assertSee('Home')
        ->assertSee('Dalil')
        ->assertSee('New');
});

it('renders the menu blade component', function () {
    $html = Blade::render('<x-filament-menu menu="main" />');

    expect($html)->toContain('Home')
        ->toContain('Dalil')
        ->toContain('New');
});

it('builds navigation items with locale fallbacks', function () {
    $items = FilamentMenuLoader::make('main');

    expect($items)->toHaveCount(2)
        ->and($items[0]->getLabel())->toBe('Home')
        ->and($items[0]->getBadge())->toBeNull()
        ->and($items[1]->getLabel())->toBe('Dalil')
        ->and($items[1]->getBadge())->toBe('New');
});
