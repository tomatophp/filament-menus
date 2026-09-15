<?php

namespace TomatoPHP\FilamentMenus\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentMenus\Models\Menu;
use TomatoPHP\FilamentMenus\Models\MenuItem;

/**
 * @extends Factory<MenuItem>
 */
class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function definition(): array
    {
        return [
            'menu_id' => Menu::factory(),
            'title' => ['en' => $this->faker->words(2, true)],
            'icon' => 'heroicon-o-link',
            'has_badge' => false,
            'badge' => null,
            'badge_color' => null,
            'is_route' => false,
            'route' => null,
            'url' => $this->faker->url(),
            'new_tab' => false,
            'permissions' => [],
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }
}
