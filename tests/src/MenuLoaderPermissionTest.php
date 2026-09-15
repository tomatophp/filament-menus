<?php

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Navigation\NavigationItem;
use TomatoPHP\FilamentMenus\Models\Menu;
use TomatoPHP\FilamentMenus\Models\MenuItem;
use TomatoPHP\FilamentMenus\Services\FilamentMenuLoader;
use TomatoPHP\FilamentMenus\Tests\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    if (! class_exists(FilamentShieldPlugin::class)) {
        require_once __DIR__ . '/../Stubs/FilamentShieldPlugin.php';
    }
});

function menuItem(Menu $menu, string $title, array $permissions, int $order): MenuItem
{
    return MenuItem::query()->create([
        'menu_id' => $menu->id,
        'title' => ['en' => $title],
        'url' => '/' . strtolower($title),
        'is_route' => false,
        'new_tab' => false,
        'has_badge' => false,
        'permissions' => $permissions,
        'order' => $order,
    ]);
}

// PR #12: with filament-shield installed, an item the user may not see must be skipped
// instead of reusing the previous item or an undefined variable.
it('skips menu items the user has no permission for', function () {
    $user = new class extends User
    {
        protected $table = 'users';

        public function hasAnyPermission($permissions): bool
        {
            return in_array('view_reports', (array) $permissions, true);
        }
    };

    actingAs($user->forceFill(['id' => 1, 'name' => 'Editor', 'email' => 'editor@example.com']));

    $menu = Menu::query()->create(['title' => 'Main', 'key' => 'main', 'location' => 'header', 'activated' => true]);

    menuItem($menu, 'Secrets', ['manage_secrets'], 1);
    menuItem($menu, 'Reports', ['view_reports'], 2);
    menuItem($menu, 'Home', [], 3);
    menuItem($menu, 'Billing', ['manage_billing'], 4);

    $labels = collect(FilamentMenuLoader::make('main'))
        ->map(fn (NavigationItem $item) => $item->getLabel())
        ->all();

    expect($labels)->toBe(['Reports', 'Home']);
});
