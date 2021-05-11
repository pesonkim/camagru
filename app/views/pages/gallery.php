<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>

<div id="postsContainer" class="w-full max-w-screen-lg grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap md:gap sm:gap mt-2 mx-auto lg:px-2 md:px-2">
    
    
    <?php
    /*
    $ctrl = new PostController();
    $data = json_decode($ctrl->getPosts(), true);

    for ($x = 0; $x < count($data); $x++) {
        echo '
        <a class="flex flex-col p-4 shadow bg-white rounded slideUp">
        <img class="w-full" src=' . $data[$x]['img'] . '>
        <span class="my-4">' . $data[$x]['name'] . '</span>
        <span class="text-sm text-gray-500">' . $data[$x]['date'] .'</span>
        </a>
        ';
    }
    ---
        <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post">
        <img class="post-media" src="https://source.unsplash.com/random/?sig=1">
        <div class="post-title">
            <span>Example post #1</span>
        </div>
        <div class="post-actions">
            <div class="post-likes">
                <span class="text-pink-500">❤ </span>460
            </div>
            <div class="post-comments">
                <span class="text-pink-500">❤ </span>190
            </div>
        </div>
        <div class="post-modal-container" name="modal">
            <img class="post-modal-content" src="https://source.unsplash.com/random/?sig=1">
        </div>
    </div>


    */
    ?>
    <!--
    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp p-4 post">
        <div class="post-media">
            <img class="post-img" src="https://source.unsplash.com/random/?sig=1"></div>
        <div class="post-meta bg-white">
            <div class="post-title">
                <span>Example post #1</span>
            </div>
            <div class="post-actions">
                <div class="flex">
                    <div class="post-likes"></div>
                    <span>940</span>
                </div>
                <div class="flex">
                    <div class="post-comments"></div>
                    <span>74</span>
                </div>
                <div class="flex">
                    <div class="post-views"></div>
                    <span>6.5K</span>
                </div>
            </div>
            <div class="like-comment flex">
                <div class="like-post shadow-md">
                    <span>like</span>
                </div>
                <div class="comment-post shadow-md">
                    <span>comment</span>
                </div>
            </div>
        </div>
        <div class="post-modal-container" name="modal">
            <img class="post-modal-content" src="https://source.unsplash.com/random/?sig=1"></div>
    </div>

    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp p-4 post">
        <div class="post-media">
            <img class="post-img" src="https://source.unsplash.com/random/?sig=1"></div>
        <div class="post-meta bg-white">
            <div class="post-title">
                <span>Example post #1</span>
            </div>
            <div class="post-actions">
                <div class="flex">
                    <div class="post-likes"></div>
                    <span>940</span>
                </div>
                <div class="flex">
                    <div class="post-comments"></div>
                    <span>74</span>
                </div>
                <div class="flex">
                    <div class="post-views"></div>
                    <span>6.5K</span>
                </div>
            </div>
        </div>
        <div class="post-modal-container" name="modal">
            <img class="post-modal-content" src="https://source.unsplash.com/random/?sig=1"></div>
    </div>
-->

</div>

<script type="text/javascript" src="<?=URL?>/app/assets/js/gallery.js"></script>