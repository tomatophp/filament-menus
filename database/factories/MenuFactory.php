<?php

namespace TomatoPHP\FilamentMenus\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentMenus\Models\Menu;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->slug(2),
            'location' => 'header',
            'title' => $this->faker->words(2, true),
            'items' => [],
            'activated' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'activated' => false,
        ]);
    }
}
