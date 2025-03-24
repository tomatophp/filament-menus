<?php

namespace TomatoPHP\FilamentMenus\Tests\Models;

use Filament\Resources\Concerns\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TomatoPHP\FilamentMenus\Tests\Database\Factories\MenuItemFactory;

class MenuItem extends Model
{
    use HasFactory;
    use Translatable;

    public array $translatable = [
        'title',
        'badge',
    ];

    protected $casts = [
        'title' => 'array',
        'badge' => 'array',
        'permissions' => 'array',
        'has_badge' => 'boolean',
        'is_route' => 'boolean',
        'new_tab' => 'boolean',
    ];

    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'title',
        'icon',
        'badge_color',
        'has_badge',
        'has_badge_query',
        'badge_table',
        'badge_condation',
        'badge',
        'is_route',
        'route',
        'url',
        'new_tab',
        'permissions',
        'order',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    protected static function newFactory(): MenuItemFactory
    {
        return MenuItemFactory::new();
    }
}
