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
var captureFile = undefined;
var fileName = document.getElementById('fileName');

const videoPlayer = document.getElementById('videoPlayer');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');
const preview = document.getElementById('preview');

function getFileName() {
    if (uploadInput.files[0]) {
        uploadFile = uploadInput.files[0];
        return uploadFile;
    }
    else {
        uploadFile = '';
        return false;
    }
}

function resetFields() {
    cancelUpload();
    uploadInput.value = '';
    captureFile = false;
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);
    preview.src = '';
    preview.style.display = 'none';
    fileName.style.display = 'block';
    var event = new Event('change');
    uploadForm.dispatchEvent(event);
}

function cancelUpload() {
    const request = new XMLHttpRequest();
    const file = uploadFile;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            console.log(json);
        }
    }

    const requestData = 'action=cancelUpload&file='+file;

    request.open('post', 'index.php?PostController&method=cancelUpload');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

function uploadImage() {
    const request = new XMLHttpRequest();
    const file = uploadInput.files[0];
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            console.log(json);
            if (json.code == 200) {
                preview.src = json.path+'?'+performance.now();
                uploadFile = json.path;
                fileName.style.display = 'none';
                preview.style.display = 'block';
                menu1.style.display = 'none';
                menu2.style.display = 'none';
                menu3.style.display = 'flex';
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
                resetFields();
            }
            if (json.code == 400) {
                if (json.errors.format)
                    flash('Oops','Uploaded file is not an image.');
                else if (json.errors.size)
                    flash('Oops','Size limit for uploads is 2MB.');
                resetFields();
            }
            if (json.code == 500) {
                flash('Error','Something went wrong uploading image, please try again.');
                resetFields();
            }
        }
    }

    if (file) {
        const formData = new FormData;
        formData.append('fileAjax', file, file.name);
        formData.append('action', 'uploadImage');
        request.open('post', 'index.php?PostController&method=uploadUserImage');
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.send(formData);
    }
    else if (captureFile) {
        var capture = canvas.toDataURL('image/png')
        const requestData = 'action=uploadImage&capture='+capture;
        request.open('post', 'index.php?PostController&method=uploadUserCapture');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.send(requestData);
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
    captureFile = true;

    videoPlayer.style.display = 'none';
    uploadImage();
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
    if (getFileName()) {
        fileName.innerHTML = uploadFile.name;
        fileName.style.display = 'block';
        uploadImage();
        menu1.style.display = 'none';
        menu2.style.display = 'none';
        menu3.style.display = 'flex';
    }
    else {
        fileName.innerHTML = 'No file selected.'
        fileName.style.display = 'block';
        menu1.style.display = 'flex';
        menu2.style.display = 'none';
        menu3.style.display = 'none';
    }
})

uploadBtn.addEventListener('click', function() {
    uploadInput.click();
})

fileCancel.addEventListener('click', function() {
    resetFields();
})

fileContinue.addEventListener('click', function() {
    console.log(uploadFile);
})

window.addEventListener('DOMContentLoaded', function() {
    var event = new Event('change');
    uploadForm.dispatchEvent(event);
});
