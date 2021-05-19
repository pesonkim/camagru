const postsContainer = document.getElementById('postsContainer');
const page = 5;
var posts, index, limit = undefined;
var loggedIn = undefined;

document.addEventListener("DOMContentLoaded", function(){
    isLoggedIn();
    getPostIds();
});

function isLoggedIn() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            const json = JSON.parse(request.responseText);
            if (json.user === '1') {
                loggedIn = true;
            }
            else if (json.user === '0') {
                loggedIn = false;
            }
        }
    }

    const requestData = 'action=isLoggedIn';

    request.open('post', 'index.php?UserController&method=isLoggedIn');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

function getPostIds() {
    const request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            console.log(request.responseText);
            posts = JSON.parse(request.responseText);
            index = 0;
            limit = posts.length;
            loadPosts();
        }
    }

    request.open('post', 'index.php?PostController&method=getPosts');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send();
}

function loadPosts() {
    if (index < limit) {
        for (var i = 0; i < page; i++) {
            if (index >= limit) {
                break ;
            }
            const request = new XMLHttpRequest();

            request.onreadystatechange = function() {
                if (request.readyState == 4) {
                    const json = JSON.parse(request.responseText);
                    console.log(json);
                    drawPost(json);
                }
            }
        
            const requestData = 'id='+posts[index]['id_post'];
        
            request.open('post', 'index.php?PostController&method=getPostById');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            request.send(requestData);
        
            index++;
        }
    }
}

function nFormatter(num) {
    if (num >= 1000) {
       return (num / 1000).toFixed(1).replace(/\.0$/, '') + 'K';
    }
    return num;
}

function getCount(text) {
    var max = 280;

    return max - [...text.value].length;
}

function updateCount(count) {
    count.textContent = getCount(count.parentElement.parentElement.parentElement.querySelector('textarea'));
}

