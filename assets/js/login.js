//Validar nombre de usuario, email y passwords
/*jshint -W033 */
var sesion = localStorage.getItem('sesionUserName');

const comprobarSesion = () => {
    if (sesion == null) {
        window.location.href = "login.php";
    }
    document.querySelector('#user').innerHTML = sesion;
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



