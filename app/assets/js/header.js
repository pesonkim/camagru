window.addEventListener('scroll', handleScroll);

var show = true;
var scrollPos = 0;
const header = document.getElementById('header');

function setShow(state) {
    show = state;
}

function setScrollPos(pos) {
    scrollPos = pos;
}

function handleScroll() {
    if (document.body.getBoundingClientRect().top === 0) {
       setShow(true);
       setScrollPos(0);
    }
    else {
        setShow(document.body.getBoundingClientRect().top > scrollPos);
        setScrollPos(document.body.getBoundingClientRect().top);
    }
    if (show) {
        header.classList.remove('header-hidden');
        header.classList.add('header-visible');
    }
    else {
        header.classList.remove('header-visible');
        header.classList.add('header-hidden');
    }
}

var modal = document.getElementById('modal-container');
var flashtitle = document.getElementById('flash-title');
var flashtext = document.getElementById('flash-text');
var redirect = '';

var close = document.getElementById('close-modal');

function flash(title, text, header) {
    if (modal.classList.contains('fadeOut')) {
        modal.classList.remove('fadeOut');
    }
    if (header) {
        redirect = header;
    }
    flashtitle.innerHTML = title;
    flashtext.innerHTML = text;
    modal.style.display = 'block';
}

close.addEventListener('click', function() {
    modal.classList.add('fadeOut');
    setTimeout(function() {
        modal.style.display = 'none';
        modal.classList.remove('fadeOut');
    }, 200);
    if (redirect) {
        var view = redirect;
        redirect = '';
        window.location = view;
    }
});

window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.classList.add('fadeOut');
        setTimeout(function() {
            modal.style.display = 'none';
            modal.classList.remove('fadeOut');
        }, 200)
    }
    if (redirect) {
        var view = redirect;
        redirect = '';
        window.location = view;
    }
});

window.addEventListener('keyup', function(event) {
    if (window.event.keyCode == 27 && modal.style.display == 'block') {
        modal.classList.add('fadeOut');
        setTimeout(function() {
            modal.style.display = 'none';
            modal.classList.remove('fadeOut');
        }, 200)
    }
    if (redirect) {
        var view = redirect;
        redirect = '';
        window.location = view;
    }
});

window.addEventListener('DOMContentLoaded', (event) => {
    if (document.getElementById('profileLg')) {
        if (window.matchMedia('(max-width: 767px)').matches) {
            document.getElementById('profileLg').style.display = 'none';
            document.getElementById('profileSm').style.display = 'block';
        }
        else {
            document.getElementById('profileSm').style.display = 'none';
            document.getElementById('profileLg').style.display = 'block';
        }
    }

    var url = new URL(window.location.href);
    if (url.searchParams.get('logout') === 'success') {
        flash('Logged out','See you again!', 'index.php');
    }
    if (url.searchParams.get('login') === 'true') {
        flash('Oops','You are already logged in.', 'index.php');
    }
    if (url.searchParams.get('verify') === 'success') {
        flash('Success!','Thank you for verifying your account. You are now ready to log in and enjoy Camagru!', 'index.php');
    }
    if (url.searchParams.get('delete') === 'success') {
        var modalContainer = document.createElement('div');
        var modalContent = document.createElement('img');
        modalContainer.setAttribute('class', 'boom-container');
        modalContainer.setAttribute('name', 'modal');
        modalContent.setAttribute('class', 'boom-content');
        modalContent.setAttribute('src', 'app/assets/img/resources/delete.gif');
        modalContainer.appendChild(modalContent);
        modal.insertBefore(modalContainer, modal.firstChild);
        flash('Account deleted','All data related to your account has been deleted', 'index.php');
    }
    if (url.searchParams.get('login') === 'false') {
        flash('Login required','Please login to see this resource.', 'index.php');
    }
    if (url.searchParams.get('auth') === 'false') {
        flash('Unauthorized','You are not authorized to see this resource.', 'index.php');
    }
    if (url.searchParams.get('token') === 'false') {
        flash('Error','The link you followed was either invalid or expired. Please request a new one.', 'index.php');
    }
});

window.matchMedia('(max-width: 767px)').addEventListener('change', function(event) {
    if (document.getElementById('profileLg')) {
        if (event.matches) {
            document.getElementById('profileLg').style.display = 'none';
            document.getElementById('profileSm').style.display = 'block';
        } else {
            document.getElementById('profileSm').style.display = 'none';
            document.getElementById('profileLg').style.display = 'block';
        }
    }
});
