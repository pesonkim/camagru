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

//remove with button
var btn = document.getElementById('open-modal');

var close = document.getElementById('close-modal');

//remove with button
btn.addEventListener('click', function() {
    if (modal.classList.contains('fadeOut')) {
        modal.classList.remove('fadeOut');
    }
    flashtitle.innerHTML = 'This is a popup';
    flashtext.innerHTML = 'Totally left here on purpose';
    modal.style.display = 'block';
});

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

