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

document.getElementById('Password').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('btn-resetPassword').focus();
});
document.getElementById('Password').addEventListener('focusout', function () {
    validateField(this.id, this.value);
});

function drawError() {
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
    document.getElementById('Password').classList.remove('input-error');
    document.getElementById('Password').classList.add('input-ok');
    document.getElementById('PasswordError').innerHTML = '';
}

function validateField(id, value) {
    const request = new XMLHttpRequest();
    if (id === 'Password') {
        var requestData = 'password='+value;
        request.open('post', 'index.php?UserController&method=validatePasswordFormat');
    }
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            if (json.password) {
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
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

document.getElementById('btn-resetPassword').addEventListener('click', validateForm);

function validateForm() {
    event.preventDefault();
    const password = document.getElementById('Password').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            console.log(json);
            if (json.code == 200) {
                drawConfirm();
                flash('Success!','Your account password was reset.', 'index.php?page=login');
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
            }
            if (json.code == 400) {
                if (json.errors.password)
                    document.getElementById('PasswordError').innerHTML = json.errors.password;
                else
                    document.getElementById('Password').innerHTML = '';
                drawError();
                document.getElementById('resetPasswordWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('resetPasswordWrapper').classList.remove('apply-shake');}, 500);
            }
        }
    }

    const requestData = 'action=resetPassword&password='+password;

    request.open('post', 'index.php?UserController&method=resetPassword');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}
