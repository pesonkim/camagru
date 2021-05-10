<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>
            <h1 class="text-3xl mb-2">Delete user account</h1>
            <form id="profileForm" class="h-full" method="POST">
                <p class="mb-4">Verify your login credentials to completely remove your account and all content linked to it. This action is permanent and cannot be reversed!</p>
                <label>Username</label>
                <input
                    id="Username"
                    type="text"
                    class="form-input rounded"
                    name="username"
                    value="<?=isset($_POST['username']) ? $_POST['username'] : '';?>"
                    onkeypress="return noEnter()"
                >
                <div class="form-error" id="UsernameError"></div>
                <label>Password</label>
                <div class="relative">                
                    <input
                        id="Password"
                        type="password"
                        class="form-input rounded"
                        name="password"
                        value="<?=isset($_POST['password']) ? $_POST['password'] : '';?>"
                        onkeypress="return noEnter()"
                    >
                    <button
                        onclick="toggle(this)"
                        class="show-hide-button"
                        type="button"
                        tabindex="-1"
                        >Show
                    </button>
                <div class="form-error" id="PasswordError"></div>
                </div>
                <button
                    id="btn-delete";
                    type="submit"
                    class="delete-button rounded"
                    name="action"
                    value="delete">
                    Delete account
                </button>
            </form>
            <div id="delete-container" class="delete-container fadeIn">
                <div id="delete-content" class="delete-content flex flex-col justify-center mx-auto my-2 p-4 px-6 bg-white rounded shadow slideDown">
                    <h1 class="text-3xl text-center mb-4" id="flash-title">Are you absolutely sure?</h1>
                    <p class="delete-message text-center" id="flash-text">Deleting a user account is permanent and cannot be reversed!</p>
                    <div class="flex flex-row">
                        <button id="confirm-delete" class="mx-auto rounded">Delete user</button>
                        <button id="close-delete" class="mx-auto rounded">Cancel</button>
                    </div>
                </div>
            </div>

            <script type="text/javascript" src="<?=URL?>/app/assets/js/deleteuser.js"></script>