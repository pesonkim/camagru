var uploadWrapper = document.getElementById('uploadWrapper');
var uploadPreview = document.getElementById('uploadPreview');
var uploadForm = document.getElementById('uploadForm');
var uploadInput = document.getElementById('fileUpload');
var webcamInput = document.getElementById('webcamUpload');

var menu1 = document.getElementById('menu1');
var uploadBtn = document.getElementById('manualUpload');
var webcamBtn = document.getElementById('webCam');

var menu2 = document.getElementById('menu2');
var webcamCancel = document.getElementById('camCancel');
var webcamCapture = document.getElementById('camCapture');

var menu3 = document.getElementById('menu3');
var fileCancel = document.getElementById('imgCancel');
var fileContinue = document.getElementById('imgContinue');

var uploadFile = undefined;
var fileName = document.getElementById('fileName');

const videoPlayer = document.getElementById('videoPlayer');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');

function getFileName() {
    uploadFile = uploadInput.value;
}

function displayFileName() {
    if (uploadFile == undefined || uploadFile == '') {
        fileName.innerHTML = 'No file selected.'
    }
    else {
        fileName.innerHTML = uploadFile;
    }
}





var video = document.querySelector("#videoElement");

webcamCancel.addEventListener('click', function() {
    videoPlayer.srcObject.getVideoTracks().forEach(track => track.stop());
    fileName.style.display = 'block';
    videoPlayer.style.display = 'none';
    menu1.style.display = 'flex';
    menu2.style.display = 'none';
    menu3.style.display = 'none';
})

webcamCapture.addEventListener('click', function() {
    canvas.width = videoPlayer.srcObject.getVideoTracks()[0].getSettings().width;
    canvas.height = videoPlayer.srcObject.getVideoTracks()[0].getSettings().height;

    context.drawImage(videoPlayer, 0, 0);
    videoPlayer.srcObject.getVideoTracks().forEach(track => track.stop());

    var capture = canvas.toDataURL('image/png');
    var canvasCapture = document.getElementById('canvasCapture');
    canvasCapture.src = capture;

    videoPlayer.style.display = 'none';
    canvasCapture.style.display = 'block';
    menu1.style.display = 'none';
    menu2.style.display = 'none';
    menu3.style.display = 'flex';
})

webcamBtn.addEventListener('click', function() {
    if (videoPlayer.style.display == 'none') {
        fileName.style.display = 'none';
        videoPlayer.style.display = 'block';
        const constraints = {
            video: true,
        };
        navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
            videoPlayer.srcObject = stream;
        });
        menu1.style.display = 'none';
        menu2.style.display = 'flex';
        menu3.style.display = 'none';
    }
})

uploadForm.addEventListener('change', function() {
    getFileName();
    displayFileName();
    if (uploadFile !== '') {
        menu1.style.display = 'none';
        menu3.style.display = 'flex';
    }
    else if (uploadFile === '') {
        menu1.style.display = 'flex';
        menu3.style.display = 'none';
    }
})

uploadBtn.addEventListener('click', function() {
    uploadInput.click();
})

fileCancel.addEventListener('click', function() {
    uploadInput.value = '';
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);
    canvasCapture.src = '';
    canvasCapture.style.display = 'none';
    fileName.style.display = 'block';
    var event = new Event('change');
    uploadForm.dispatchEvent(event);
})

fileContinue.addEventListener('click', function() {
    console.log(uploadInput.value);
})

window.addEventListener('DOMContentLoaded', function() {
    if (uploadFile === undefined) {
        menu2.style.display = 'none';
        menu3.style.display = 'none';
        fileName.innerHTML = 'No file selected.'
        fileName.style.display = 'block';
    }
});
