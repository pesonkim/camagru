<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>

<div id="postsContainer" class="w-full max-w-screen-lg grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap md:gap sm:gap mt-2 mx-auto lg:px-2 md:px-2">

    <div id="uploadWrapper" class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp">
        <h1 class="text-3xl text-center mb-4">File upload</h1>
        <div class="uploadMedia">
            
        </div>
        <div class="uploadSelect flex flex-row mt-2">
            <input id="fileUpload" type='file' hidden/>
            <button
                id="manualUpload"
                class="mr-1 shadow-md"
            >
            <img class="uploadIcon" src="<?=URL?>/app/assets/img/resources/upload.svg" alt="upload">
            Upload
            </button>
            <button
                id="webCam"
                class="ml-1 shadow-md"
            >
            <img class="webcamIcon" src="<?=URL?>/app/assets/img/resources/webcam.svg" alt="webcam">
            Webcam
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
-->