function comment(count) {
    var len = getCount(count.parentElement.parentElement.parentElement.querySelector('textarea'));

    if (len == 280) {
        flash('Oops', 'Comment body cannot be empty.');
    }
    else if (len < 0) {
        flash('Oops', 'Comment character limit exceeded.');
    }
    else {
        //find commentList and create new entry
        var list = count.parentElement.parentElement.parentElement.parentElement.querySelector('.commentList');
        var entry = document.createElement('div');
        var authorDate = document.createElement('div');
        var author = document.createElement('span');
        var date = document.createElement('span');
        var comment = count.parentElement.parentElement.parentElement.querySelector('textarea').value;

        entry.setAttribute('class', 'commentEntry slideDown');
        authorDate.setAttribute('class', 'authorDate');
        author.appendChild(document.createTextNode('Author'));
        date.appendChild(document.createTextNode('Date'));
        authorDate.appendChild(author);
        authorDate.appendChild(date);

        entry.appendChild(authorDate);
        entry.appendChild(document.createTextNode(comment));

        console.log(comment);
        list.insertBefore(entry, list.firstChild);
        count.parentElement.parentElement.parentElement.querySelector('textarea').value = '';
        updateCount(count);
        list.firstChild.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
        //flash('Comment:', count.parentElement.parentElement.parentElement.querySelector('textarea').value);

        //<div class="commentEntry">
        //    <div class="authorDate">
        //        <span>Author</span>
        //        <span> - </span>
        //        <span>Time of posting</span>
        //    </div>
        //    <span>This is the comment body.</span>
        //</div>
    }
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

    var commentContainer = document.createElement('div');
    var commentCreate = document.createElement('div');
    var commentList = document.createElement('div');

    newDiv.setAttribute('class', 'flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideUp post');
    newDiv.setAttribute('id', postData.id_post);
    imgDiv.setAttribute('class', 'post-media');
    img.setAttribute('class', 'post-img');
    img.setAttribute('src', postData.post_src);
    imgDiv.appendChild(img);
    
    metaDiv.setAttribute('class', 'post-meta bg-white');
    titleDiv.setAttribute('class', 'post-title');
    name.appendChild(document.createTextNode(postData.author+' - '+postData.post_title));
    titleDiv.appendChild(name);
    actionDiv.setAttribute('class', 'post-actions');
    likeDiv.setAttribute('class', 'flex');
    commentDiv.setAttribute('class', 'flex');
    viewDiv.setAttribute('class', 'flex');

    if (postData.like) {
        likes.setAttribute('class', 'post-heart');
    }
    else {
        likes.setAttribute('class', 'post-likes');
    }
    likeDiv.appendChild(likes);
    likes = document.createElement('span');
    //likes.appendChild(document.createTextNode(nFormatter(Math.floor(Math.random() * 1000))));
    likes.appendChild(document.createTextNode(nFormatter(postData.likes)));
    likeDiv.appendChild(likes);
    
    comments.setAttribute('class', 'post-comments');
    commentDiv.appendChild(comments);
    comments = document.createElement('span');
    //comments.appendChild(document.createTextNode(nFormatter(Math.floor(Math.random() * 1000))));
    comments.appendChild(document.createTextNode(nFormatter(postData.comments)));
    commentDiv.appendChild(comments);
    
    views.setAttribute('class', 'post-views');
    viewDiv.appendChild(views);
    views = document.createElement('span');
    //views.appendChild(document.createTextNode(nFormatter(Math.floor(Math.random() * 10000))));
    views.appendChild(document.createTextNode(nFormatter(postData.views)));
    viewDiv.appendChild(views);

    buttonDiv.setAttribute('class', 'like-comment flex');

    if (postData.like) {
        buttonLike.setAttribute('class', 'like-post shadow-md selected');
    }
    else {
        buttonLike.setAttribute('class', 'like-post shadow-md');
    }
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
    modalContent.setAttribute('src', postData.post_src);
    modalContainer.appendChild(modalContent);

    commentContainer.setAttribute('class', 'flex flex-col justify-center shadow bg-white lg:rounded md:rounded slideDown commentContainer');
    commentContainer.setAttribute('style', 'display:none')
    commentCreate.setAttribute('class', 'commentCreate');
    var input = document.createElement('textarea');
    input.setAttribute('type', 'text');
    input.setAttribute('class', 'form-input rounded');
    input.setAttribute('name', 'commentField');
    input.setAttribute('placeholder', (loggedIn ? 'Leave a comment.' : 'Login to leave a comment.'));
    if (!loggedIn) {
        input.style.pointerEvents = 'none';
        input.style.height = '50px';
        var div = document.createElement('div');
        var url = new URL(window.location.href);

        var a1 = document.createElement('a');
        a1.setAttribute('href', url.pathname+'?page=login');
        var button1 = document.createElement('button');
        button1.setAttribute('class', 'commentLoginButton');
        button1.appendChild(document.createTextNode('Login'));
        a1.appendChild(button1);
        div.appendChild(a1);

        var a2 = document.createElement('a');
        a2.setAttribute('href', url.pathname+'?page=signup');
        var button2 = document.createElement('button');
        button2.setAttribute('class', 'commentSignupButton');
        button2.appendChild(document.createTextNode('Signup'));
        a2.appendChild(button2);
        div.appendChild(a2);

        commentCreate.appendChild(input);
        commentCreate.appendChild(div);
    }
    //character counter
    else {
        var div = document.createElement('div');
        var count = document.createElement('div');
        var span = document.createElement('span');
        span.appendChild(document.createTextNode('Characters remaining: '));

        var counter = document.createElement('span');
        counter.setAttribute('class', 'countChar');

        var button = document.createElement('button');
        count.setAttribute('class', 'charCount');
        button.setAttribute('class', 'commentButton');
        button.appendChild(document.createTextNode('Comment'));
        count.appendChild(span);
        count.appendChild(counter);
        div.appendChild(count);
        div.appendChild(button);

        commentCreate.appendChild(input);
        commentCreate.appendChild(div);
        counter.appendChild(document.createTextNode(getCount(counter.parentElement.parentElement.parentElement.querySelector('textarea'))));
        input.addEventListener('input', function() {
            updateCount(counter);
        }, false);
        button.addEventListener('click', function() {
            comment(counter);
        }, false);
    }
    commentList.setAttribute('class', 'commentList');
    commentContainer.appendChild(commentCreate);
    commentContainer.appendChild(commentList);

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

            if (!loggedIn)
                flash('Login required', 'Please login to like posts.');
            else if (icon.querySelector('div').classList.contains('post-likes')) {
                likePost(event.currentTarget.id);
                event.target.classList.toggle('selected');
                icon.querySelectorAll('span')[0].textContent = parseInt(icon.querySelectorAll('span')[0].textContent) + 1;
                icon.querySelector('div').classList.toggle('post-heart');
                icon.querySelector('div').classList.toggle('post-likes');
            }
            else if (icon.querySelector('div').classList.contains('post-heart')) {
                likePost(event.currentTarget.id);
                event.target.classList.toggle('selected');
                icon.querySelectorAll('span')[0].textContent = parseInt(icon.querySelectorAll('span')[0].textContent) - 1;
                icon.querySelector('div').classList.toggle('post-heart');
                icon.querySelector('div').classList.toggle('post-likes');
            }
        }
        //comment button
        else if (event.target.classList.contains('comment-post')) {

            commentPost(event.currentTarget.id);

            //small screens
            /*
            if (window.matchMedia('(max-width: 767px)').matches) {
                if (event.currentTarget.nextElementSibling.style.display=='none') {
                    event.currentTarget.nextElementSibling.style.display='flex';
                    event.currentTarget.nextElementSibling.getElementsByClassName('commentCreate')[0].getElementsByTagName('textarea')[0].focus();
                }
                else {
                    event.currentTarget.nextElementSibling.style.display='none';
                }
            }
            else if (!event.currentTarget.classList.contains('post-expanded')) {
                event.currentTarget.classList.toggle('post-expanded');
                event.currentTarget.nextElementSibling.style.display='flex';
                event.currentTarget.nextElementSibling.getElementsByClassName('commentCreate')[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
            }
            else {
                if (loggedIn)
                    event.currentTarget.nextElementSibling.getElementsByClassName('commentCreate')[0].getElementsByTagName('textarea')[0].focus();
                else
                    flash('Login required', 'Please login to leave a comment.');
            }
            */
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
                    event.currentTarget.nextElementSibling.style.display='none';
                }
                event.currentTarget.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

        }
        else {
            event.currentTarget.classList.toggle('post-expanded');
            event.currentTarget.nextElementSibling.style.display='flex';
            event.currentTarget.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });
    postsContainer.appendChild(newDiv);
    postsContainer.appendChild(commentContainer);
}

