<?php
if(!defined('Restricted')) {
    die('Direct access not permitted');
}
?>
            </main>
            <footer class="h-16 w-full flex flex-col justify-center items-center">
                <a href="#">
                    <?php
                        if (isset($_SESSION["user"]))
                        {
                            echo $_SESSION["user"];
                        }
                        else
                        {
                            echo 'kpesonen';
                        }
                    ?>
                </a>
            </footer>
        </div>
    </body>
</html>