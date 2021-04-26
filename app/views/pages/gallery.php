<div class="w-full max-w-screen-lg grid lg:grid-cols-3 gap-7 md:grid-cols-2 mx-auto">
    <?php
    for ($x = 0; $x < $_GET["example"]; $x++) {
        echo '
        <a class="flex flex-col my-2 p-4 shadow bg-white rounded">
        <img class="w-full" src="https://test-blog-lzycsjehg-pesonkim.vercel.app/images/first-post/cover-image.png">
        <span class="my-4">Example post</span><span class="text-sm text-gray-500">';
        echo $randomDate = date("d M Y", mt_rand(1, time()));
        echo '</span>
        </a>
        ';
    }
    ?>

</div>