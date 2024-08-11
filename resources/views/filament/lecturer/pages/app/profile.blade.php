<x-filament-panels::page>
    <x-filament::grid @class(['gap-6']) xl="2">
        <x-filament::grid.column>
            <livewire:app.user.profile />
        </x-filament::grid.column>

        <x-filament::grid.column>
            <livewire:app.user.password />
        </x-filament::grid.column>
    </x-filament::grid>
</x-filament-panels::page>
