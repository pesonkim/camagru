<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>

<div id="postsContainer" class="w-full max-w-screen-lg grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap md:gap sm:gap mt-2 mx-auto lg:px-2 md:px-2">

    <div id="uploadWrapper" class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp">
        <h1 class="text-3xl text-center mb-4">Create new post</h1>
        <div id="uploadPreview" class="uploadMedia">
            <span id="fileName" style="display: none"></span>
            <video autoplay="true" id="videoPlayer" style="display: none"></video>
            <canvas id="canvas" height="" width="" style="display: none"></canvas>
            <img id="preview" class="shutter" src="" alt="capture" draggable="false" style="display: none">
            <div id="stickerList"></div>
        </div>
        <form id="uploadForm" enctype="multipart/form-data" method="POST" hidden>
            <input
                id="fileUpload"
                type='file'
                accept="image/*"
                hidden
            />
            <input
                id="webcamUpload"
                type='file'
                capture="camera"
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
        <div id="editMenu" class="slideDown flex-col" style="display: flex">
            <label>Add stickers (optional)</label>
            <div id="stickers" class="rounded">
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/forager.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/guard.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/builder.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/h.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/i.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/v.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/e.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/42.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/0.png">
                </div>

                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/100.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/thumb.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/smile.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/joy.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/sun.png">
                </div>
                <div class="sticker">
                    <img src="<?=URL?>/app/assets/img/stickers/heart.png">
                </div>
            </div>
            <label>Post title</label>
            <input
                id="title"
                type="text"
                class="form-input rounded"
                name="title"
                onkeypress="return noEnter()"
            >
            <div class="uploadSelect mt-4 mb-2">
                <button
                    id="postCancel"
                    class="mr-1 shadow-md fileCancel"
                >
                <img class="uploadIcon" src="<?=URL?>/app/assets/img/resources/upload.svg" alt="upload">
                Cancel
                </button>
                <button
                    id="postCreate"
                    class="ml-1 shadow-md fileContinue"
                >
                <img class="uploadIcon" src="<?=URL?>/app/assets/img/resources/upload.svg" alt="upload">
                Create post
                </button>
            </div>
        </div>

        <div class="post-modal-container" name="modal">
            <img class="post-modal-content" src="">
        </div>
        <div id="delete-container" class="delete-container fadeIn">
            <div id="delete-content" class="delete-content flex flex-col justify-center mx-auto my-2 p-4 px-6 bg-white rounded shadow slideDown">
                <h1 class="text-3xl text-center mb-4" id="flash-title">Are you sure?</h1>
                <p class="delete-message text-center" id="flash-text">This will delete your post.</p>
                <div class="flex flex-row">
                    <button id="confirm-delete" class="mx-auto rounded">Delete post</button>
                    <button id="close-delete" class="mx-auto rounded">Cancel</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="<?=URL?>/app/assets/js/upload.js"></script>
<script type="text/javascript" src="<?=URL?>/app/assets/js/userposts.js"></script>

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