<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>
            <h1 class="text-3xl">Notification preferences</h1>
            <form id="signupForm" class="h-full" method="POST">
                <p class="mb-4">Send me an email when a user comments on my posts</p>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                </label>
            </form>