function noEnter() {
    return !(window.event && window.event.keyCode == 13);
}

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

document.getElementById('Username').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('Password').focus();
});
document.getElementById('Username').addEventListener('focusout', function () {
    validateField(this.id, this.value);
});
document.getElementById('Password').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('btn-login').focus();
});
document.getElementById('Password').addEventListener('focusout', function () {
    validateField(this.id, this.value);
});

function drawError() {
    if (document.getElementById('UsernameError').innerHTML == '') {
        document.getElementById('Username').classList.remove('input-error');
        document.getElementById('Username').classList.add('input-ok');
    }
    else {
        document.getElementById('Username').classList.remove('input-ok');
        document.getElementById('Username').classList.add('input-error');
    }
    if (document.getElementById('PasswordError').innerHTML == '') {
        document.getElementById('Password').classList.remove('input-error');
        document.getElementById('Password').classList.add('input-ok');
    }
    else {
        document.getElementById('Password').classList.remove('input-ok');
        document.getElementById('Password').classList.add('input-error');
    }
}

function drawConfirm() {
    document.getElementById('Username').classList.remove('input-error');
    document.getElementById('Username').classList.add('input-ok');
    document.getElementById('UsernameError').innerHTML = '';
    document.getElementById('Password').classList.remove('input-error');
    document.getElementById('Password').classList.add('input-ok');
    document.getElementById('PasswordError').innerHTML = '';
}

function validateField(id, value) {
    if (value == "") {
        document.getElementById(id).classList.remove('input-ok');
        document.getElementById(id).classList.add('input-error');
        if (id == 'Username') {
            document.getElementById(id+'Error').innerHTML = 'Please enter a username.';
        }
        else {
            document.getElementById(id+'Error').innerHTML = 'Please enter a password.';
        }
    }
    else {
        document.getElementById(id).classList.remove('input-error');
        document.getElementById(id).classList.add('input-ok');
        document.getElementById(id+'Error').innerHTML = '';
    }
}

document.getElementById('btn-login').addEventListener('click', validateForm);

function validateForm() {
    event.preventDefault();
    const username = document.getElementById('Username').value;
    const password = document.getElementById('Password').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            console.log(request.responseText);
            const json = JSON.parse(request.responseText);
            console.log(json);
            if (json.code == 200) {
                drawConfirm();
                flash('Success!','Welcome to Camagru!', 'index.php?page=gallery');
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
            }
            if (json.code == 400) {
                if (json.errors.login) {
                    document.getElementById('UsernameError').innerHTML = '';
                    document.getElementById('PasswordError').innerHTML = json.errors.login;
                    document.getElementById('Username').classList.remove('input-ok');
                    document.getElementById('Username').classList.add('input-error');
                    document.getElementById('Password').classList.remove('input-ok');
                    document.getElementById('Password').classList.add('input-error');
                    document.getElementById('loginWrapper').classList.add('apply-shake');
                    setTimeout(function() {document.getElementById('loginWrapper').classList.remove('apply-shake');}, 500);
                }
                else if (json.errors.verify) {
                    document.getElementById('UsernameError').innerHTML = '';
                    document.getElementById('PasswordError').innerHTML = json.errors.verify;
                    document.getElementById('Username').classList.remove('input-ok');
                    document.getElementById('Username').classList.add('input-error');
                    document.getElementById('Password').classList.remove('input-ok');
                    document.getElementById('Password').classList.add('input-error');
                    flash('Account verification needed.','Please follow the link in the email we sent you to verify your account before logging in.');
                }
                else {
                    if (json.errors.username)
                        document.getElementById('UsernameError').innerHTML = json.errors.username;
                    else
                        document.getElementById('UsernameError').innerHTML = '';
                    if (json.errors.password)
                        document.getElementById('PasswordError').innerHTML = json.errors.password;
                    else
                        document.getElementById('PasswordError').innerHTML = '';
                    drawError();
                    document.getElementById('loginWrapper').classList.add('apply-shake');
                    setTimeout(function() {document.getElementById('loginWrapper').classList.remove('apply-shake');}, 500);
                }
            }
        }
    }

    const requestData = 'action=login&username='+username+'&password='+password;

    request.open('post', 'index.php?UserController&method=loginUser');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}
