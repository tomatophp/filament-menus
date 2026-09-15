<?php

namespace TomatoPHP\FilamentMenus\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use TomatoPHP\FilamentMenus\Database\Factories\MenuItemFactory;

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
        'group',
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

    /**
     * A translated attribute in the app locale, falling back to the fallback locale, then any locale.
     */
    public function localized(string $attribute): ?string
    {
        $value = $this->getAttribute($attribute);

        if (! is_array($value)) {
            return filled($value) ? (string) $value : null;
        }

        $translation = $value[app()->getLocale()] ?? $value[config('app.fallback_locale')] ?? (reset($value) ?: null);

        return filled($translation) ? (string) $translation : null;
    }

    protected static function newFactory(): MenuItemFactory
    {
        return MenuItemFactory::new();
    }
}
