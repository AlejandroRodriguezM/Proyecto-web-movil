//Validar nombre de usuario, email y passwords

const $formulario = document.querySelector("#formulario"),
    $username = document.querySelector("#username"),
    $email = document.querySelector("#email"),
    $password = document.querySelector("#password"),
    $passwordRepeat = document.querySelector("#passwordRepeat");

$formulario.onsubmit = evento => {
    evento.preventDefault();
    const username = $username.value,
        email = $email.value;
    password = $password.value;
    passwordRepeat = $passwordRepeat.value;
    // Validar
    if (!validateUserNAme(username)) {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Nombre de usuario no válido, debe contener letras",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }
    if (!validateEmail(email)) {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "E-mail no válido",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }
    if (!validatePassword(password)) {
        Swal.fire({
            icon: "error",
            title: "ERROR",
            text: "Contraseña no válida, debe tener entre 8 a 16 caracteres, mínimo una letra mayúscula, una letra minúscula y un dígito ",
            footer: "Tienda Virual Reparación de móviles"
        })
        return;
    }
    if (password !== passwordRepeat) {
        alert("Las contraseñas no coinciden");
        return;
    }

    $formulario.submit();
};


const validateEmail = (email) => {
    return /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(email.trim());
}

const validatePassword = (password) => {
    //password de 8 a 16 caracteres, mínimo una letra mayúscula, una letra minúscula y un dígito
    return /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,16}$/.test(password.trim());

}

const validateUserNAme = (username) => {
    return /^[a-zA-Z0-9]{4,16}$/.test(username.trim());

}

