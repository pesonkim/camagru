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
    if (this.value !== '')
        validateField(this.id, this.value);
    else {
        document.getElementById(this.id+'Error').innerHTML = '';
        document.getElementById('Username').classList.remove('input-error');
        document.getElementById('Username').classList.remove('input-ok');
    }
});
document.getElementById('Password').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
    document.getElementById('Password').blur();
});
document.getElementById('Password').addEventListener('focusout', function () {
    if (this.value !== '')
        validateField(this.id, this.value);
    else {
        document.getElementById(this.id+'Error').innerHTML = '';
        document.getElementById('Password').classList.remove('input-error');
        document.getElementById('Password').classList.remove('input-ok');
    }
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
    }
    else {
        document.getElementById(id).classList.remove('input-error');
        document.getElementById(id).classList.add('input-ok');
        document.getElementById(id+'Error').innerHTML = '';
    }
}

document.getElementById('btn-delete').addEventListener('click', validateForm);

function validateForm() {
    event.preventDefault();
    const username = document.getElementById('Username').value;
    const password = document.getElementById('Password').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            //console.log(json);
            if (json.code == 200) {
                deleteConf.style.display = 'block';
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
                    document.getElementById('sectionWrapper').classList.add('apply-shake');
                    setTimeout(function() {document.getElementById('sectionWrapper').classList.remove('apply-shake');}, 500);
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
                    document.getElementById('sectionWrapper').classList.add('apply-shake');
                    setTimeout(function() {document.getElementById('sectionWrapper').classList.remove('apply-shake');}, 500);
                }
            }
        }
    }

    const requestData = 'action=delete&username='+username+'&password='+password;

    request.open('post', 'index.php?UserController&method=deleteUser');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

function deleteUserPosts() {
    const request = new XMLHttpRequest();

    const requestData = 'action=deleteUserPosts'

    request.open('post', 'index.php?PostController&method=deleteUserPosts');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

function deleteUserData() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            window.location = 'index.php?delete=success';
        }
    }

    const requestData = 'action=deleteUserData'

    request.open('post', 'index.php?UserController&method=deleteUserData');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

var deleteConf = document.getElementById('delete-container');
var closeConf = document.getElementById('close-delete');
var confirmDelete = document.getElementById('confirm-delete');

confirmDelete.addEventListener('click', function() {
    deleteConf.classList.add('fadeOut');
    setTimeout(function() {
        deleteConf.style.display = 'none';
        deleteConf.classList.remove('fadeOut');
    }, 200);
    deleteUserPosts();
    deleteUserData();
});

closeConf.addEventListener('click', function() {
    deleteConf.classList.add('fadeOut');
    setTimeout(function() {
        deleteConf.style.display = 'none';
        deleteConf.classList.remove('fadeOut');
    }, 200);
    if (redirect) {
        var view = redirect;
        redirect = '';
        window.location = view;
    }
});

window.addEventListener('click', function(event) {
    if (event.target == deleteConf) {
        deleteConf.classList.add('fadeOut');
        setTimeout(function() {
            deleteConf.style.display = 'none';
            deleteConf.classList.remove('fadeOut');
        }, 200)
    }
});
