<x-filament-panels::page>

    <x-slot name="title">Student Images</x-slot>

    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <p>Upload student's face for recognition</p>

    </form>

        {{view('take-image')}}


</x-filament-panels::page>
