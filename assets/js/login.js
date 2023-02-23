//Validar nombre de usuario, email y passwords
/*jshint -W033 */
var sesion = localStorage.getItem('sesionUserName');
var image;

const comprobarSesion = () => {
    if (sesion != null) {
        window.location.href = "inicio.php";
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
    var horas_estimadas = document.querySelector("#horas_cliente").value;
    var num_factura = document.querySelector("#num_factura").value;

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
    data.append('horas_estimadas', horas_estimadas);
    data.append('num_factura', num_factura);

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

const editCSV = async () => {
    var id_cliente = document.querySelector("#id").value;
    var nombre_cliente = document.querySelector("#nombre_cliente").value;
    var email_cliente = document.querySelector("#email_cliente").value;
    var problema_cliente = document.querySelector("#problema_cliente").value;
    var fecha_entrega_cliente = document.querySelector("#fecha_entrega").value;
    var fecha_terminado_cliente = document.querySelector("#fecha_terminado").value;
    var horas_estimadas = document.querySelector("#horas_estimadas").value;
    var horas_trabajadas = document.querySelector("#horas_trabajadas").value;
    var resuelto = document.querySelector("#resuelto").value;
    var num_factura = document.querySelector("#num_factura").value;
    var tecnico = document.querySelector('#tecnico_firma').value;

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

    if (fecha_terminado_cliente.trim() === '') {
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
    data.append('fecha_terminado_cliente', fecha_terminado_cliente);
    data.append('horas_estimadas', horas_estimadas);
    data.append('horas_trabajadas', horas_trabajadas);
    data.append('resuelto', resuelto);
    data.append('num_factura', num_factura);
    data.append('tecnico', tecnico);

    var respond = await fetch("php/user/edit_csv.php", {
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
        document.querySelector('#editForm').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const updateCSV = async () => {
    var id_cliente = document.querySelector("#id").value;
    var nombre_cliente = document.querySelector("#nombre_cliente").value;
    var email_cliente = document.querySelector("#email_cliente").value;
    var problema_cliente = document.querySelector("#problema_cliente").value;
    var fecha_entrega_cliente = document.querySelector("#fecha_entrega").value;
    var fecha_terminado_cliente = document.querySelector("#fecha_terminado").value;
    var horas_estimadas = document.querySelector("#horas_estimadas").value;
    var horas_trabajadas = document.querySelector("#horas_trabajadas").value;
    var resuelto = document.querySelector("#resuelto").value;
    var num_factura = document.querySelector("#num_factura").value;
    var tecnico = document.querySelector('#tecnico_firma').value;

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

    if (fecha_terminado_cliente.trim() === '') {
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
    data.append('fecha_terminado_cliente', fecha_terminado_cliente);
    data.append('horas_estimadas', horas_estimadas);
    data.append('horas_trabajadas', horas_trabajadas);
    data.append('resuelto', resuelto);
    data.append('num_factura', num_factura);
    data.append('tecnico', tecnico);

    var respond = await fetch("php/user/update_csv.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virtual Reparación de móviles"
        })
        document.querySelector('#editForm').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}

const delete_slice_CSV = async () => {
    var id_cliente = document.querySelector("#id_eliminar").value;
    const data = new FormData();
    // Serialize the form data
    data.append('id_cliente', id_cliente);

    var respond = await fetch("php/user/delete_slice_csv.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virtual Reparación de móviles"
        })
        document.querySelector('#editForm').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
}



const callPHPScript = async () => {
    var nombre_cliente = document.querySelector("#nombre_cliente_test").value;
    var email_cliente = document.querySelector("#email_cliente_test").value;
    var problema_cliente = document.querySelector("#problema_cliente_test").value;
    var fecha_entrega_cliente = document.querySelector("#fecha_cliente_test").value;
    var fecha_terminado_test = document.querySelector("#fecha_terminado_test").value;
    var horas_trabajadas = document.querySelector("#horas_reales_test").value;
    var trabajador = document.querySelector("#tecnico_test").value;

    // Serialize the form data
    const data = new FormData();
    data.append('nombre_cliente', nombre_cliente);
    data.append('email_cliente', email_cliente);
    data.append('problema_cliente', problema_cliente);
    data.append('fecha_entrega_cliente', fecha_entrega_cliente);
    data.append('fecha_terminado_test', fecha_terminado_test);
    data.append('horas_trabajadas', horas_trabajadas);
    data.append('trabajador', trabajador);

    var respond = await fetch("php/funciones/factura.php", {
        method: "POST",
        body: data
    });
};

const new_user = async () => {
    var id_user = document.querySelector("#id_usuario").value;
    var nombre_user = document.querySelector("#nombre_user").value;
    if (nombre_user.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Nombre cliente No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    const data = new FormData();
    data.append('id_user', id_user);
    data.append('nombre_user', nombre_user);
    if (image == null) {
        data.append("userPicture", "");
    } else {
        data.append("userPicture", image);
    }

    var respond = await fetch("php/user/new_user.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virtual Reparación de móviles"
        })
        document.querySelector('#formInsert').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
    else{
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: result.mensaje,
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }
}

const modify_user = async () => {
    var id_user = document.querySelector("#id_trabajador").value;
    var nombre_user = document.querySelector("#nombre_trabajador").value;
    var password_user = document.querySelector("#password_trabajador").value;
    console.log(id_user)
    console.log(nombre_user)
    console.log(password_user)
    if (nombre_user.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Nombre user No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    if (password_user.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Password No dejes vacio esto",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }

    const data = new FormData();
    data.append('id_user', id_user);
    data.append('nombre_user', nombre_user);
    data.append('password_user', password_user);
    if (image == null) {
        data.append("userPicture", "");
    } else {
        data.append("userPicture", image);
    }

    var respond = await fetch("php/user/modify_user.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virtual Reparación de móviles"
        })
        document.querySelector('#formModify').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
    else{
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: result.mensaje,
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }
}

const modify_pass = async () => {
    var nombre_user = document.querySelector("#nombre_trabajador").value;
    var password_user = document.querySelector("#password_trabajador").value;

    if (password_user.trim() === '') {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Password No dejes vacio esto",
            footer: "Tienda Virtual Reparación de móviles"
        })
        return;
    }

    

    const data = new FormData();
    data.append('nombre_user', nombre_user);
    data.append('password_user', password_user);

    var respond = await fetch("php/user/modify_pass.php", {
        method: "POST",
        body: data
    });

    var result = await respond.json();

    if (result.success == true) {
        Swal.fire({
            icon: "success",
            title: "Great",
            text: result.mensaje,
            footer: "Tienda Virtual Reparación de móviles"
        })
        document.querySelector('#formInsert').reset();
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    }
    else{
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: result.mensaje,
            footer: "Tienda Virtual Reparación de móviles"
        })
        return;
    }
}


//