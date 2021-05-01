var modal = document.getElementById('modal-container');

var btn = document.getElementById('open-modal');

var close = document.getElementById('close-modal');

btn.addEventListener('click', function() {
    modal.style.display = 'block';
});

close.addEventListener('click', function() {
    modal.style.display = 'none';
});

window.addEventListener('click', function() {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});
