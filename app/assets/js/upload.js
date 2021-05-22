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

var menu4 = document.getElementById('editMenu');
var postCancel = document.getElementById('postCancel');
var postCreate = document.getElementById('postCreate');

var uploadFile = undefined;
var captureFile = undefined;
var fileName = document.getElementById('fileName');

const videoPlayer = document.getElementById('videoPlayer');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');
const preview = document.getElementById('preview');

const stickerList = document.getElementById('stickerList');

function noEnter() {
    return !(window.event && window.event.keyCode == 13);
}

document.getElementById('title').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('title').blur();
});

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

//clear anything related to temp image upload
function resetFields() {
    cancelUpload();
    uploadInput.value = '';
    captureFile = false;
    context.clearRect(0, 0, context.canvas.width, context.canvas.height);
    preview.src = '';
    preview.style.display = 'none';
    preview.style.cursor = 'zoom-in';
    fileName.style.display = 'block';
    var modal = preview.parentElement.parentElement.querySelector('.post-modal-container');
    modal.querySelector('.post-modal-content').src = '';
    while (stickerList.firstChild) {
        stickerList.removeChild(stickerList.lastChild);
    }
    var toggles = (document.getElementById('stickers')).getElementsByTagName('div');
    for (var j = 0; j < toggles.length; j++) {
        if (toggles[j].classList.contains('selected'))
            toggles[j].classList.toggle('selected');
    }
    var event = new Event('change');
    uploadForm.dispatchEvent(event);
}

//send src image and title for post controller
function createPost() {
    const request = new XMLHttpRequest();
    const file = uploadFile;
    const title = document.getElementById('title').value;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            //console.log(request.responseText);
            const json = JSON.parse(request.responseText);
            //console.log(json);
            if (json.code == 200) {
                flash('Success','Your post was created.', 'index.php?page=upload');
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
            }
            if (json.code == 400) {
                if (json.errors.file)
                    flash('Error','Something went wrong uploading image, please try again.');
                else if (json.errors.title)
                    flash('Title required','Please give your post a title.');
            }
        }
    }
    const requestData = 'action=createPost&file='+file+'&title='+encodeURIComponent(title);

    request.open('post', 'index.php?PostController&method=createPost');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With' , 'XMLHttpRequest');
    request.send(requestData);
}

//clear currently uploaded temp image
function cancelUpload() {
    const request = new XMLHttpRequest();
    const file = uploadFile;

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            //console.log(json);
        }
    }

    const requestData = 'action=cancelUpload&file='+file;

    request.open('post', 'index.php?PostController&method=cancelUpload');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

