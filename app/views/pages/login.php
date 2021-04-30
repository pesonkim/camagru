<?php
echo "<script>
    function toggle(e) {
        x = document.getElementById('Password').type;
        if (x == 'password') {
            e.innerHTML = 'Hide';
            document.getElementById('Password').type='text';
        }
        else {
            e.innerHTML = 'Show'
            document.getElementById('Password').type='password';
        }
    }
    </script>";
?>
<button id="open-modal" >
    click me
</button>

<div class="modal-container" id="modal-container">
    <div class="modal-content">
        <h1>This is a popup
        </h1>
        <p>Lorem Khaled Ipsum is a major key to success. Another one. Lion! Don’t ever play yourself. The key is to drink coconut, fresh coconut, trust me. I’m giving you cloth talk, cloth. Special cloth alert, cut from a special cloth. Fan luv. In life you have to take the trash out, if you have trash in your life, take it out, throw it away, get rid of it, major key. I’m up to something. The key to success is to keep your head above the water, never give up. Every chance I get, I water the plants, Lion! Fan luv.</p>
        <button id="close-modal">close me</button>
    </div>
</div>

<script>
    var modal = document.getElementById('modal-container');

    var btn = document.getElementById('open-modal');

    btn.onclick = function() {
        modal.style.display = 'block';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

</script>

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
                        tabindex="-1"
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
