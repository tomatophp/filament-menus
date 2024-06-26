@php
    $record = \TomatoPHP\FilamentMenus\Models\MenuItem::find($getState());
@endphp
<div class="flex justify-start gap-2">
    @if(!empty($record->icon))
        <x-icon :name="$record->icon" class="w-6 h-6"/>
    @endif
    <div>
        {{ $record->title[app()->getLocale()] }}
    </div>
    @if($record->has_badge)
        <div>
            <x-filament::badge :hidden="$record->has_badge" :color="$record->badge_color">
                {{ $record->badge[app()->getLocale()] }}
            </x-filament::badge>
        </div>
    @endif
</div>
