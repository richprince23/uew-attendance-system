<x-filament-panels::page>

    <x-slot name="title">Student Images</x-slot>
    @vite('resources/sass/app.scss')

    <main class="" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('webcamjs'))]">
        <x-filament::section>
    <x-slot name="heading">
       Current User details
    </x-slot>
    <p class="text-xl font-bold">{{ $record->name }}</p>
    <p class="text-xl font-bold">{{ $record->id }}</p>

    {{-- Content --}}

        <section>
            <form method="POST" enctype="multipart/form-data" action="{{ route('getEncodings') }}" id="imageForm">
                @csrf

                <article class="flex flex-col md:flex-row justify-around">
                    <div class="relative w-1/2">
                        <video class="w-full border-blue-600" id="video"></video>
                        <!-- Guiding box -->
                        <div class="guiding-box relative border-2 border-dashed border-green-500 object-center">
                        </div>
                    </div>

                    <img alt="Captured image" class="w-1/2 border-1 border-blue-600 hidden" id="photo">
                    <input type="file" name="image" id="input-image" class="hidden">

                    <canvas id="canvas" class="hidden"></canvas>
                    <canvas id="croppedCanvas" class="hiddens"></canvas>
                </article>

                <select id="camList" onChange="changeCamera(this.value)" class="my-4 w-[200px]">
                    <option value="">Select a camera</option>
                </select>

                <input type="hidden" name="student_id" value="{{ $record->id }}" id="s_id">

                <div class="flex flex-row flex-wrap my-4 justify-start">
                    <x-filament::button class="mx-2" id="start" icon="heroicon-m-video-camera" outlined
                        onClick="startCam()">Start Cam</x-filament::button>
                    <x-filament::button class="mx-2" id="stop" icon="heroicon-o-video-camera-slash" outlined
                        onClick="stopCam()">Stop Cam</x-filament::button>
                    <x-filament::button class="mx-2" id="capture" icon="heroicon-m-camera"
                        outlined>Capture</x-filament::button>
                </div>
                <hr>
                <x-filament::button type="submit" class="px-8 my-4" id="submitBtn">Save Image</x-filament::button>
            </form>

            <div class="p-8">
                <p class="text-xl font-bold p-4 text-black bg-white" id="res"></p>
            </div>
        </section>
    </x-filament::section>
    </main>

    <script>
        let cameraList = [];
        let stream;
        const width = 480;
        let height = 480;
        const photo = document.getElementById("photo");
        const startbutton = document.getElementById("capture");
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
        context.willReadFrequently = true;
        const video = document.getElementById("video");
        const inputImage = document.getElementById("input-image");

        const guidingBox = document.querySelector('.guiding-box');

        // Get list of available camera devices
        navigator.mediaDevices.enumerateDevices()
            .then((devices) => {
                devices.forEach((device) => {
                    if (device.kind === 'videoinput') {
                        cameraList.push(device.deviceId);
                        const camSelect = document.querySelector("#camList");
                        const option = document.createElement('option');
                        option.value = device.deviceId;
                        option.text = device.label;
                        camSelect.appendChild(option);
                    }
                });
            })
            .catch((err) => {
                console.error(`${err.name}: ${err.message}`);
            });

        // Video constraints
        const constraints = {
            video: {
                width: 1280,
                height: 720
            },
        };

        // Start the selected camera
        function startCam() {
            navigator.mediaDevices.getUserMedia(constraints)
                .then((mediaStream) => {
                    stream = mediaStream;
                    video.srcObject = mediaStream;
                    video.onloadedmetadata = () => {
                        video.play();

                        height = video.videoHeight / (video.videoWidth / width);

                        if (isNaN(height)) {
                            height = width / (16 / 9);
                        }

                        video.setAttribute("width", width);
                        video.setAttribute("height", height);
                        canvas.setAttribute("width", width);
                        canvas.setAttribute("height", height);

                        guidingBox.style.height = (height) + "px";
                        guidingBox.style.width = (height) + "px";
                    };
                })
                .catch((err) => {
                    console.error(`${err.name}: ${err.message}`);
                });
        }

        // Change camera device
        function changeCamera(cameraId) {
            constraints.video.deviceId = cameraId;
            startCam();
        }

        // Take picture function
        function takepicture() {
            if (width && height) {
                // Draw the entire video frame onto the canvas
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                // Get the guiding box coordinates relative to the video element
                const videoRect = video.getBoundingClientRect();
                const boxRect = guidingBox.getBoundingClientRect();

                // Calculate the scale factor to maintain aspect ratio
                const scaleFactorX = video.videoWidth / videoRect.width;
                const scaleFactorY = video.videoHeight / videoRect.height;

                // Calculate the coordinates on the original video frame
                const videoX = (boxRect.left - videoRect.left) * scaleFactorX;
                const videoY = (boxRect.top - videoRect.top) * scaleFactorY;
                const videoW = boxRect.width * scaleFactorX;
                const videoH = boxRect.height * scaleFactorY;

                const boxAspectRatio = boxRect.width / boxRect.height;

                // Calculate the dimensions of the area to crop from the video frame
                let cropWidth = videoW;
                let cropHeight = videoH;
                if (videoW / videoH > boxAspectRatio) {
                    // Video is wider than the box aspect ratio
                    cropWidth = videoH * boxAspectRatio;
                } else {
                    // Video is taller than the box aspect ratio
                    cropHeight = videoW / boxAspectRatio;
                }

                // Adjust the cropping area to maintain centering
                const cropX = videoX + (videoW - cropWidth) / 2;
                const cropY = videoY + (videoH - cropHeight) / 2;

                // Set croppedCanvas dimensions to match the guiding box aspect ratio
                const croppedCanvas = document.getElementById('croppedCanvas');
                croppedCanvas.width = boxRect.width;
                croppedCanvas.height = boxRect.height;
                croppedCanvas.classList.add('w-[320px]');
                const croppedContext = croppedCanvas.getContext('2d');

                // Draw the cropped region from the video frame onto croppedCanvas
                croppedContext.drawImage(
                    video,
                    cropX, cropY, cropWidth, cropHeight,
                    0, 0, croppedCanvas.width, croppedCanvas.height
                );

                // Convert the cropped canvas to a Blob and set it as the file input value
                croppedCanvas.toBlob((blob) => {
                    const file = new File([blob], "student_image.png", {
                        type: "image/png"
                    });
                    const dT = new DataTransfer();
                    dT.items.add(file);
                    inputImage.files = dT.files;
                });

                // Update the photo element to show the cropped image
                const data = croppedCanvas.toDataURL("image/png");
                photo.setAttribute("src", data);


                guidingBox.style.height = (height - 20) + "px";
                guidingBox.style.width = (height - 20) + "px";
            } else {
                clearphoto();
            }
        }

        // Fill the photo with an indication that none has been captured
        function clearphoto() {
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            const data = canvas.toDataURL("image/png");
            photo.setAttribute("src", data);
        }

        // Stop camera
        function stopCam() {
            stream.getTracks().forEach((track) => {
                track.stop();
                clearphoto();
            });
        }

        startbutton.addEventListener(
            "click",
            (ev) => {
                takepicture();
                ev.preventDefault();
            },
            false,
        );

        clearphoto();

        document.getElementById('imageForm').addEventListener('submit', (event) => {
            event.preventDefault();
            const student_id = document.querySelector("#s_id").value;
            const formData = new FormData();
            formData.append('image', inputImage.files[0]);
            formData.append('student_id', student_id);

            fetch('/get-encodings', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value
                    },
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector("#res").innerHTML = data.message;
                    if (data.success) {
                        alert('Facial recognition successful!');
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`An error occurred during facial recognition: ${error}`);
                });
        });
    </script>

    <style>
        .guiding-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 2px dashed green;
            z-index: 1;
        }

        #croppedCanvas {
            /* width: 320px !important; */
            object-fit: contain;
            max-width: 100%;
            height: auto;
        }
    </style>


</x-filament-panels::page>
