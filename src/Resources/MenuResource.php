<?php

namespace TomatoPHP\FilamentMenus\Resources;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use TomatoPHP\FilamentMenus\Models\Menu;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages\CreateMenus;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages\EditMenus;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages\ManageMenus;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Relations\MenuItems;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $slug = 'menus';

    protected static ?string $recordTitleAttribute = 'title';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bars-3';

    protected static string | \UnitEnum | null $navigationGroup = 'Settings';

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
            MenuItems::make(),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 3])->schema([
                    TextInput::make('title')
                        ->label(trans('filament-menus::messages.cols.title'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('key')
                        ->label(trans('filament-menus::messages.cols.key'))
                        ->required()
                        ->maxLength(255),
                    TextInput::make('location')
                        ->label(trans('filament-menus::messages.cols.location'))
                        ->required()
                        ->default('header')
                        ->maxLength(255),
                    Toggle::make('activated')
                        ->default(true)
                        ->label(trans('filament-menus::messages.cols.activated'))
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordActions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->modalContent(fn ($record) => new HtmlString(Blade::render('<x-filament-menu menu="' . $record->key . '" />')))
                    ->iconButton()
                    ->tooltip(__('filament-actions::view.single.label')),
                EditAction::make()->iconButton()->tooltip(__('filament-actions::edit.single.label')),
                DeleteAction::make()->iconButton()->tooltip(__('filament-actions::delete.single.label')),
            ])
            ->deferLoading()
            ->columns([
                TextColumn::make('title')
                    ->label(trans('filament-menus::messages.cols.title'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('key')
                    ->copyable()
                    ->color('danger')
                    ->formatStateUsing(fn ($record) => '<x-filament-menu menu="' . $record->key . '" />')
                    ->copyableState(fn ($record) => '<x-filament-menu menu="' . $record->key . '" />')
                    ->label(trans('filament-menus::messages.cols.component'))
                    ->searchable(),
                TextColumn::make('location')
                    ->label(trans('filament-menus::messages.cols.location'))
                    ->sortable(),
                ToggleColumn::make('activated')
                    ->label(trans('filament-menus::messages.cols.activated')),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->filters([
                Filter::make('activated')
                    ->label(trans('filament-menus::messages.filters.activated'))
                    ->query(fn (Builder $query): Builder => $query->where('activated', true)),
            ]);

    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMenus::route('/'),
            'create' => CreateMenus::route('/create'),
            'edit' => EditMenus::route('/{record}'),
        ];
    }
}
