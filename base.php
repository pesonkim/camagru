<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <title>Camagru</title>
        <link rel="stylesheet" href="public/css/style.css">
    </head>
    <body>
        <div class="flex flex-col justify-between min-h-screen mx-4">
            <header class="h-16 w-full flex justify-center fixed top-0 left-0 right-0 z-50 blur shadow">
                <section class="w-full max-w-screen-lg flex justify-between items-center mx-4">
                    <section class="flex items-center">
                        <a href="#" class="flex flex-row items-center no-underline text-gray-700 text-2xl cursor-pointer select-none">
                        <h3 class="m-0">Camagru</h3>
                        <div class="animatedCursor"></div>
                        </a>
                    </section>
                    <div class="flex items-center"><div>
                    <section class="flex items-center">
                        <button class="mx-2">Login</button>
                        <button class="mx-2">Register</button>
                    </section>
                </section>
            </header>
            <main class="w-full max-w-screen-lg grid lg:grid-cols-3 gap-7 md:grid-cols-2 mx-auto mt-20">
                
                <?php
                    if(!empty($_GET) && is_numeric($_GET["example"])){
                        for ($x = 0; $x <= $_GET["example"]; $x++) {
                            echo '
                            <a class="flex flex-col my-2 p-4 cursor-pointer shadow bg-white">
                            <img class="w-full" src="https://test-blog-lzycsjehg-pesonkim.vercel.app/images/first-post/cover-image.png">
                            <span class="my-4">Example post</span><span class="text-sm text-gray-500">';
                            echo $randomDate = date("d M Y", mt_rand(1, time()));
                            echo '</span>
                            </a>
                            ';
                        }
                    }
                ?>

            </main>
            <footer class="h-16 w-full flex flex-col justify-center items-center">
                <a href="#">kpesonen</a>
            </footer>
        </div>
    </body>
</html>