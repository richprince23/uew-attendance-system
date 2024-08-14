<x-filament-panels::page>
    <h3 class="text-2xl">Start a New Class Attendance Session</h3>
    <p>Schedule ID: {{ $record->id }}</p>

    <div class="my-4">
        <x-filament-panels::button wire:click="startSession">
    </div>
</x-filament-panels::page>
