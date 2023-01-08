const updateCSV = async () =>{
    var nombre_cliente = document.querySelector("#nombre_cliente").value;
    var email_cliente = document.querySelector("#email_cliente").value;
    var problema_cliente = document.querySelector("#problema_cliente").value;
    var fecha_entrega_cliente = document.querySelector("#fecha_entrega_cliente").value;
    var resuelto = document.querySelector("#resulto").value;
    // Add a submit handler to the form in the modal
    $('#editEmployeeModal form').submit(function (event) {
        // Prevent the form from being submitted
        event.preventDefault();
        // Serialize the form data
        const data = new FormData();
        data.append('nombre_cliente', nombre_cliente);
        data.append('email_cliente', email_cliente);
        data.append('problema_cliente', problema_cliente);
        data.append('fecha_entrega_cliente', fecha_entrega_cliente);
        data.append('resuelto', resuelto);

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
                window.location.href = "crud.php";
            }, 2000);
        }

    });
}