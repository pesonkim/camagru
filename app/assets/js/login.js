function noEnter() {
    return !(window.event && window.event.keyCode == 13);
}

document.getElementById('Username').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('password').focus();
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
    if (value == "") {
        document.getElementById(id).classList.remove('input-ok');
        document.getElementById(id).classList.add('input-error');
        document.getElementById(id+'Error').innerHTML = id + ' is required.';
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
            if (json.code == 200) {
                alert(json.message);
                window.location ='index.php';
            }
            if (json.code == 401) {
                alert(json.message);
            }
            if (json.code == 400) {
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
            if (json.code == 409) {
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

    const requestData = 'action=login&username='+username+'&password='+password;

    request.open('post', 'index.php?UserController&method=checkLogin');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}