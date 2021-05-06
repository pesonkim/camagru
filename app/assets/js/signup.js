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
        document.getElementById('Email').focus();
});
document.getElementById('Username').addEventListener('focusout', function () {
    validateField(this.id, this.value);
});
document.getElementById('Email').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('Password').focus();
});
document.getElementById('Email').addEventListener('focusout', function () {
    validateField(this.id, this.value);
});
document.getElementById('Password').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('btn-signup').focus();
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
    if (document.getElementById('EmailError').innerHTML == '') {
        document.getElementById('Email').classList.remove('input-error');
        document.getElementById('Email').classList.add('input-ok');
    }
    else {
        document.getElementById('Email').classList.remove('input-ok');
        document.getElementById('Email').classList.add('input-error');
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

function validateField(id, value) {
    const request = new XMLHttpRequest();
    if (id === 'Username') {
        var requestData = 'username='+value;
        request.open('post', 'index.php?UserController&method=validateUsernameFormat');
    }
    if (id === 'Email') {
        var requestData = 'email='+value;
        request.open('post', 'index.php?UserController&method=validateEmailFormat');
    }
    if (id === 'Password') {
        var requestData = 'password='+value;
        request.open('post', 'index.php?UserController&method=validatePasswordFormat');
    }
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            if (json.username) {
                document.getElementById('UsernameError').innerHTML = json.username;
                document.getElementById(id).classList.remove('input-ok');
                document.getElementById(id).classList.add('input-error');
            }
            else if (json.email) {
                document.getElementById('EmailError').innerHTML = json.email;
                document.getElementById(id).classList.remove('input-ok');
                document.getElementById(id).classList.add('input-error');
            }
            else if (json.password) {
                document.getElementById('PasswordError').innerHTML = json.password;
                document.getElementById(id).classList.remove('input-ok');
                document.getElementById(id).classList.add('input-error');
            }
            else {
                document.getElementById(id).classList.remove('input-error');
                document.getElementById(id).classList.add('input-ok');
                document.getElementById(id+'Error').innerHTML = '';
            }
        }
    }
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}

document.getElementById('btn-signup').addEventListener('click', validateForm);

function validateForm() {
    event.preventDefault();
    const username = document.getElementById('Username').value;
    const email = document.getElementById('Email').value;
    const password = document.getElementById('Password').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                alert('yay');
                window.location = 'index.php?page=login';
            }
            const json = JSON.parse(request.responseText);
            console.log(json);
            if (json.code == 200) {
                alert(json.message);
                window.location = 'index.php?page=login';
            }
            if (json.code == 401) {
                alert(json.message);
            }
            if (json.code == 400) {
                if (json.errors.username)
                    document.getElementById('UsernameError').innerHTML = json.errors.username;
                else
                    document.getElementById('UsernameError').innerHTML = '';
                if (json.errors.email)
                    document.getElementById('EmailError').innerHTML = json.errors.email;
                else
                    document.getElementById('EmailError').innerHTML = '';
                if (json.errors.password)
                    document.getElementById('PasswordError').innerHTML = json.errors.password;
                else
                    document.getElementById('PasswordError').innerHTML = '';
                drawError();
                document.getElementById('signupWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('signupWrapper').classList.remove('apply-shake');}, 500);
            }
            if (json.code == 409) {
                if (json.errors.username)
                    document.getElementById('UsernameError').innerHTML = json.errors.username;
                else
                    document.getElementById('UsernameError').innerHTML = '';
                if (json.errors.email)
                    document.getElementById('EmailError').innerHTML = json.errors.email;
                else
                    document.getElementById('EmailError').innerHTML = '';
                if (json.errors.password)
                    document.getElementById('PasswordError').innerHTML = json.errors.password;
                else
                    document.getElementById('PasswordError').innerHTML = '';
                drawError();
                document.getElementById('signupWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('signupWrapper').classList.remove('apply-shake');}, 500);
            }
        }
    }

    const requestData = 'action=signup&username='+username+'&email='+email+'&password='+password;

    request.open('post', 'index.php?UserController&method=signupUser');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}