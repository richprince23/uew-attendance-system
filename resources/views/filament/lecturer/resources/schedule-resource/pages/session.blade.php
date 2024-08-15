<x-filament-panels::page>
    <h3 class="text-2xl">Start a New Class Attendance Session</h3>
    <p>Schedule ID: {{ $record->id }}</p>

    <div class="my-4">

        <x-filament::button wire:click="openNewUserModal">
            New user
        </x-filament::button>
    </div>
    <x-filament::section>
    <x-slot name="heading">
        Session Details
    </x-slot>

    {{-- Content --}}
</x-filament::section>
</x-filament-panels::page>
