<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>

<div id="postsContainer" class="w-full max-w-screen-lg grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap md:gap sm:gap mt-2 mx-auto lg:px-2 md:px-2">

    <div id="uploadWrapper" class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp">
        <h1 class="text-3xl text-center mb-4">File upload</h1>
        <div id="uploadPreview" class="uploadMedia">
            <span id="fileName" style="display: none"></span>
            <video autoplay="true" id="videoPlayer" style="display: none"></video>
            <canvas id="canvas" height="" width="" style="display: none"></canvas>
            <img id="canvasCapture" src="" alt="capture" style="display: none">
        </div>
        <form id="uploadForm" action="POST" hidden>
            <input
                id="fileUpload"
                type='file'
                accept="image/*"
                enctype="multipart/form-data"
                hidden
            />
            <input
                id="webcamUpload"
                type='file'
                capture="camera"
                enctype="multipart/form-data"
                hidden
            />
        </form>
        <div id="menu1" class="uploadSelect slideDown flex flex-row mt-2">
            <button
                id="manualUpload"
                class="mr-1 shadow-md fileButton"
            >
            <img class="uploadIcon" src="<?=URL?>/app/assets/img/resources/upload.svg" alt="upload">
            Upload file
            </button>

            <button
                id="webCam"
                class="ml-1 shadow-md fileButton"
            >
            <img class="webcamIcon" src="<?=URL?>/app/assets/img/resources/webcam.svg" alt="webcam">
            Use webcam
            </button>
        </div>
        <div id="menu2" class="uploadSelect slideDown flex-row mt-2">
            <button
                id="camCancel"
                class="mr-1 shadow-md fileCancel"
            >
            <img class="webcamIcon" src="<?=URL?>/app/assets/img/resources/webcam.svg" alt="webcam">
            Cancel
            </button>
            <button
                id="camCapture"
                class="ml-1 shadow-md fileContinue"
            >
            <img class="webcamIcon" src="<?=URL?>/app/assets/img/resources/webcam.svg" alt="webcam">
            Capture
            </button>
        </div>
        <div id="menu3" class="uploadSelect slideDown flex-row mt-2">
            <button
                id="imgCancel"
                class="mr-1 shadow-md fileCancel"
            >
            <img class="uploadIcon" src="<?=URL?>/app/assets/img/resources/upload.svg" alt="upload">
            Cancel
            </button>
            <button
                id="imgContinue"
                class="ml-1 shadow-md fileContinue"
            >
            <img class="uploadIcon" src="<?=URL?>/app/assets/img/resources/upload.svg" alt="upload">
            Continue
            </button>
        </div>

    </div>

</div>

<script type="text/javascript" src="<?=URL?>/app/assets/js/upload.js"></script>

<!--
                <form id="uploadForm" class="flex flex-row uploadSelect" method="POST">
                <button id="webCam" class="mx-auto rounded">Use webcam</button>
                <button id="manualUpload" class="mx-auto rounded">Upload file</button>
            </form>




                    <div class="uploadConfirm">
            <input
                id="fileName"
                type="text"
                class="form-input rounded"
                name="filename"
                placeholder="Login to leave a comment"
            >
            <div>
                <button
                class="commentLoginButton"
                >
                Cancel
                </button>
                <button
                class="commentSignupButton"
                >
                Continue
                </button>
            </div>
        </div>
-->