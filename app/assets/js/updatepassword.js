function noEnter() {
    return !(window.event && window.event.keyCode == 13);
}

function toggleOld(e) {
    x = document.getElementById('OldPassword').type;
    if (x == 'password') {
        e.innerHTML = 'Hide';
        document.getElementById('OldPassword').type='text';
    }
    else {
        e.innerHTML = 'Show'
        document.getElementById('OldPassword').type='password';
    }
}

function toggleNew(e) {
    x = document.getElementById('NewPassword').type;
    if (x == 'password') {
        e.innerHTML = 'Hide';
        document.getElementById('NewPassword').type='text';
    }
    else {
        e.innerHTML = 'Show'
        document.getElementById('NewPassword').type='password';
    }
}

const form = document.getElementById('profileForm');
var initValues = new Array();
var button = document.getElementById('btn-update');

function getInitValues() {
    var formData = form.querySelectorAll('input');
    for (var i = 0; i < formData.length; i++) {
        initValues.push(formData[i].value);
    }
}

function getFormValues() {
    var values = new Array();
    var formData = form.querySelectorAll('input');
    for (var i = 0; i < formData.length; i++) {
        values.push(formData[i].value);
    }
    return values;
}

function hasFormChanged() {
    var changed = false;
    var values = getFormValues();
    for (var i = 0; i < values.length; i++) {
        if (values[i] !== initValues[i]) {
            changed = true;
            break;
        }
    }
    return changed;
}

form.addEventListener('input', function() {
    if (hasFormChanged()) {
        button.classList.remove('update-button');
        button.classList.add('form-button');
    }
    else {
        button.classList.remove('form-button');
        button.classList.add('update-button');
    }
});

function drawError() {
    if (document.getElementById('OldPasswordError').innerHTML == '') {
        document.getElementById('OldPassword').classList.remove('input-error');
        document.getElementById('OldPassword').classList.add('input-ok');
    }
    else {
        document.getElementById('OldPassword').classList.remove('input-ok');
        document.getElementById('OldPassword').classList.add('input-error');
    }
    if (document.getElementById('NewPasswordError').innerHTML == '') {
        document.getElementById('NewPassword').classList.remove('input-error');
        document.getElementById('NewPassword').classList.add('input-ok');
    }
    else {
        document.getElementById('NewPassword').classList.remove('input-ok');
        document.getElementById('NewPassword').classList.add('input-error');
    }
}

window.addEventListener('DOMContentLoaded', function() {
    getInitValues();
});

document.getElementById('OldPassword').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('NewPassword').focus();
});
document.getElementById('OldPassword').addEventListener('focusout', function () {
    if (this.value !== '')
        validateField(this.id, this.value);
    else {
        document.getElementById(this.id+'Error').innerHTML = '';
        document.getElementById('OldPassword').classList.remove('input-error');
        document.getElementById('OldPassword').classList.remove('input-ok');
    }
});
document.getElementById('NewPassword').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('NewPassword').blur();
});
document.getElementById('NewPassword').addEventListener('focusout', function () {
    if (this.value !== '')
        validateField(this.id, this.value);
    else {
        document.getElementById(this.id+'Error').innerHTML = '';
        document.getElementById('NewPassword').classList.remove('input-error');
        document.getElementById('NewPassword').classList.remove('input-ok');

    }
});

document.getElementById('btn-update').addEventListener('click', validateForm);

function validateField(id, value) {
    const request = new XMLHttpRequest();
    if (id === 'OldPassword') {
        var requestData = 'password='+value;
        request.open('post', 'index.php?UserController&method=validatePasswordFormat');
    }
    if (id === 'NewPassword') {
        var requestData = 'password='+value;
        request.open('post', 'index.php?UserController&method=validatePasswordFormat');
    }
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            if (json.password) {
                document.getElementById(id+'Error').innerHTML = json.password;
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

function validateForm() {
    event.preventDefault();
    const oldPassword = document.getElementById('OldPassword').value;
    const newPassword = document.getElementById('NewPassword').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            //console.log(json);
            if (json.code == 200) {
                flash('Success!','Your account password was updated.', 'index.php?page=profile&tab=sec');
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
            }
            if (json.code == 400) {
                if (json.errors.oldpassword)
                    document.getElementById('OldPasswordError').innerHTML = json.errors.oldpassword;
                else
                document.getElementById('OldPassword').innerHTML = '';
                if (json.errors.newpassword)
                    document.getElementById('NewPasswordError').innerHTML = json.errors.newpassword;
                else
                    document.getElementById('NewPassword').innerHTML = '';
                drawError();
                document.getElementById('sectionWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('sectionWrapper').classList.remove('apply-shake');}, 500);
            }
        }
    }

    const requestData = 'action=updatePassword&oldPassword='+oldPassword+'&newPassword='+newPassword;

    request.open('post', 'index.php?UserController&method=updatePassword');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}