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


    */
    ?>
<!--
    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post post-expanded">
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
            <img class="post-modal-content" src="https://source.unsplash.com/random/?sig=1">
        </div>
    </div>
    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post-expanded commentContainer">
        <div class="commentCreate">
            <input
                id="comment"
                type="text"
                class="form-input rounded"
                name="comment"
                placeholder="Login to leave a comment"
            >
            <div>
                <a 
                href="http://127.0.0.1:8080/camagru/index.php?page=login"
                >
                <button
                class="commentLoginButton"
                >
                Login
                </button>
                </a>
                <a
                href="http://127.0.0.1:8080/camagru/index.php?page=signup"
                >
                <button
                class="commentSignupButton"
                >
                Signup
                </button>
                </a>
            </div>
        </div>
        <div class="commentList">
            <div class="commentEntry">
                <div class="authorDate">
                    <span>Author</span>
                    <span> - </span>
                    <span>Time of posting</span>
                </div>
                <span>This is the comment body.</span>
            </div>
        </div>
    </div>


    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post post-expanded">
        <div class="post-media">
            <img class="post-img" src="https://source.unsplash.com/random/?sig=2"></div>
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
            <img class="post-modal-content" src="https://source.unsplash.com/random/?sig=2">
        </div>
    </div>
    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post-expanded commentContainer">
        <div class="commentCreate">
            <input
                id="comment"
                type="text"
                class="form-input rounded"
                name="comment"
                placeholder="Leave a comment"
            >
            <div>
                <button class="commentButton">Comment</button>
            </div>
        </div>
        <div class="commentList">
            <div class="commentEntry">
                <div class="authorDate">
                    <span>Author</span>
                    <span> - </span>
                    <span>Time of posting</span>
                </div>
                <span>This is the comment body.</span>
            </div>
        </div>
    </div>
-->

<!--
    <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post post-expanded">
        <div class="post-media">
            <img class="post-img" src="https://source.unsplash.com/random/?sig=2">
        </div>
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
            <img class="post-modal-content" src="https://source.unsplash.com/random/?sig=2">
        </div>
        <div class="flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideDown commentContainer">
        <div class="commentCreate">
            <input
                id="commentField"
                type="text"
                class="form-input rounded"
                name="comment"
                placeholder="Leave a comment"
            >
            <div>
                <button class="commentButton">Comment</button>
            </div>
        </div>
        <div class="commentList">
            <div class="commentEntry">
                <div class="authorDate">
                    <span>Author</span>
                    <span> - </span>
                    <span>Time of posting</span>
                </div>
                <span>This is the comment body.</span>
            </div>
        </div>
    </div>
    </div>

-->



</div>

<script type="text/javascript" src="<?=URL?>/app/assets/js/gallery.js"></script>

