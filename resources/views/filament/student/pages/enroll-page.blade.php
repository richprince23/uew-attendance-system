<x-filament-panels::page>

    <div class="space-y-6">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                {{-- Render the form --}}
                {{ $this->form }}

                <br>
                <x-filament::button wire:click='save'> Enroll Courses</x-filament::button>
            </div>
        </div>
    </div>

</x-filament-panels::page>
