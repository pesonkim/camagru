<?php
echo "<script>
    function toggle(e) {
        x = document.getElementById('password').type;
        if (x == 'password') {
            e.innerHTML = 'Hide';
            document.getElementById('password').type='text';
        }
        else {
            e.innerHTML = 'Show'
            document.getElementById('password').type='password';
        }
    }
    </script>";
?>

<div class="max-w-screen-sm mx-auto items-center justify-center">
    <div class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
        <h1 class="text-3xl text-center mb-4">Signup</h1>
        <form id="signupForm" class="h-full" method="POST">
            <label>Username</label>
            <input
                id="username"
                type="text"
                class="form-input rounded"
                name="username"
                value="<?=isset($_POST['username']) ? $_POST['username'] : '';?>"
                onkeypress="return noEnter()"
            >
            <div class="form-error" id="usernameError"></div>
            <label>Email</label>
            <input
                id="email"
                type="text"
                class="form-input rounded"
                name="email"
                value="<?=isset($_POST['email']) ? $_POST['email'] : '';?>"
                onkeypress="return noEnter()"
            >
            <div class="form-error" id="emailError"></div>
            <label>Password</label>
            <div class="relative">                
                <input
                    id="password"
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
            <div class="form-error" id="passwordError"></div>
            </div>
            <button
                id="btn-signup";
                type="submit"
                class="form-button rounded"
                name="action"
                value="signup">
                Create account
            </button>
        </form>
    </div>
</div>
<div class="max-w-screen-sm mx-auto">
    <div class="flex flex-col justify-center my-4 p-4 shadow bg-white rounded">
        <div class="text-center">
            Have an account? <a style="color: #3490dc;" href="index.php?page=login">Login</a>
        </div>  
    </div>
</div>

<script type="text/javascript" src="/camagru/app/assets/js/signup.js"></script>