<?php

namespace TomatoPHP\FilamentMenus\Resources\MenuResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentMenus\Resources\MenuResource;
use Filament\Resources\Pages\ManageRecords;

class CreateMenus extends CreateRecord
{
    protected static string $resource = MenuResource::class;

    #[Reactive]
    public ?string $local = "en";
    public function setLocal($local){
        $this->local = $local;
        $this->activeLocale = $local;
    }


    public function getTitle(): string
    {
        return trans('filament-menus::messages.title');
    }
}
