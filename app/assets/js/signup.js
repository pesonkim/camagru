document.getElementById('btn-signup').addEventListener('click', validateForm);

function validateForm() {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            if (json.code == 200) {
                alert(json.message);
                window.location ='index.php?page=login';
            }
            if (json.code == 401) {
                alert(json.message);
            }
            if (json.code == 400) {
                if (json.errors.username)
                    document.getElementById('usernameError').innerHTML = json.errors.username;
                else
                    document.getElementById('usernameError').innerHTML = '';
                if (json.errors.email)
                    document.getElementById('emailError').innerHTML = json.errors.email;
                else
                    document.getElementById('emailError').innerHTML = '';
                if (json.errors.password)
                    document.getElementById('passwordError').innerHTML = json.errors.password;
                else
                    document.getElementById('passwordError').innerHTML = '';
            }
            if (json.code == 409) {
                if (json.errors.username)
                    document.getElementById('usernameError').innerHTML = json.errors.username;
                else
                    document.getElementById('usernameError').innerHTML = '';
                if (json.errors.email)
                    document.getElementById('emailError').innerHTML = json.errors.email;
                else
                    document.getElementById('emailError').innerHTML = '';
                if (json.errors.password)
                    document.getElementById('passwordError').innerHTML = json.errors.password;
                else
                    document.getElementById('passwordError').innerHTML = '';
            }
        }
    }

    const requestData = 'action=signup&username='+username+'&email='+email+'&password='+password;

    request.open('post', 'index.php?UserController&method=signup');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
}

/*
function validateForm() {
    
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    var error = false;

    if (username == "") {
        document.getElementById('usernameError').innerHTML = 'Username is required.';
        error = true;
    }
    else
        document.getElementById('usernameError').innerHTML = '';
    if (email == "") {
        document.getElementById('emailError').innerHTML = 'Email is required.';
        error = true;
    }
    else
        document.getElementById('emailError').innerHTML = '';
    if (password == "") {
        document.getElementById('passwordError').innerHTML = 'Password is required.';
        error = true;
    }
    else
        document.getElementById('passwordError').innerHTML = '';
    if (error)
        event.preventDefault();
    else
        checkSignup();
}
*/
