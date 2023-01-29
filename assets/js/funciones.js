/*jshint -W033 */
var loadFile = function (event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
    }
}

var loadFile2 = function (event) {
    var output = document.getElementById('output2');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function () {
        URL.revokeObjectURL(output.src) // free memory
    }
}

var pictureProfileUser = (id) => {
    var modal = document.getElementById("myModal");
    var img = document.getElementById(id);
    var modalImg = document.getElementById("img01");
    img.onclick = function (event) {
        event.stopPropagation();
        modal.style.display = "block";
        modalImg.src = this.src;
    }
    var span = document.getElementsByClassName("close")[0];
    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}

function pictureProfileAvatar() {
    var modal = document.getElementById("myModal");
    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("avatar");
    var modalImg = document.getElementById("img01");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
    }

    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}