//upload initial image for image editing
function uploadImage() {
    const request = new XMLHttpRequest();
    const file = uploadInput.files[0];
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            //console.log(json);
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
                    flash('Oops','Size limit for uploads is 4MB.');
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

preview.addEventListener('click', function(event) {
    //open lightbox
    if (preview.src !== '' && menu4.style.display !== 'flex') {
        var modal = preview.parentElement.parentElement.querySelector('.post-modal-container');
        modal.querySelector('.post-modal-content').src = preview.src;
        modal.style.display = 'grid';
        document.getElementsByTagName("html")[0].style.overflow = 'hidden';
    }
});

uploadWrapper.addEventListener('click', function(event) {
    //close lightbox
    if (event.target.classList.contains('post-modal-content')) {
        event.target.parentNode.style.display = 'none';
        document.getElementsByTagName("html")[0].style.overflow = 'scroll';
    }
    //close lightbox
    else if (event.target.classList.contains('post-modal-container')) {
        event.target.style.display = 'none';
        document.getElementsByTagName("html")[0].style.overflow = 'scroll';
    }
});

//close webcam and clear video channels
webcamCancel.addEventListener('click', function() {
    if (videoPlayer.srcObject)
        videoPlayer.srcObject.getVideoTracks().forEach(track => track.stop());
    fileName.style.display = 'block';
    videoPlayer.style.display = 'none';
    menu1.style.display = 'flex';
    menu2.style.display = 'none';
    menu3.style.display = 'none';
})

//capture image from webcam and save to canvas
webcamCapture.addEventListener('click', function() {
    if (!videoPlayer.srcObject) {
        flash('Camera blocked', 'Please enable webcam access for captures.', 'index.php?page=upload');
    }
    canvas.width = videoPlayer.srcObject.getVideoTracks()[0].getSettings().width;
    canvas.height = videoPlayer.srcObject.getVideoTracks()[0].getSettings().height;

    context.drawImage(videoPlayer, 0, 0);
    videoPlayer.srcObject.getVideoTracks().forEach(track => track.stop());
    captureFile = true;

    videoPlayer.style.display = 'none';
    uploadImage();
})

//open webcam and init video channels
webcamBtn.addEventListener('click', function() {
    if (videoPlayer.style.display == 'none') {
        fileName.style.display = 'none';
        videoPlayer.style.display = 'block';
        const constraints = {
            video: true,
        };
        navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
            videoPlayer.srcObject = stream;
        })
        .catch(function (err) {
            flash('Camera blocked', 'Please enable webcam access for captures.', 'index.php?page=upload');
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
        //menu4.style.display = 'none';
    }
    else {
        fileName.innerHTML = 'No file selected.'
        fileName.style.display = 'block';
        menu1.style.display = 'flex';
        menu2.style.display = 'none';
        menu3.style.display = 'none';
        //menu4.style.display = 'none';
    }
})

uploadBtn.addEventListener('click', function() {
    uploadInput.click();
})

fileCancel.addEventListener('click', function() {
    resetFields();
})

fileContinue.addEventListener('click', function() {
    menu3.style.display = 'none';
    menu4.style.display = 'flex';
    preview.style.cursor = 'default';
})

postCancel.addEventListener('click', function() {
    resetFields();
})

postCreate.addEventListener('click', function() {
    //createPost();


    //stickerList.getElementsByTagName('div')[0].querySelector('img').src;
    var stickers = stickerList.getElementsByTagName('div');
    for (var i = 0; i < stickers.length; i++) {
        //console.log(stickers[i].querySelector('img');
        console.log(stickers[i].querySelector('img').src);
        getRelativePos(stickers[i]);
    }

})

function getRelativePos(sticker) {
    var parentPos = document.getElementById('preview').getBoundingClientRect(),
    childPos = document.getElementById(sticker.id).getBoundingClientRect(),
    relativePos = {};

    relativePos.top = childPos.top - parentPos.top,
    relativePos.left = childPos.left - parentPos.left,
    relativePos.width = childPos.width,
    relativePos.height = childPos.height;

    console.log(relativePos);
}

const slider = document.getElementById('stickers');
var isDown = false;
var startX;
var scrollLeft;

slider.addEventListener('mousedown', function(event) {
    isDown = true;
    startX = event.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
});

slider.addEventListener('mouseup', function() {
    isDown = false;
    slider.classList.remove('grabbing');
});

slider.addEventListener('mouseleave', function() {
    isDown = false;
    slider.classList.remove('grabbing');
});

slider.addEventListener('mousemove', function(event) {
    if (!isDown)
        return;
    slider.classList.add('grabbing');
    event.preventDefault();
    const x = event.pageX - slider.offsetLeft;
    const walk = (x - startX);
    slider.scrollLeft = scrollLeft - walk;
});

var initX;
var initY;
var mousePressX;
var mousePressY;

var stickers = document.querySelectorAll('.sticker');
for (var i = 0; i < stickers.length; i++) {
    stickers[i].addEventListener('mouseup', function(event) {
        //console.log(event.currentTarget.querySelector('img').src);
        if (!event.currentTarget.parentElement.classList.contains('grabbing')) {
            //create sticker
            if (!event.currentTarget.classList.contains('selected')) {
                var stickerModal = document.createElement('div');
                stickerModal.setAttribute('class', 'sticker-modal');
                var stickerImg = document.createElement('img');
                stickerImg.src = event.currentTarget.querySelector('img').src;
                stickerImg.setAttribute('class', 'draggable');
                stickerImg.setAttribute('draggable', false);

                stickerModal.setAttribute('id', event.currentTarget.querySelector('img').src);
                stickerModal.appendChild(stickerImg);

                stickerModal.addEventListener('mousedown', function(event) {
                    initX = this.offsetLeft;
                    initY = this.offsetTop;
                    mousePressX = event.clientX;
                    mousePressY = event.clientY;

                    this.addEventListener('mousemove', moveSticker, false);

                    window.addEventListener('mouseup', function() {
                        stickerModal.removeEventListener('mousemove', moveSticker, false);
                    }, false);
                }, false);

                stickerList.appendChild(stickerModal);

                event.currentTarget.classList.toggle('selected');
            }
            //delete sticker
            else {
                var stickerModal = document.getElementById(event.currentTarget.querySelector('img').src);
                stickerList.removeChild(stickerModal);

                event.currentTarget.classList.toggle('selected');
            }
        }
    });
}

function moveSticker(event) {
    this.style.left = initX + event.clientX - mousePressX + 'px';
    this.style.top = initY + event.clientY - mousePressY + 'px';
}


window.addEventListener('DOMContentLoaded', function() {
    var event = new Event('change');
    uploadForm.dispatchEvent(event);
});

//delete user post after popup confirmation
function deletePost(id) {
    //console.log(id);
    const request = new XMLHttpRequest();

    const requestData = 'action=deletePost&id='+id;

    request.open('post', 'index.php?PostController&method=deletePost');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}
