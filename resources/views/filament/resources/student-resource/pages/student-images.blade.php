<x-filament-panels::page>

    <x-slot name="title">Student Images</x-slot>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4 ">
            Save
        </x-filament::button>
        <p>Upload student's face for recognition</p>

    </form>

    <div class="container">
        <x-filament::input.wrapper>
            <x-filament::input type="file" accept="image/*" wire:model="name" capture />
        </x-filament::input.wrapper>
    </div>

    <h1 class="text-6xl">Hey </h1>
</x-filament-panels::page>
