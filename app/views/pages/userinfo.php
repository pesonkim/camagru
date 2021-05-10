<?php
if (!defined('RESTRICTED')) {
    die ("Direct access not permitted");
}
?>
            <h1 class="text-3xl mb-4">Edit user info</h1>
            <form id="profileForm" class="h-full" method="POST">
                <label>Username</label>
                <input
                    id="Username"
                    type="text"
                    class="form-input rounded"
                    name="username"
                    placeholder="<?=isset($_SESSION['username']) ? $_SESSION['username'] : '';?>"
                    value="<?=isset($_POST['username']) ? $_POST['username'] : '';?>"
                    onkeypress="return noEnter()"
                >
                <div class="form-error" id="UsernameError"></div>
                <label>Email</label>
                <input
                    id="Email"
                    type="text"
                    class="form-input rounded"
                    name="email"
                    placeholder="<?=isset($_SESSION['email']) ? $_SESSION['email'] : '';?>"
                    value="<?=isset($_POST['email']) ? $_POST['email'] : '';?>"
                    onkeypress="return noEnter()"
                >
                <div class="form-error" id="EmailError"></div>
                <button
                    id="btn-update";
                    type="submit"
                    class="update-button rounded"
                    name="action"
                    value="update">
                    Save changes
                </button>
            </form>
            <script type="text/javascript" src="<?=URL?>/app/assets/js/userinfo.js"></script>