<?php

namespace TomatoPHP\FilamentMenus\Resources;

use App\Forms\Components\Translation;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Spatie\Permission\Models\Permission;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use TomatoPHP\FilamentMenus\Models\Menu;
use Filament\Tables;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Route;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages;
use Illuminate\Contracts\Database\Eloquent\Builder;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Relations\MenuItems;

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

    public static function getRelations(): array
    {
        return [
            MenuItems::make()
        ];
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(["default" => 3])->schema([
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
                    Forms\Components\Toggle::make('activated')
                        ->default(true)
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
            'create' => Pages\CreateMenus::route('/create'),
            'edit' => Pages\EditMenus::route('/{record}'),
        ];
    }
}
