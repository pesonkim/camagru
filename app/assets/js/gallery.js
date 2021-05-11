document.addEventListener("DOMContentLoaded", function(){
    loadPosts();
});

const postsContainer = document.getElementById('postsContainer');
var index = 0;
var limit = 0;

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
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);

    index += limit;
}

function nFormatter(num) {
    if (num >= 1000) {
       return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num;
}

function drawPost(postData) {
    
    var newDiv = document.createElement('div');
    var imgDiv = document.createElement('div');
    var img = document.createElement('img');
    var metaDiv = document.createElement('div');
    var titleDiv = document.createElement('div');
    var name = document.createElement('span');
    var actionDiv = document.createElement('div');
    var likeDiv = document.createElement('div');
    var likes = document.createElement('div');
    var viewDiv = document.createElement('div');
    var views = document.createElement('div');
    var buttonDiv = document.createElement('div');
    var buttonLike = document.createElement('div');
    var buttonComment = document.createElement('div');
    var commentDiv = document.createElement('div');
    var comments = document.createElement('div');
    var modalContainer = document.createElement('div');
    var modalContent = document.createElement('img');

    newDiv.setAttribute('class', 'flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post');
    imgDiv.setAttribute('class', 'post-media');
    img.setAttribute('class', 'post-img');
    img.setAttribute('src', postData.img);
    imgDiv.appendChild(img);
    
    metaDiv.setAttribute('class', 'post-meta bg-white');
    titleDiv.setAttribute('class', 'post-title');
    name.appendChild(document.createTextNode(postData.name));
    titleDiv.appendChild(name);
    actionDiv.setAttribute('class', 'post-actions');
    likeDiv.setAttribute('class', 'flex');
    commentDiv.setAttribute('class', 'flex');
    viewDiv.setAttribute('class', 'flex');

    likes.setAttribute('class', 'post-likes');
    likeDiv.appendChild(likes);
    likes = document.createElement('span');
    likes.appendChild(document.createTextNode(nFormatter(Math.floor(Math.random() * 1000))));
    likeDiv.appendChild(likes);
    
    comments.setAttribute('class', 'post-comments');
    commentDiv.appendChild(comments);
    comments = document.createElement('span');
    comments.appendChild(document.createTextNode(nFormatter(Math.floor(Math.random() * 1000))));
    commentDiv.appendChild(comments);
    
    views.setAttribute('class', 'post-views');
    viewDiv.appendChild(views);
    views = document.createElement('span');
    views.appendChild(document.createTextNode(nFormatter(Math.floor(Math.random() * 10000))));
    viewDiv.appendChild(views);

    buttonDiv.setAttribute('class', 'like-comment flex');
    buttonLike.setAttribute('class', 'like-post shadow-md');
    buttonLike.setAttribute('type', 'checkbox');
    buttonComment.setAttribute('class', 'comment-post shadow-md');
    likes = document.createElement('span');
    likes.appendChild(document.createTextNode('like'));
    comments = document.createElement('span');
    comments.appendChild(document.createTextNode('comment'));
    buttonLike.appendChild(likes);
    buttonComment.appendChild(comments);
    buttonDiv.appendChild(buttonLike);
    buttonDiv.appendChild(buttonComment);

    actionDiv.appendChild(likeDiv);
    actionDiv.appendChild(commentDiv);
    actionDiv.appendChild(viewDiv);
    metaDiv.appendChild(titleDiv);
    metaDiv.appendChild(actionDiv);
    metaDiv.appendChild(buttonDiv);

    modalContainer.setAttribute('class', 'post-modal-container');
    modalContainer.setAttribute('name', 'modal');
    modalContent.setAttribute('class', 'post-modal-content');
    modalContent.setAttribute('src', postData.img);
    modalContainer.appendChild(modalContent);

    newDiv.appendChild(imgDiv);
    newDiv.appendChild(metaDiv);
    newDiv.appendChild(modalContainer);

    newDiv.addEventListener('click', function(event) {
        //close lightbox
        if (event.target.classList.contains('post-modal-content')) {
            event.target.parentNode.style.display = 'none';
            document.getElementsByTagName("html")[0].style.overflow = 'scroll';
        }
        //like button toggle
        else if (event.target.classList.contains('like-post')) {
            var icon = event.currentTarget.querySelector('.post-actions').querySelectorAll('.flex')[0];

            if (icon.querySelector('div').classList.contains('post-likes')) {
                event.target.classList.toggle('selected');
                icon.querySelectorAll('span')[0].textContent = parseInt(icon.querySelectorAll('span')[0].textContent) + 1;
                icon.querySelector('div').classList.toggle('post-heart');
                icon.querySelector('div').classList.toggle('post-likes');
            }
            else if (icon.querySelector('div').classList.contains('post-heart')) {
                event.target.classList.toggle('selected');
                icon.querySelectorAll('span')[0].textContent = parseInt(icon.querySelectorAll('span')[0].textContent) - 1;
                icon.querySelector('div').classList.toggle('post-heart');
                icon.querySelector('div').classList.toggle('post-likes');
            }
        }
        //lightbox zoom in
        else if (event.currentTarget.classList.contains('post-expanded') || window.matchMedia('(max-width: 767px)').matches) {
            if (event.target.classList.contains('post-img')) {
                event.currentTarget.querySelector('.post-modal-container').style.display = 'grid';
                document.getElementsByTagName("html")[0].style.overflow = 'hidden'
            }
            //close lightbox
            else if (event.target.classList.contains('post-modal-container')) {
                event.target.style.display = 'none';
                document.getElementsByTagName("html")[0].style.overflow = 'scroll';
            }
            //close post expand
            else {
                if ((!window.matchMedia('(max-width: 767px)').matches)) {
                    event.currentTarget.classList.toggle('post-expanded');
                }
                event.currentTarget.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

        }
        else {
            event.currentTarget.classList.toggle('post-expanded');
            event.currentTarget.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });
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

window.matchMedia('(min-width: 1024px)').addEventListener('change', function(event) {
    if (event.matches) {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
    } else {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
    }
});

window.matchMedia('(max-width: 767px)').addEventListener('change', function(event) {
    if (event.matches) {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
    } else {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
    }
});