function likePost(id) {
    console.log(id);
    const request = new XMLHttpRequest();

    const requestData = 'action=likePost&id='+id;

    request.open('post', 'index.php?PostController&method=likePost');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    request.send(requestData);
}

function commentPost(id) {
    console.log(id);
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
        var comments = document.getElementById('postsContainer').querySelectorAll('.commentContainer:not([style*="display: none"])');
        for (var i = 0; i < comments.length; i++) {
            comments[i].style.display='none';
        }
    } else {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
        var comments = document.getElementById('postsContainer').querySelectorAll('.commentContainer:not([style*="display: none"])');
        for (var i = 0; i < comments.length; i++) {
            comments[i].style.display='none';
        }
    }
});

window.matchMedia('(max-width: 767px)').addEventListener('change', function(event) {
    if (event.matches) {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
        var comments = document.getElementById('postsContainer').querySelectorAll('.commentContainer:not([style*="display: none"])');
        for (var i = 0; i < comments.length; i++) {
            comments[i].style.display='none';
        }
    } else {
        var divs = document.getElementById('postsContainer').querySelectorAll('.post-expanded');
        for (var i = 0; i < divs.length; i++) {
            divs[i].classList.toggle('post-expanded');
        }
        var comments = document.getElementById('postsContainer').querySelectorAll('.commentContainer:not([style*="display: none"])');
        for (var i = 0; i < comments.length; i++) {
            comments[i].style.display='none';
        }
    }
});
