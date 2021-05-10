<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>

<div class="max-w-screen-sm mx-auto items-center justify-center px-2">
    <div id="forgotpasswordWrapper" class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
        <h1 class="text-3xl text-center mb-4">Forgot your password?</h1>
        <form id="forgotpasswordForm" class="h-full" method="POST">
            <div>
                <p>Please enter the <b>email address</b> associated with your account to receive a link to reset your password.</p>
                <input
                    id="Email"
                    type="text"
                    class="form-input rounded"
                    name="Email"
                    value="<?=isset($_POST['email']) ? $_POST['email'] : '';?>"
                    onkeypress="return noEnter()"
                >
                <div class="form-error" id="EmailError"></div>
            </div>
            <button
                id="btn-resetemail";
                type="submit"
                class="form-button rounded"
                name="action"
                value="sendResetEmail">
                Send password reset email
            </button>
        </form>
        <div class="form-footer text-center">
            <a style="color: #3490dc;" href="index.php?page=login">Back to login</a>
        </div>  
    </div>
</div>
<div class="max-w-screen-sm mx-auto px-2">
    <div class="flex flex-col justify-center my-4 p-4 shadow bg-white rounded">
        <div class="text-center">
            Don't have an account? <a style="color: #3490dc;" href="index.php?page=signup">Signup</a>
        </div>  
    </div>
</div>

<script type="text/javascript" src="<?=URL?>/app/assets/js/forgotpassword.js"></script>
