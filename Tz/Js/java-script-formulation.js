function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}

function checkpn() {
    //try{


    //}
}
function delete_post(id) {
    document.getElementById(id).value = "";
}

function checkeded(id1, id2, ch) {
    if (document.getElementById(ch).checked) {
        document.getElementById(id1).type = "text";
        document.getElementById(id2).type = "text";
    }
    else {
        document.getElementById(id1).type = "password";
        document.getElementById(id2).type = "password";
    }
}


const imageInput = document.getElementById('imgfile');
const imagePreview = document.getElementById('idimage');

let binaryData = "";
let fileSize = 0
imageInput.addEventListener('change', function (event) {
    const file = event.target.files[0];
    let fileSize = event.target.files[0].size / 1000 / 1000;
    let type = event.target.files[0].type;
    if (file && fileSize < 5) {
        const reader = new FileReader();
        const launchDT = new FormData();
        reader.onload = function (e) {
            imagePreview.src = e.target.result; // بارگذاری منبع تصویر  
            
        }
        reader.readAsDataURL(file); // خواندن تصویر به عنوان URL  
    }
    else{
        alert(
            'اندازه تصویر شما باید از 5 مگابایت کمتر باشد'
        )
    }
});  


function next_page(idp1, idp2) {
    document.getElementById(idp1).style.display = 'none';
    document.getElementById(idp2).style.display = 'block';

}

function href(url){
    window.location.href=url
}

function pc_back(p1,p2,p3){
    if(
        document.getElementById(p1).style.display != 'none'
    ){
        window.location.href="../index.php"
    }

    else if(
        document.getElementById(p2).style.display == 'block'
    ){
        document.getElementById(p1).style.display = 'block'
        document.getElementById(p2).style.display = 'none'
    }

    else if(
        document.getElementById(p3).style.display == 'block'
    ){
        document.getElementById(p2).style.display = 'block'
        document.getElementById(p3).style.display = 'none'
    }
}