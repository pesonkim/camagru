var uploadWrapper = document.getElementById('uploadWrapper');
var uploadBtn = document.getElementById('manualUpload');
var input = document.getElementById('fileUpload');
var fileName = document.createElement('span');

function getFileNameWithExt(event) {

    if (!event || !event.target || !event.target.files || event.target.files.length === 0) {
      return;
    }
  
    const name = event.target.files[0].name;
    const lastDot = name.lastIndexOf('.');
  
    const fileName = name.substring(0, lastDot);
    const ext = name.substring(lastDot + 1);
  
    console.log(fileName+'.'+ext);    
}

window.addEventListener('DOMContentLoaded', function() {
    uploadWrapper.querySelector('.uploadMedia').appendChild(fileName);
});


uploadBtn.addEventListener('click', function() {
    input.click();
});

input.onchange = function() {
    getFileNameWithExt(event);
}