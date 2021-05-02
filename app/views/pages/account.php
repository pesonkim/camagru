<?php
$token = bin2hex(random_bytes(32));
$_SESSION["token"] = $token;
?>


<div class="grid lg:grid-cols-1 gap-7 md:grid-cols-2 mx-auto px-2">
    <div class="">
        <div class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
            <div class="">
                <div class="account-tab">Update username</div>
                <div class="account-tab">Update password</div>
                <div class="account-tab">Update email</div>
                <div class="account-tab">Delete account</div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="flex flex-col justify-center my-2 p-4 px-6 shadow bg-white rounded">
            <h1 class="text-3xl mb-4">Account</h1>
            <form class="text-center h-full" method="post">
                <input type="text" class="form-input rounded" placeholder="Username" name="username" value="" >
                <input type="text" class="form-input rounded" placeholder="Email" name="email" value="" >
                <input type="password" class="form-input rounded" placeholder="Password" name="password" value="" >
                <input type="password" class="form-input rounded" placeholder="Confirm password" name="confirm" value="" >
                <button type="submit" class="form-button rounded" value="login">Create account</button>
                <input type="hidden" name="token" value="<?=$token?>" >
            </form>
        </div>
    </div>
</div>


