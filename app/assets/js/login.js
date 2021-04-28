document.getElementById('loginForm').addEventListener('submit', validateForm);

function validateForm() {
    
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var error = false;

    if (username == "") {
        document.getElementById('usernameError').innerHTML = 'Username is required.';
        error = true;
    }
    else
        document.getElementById('usernameError').innerHTML = '';
    if (password == "") {
        document.getElementById('passwordError').innerHTML = 'Password is required.';
        error = true;
    }
    else
        document.getElementById('passwordError').innerHTML = '';
    if (error)
        event.preventDefault();
    else
        alert('check');
}

