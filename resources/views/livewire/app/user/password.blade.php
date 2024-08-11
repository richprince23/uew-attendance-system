<x-filament::section>
    <x-slot name="heading">
        Change Password
    </x-slot>

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <div class="text-left">
            <x-filament::button type="submit">
                Save
            </x-filament::button>
        </div>
    </x-filament-panels::form>
</x-filament::section>
