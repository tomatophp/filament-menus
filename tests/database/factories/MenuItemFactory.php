<?php

namespace TomatoPHP\FilamentMenus\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use TomatoPHP\FilamentMenus\Tests\Models\Menu;
use TomatoPHP\FilamentMenus\Tests\Models\MenuItem;

class MenuItemFactory extends Factory
{
    protected $model = MenuItem::class;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null, ?Collection $recycle = null, bool $expandRelationships = true)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection, $recycle, $expandRelationships);
    }

    public function definition(): array
    {
        return [
            'title' => json_encode(['en' => $this->faker->word()]),
            'icon' => $this->faker->word(),
            'badge_color' => $this->faker->word(),
            'has_badge' => $this->faker->boolean(),
            'has_badge_query' => $this->faker->word(),
            'badge_table' => $this->faker->word(),
            'badge_condation' => $this->faker->word(),
            'badge' => json_encode(['en' => $this->faker->word()]),
            'is_route' => $this->faker->boolean(),
            'route' => $this->faker->word(),
            'url' => $this->faker->url(),
            'new_tab' => $this->faker->boolean(),
            'permissions' => json_encode([]),
            'order' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function withMenu($id)
    {
        $menu = Menu::findOrFail($id);

        return $this->state([
            'menu_id' => $menu->id,
        ]);
    }
}
