<?php

namespace TomatoPHP\FilamentMenus\Resources;

use Filament\Forms;
use TomatoPHP\FilamentMenus\Models\Menu;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $slug = 'menus';

    protected static ?string $recordTitleAttribute = "title";

    protected static ?string $navigationIcon = 'heroicon-o-menu';

    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationLabel(): string
    {
        return __('Menus');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        $routeList = [];
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $key => $route) {
            if (isset($route->action['as'])) {
                $routeList[$route->action['as']] = $route->uri;
            } else {
                array_push($routeList, $route->uri);
            }
        }

        return $form
            ->schema([
                Grid::make(["default" => 1])->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('Menu Title'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('key')
                        ->label(__('Menu Key'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('location')
                        ->label(__('Menu Location'))
                        ->required()
                        ->default('header')
                        ->maxLength(255),
                    Forms\Components\Repeater::make('items')->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Item Title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('url')
                            ->label(__('Item URL'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('route')
                            ->label(__('Item Route'))
                            ->searchable()
                            ->options($routeList),
                        Forms\Components\TextInput::make('icon')
                            ->label("Item Icon")
                            ->hint('icon must start with [heroicon-o-]')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('blank')
                            ->label("Open on new window")
                            ->required(),
                    ]),
                    Forms\Components\Toggle::make('activated')
                        ->label("Active Menu")
                        ->required(),
                ])
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('key')->view('filament-menus::menu-item')->searchable(),
                Tables\Columns\TextColumn::make('location')->sortable(),
                Tables\Columns\BooleanColumn::make('activated'),
            ])
            ->filters([
                Filter::make('activated')
                    ->query(fn (Builder $query): Builder => $query->where('activated', true))
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMenus::route('/'),
        ];
    }
}
