document.addEventListener("DOMContentLoaded", function(){
    loadPosts();
});

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

    index += 10;
}

function drawPost(postData) {
    const postsContainer = document.getElementById('postsContainer');
    var newDiv = document.createElement('div');
    var img = document.createElement('img');
    var name = document.createElement('span');
    var date = document.createElement('span');

    newDiv.setAttribute('class', 'flex flex-col p-4 shadow bg-white rounded slideUp');
    img.setAttribute('class', 'w-full');
    img.setAttribute('src', postData.img);
    name.setAttribute('class', 'my-4');
    name.appendChild(document.createTextNode(postData.name));
    date.setAttribute('class', 'text-sm text-gray-500');
    date.appendChild(document.createTextNode(postData.date));

    newDiv.appendChild(img);
    newDiv.appendChild(name);
    newDiv.appendChild(date);

    postsContainer.appendChild(newDiv);
}

window.onload = function() {
    setTimeout(function() {
        if (document.body.scrollHeight <= window.innerHeight) {
            loadPosts();
        }
    }, 1000);
};

window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        loadPosts();
    }
};
