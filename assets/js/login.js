//Validar nombre de usuario, email y passwords
/*jshint -W033 */
var sesion = localStorage.getItem('sesionUserName');

const comprobarSesion = () => {
    if (sesion != null) {
        window.location.href = "inicio.php";
    }
}

const comprobarLogin = () => {
    if (sesion != null) {
        document.querySelector('#user').innerHTML = sesion;
    }
}

const closeSesion = () => {
    localStorage.clear();
    //window location in php/user
    window.location.href = "logOut.php";
}

const login = async () => {
    var username = document.querySelector("#username").value;
    var password = document.querySelector("#password").value;

    if (username.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "UserName No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (password.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Pass No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    const data = new FormData();
    data.append('user', username);
    data.append('password', password);

    var respond = await fetch("php/user/login_user.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virual Reparación de móviles"
        })
        document.querySelector('#formLogin').reset();
        localStorage.setItem('sesionUserName', result.userName);

        setTimeout(() => {
            window.location.href = "inicio.php";
        }, 2000);
    }
    else {
        Swal.fire({
            icon: "error",
            title: "ERROR de usuario",
            text: result.mensaje,
            footer: "Tienda Virual Reparación de móviles"
        })
        document.querySelector("#username").value = "";
        document.querySelector("#password").value = "";
    }
}

const insert_request = async () => {
    var nombre_cliente = document.querySelector("#nombre_cliente").value;
    var email_cliente = document.querySelector("#email_cliente").value;
    var problema_cliente = document.querySelector("#problema_cliente").value;
    var fecha_entrega_cliente = document.querySelector("#fecha_entrega_cliente").value;

    if (nombre_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Nombre cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (email_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "email_cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (problema_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "problema_cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (fecha_entrega_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "fecha_entrega_cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    const data = new FormData();
    data.append('nombre_cliente', nombre_cliente);
    data.append('email_cliente', email_cliente);
    data.append('problema_cliente', problema_cliente);
    data.append('fecha_entrega_cliente', fecha_entrega_cliente);

    var respond = await fetch("php/user/movil_request.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virual Reparación de móviles"
        })
        document.querySelector('#formInsert').reset();
        setTimeout(() => {
            window.location.href = "inicio.php";
        }, 2000);
    }
}

const updateCSV = async () => {
    var id_cliente = document.querySelector("#id_movil").value;
    var nombre_cliente = document.querySelector("#nombre_cliente").value;
    var email_cliente = document.querySelector("#email_cliente").value;
    var problema_cliente = document.querySelector("#problema_cliente").value;
    var fecha_entrega_cliente = document.querySelector("#fecha_entrega_cliente").value;
    var resuelto = document.querySelector("#resuelto").value;

    if (nombre_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Nombre cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (email_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "email_cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (problema_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "problema_cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (fecha_entrega_cliente.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "fecha_entrega_cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (resuelto.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "resuelto No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    // Serialize the form data
    const data = new FormData();
    data.append('id_cliente', id_cliente);
    data.append('nombre_cliente', nombre_cliente);
    data.append('email_cliente', email_cliente);
    data.append('problema_cliente', problema_cliente);
    data.append('fecha_entrega_cliente', fecha_entrega_cliente);
    data.append('resuelto', resuelto);


    var respond = await fetch("php/user/edit_csv.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();
    
    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: 'juja',
            footer: "Tienda Virual Reparación de móviles"
        })
        document.querySelector('#editForm').reset();
        setTimeout(() => {
            window.location.href = "crud.php";
        }, 2000);
    }
}


