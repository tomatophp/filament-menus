<?php

namespace TomatoPHP\FilamentMenus\Resources\MenuResource\Relations;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class MenuItems extends RelationManager
{
    protected static string $relationship = 'menuItems';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('filament-menus::messages.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('filament-menus::messages.title');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-menus::messages.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-menus::messages.title');
    }

    public static function getModelLabel(): string
    {
        return trans('filament-menus::messages.title');
    }

    public function form(Schema $schema): Schema
    {
        $routeList = [];
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $key => $route) {
            if (isset($route->action['as'])) {
                $routeList[] = [
                    'name' => $route->action['as'],
                    'url' => $route->uri,
                ];
            } else {
                $routeList[] = [
                    'name' => $route->uri,
                    'url' => $route->uri,
                ];
            }
        }

        $repeaterSchema = [];
        if (class_exists(FilamentShieldPlugin::class)) {
            $repeaterSchema[] = Select::make('permissions')
                ->label(trans('filament-menus::messages.cols.item.permissions'))
                ->searchable()
                ->multiple()
                ->options(class_exists(Permission::class) ? Permission::query()->get()->pluck('name', 'name')->toArray() : []);
        }

        $localsTitle = [];
        $localsBadge = [];
        foreach (config('filament-menus.locals') as $key => $local) {
            $localsTitle[] = TextInput::make($key)
                ->label($local[app()->getLocale()])
                ->required();
            $localsBadge[] = TextInput::make($key)
                ->label($local[app()->getLocale()])
                ->required();
        }

        return $schema->components([
            Grid::make(['default' => 1])->schema(array_merge([
                Translation::make('title')
                    ->label(trans('filament-menus::messages.cols.item.title')),
                Toggle::make('is_route')
                    ->hidden(! filament('filament-menus')::$allowRoute)
                    ->default(false)
                    ->label(trans('filament-menus::messages.cols.item.is_route'))
                    ->required()
                    ->live(),
                TextInput::make('url')
                    ->label(trans('filament-menus::messages.cols.item.url'))
                    ->hidden(fn (Get $get) => $get('is_route') === true)
                    ->required(fn (Get $get) => $get('is_route') === false)
                    ->maxLength(255),
                Select::make('route')
                    ->label(trans('filament-menus::messages.cols.item.route'))
                    ->hidden(fn (Get $get) => $get('is_route') === false)
                    ->required(fn (Get $get) => $get('is_route') === true)
                    ->searchable()
                    ->options(collect($routeList)->pluck('url', 'name')->toArray()),
                Toggle::make('has_badge')
                    ->default(false)
                    ->label(trans('filament-menus::messages.cols.item.has_badge'))
                    ->required()
                    ->live(),
                Translation::make('badge')
                    ->hidden(fn (Get $get) => $get('has_badge') === false)
                    ->label(trans('filament-menus::messages.cols.item.badge')),
                //                Forms\Components\TextInput::make('badge_model')
                //                    ->hidden(fn(Forms\Get $get) => $get('has_badge') === false)
                //                    ->maxLength(255)
                //                    ->label(trans('filament-menus::messages.cols.item.badge_model')),
                //                Forms\Components\TextInput::make('badge_condation')
                //                    ->hidden(fn(Forms\Get $get) => $get('has_badge') === false)
                //                    ->maxLength(255)
                //                    ->label(trans('filament-menus::messages.cols.item.badge_condation')),
                Select::make('badge_color')
                    ->hidden(fn (Get $get) => $get('has_badge') === false)
                    ->searchable()
                    ->options([
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'success' => 'Success',
                        'danger' => 'Danger',
                        'warning' => 'Warning',
                        'info' => 'Info',
                    ])
                    ->label(trans('filament-menus::messages.cols.item.badge_color')),
                IconPicker::make('icon')
                    ->label(trans('filament-menus::messages.cols.item.icon')),
                Toggle::make('new_tab')
                    ->label(trans('filament-menus::messages.cols.item.target'))
                    ->required(),
            ], $repeaterSchema)),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->columns([
                TextColumn::make('id')
                    ->label('Menu')
                    ->view('filament-menus::menu-item-column'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order');
    }
}
