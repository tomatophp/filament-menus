<?php

namespace TomatoPHP\FilamentMenus\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The table name
     *
     * @var string
     */
    protected $table = "menus";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "key",
        "location",
        "title",
        "items",
        "activated",
    ];

    protected $casts = [
        "items" => "array"
    ];


    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }

}
