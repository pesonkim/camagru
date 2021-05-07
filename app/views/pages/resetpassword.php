<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not premitted");
}
?>

<div class="max-w-screen-sm mx-auto items-center justify-center px-2">
    <div id="resetPasswordWrapper" class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
        <h1 class="text-3xl text-center mb-4">Password reset</h1>
        <form id="resetpasswordForm" class="h-full" method="POST">
            <p>Please enter a new password for your account.</p>
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
                id="btn-resetPassword";
                type="submit"
                class="form-button rounded"
                name="action"
                value="resetPassword">
                Set new password
            </button>
        </form>
        <div class="form-footer text-center">
            <a style="color: #3490dc;" href="index.php?page=login">Back to login</a>
        </div>  
    </div>
</div>


<script type="text/javascript" src="<?=URL?>/app/assets/js/resetpassword.js"></script>