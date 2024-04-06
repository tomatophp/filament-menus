<?php

namespace TomatoPHP\FilamentMenus\Resources;

use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use TomatoPHP\FilamentMenus\Models\Menu;
use Filament\Tables;
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

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Settings';

    public static function getNavigationLabel(): string
    {
        return trans('filament-menus::messages.title');
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
                        ->label(trans('filament-menus::messages.cols.title'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('key')
                        ->label(trans('filament-menus::messages.cols.key'))
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('location')
                        ->label(trans('filament-menus::messages.cols.location'))
                        ->required()
                        ->default('header')
                        ->maxLength(255),
                    Forms\Components\Repeater::make('items')
                        ->label(trans('filament-menus::messages.cols.item.item'))
                        ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(trans('filament-menus::messages.cols.item.title'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('url')
                            ->label(trans('filament-menus::messages.cols.item.url'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('route')
                            ->label(trans('filament-menus::messages.cols.item.route'))
                            ->searchable()
                            ->options($routeList),
                        Forms\Components\TextInput::make('icon')
                            ->label(trans('filament-menus::messages.cols.item.icon'))
                            ->hint('icon must start with [heroicon-o-]')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('blank')
                            ->label(trans('filament-menus::messages.cols.item.target'))
                            ->required(),
                    ]),
                    Forms\Components\Toggle::make('activated')
                        ->label(trans('filament-menus::messages.cols.activated'))
                        ->required(),
                ])
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {

        $table->actions([
            ActionGroup::make([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ]),
        ]);

        return $table
            ->recordAction(null)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('filament-menus::messages.cols.title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('filament-menus::messages.cols.component'))
                    ->view('filament-menus::menu-item')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(trans('filament-menus::messages.cols.location'))
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('activated')
                    ->label(trans('filament-menus::messages.cols.activated')),
            ])
            ->filters([
                Filter::make('activated')
                    ->label(trans('filament-menus::messages.filters.activated'))
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
