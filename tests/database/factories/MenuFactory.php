<?php

namespace TomatoPHP\FilamentMenus\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use TomatoPHP\FilamentMenus\Tests\Models\Menu;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(),
            'location' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'items' => json_encode([]),
            'activated' => 1,
        ];
    }
}
