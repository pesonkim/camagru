document.addEventListener("DOMContentLoaded", function(){
    loadPosts();
});

const postsContainer = document.getElementById('postsContainer');
var index = 0;
var limit = 10;

function loadPosts() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);

            for (var i = 0; i < json.length; i++) {
                drawPost(json[i]);
            }

        }
    }

    const requestData = 'index='+index+'&limit='+limit;

    request.open('post', 'index.php?PostController&method=getPosts');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);

    index += limit;
}

function drawPost(postData) {
    
    var newDiv = document.createElement('div');
    var img = document.createElement('img');
    var name = document.createElement('span');
    var date = document.createElement('span');
    var modalContainer = document.createElement('div');
    var modalContent = document.createElement('img');

    newDiv.setAttribute('class', 'flex flex-col justify-center p-4 shadow bg-white rounded slideUp post');
    img.setAttribute('class', 'post-preview');
    img.setAttribute('src', postData.img);
    name.setAttribute('class', 'my-4');
    name.appendChild(document.createTextNode(postData.name));
    date.setAttribute('class', 'text-sm text-gray-500');
    date.appendChild(document.createTextNode(postData.date));

    modalContainer.setAttribute('class', 'post-modal-container');
    modalContainer.setAttribute('name', 'modal');
    modalContent.setAttribute('class', 'post-modal-content');
    modalContent.setAttribute('src', postData.img);
    modalContainer.appendChild(modalContent);

    newDiv.appendChild(img);
    newDiv.appendChild(name);
    newDiv.appendChild(date);
    newDiv.appendChild(modalContainer);

    postsContainer.appendChild(newDiv);
}

window.onload = function() {
    var timer = setInterval(function() {
        if (document.body.scrollHeight <= window.innerHeight)
            loadPosts();
        else
            clearInterval(timer);
    }, 1000);
};

window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        loadPosts();
    }
};


postsContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('post') || event.target.parentNode.classList.contains('post')) {
        if (event.target.classList.contains('post-preview') && event.target.parentNode.classList.contains('post-expanded')) {
            event.target.parentNode.querySelector('.post-modal-container').style.display = 'grid';
            document.getElementsByTagName("html")[0].style.overflow = 'hidden'
        }

        else if (event.target.classList.contains('post-modal-container')) {
            event.target.style.display = 'none';
            document.getElementsByTagName("html")[0].style.overflow = 'scroll';
        }
        else if (event.target.classList.contains('post')) {
            event.target.classList.toggle('post-expanded');
            event.target.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
        else {
            event.target.parentNode.classList.toggle('post-expanded');
            event.target.parentNode.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    }
    else if (event.target.classList.contains('post-modal-content')) {
        event.target.parentNode.style.display = 'none';
        document.getElementsByTagName("html")[0].style.overflow = 'scroll';
    }
});

window.matchMedia('(min-width: 1024px)').addEventListener('change', function(event) {
    if (event.matches) {
        console.log('lg');
    } else {
        console.log('md');
    }
});
window.matchMedia('(max-width: 767px)').addEventListener('change', function(event) {
    if (event.matches) {
        console.log('sm');
    } else {
        console.log('md');
    }
});


