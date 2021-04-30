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
    <div id="loginWrapper" class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
        <h1 class="text-3xl text-center mb-4">Login</h1>
        <form id="loginForm" class="h-full" method="POST">
            <div>
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
            </div>
            <div>
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
                        >Show
                    </button>
                </div>
                <div class="form-error" id="PasswordError"></div>
            </div>
            <button
                id="btn-login";
                type="submit"
                class="form-button rounded"
                name="action"
                value="login">
                Login
            </button>
        </form>
        <div class="form-footer text-center">
            <a style="color: #3490dc;" href="#">Forgot password?</a>
        </div>  
    </div>
</div>
<div class="max-w-screen-sm mx-auto">
    <div class="flex flex-col justify-center my-4 p-4 shadow bg-white rounded">
        <div class="text-center">
            Don't have an account? <a style="color: #3490dc;" href="index.php?page=signup">Signup</a>
        </div>  
    </div>
</div>

<script type="text/javascript" src="/camagru/app/assets/js/login.js"></script>