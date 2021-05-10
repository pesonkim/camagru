<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>
            <h1 class="text-3xl ">Delete user account</h1>
            <form id="signupForm" class="h-full" method="POST">
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