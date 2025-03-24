<?php

namespace TomatoPHP\FilamentMenus\Resources;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use TomatoPHP\FilamentMenus\Models\Menu;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Pages;
use TomatoPHP\FilamentMenus\Resources\MenuResource\Relations\MenuItems;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $slug = 'menus';

    protected static ?string $recordTitleAttribute = 'title';

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
            MenuItems::make(),
        ];
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Grid::make(['default' => 3])->schema([
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
                ]),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->actions([
                Tables\Actions\Action::make('view')
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
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('filament-menus::messages.cols.title'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('key')
                    ->copyable()
                    ->color('danger')
                    ->formatStateUsing(fn ($record) => '<x-filament-menu menu="' . $record->key . '" />')
                    ->copyableState(fn ($record) => '<x-filament-menu menu="' . $record->key . '" />')
                    ->label(trans('filament-menus::messages.cols.component'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(trans('filament-menus::messages.cols.location'))
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('activated')
                    ->label(trans('filament-menus::messages.cols.activated')),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ManageMenus::route('/'),
            'create' => Pages\CreateMenus::route('/create'),
            'edit' => Pages\EditMenus::route('/{record}'),
        ];
    }
}
