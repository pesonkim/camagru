<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
if (!isset($_GET['tab']))
    header("Location: " . URL . '/index.php?page=profile&tab=info');
?>

<div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5 mx-auto px-2">
    <div id="tabWrapper">
        <div class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
            <div class="">
                <a href="<?=URL?>/index.php?page=profile&tab=info" class="account-tab mb-2
                <?php if ($_GET['tab'] === 'info') {echo 'active';} ?>">User info</a>
                <a href="<?=URL?>/index.php?page=profile&tab=sec" class="account-tab mb-2
                <?php if ($_GET['tab'] === 'sec') {echo 'active';} ?>">Security</a>
                <a href="<?=URL?>/index.php?page=profile&tab=notif" class="account-tab mb-2
                <?php if ($_GET['tab'] === 'notif') {echo 'active';} ?>">Notifications</a>
                <a href="<?=URL?>/index.php?page=profile&tab=delete" class="account-tab
                <?php if ($_GET['tab'] === 'delete') {echo 'active';} ?>">Delete account</a>
            </div>
        </div>
    </div>
    <div id="sectionWrapper">
        <div class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
            <?php
            //include right form depending on selected tab
            $tab = $_GET['tab'];
            switch ($tab) {
                case "info": {
                    require_once DIRPATH . '/app/views/pages/userinfo.php';
                    break ;
                }
                case "sec": {
                    require_once DIRPATH . '/app/views/pages/password.php';
                    break ;
                }
                case "notif": {
                    require_once DIRPATH . '/app/views/pages/notification.php';
                    break ;
                }
                case "delete": {
                    require_once DIRPATH . '/app/views/pages/delete.php';
                    break ;
                }
                default: {
                    header("Location: " . URL . '/index.php?page=profile&tab=info');
                    break ;
                }
            }
            ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?=URL?>/app/assets/js/profile.js"></script>