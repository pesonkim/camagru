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

var btn = document.getElementById('open-modal');

var close = document.getElementById('close-modal');

btn.addEventListener('click', function() {
    if (modal.classList.contains('fadeOut')) {
        modal.classList.remove('fadeOut');
    }
    modal.style.display = 'block';
});

close.addEventListener('click', function() {
    modal.classList.add('fadeOut');
    setTimeout(function() {
        modal.style.display = 'none';
        modal.classList.remove('fadeOut');
    }, 200)
});

window.addEventListener('click', function(event) {
    if (event.target == modal) {
        modal.classList.add('fadeOut');
        setTimeout(function() {
            modal.style.display = 'none';
            modal.classList.remove('fadeOut');
        }, 200)
    }
});

