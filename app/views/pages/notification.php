<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>
            <h1 class="text-3xl mb-2">Notification preferences</h1>
            <form id="profileForm" class="h-full" method="POST">
                <p class="mb-4">Send me an email when a user comments on my posts</p>
                <div id="toggleContainer" class="toggleContainer bg-active">
                    <div id="toggleNotif" class="toggle bg-white shadow-md transform translate-x-6">
                        
                    </div>
                </div>
            </form>
            <script type="text/javascript" src="<?=URL?>/app/assets/js/toggle.js"></script>