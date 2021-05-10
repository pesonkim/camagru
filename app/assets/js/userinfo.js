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

window.addEventListener('DOMContentLoaded', function() {
    getInitValues();
});

document.getElementById('Username').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('Email').focus();
});
document.getElementById('Username').addEventListener('focusout', function () {
    if (this.value !== '')
        validateField(this.id, this.value);
    else {
        document.getElementById(this.id+'Error').innerHTML = '';
        document.getElementById('Username').classList.remove('input-error');
        document.getElementById('Username').classList.remove('input-ok');
    }
});
document.getElementById('Email').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('Email').blur();
});
document.getElementById('Email').addEventListener('focusout', function () {
    if (this.value !== '')
        validateField(this.id, this.value);
    else {
        document.getElementById(this.id+'Error').innerHTML = '';
        document.getElementById('Email').classList.remove('input-error');
        document.getElementById('Email').classList.remove('input-ok');

    }
});

document.getElementById('btn-update').addEventListener('click', validateForm);

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
    const username = document.getElementById('Username').value;
    const email = document.getElementById('Email').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            console.log(json);
            if (json.code == 200) {
                flash('Success!','Your user info was updated.', 'index.php?page=profile&tab=info');
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
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
                document.getElementById('sectionWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('sectionWrapper').classList.remove('apply-shake');}, 500);
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
                document.getElementById('sectionWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('sectionWrapper').classList.remove('apply-shake');}, 500);
            }
        }
    }

    const requestData = 'action=update&username='+username+'&email='+email;

    request.open('post', 'index.php?UserController&method=updateUserInfo');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}