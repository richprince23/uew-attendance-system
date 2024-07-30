@extends('layouts.main')
@section('headers')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="space-6 text-center">
    <h1 class="text-2xl font-bold tracking-tight md:text-3xl">Live Attendance Session</h1>
    <h3 class="text-xl font-bold tracking-tight md:text-3xl my-4">Course : {{$course_name}}</h1>
    <div class="space-4">
        <select id="cameraSelect" class="w-auto my-8 border-2 p-4 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
            <option value="">Select a camera</option>
        </select>

        <div class="relative ">
            <video id="video" autoplay class="w-5/6 mx-auto my-8 h-auto border border-gray-300 rounded-lg shadow-sm"></video>
        </div>

        <div class="w-3/4 mx-auto p-8  bg-grey-300 border-2 border-gray-300 rounded-lg shadow-sm text-2xl">
            <p>Recognized Student's Details:</p>
            <hr>
            <p class="text-2xl font-medium text-gray-500 my-4">Index Number:
                <span id="student_id" class="text-2xl font-semibold text-gray-900"></
            </p>
            <p class="text-2xl font-medium text-gray-500 my-4">Student:
                <span id="student_details" class="text-2xl font-semibold text-gray-900"></
            </p>
        </div>
    </div>
</div>



@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentId = document.getElementById('student_id');
        const student_details = document.getElementById('student_details');

        const video = document.getElementById('video');
        const cameraSelect = document.getElementById('cameraSelect');
        const canvas = document.createElement('canvas');
        canvas.width = 640;
        canvas.height = 480;
        const ctx = canvas.getContext('2d');

        let stream;
        let recognitionInterval;

        async function populateCameraOptions() {
            const devices = await navigator.mediaDevices.enumerateDevices();
            const videoDevices = devices.filter(device => device.kind === 'videoinput');
            videoDevices.forEach(device => {
                const option = document.createElement('option');
                option.value = device.deviceId;
                option.text = device.label || `Camera ${cameraSelect.length + 1}`;
                cameraSelect.appendChild(option);
            });
        }

        async function startVideoStream(deviceId) {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            const constraints = {
                video: {deviceId: deviceId ? {exact: deviceId} : undefined}
            };
            try {
                stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
                await video.play();
                startRecognition();
            } catch (error) {
                console.error('Error accessing the camera:', error);
            }
        }

        function startRecognition() {
            if (recognitionInterval) {
                clearInterval(recognitionInterval);
            }
            recognitionInterval = setInterval(() => {
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                canvas.toBlob(blob => {
                    const formData = new FormData();
                    formData.append('image', blob, 'frame.jpg');
                    // fetch('http://localhost:3000/recognize', {
                    fetch("{{route( 'recognize' )}}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            console.log(`Recognized face: ${data.student.index_number}`);
                            studentId.innerText = data.student.index_number;
                            student_details.innerText = `${data.student.name}`;
                            alert('attendance taken!')
                        } else {
                            studentId.innerText = "No match found";
                            student_details.innerText = "";
                            console.log('No match found');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }, 'image/jpeg');
            }, 3000);
        }

        cameraSelect.addEventListener('change', (event) => {
            if (event.target.value) {
                startVideoStream(event.target.value);
            }
        });

        populateCameraOptions().then(() => {
            if (cameraSelect.options.length > 1) {
                cameraSelect.selectedIndex = 1;
                startVideoStream(cameraSelect.value);
            }
        });
    });
</script>

@endsection
@endsection
