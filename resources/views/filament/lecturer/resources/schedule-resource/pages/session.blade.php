<x-filament-panels::page>
    {{-- @vite('resources/sass/app.scss') --}}

    <p id="recordId" class="hidden">{{ $record->id }}</p>

    @php
        $lecturer = \App\Models\Lecturer::where('user_id', auth()->user()->id)
            ->get()
            ->first();

        $lecturerId = $lecturer->id ?? 0;

        // get  course schedules details
        $schedule = \App\Models\Schedules::where('schedules.id', $record->id)
            ->join('courses', 'schedules.course_id', 'courses.id')
            ->get()
            ->first();

        Log::info($schedule);
    @endphp


    <x-filament::section>
        <x-slot name="heading">
            Session Details
        </x-slot>

        <p class="text-2xl font-bold my-4">Course Name: {{ $schedule->course_name }}</p>
        <p class="text-2xl my-4">Course Code: {{ $schedule->course_code }}</p>
        <p class="text-2xl my-4">Level: {{ $schedule->level }}</p>


        {{-- submit to start session --}}
        <form action="#" method="post" id="sessionForm">
            @csrf

            {{-- <x-filament::input.wrapper>
            <x-filament::input type="text" wire:model="schedules_id" id="scheduleId" name="schedules_id"
                title="The class to to take attendance for" value="{{ $record->id }}"  readonly/>
            </x-filament::input.wrapper> --}}
            {{-- duration --}}
            <br>
            <label for="duration" class="mt-4 mb-8">Choose Attendance Session Duration</label>
            <x-filament::input.wrapper>
                <x-filament::input.select wire:model="duration" id="duration" name="duration"
                    title="How long before attendance session ends" required>
                    <option value="" disabled>Select attendance duration</option>
                    <option value="10">10 Minutes</option>
                    <option value="15">15 Minutes</option>
                    <option value="20">20 Minutes</option>
                    <option value="30">30 Minutes</option>
                    <option value="45">45 Minutes</option>
                </x-filament::input.select>
            </x-filament::input.wrapper>

            {{-- venue --}}
            <br>
            <label for="venue" class="mt-4 mb-8">Venue for Class Session</label>
            <x-filament::input.wrapper>
                <x-filament::input type="text" wire:model="{{$schedule->venue}}" id="venue" name="venue"
                    title="Where exactly this class is taking place" value="{{$schedule->venue}}" required />
            </x-filament::input.wrapper>

            <br>
            <div class="my-8">
                <x-filament::button type="submit">Start Session </x-filament::button>
            </div>

        </form>

        <br>
        <p id="res" class="text-xl"></p>

        {{-- Content --}}
    </x-filament::section>

    <script>
        document.getElementById('sessionForm').addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData();
            formData.append('schedules_id', Number(document.getElementById('recordId').textContent));
            formData.append('duration', document.getElementById('duration').value);
            formData.append('venue', document.getElementById('venue').value);
            // formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch(`{{route('config-session')}}`, {
                    method: 'POST',
                    body: formData,
                    // headers: {
                    //     'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
                    // },
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector("#res").innerHTML = data.course_name; // Adjust accordingly
                    if (data.success) {
                        // alert('Session Started');
                        setTimeout(() => {
                            window.location.href = "{{route('start-session')}}";
                        }, 5);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`An error while starting session : ${error}`);
                });
        });
    </script>
</x-filament-panels::page>
