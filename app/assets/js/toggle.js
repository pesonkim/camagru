const toggleContainer = document.getElementById('toggleContainer');
const toggleNotif = document.getElementById('toggleNotif');
var notifPref = undefined;

window.addEventListener('DOMContentLoaded', function() {
    getNotifPref();
});

function getNotifPref() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            //console.log(json);
            if (json.pref === '1') {
                notifPref = true;
            }
            else if (json.pref === '0') {
                notifPref = false;
                toggleNotif.classList.remove('translate-x-6');
                toggleContainer.classList.remove('bg-active');
            }
        }
    }

    const requestData = 'action=getNotifyPref';

    request.open('post', 'index.php?UserController&method=getNotifyPref');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

toggleContainer.addEventListener('click', function() {
    notifPref = !notifPref;
    updateNotifPref()
    toggleNotif.classList.toggle('translate-x-6');
    toggleContainer.classList.toggle('bg-active');
});

function updateNotifPref() {
    const request = new XMLHttpRequest();

    if (notifPref)
        var requestData = 'action=updateNotifyPref&pref=1';
    else
        var requestData = 'action=updateNotifyPref&pref=0';    

    request.open('post', 'index.php?UserController&method=updateNotifyPref');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}