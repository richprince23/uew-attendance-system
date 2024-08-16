@extends('layouts.main')
@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/sass/app.scss')
@endsection

@section('title', 'Attendance Session')

@section('content')


    @if ($duration > 0)
        <div class="space-4 text-center">


            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight md:text-3xl">Live Attendance Session </h1>
                <h3 class="text-2xl font-bold tracking-tight md:text-3xl my-4 text-blue-500"> {{ session('course_name') }}
                    </h1>
                    <p id="remainingTime" class="text-xl"></p>
            </div>
            <x-filament::section class="rounded-lg" id="main">

                {{-- contents --}}

                <div class="space-4">
                    <select id="cameraSelect"
                        class="w-auto my-4 border-2 py-4 border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select a camera</option>
                    </select>
                    <br>


                    <div id="status">
                        <p id="statusText"></p>
                    </div>

                    <div class="relative ">
                        <video id="video" autoplay
                            class="w-1/3 mx-auto my-4 h-auto border border-gray-300 rounded-lg shadow-sm"></video>
                    </div>

                    <div class="w-3/4 mx-auto p-4  bg-grey-300 border-2 border-gray-300 rounded-lg shadow-sm text-2xl">
                        {{-- <p>Recognized Student's Details:</p>
                        <hr> --}}
                        <p class="text-2xl font-medium text-gray-500 my-4">Index Number:
                            <span id="student_id" class="text-2xl font-semibold text-gray-900"></span>
                        </p>
                        <p class="text-2xl font-medium text-gray-500 my-4">Student:
                            <span id="student_details" class="text-2xl font-semibold text-gray-900"></span>
                        </p>
                    </div>
                </div>
                <button id="endSessionBtn" class="bg-red-500 px-4 py-2 text-white rounded-2xl mt-4">End Attendance
                    Session</button>
            </x-filament::section>
        </div>

        @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', async function() {
                    // Load face-api.js models
                    await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
                    // await faceapi.nets.faceLandmark68Net.loadFromUri('/models');
                    // await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

                    const studentId = document.getElementById('student_id');
                    const student_details = document.getElementById('student_details');
                    const statusText = document.getElementById('statusText');
                    const video = document.getElementById('video');
                    const cameraSelect = document.getElementById('cameraSelect');
                    const canvas = document.createElement('canvas');
                    canvas.width = 640;
                    canvas.height = 480;
                    const ctx = canvas.getContext('2d');

                    const countdownDisplay = document.getElementById("remainingTime");
                    const storedEndTime = localStorage.getItem('sessionEndTime');
                    let countdownDuration = 0;

                    if (storedEndTime) {
                        const endTime = new Date(storedEndTime);
                        const now = new Date();
                        countdownDuration = Math.max(Math.floor((endTime - now) / 1000), 0);
                    } else {
                        countdownDuration = parseInt("{{ session('duration') }}") * 60;
                        const endTime = new Date();
                        endTime.setSeconds(endTime.getSeconds() + countdownDuration);
                        localStorage.setItem('sessionEndTime', endTime.toISOString());
                    }

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
                            video: {
                                deviceId: deviceId ? {
                                    exact: deviceId
                                } : undefined
                            }
                        };
                        try {
                            stream = await navigator.mediaDevices.getUserMedia(constraints);
                            video.srcObject = stream;
                            await video.play();
                            startRecognition();
                        } catch (error) {
                            console.error('Error accessing the camera:', error);
                            statusText.innerText = `Error accessing the camera: ${error}`;
                        }
                    }

                    function startRecognition() {
                        if (recognitionInterval) {
                            clearInterval(recognitionInterval);
                        }
                        recognitionInterval = setInterval(async () => {
                            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                            const detections = await faceapi.detectAllFaces(canvas, new faceapi
                                .TinyFaceDetectorOptions());
                            // const resizedDetections = faceapi.resizeResults(detections, {
                            //     width: video.width,
                            //     height: video.height
                            // });

                            if (detections.length > 0) {
                                // faceapi.draw.drawDetections(canvas, resizedDetections);

                                canvas.toBlob(blob => {
                                    const formData = new FormData();
                                    formData.append('image', blob, 'frame.jpg');

                                    fetch("{{ route('recognize') }}", {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]').getAttribute(
                                                    'content')
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.status === 'success') {
                                                studentId.innerText = data.student.index_number;
                                                student_details.innerText =
                                                    `${data.student.name}`;
                                                statusText.innerText = `${data.message}`;
                                                statusText.style.color = "green";
                                                if (data.message === "Attendance recorded") {
                                                    speakText(`Recorded, ${data.student.name}`);
                                                }
                                            } else {
                                                // Clear UI when no match is found
                                                studentId.innerText = "No match found";
                                                student_details.innerText = "";
                                                statusText.innerText = `${data.message}`;
                                                statusText.style.color = "red";
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            // Clear UI on error
                                            studentId.innerText = "Error occurred";
                                            student_details.innerText = "";
                                            statusText.innerText = "Error occurred";
                                            statusText.style.color = "red";
                                        });
                                }, 'image/jpeg');

                            } else {
                                studentId.innerText = "No face detected";
                                student_details.innerText = "";
                                statusText.innerText = "No face detected";
                                statusText.style.color = "red";
                                // speakText("No face detected");
                            }
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

                    // Countdown timer
                    const countdownInterval = setInterval(() => {
                        countdownDuration--;
                        let minutes = Math.floor(countdownDuration / 60);
                        let seconds = countdownDuration % 60;
                        countdownDisplay.innerText =
                            `Time remaining: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                        if (countdownDuration <= 0) {
                            clearInterval(countdownInterval);
                            countdownDisplay.innerText = "Time's up!";
                            countdownDisplay.style.color = "red";
                            speakText("Session has timed out");
                            stopCam();
                            clearSessionData();
                        }

                        // Update the end time in localStorage
                        const endTime = new Date();
                        endTime.setSeconds(endTime.getSeconds() + countdownDuration);
                        localStorage.setItem('sessionEndTime', endTime.toISOString());
                    }, 1000); // Update every second

                    function stopCam() {
                        if (stream) {
                            stream.getTracks().forEach((track) => track.stop());
                        }
                        clearInterval(recognitionInterval);
                    }

                    function clearSessionData() {
                        fetch("{{ route('clear.session') }}", { // Define this route in your web.php file
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                statusText.innerText = "Attendance session has ended!";
                                statusText.style.color = "red";
                                video.style.display = "none"; // Hide video element
                                cameraSelect.disabled = true; // Disable camera selection

                            }
                        }).catch(error => console.error('Error clearing session:', error)).then(() => setTimeout(
                            () => {
                                localStorage.removeItem('sessionEndTime'); // Remove end time from localStorage
                                location.reload(true); // Force reload from server
                            }, 500));
                    }


                    //manually end session
                    document.getElementById('endSessionBtn').addEventListener('click', function() {
                        // Stop the camera
                        stopCam();
                        // Send a request to end the session
                        clearSessionData();
                    });

                    function speakText(text) {
                        // Create a new instance of SpeechSynthesisUtterance
                        const utterance = new SpeechSynthesisUtterance(text);

                        // Set language (optional, default is browser language)
                        utterance.lang = 'en-US'; // You can change this to other languages like 'en-GB', 'fr-FR', etc.

                        // Speak the text
                        window.speechSynthesis.speak(utterance);
                    }

                });
            </script>
        @endsection
    @else
        <div class="flex flex-col items-center justify-center h-screen text-center">
            <div class=" p-8 border-2 border-blue-500 rounded-lg">
                <h3 class="text-red-500 my-8 text-3xl">Attendance Session Ended!</h3>
                <p>
                    <i>If you are a student, you may contact your lecturer for manual attendance recording</i>
                </p>

            </div>
            <a href="{{ url('/lecturer/schedules') }}" class="bg-blue-500 px-4 py-3 text-white mt-8 block rounded-xl"> Go to
                Schedules </a>
        </div>

    @endif

@endsection
