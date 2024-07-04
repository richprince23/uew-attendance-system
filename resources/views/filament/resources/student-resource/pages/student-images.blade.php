<x-filament-panels::page>

    <x-slot name="title">Student Images</x-slot>

    <main class="" x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('webcamjs'))]">
        <section>

            <form wire:submit.prevent="submit">
                {{ $this->form }}

                <p class="my-8">Capture student's face for recognition</p>

                <article class="flex flex-col md:flex-row justify-around">
                    {{-- <video width="400" height="400" id="video"></video> --}}
                    <video class="w-1/2 border-blue-600" id="video"></video>
                    <img alt="Captured image" class="w-1/2 border-1 border-blue-600 hidden" id="photo">

                    <canvas id="canvas"></canvas>
                </article>


                <select name="cameras" id="camList" onChange="changeCamera(this.value)" class="my-4 w-[200px]">
                    <option value="">Select a camera</option>
                </select>

                <div id="container"></div>


                <div class="flex flex-row flex-wrap my-4 justify-evenly">
                    <x-filament::button class="mx-2"  id="start" icon="heroicon-m-video-camera" onClick="startCam()">Start Cam
                    </x-filament::button>
                    <x-filament::button class="mx-2"  id="stop" icon="heroicon-o-video-camera-slash" onClick="stopCam()">Stop Cam
                    </x-filament::button>
                    <x-filament::button  class="mx-2" id="capture" icon="heroicon-m-camera">Capture
                    </x-filament::button>

                </div>

            </form>

        </section>


    </main>

    <script>
        let cameraList = [];
        // let video = document.getElementById("video");
        let stream;
        let width = 640;
        let height = 480;
        photo = document.getElementById("photo");
        startbutton = document.getElementById("capture")
        const canvas = document.getElementById("canvas");
        const context = canvas.getContext("2d");
        const video = document.getElementById("video");
        const img = document.getElementById("img");

        // get list of available camera devices
        navigator.mediaDevices.enumerateDevices()
            .then((devices) => {
                devices.forEach((device) => {
                    if (device.kind == 'videoinput') {
                        cameraList.push(device.deviceId)
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

        //video constraints
        const constraints = {
            // audio: true,
            video: {
                width: {
                    min: 800,
                    ideal: 1280,
                    max: 1920
                },
                height: {
                    min: 400,
                    ideal: 720,
                    max: 1080
                },
            },
        };

        // starts the selected camera
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
                    };
                })
                .catch((err) => {
                    console.error(`${err.name}: ${err.message}`);
                });
        }

        // change camera device
        function changeCamera(cameraId) {
            constraints.video.deviceId = cameraId;
            startCam();
        }

        //second take picture function
        function takepicture() {
            const context = canvas.getContext("2d");
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                const data = canvas.toDataURL("image/png");
                photo.setAttribute("src", data);
            } else {
                clearphoto();
            }
        }

        // Fill the photo with an indication that none has been
        // captured.

        function clearphoto() {
            const context = canvas.getContext("2d");
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);
            const data = canvas.toDataURL("image/png");
            photo.setAttribute("src", data);
        }


        //stop camera
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
    </script>

</x-filament-panels::page>
