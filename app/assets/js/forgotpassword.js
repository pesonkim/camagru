function noEnter() {
    return !(window.event && window.event.keyCode == 13);
}

document.getElementById('Email').addEventListener('keyup', function (event) {
    if (window.event.keyCode == 13)
        document.getElementById('btn-resetemail').focus();
});
document.getElementById('Email').addEventListener('focusout', function () {
    validateField(this.id, this.value);
});

function drawError() {
    if (document.getElementById('EmailError').innerHTML == '') {
        document.getElementById('Email').classList.remove('input-error');
        document.getElementById('Email').classList.add('input-ok');
    }
    else {
        document.getElementById('Email').classList.remove('input-ok');
        document.getElementById('Email').classList.add('input-error');
    }
}

function drawConfirm() {
    document.getElementById('Email').classList.remove('input-error');
    document.getElementById('Email').classList.add('input-ok');
    document.getElementById('EmailError').innerHTML = '';
}

function validateField(id, value) {
    if (value == "") {
        document.getElementById(id).classList.remove('input-ok');
        document.getElementById(id).classList.add('input-error');
        document.getElementById(id+'Error').innerHTML = 'Please enter an email address.';
    }
    else {
        document.getElementById(id).classList.remove('input-error');
        document.getElementById(id).classList.add('input-ok');
        document.getElementById(id+'Error').innerHTML = '';
    }
}

document.getElementById('btn-resetemail').addEventListener('click', validateForm);

function validateForm() {
    event.preventDefault();
    const email = document.getElementById('Email').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            console.log(json);
            if (json.code == 200) {
                drawConfirm();
                flash('Success!','Please check your email for a link to reset your password.', 'index.php?page=login');
            }
            if (json.code == 401) {
                flash('Unauthorized','The request was unauthorized');
            }
            if (json.code == 400) {
                if (json.errors.email)
                    document.getElementById('EmailError').innerHTML = json.errors.email;
                else
                    document.getElementById('Email').innerHTML = '';
                drawError();
                document.getElementById('forgotpasswordWrapper').classList.add('apply-shake');
                setTimeout(function() {document.getElementById('forgotpasswordWrapper').classList.remove('apply-shake');}, 500);
            }
        }
    }

    const requestData = 'action=sendResetEmail&email='+email;

    request.open('post', 'index.php?UserController&method=forgotPassword');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}
