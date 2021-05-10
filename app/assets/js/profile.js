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
