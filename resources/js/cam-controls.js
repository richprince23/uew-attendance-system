var wcm = new WebCamera({
    //If "videoTag" is omitted, it is generated automatically
    constraints: {
        video: {
            width: 320,
            height: 240
        }
    }
});


var container = document.getElementById("container");
var videoTag = wcm.getVideoTag();
container.appendChild(videoTag);

wcm.startCamera();


var btnStart = document.getElementById("start");
btnStart.addEventListener("click", function () {
    wcm.startCamera();
});

var btnStop = document.getElementById("stop");
btnStop.addEventListener("click", function () {
    wcm.stopCamera();
});

var btnCapture = document.getElementById("capture");
btnCapture.addEventListener("click", function () {

    //capture image in a classical way
    var image = wcm.capture(160, 120);
    var htmlImageEle = document.getElementById("image");
    htmlImageEle.src = image;

});

var btnGrabFrame = document.getElementById("grabFrame");
btnGrabFrame.addEventListener("click", function () {
    wcm.setUseImageCaptureAPI(true);
    wcm.grabFrame().then(function (imageBitmap) {

        var canvas = document.getElementById("canvas");
        canvas.width = imageBitmap.width;
        canvas.height = imageBitmap.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(imageBitmap, 0, 0);

    });

});

var btnTakePhoto = document.getElementById("takePhoto");
btnTakePhoto.addEventListener("click", function () {
    wcm.setUseImageCaptureAPI(true);
    wcm.takePhoto()
        .then(function (blob) {
            return window.createImageBitmap(blob);
        })
        .then(function (imageBitmap) {

            var canvas = document.getElementById("canvas");
            canvas.width = imageBitmap.width;
            canvas.height = imageBitmap.height;
            var ctx = canvas.getContext("2d");
            ctx.drawImage(imageBitmap, 0, 0);
        });

});


var btnContStart = document.getElementById("continuousStart");
btnContStart.addEventListener("click", function () {

    var canvas = document.getElementById("canvas");

    //continuous capture with specfied size
    wcm.setOnSnapShotCallback(function (imageBitmap) {
        canvas.width = imageBitmap.width;
        canvas.height = imageBitmap.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(imageBitmap, 0, 0);

    });

});

var btnContEnd = document.getElementById("continuousStop");
btnContEnd.addEventListener("click", function () {
    wcm.setOnSnapShotCallback(null);
});


var cbFlipImage = document.getElementById("flipImage");
cbFlipImage.addEventListener("click", function () {
    wcm.setFlipImageEnabled(cbFlipImage.checked);
});


//-->
