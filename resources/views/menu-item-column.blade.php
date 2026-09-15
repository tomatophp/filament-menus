@php
    $record = \TomatoPHP\FilamentMenus\Models\MenuItem::find($getState());
@endphp
@if($record)
    <div style="display: flex; align-items: center; gap: 0.5rem;">
        @if(!empty($record->icon))
            <x-icon :name="$record->icon" style="width: 1.25rem; height: 1.25rem; flex-shrink: 0;"/>
        @endif
        <span>
            {{ $record->localized('title') }}
        </span>
        @if($record->has_badge && filled($record->localized('badge')))
            <x-filament::badge :color="$record->badge_color">
                {{ $record->localized('badge') }}
            </x-filament::badge>
        @endif
    </div>
@endif
