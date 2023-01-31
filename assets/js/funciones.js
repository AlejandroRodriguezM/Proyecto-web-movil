/*jshint -W033 */

// Función que carga un archivo a la página
var loadFile = function (event) {
    // Obtiene el elemento donde se mostrará la imagen cargada
    var output = document.getElementById('output');
    // Establece la imagen como la fuente del elemento obtenido
    output.src = URL.createObjectURL(event.target.files[0]);
    // Libera la memoria una vez que la imagen esté cargada
    output.onload = function () {
        URL.revokeObjectURL(output.src)
    }
}

// Función que carga un segundo archivo a la página
var loadFile2 = function (event) {
    // Obtiene el elemento donde se mostrará la imagen cargada
    var output = document.getElementById('output2');
    // Establece la imagen como la fuente del elemento obtenido
    output.src = URL.createObjectURL(event.target.files[0]);
    // Libera la memoria una vez que la imagen esté cargada
    output.onload = function () {
        URL.revokeObjectURL(output.src)
    }
}

// Función que muestra una imagen en un modal al hacer clic sobre ella
var pictureProfileUser = (id) => {
    // Obtiene el elemento modal
    var modal = document.getElementById("myModal");
    // Obtiene la imagen que se clickeó
    var img = document.getElementById(id);
    // Obtiene la imagen dentro del modal
    var modalImg = document.getElementById("img01");
    // Al hacer clic en la imagen, se muestra el modal
    img.onclick = function (event) {
        // Detiene la propagación de eventos para evitar errores
        event.stopPropagation();
        // Muestra el modal
        modal.style.display = "block";
        // Establece la imagen clickeada como la fuente del modal
        modalImg.src = this.src;
    }
    // Obtiene el elemento span que cierra el modal
    var span = document.getElementsByClassName("close")[0];
    // Al hacer clic en el modal, se oculta
    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}

// Función que muestra una imagen de perfil en un modal al hacer clic sobre ella
function pictureProfileAvatar() {
    // Obtiene el elemento modal
    var modal = document.getElementById("myModal");
    // Obtiene la imagen de perfil
    var img = document.getElementById("avatar");
    // Obtiene la imagen dentro del modal
    var modalImg = document.getElementById("img01");
    // Asigna un evento click a la imagen para mostrar el modal y establecer la imagen en la fuente.
    img.onclick = function (event) {
        event.stopPropagation(); // detiene la propagación del evento
        modal.style.display = "block";
        modalImg.src = this.src;
    }

    // Obtiene el elemento span cerrar y asigna un evento click para cerrar el modal.
    var span = document.getElementsByClassName("close")[0];
    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}

// Esta función muestra la imagen en un modal al hacer clic en la imagen de perfil de avatar.
function pictureProfileAvatar() {
    // Obtiene el elemento modal y la imagen a partir de su id.
    var modal = document.getElementById("myModal");
    var img = document.getElementById("avatar");
    var modalImg = document.getElementById("img01");
    // Asigna un evento click a la imagen para mostrar el modal y establecer la imagen en la fuente.
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
    }

    // Asigna un evento click para cerrar el modal al hacer clic en cualquier parte del modal.
    modal.addEventListener('click', function () {
        this.style.display = "none";
    })
}