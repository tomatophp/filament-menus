<?php

namespace TomatoPHP\FilamentMenus\Tests;

use Filament\Actions\EditAction;
use TomatoPHP\FilamentMenus\Resources\MenuResource;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages\ManageMenus;
use TomatoPHP\FilamentMenus\Tests\Models\Menu;
use TomatoPHP\FilamentMenus\Tests\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\get;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can render menus resource', function () {
    get(MenuResource::getUrl())->assertSuccessful();
});

it('can list menus', function () {
    Menu::query()->delete();
    $menus = Menu::factory()->count(10)->create();

    livewire(ManageMenus::class)
        ->loadTable()
        ->assertCanSeeTableRecords($menus)
        ->assertCountTableRecords(10);
});

it('can render menu title/key/location/activated column in table', function () {
    Menu::factory()->count(10)->create();

    livewire(ManageMenus::class)
        ->loadTable()
        ->assertCanRenderTableColumn('title')
        ->assertCanRenderTableColumn('key')
        ->assertCanRenderTableColumn('location')
        ->assertCanRenderTableColumn('activated');
});

it('can render menu list page', function () {
    livewire(ManageMenus::class)->assertSuccessful();
});

it('can render view menu page', function () {
    livewire(ManageMenus::class, [
        'record' => User::factory()->create(),
    ])
        ->mountAction('view')
        ->assertSuccessful();
});

it('can render menu create page', function () {
    livewire(ManageMenus::class)
        ->mountAction('create')
        ->assertSuccessful();
});

it('can create new menu', function () {
    $newData = Menu::factory()->make();

    livewire(ManageMenus::class)
        ->callAction('create', data: [
            'title' => $newData->title,
            'key' => $newData->key,
            'location' => $newData->location,
            'activated' => $newData->activated,
        ])
        ->assertHasNoActionErrors();

    assertDatabaseHas(Menu::class, [
        'title' => $newData->title,
        'key' => $newData->key,
        'location' => $newData->location,
        'activated' => $newData->activated,
    ]);
});

it('can validate menu input', function () {
    livewire(ManageMenus::class)
        ->callAction('create', data: [
            'title' => null,
            'key' => null,
            'location' => null,
            'activated' => null,
        ])->assertHasActionErrors([
            'title' => 'required',
            'key' => 'required',
            'location' => 'required',
        ]);
});

it('can render menu edit page', function () {
    livewire(ManageMenus::class, [
        'record' => Menu::factory()->create(),
    ])
        ->mountAction('edit')
        ->assertSuccessful();
});

it('can retrieve menu data', function () {
    $menu = Menu::factory()->create();

    livewire(ManageMenus::class)
        ->mountTableAction(EditAction::class, $menu)
        ->assertTableActionDataSet([
            'title' => $menu->title,
            'key' => $menu->key,
            'location' => $menu->location,
            'activated' => $menu->activated,
        ])
        ->assertHasNoTableActionErrors();
});

it('can validate edit menu input', function () {
    $menu = Menu::factory()->create();

    livewire(ManageMenus::class, [
        'record' => $menu->getRouteKey(),
    ])
        ->callTableAction('edit', $menu, [
            'title' => null,
            'key' => null,
            'location' => null,
            'activated' => null,
        ])->assertHasTableActionErrors([
            'title' => 'required',
            'key' => 'required',
            'location' => 'required',
        ]);
});

it('can save menu data', function () {
    $menu = Menu::factory()->create();
    $newData = Menu::factory()->make();

    livewire(ManageMenus::class)
        ->callTableAction('edit', $menu, data: [
            'title' => $newData->title,
            'key' => $newData->key,
            'location' => $newData->location,
            'activated' => $newData->activated,
        ])
        ->assertHasNoTableActionErrors();

    expect($menu->refresh())->key->toBe($newData->key);
});

it('can delete type', function () {
    $menu = Menu::factory()->create();

    livewire(ManageMenus::class)
        ->callTableAction('delete', $menu)
        ->assertHasNoTableActionErrors();

    assertModelMissing($menu);
});
