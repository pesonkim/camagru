<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>
            <h1 class="text-3xl mb-4">Change password</h1>
            <form id="signupForm" class="h-full" method="POST">
                <label>Current password</label>
                <div class="relative">                
                    <input
                        id="OldPassword"
                        type="password"
                        class="form-input rounded"
                        name="oldpassword"
                        value="<?=isset($_POST['oldpassword']) ? $_POST['oldpassword'] : '';?>"
                        onkeypress="return noEnter()"
                    >
                    <button
                        onclick="toggle(this)"
                        class="show-hide-button"
                        type="button"
                        tabindex="-1"
                        >Show
                    </button>
                    <div class="form-error" id="OldPasswordError"></div>
                </div>
                <label>New password</label>
                <div class="relative">                
                    <input
                        id="NewPassword"
                        type="password"
                        class="form-input rounded"
                        name="newpassword"
                        value="<?=isset($_POST['newpassword']) ? $_POST['newpassword'] : '';?>"
                        onkeypress="return noEnter()"
                    >
                    <button
                        onclick="toggle(this)"
                        class="show-hide-button"
                        type="button"
                        tabindex="-1"
                        >Show
                    </button>
                    <div class="form-error" id="NewPasswordError"></div>
                </div>
                <button
                    id="btn-update";
                    type="submit"
                    class="form-button rounded"
                    name="action"
                    value="update">
                    Save changes
                </button>
            </form>