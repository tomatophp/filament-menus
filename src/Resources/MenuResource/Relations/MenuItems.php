<?php

namespace TomatoPHP\FilamentMenus\Resources\MenuResource\Relations;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\RelationManagers\Concerns\Translatable;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use TomatoPHP\FilamentIcons\Components\IconColumn;
use TomatoPHP\FilamentIcons\Components\IconPicker;

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

    public function form(Form $form): Form
    {
        $routeList = [];
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $key => $route) {
            if (isset($route->action['as'])) {
                $routeList[] = [
                    "name" =>$route->action['as'],
                    "url" => $route->uri
                ];
            } else {
                $routeList[] = [
                    "name" => $route->uri,
                    "url" => $route->uri
                ];
            }
        }

        $repeaterSchema = [];
        if(class_exists(FilamentShieldPlugin::class)){
            $repeaterSchema[] = Forms\Components\Select::make('permissions')
                ->label(trans('filament-menus::messages.cols.item.permissions'))
                ->searchable()
                ->multiple()
                ->options(Permission::all()->pluck('name', 'name')->toArray());
        }

        $localsTitle = [];
        $localsBadge = [];
        foreach (config('filament-menus.locals') as $key=>$local){
            $localsTitle[] = Forms\Components\TextInput::make($key)
                ->label($local[app()->getLocale()])
                ->required();
            $localsBadge[] = Forms\Components\TextInput::make($key)
                ->label($local[app()->getLocale()])
                ->required();
        }
        return $form->schema([
            Forms\Components\Grid::make(["default" => 1])->schema(array_merge([
                Forms\Components\KeyValue::make('title')
                    ->schema($localsTitle)
                    ->keyLabel(trans('filament-menus::messages.cols.item.language'))
                    ->editableKeys(false)
                    ->addable(false)
                    ->deletable(false)
                    ->label(trans('filament-menus::messages.cols.item.title')),
                Forms\Components\Toggle::make('is_route')
                    ->default(true)
                    ->label(trans('filament-menus::messages.cols.item.is_route'))
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('url')
                    ->label(trans('filament-menus::messages.cols.item.url'))
                    ->hidden(fn(Forms\Get $get) => $get('is_route') === true)
                    ->required(fn(Forms\Get $get) => $get('is_route') === false)
                    ->maxLength(255),
                Forms\Components\Select::make('route')
                    ->label(trans('filament-menus::messages.cols.item.route'))
                    ->hidden(fn(Forms\Get $get) => $get('is_route') === false)
                    ->required(fn(Forms\Get $get) => $get('is_route') === true)
                    ->searchable()
                    ->options(collect($routeList)->pluck('url', 'name')->toArray()),
                Forms\Components\Toggle::make('has_badge')
                    ->default(false)
                    ->label(trans('filament-menus::messages.cols.item.has_badge'))
                    ->required()
                    ->live(),
                Forms\Components\KeyValue::make('badge')
                    ->hidden(fn(Forms\Get $get) => $get('has_badge') === false)
                    ->schema($localsBadge)
                    ->keyLabel(trans('filament-menus::messages.cols.item.language'))
                    ->editableKeys(false)
                    ->addable(false)
                    ->deletable(false)
                    ->label(trans('filament-menus::messages.cols.item.badge')),
// TODO: Implement badge model and condition
//                Forms\Components\TextInput::make('badge_model')
//                    ->hidden(fn(Forms\Get $get) => $get('has_badge') === false)
//                    ->maxLength(255)
//                    ->label(trans('filament-menus::messages.cols.item.badge_model')),
//                Forms\Components\TextInput::make('badge_condation')
//                    ->hidden(fn(Forms\Get $get) => $get('has_badge') === false)
//                    ->maxLength(255)
//                    ->label(trans('filament-menus::messages.cols.item.badge_condation')),
                Forms\Components\Select::make('badge_color')
                    ->hidden(fn(Forms\Get $get) => $get('has_badge') === false)
                    ->searchable()
                    ->options([
                        "primary" => "Primary",
                        "secondary" => "Secondary",
                        "success" => "Success",
                        "danger" => "Danger",
                        "warning" => "Warning",
                        "info" => "Info"
                    ])
                    ->label(trans('filament-menus::messages.cols.item.badge_color')),
                IconPicker::make('icon')
                    ->label(trans('filament-menus::messages.cols.item.icon'))
                    ->required(),
                Forms\Components\Toggle::make('new_tab')
                    ->label(trans('filament-menus::messages.cols.item.target'))
                    ->required(),
    ], $repeaterSchema))
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\CreateAction::make()
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Menu')
                    ->view('filament-menus::menu-item-column')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order');
    }
}
