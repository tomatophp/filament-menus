<?php

namespace TomatoPHP\FilamentMenus\Resources\MenuResource\Pages;

use Filament\Actions\CreateAction;
use TomatoPHP\FilamentMenus\Resources\MenuResource;
use Filament\Resources\Pages\ManageRecords;

class ManageMenus extends ManageRecords
{
    protected static string $resource = MenuResource::class;


    public function getTitle(): string
    {
        return trans('filament-menus::messages.title');
    }

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('filament-menus::messages.create'))
        ];
    }
}
