
<?php
/**
 * API que sirve para loguearse dentro de la pagina
 */
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

// Creación de un arreglo para almacenar el resultado de la validación
$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

// Verificar si se reciben datos por el método POST
if ($_POST){
    // Recoger el nombre de usuario y la contraseña enviados en el formulario
    $nombre = $_POST['user'];
    $password = $_POST['password'];
    // Comprobar si los archivos CSV necesarios existen y están disponibles
    checkCSV();
    checkCSVUser();
    checkCSVdatos();
    // Verificar si el usuario existe y la contraseña es correcta
    if(comprobarUsuarioCSV($nombre,$password)){
        // Actualizar el arreglo de validación si el usuario es correcto
        $validate['success'] = true;
        $validate['mensaje'] = "Usuario correcto";
        $validate['userName'] = $nombre;
        // Almacenar el nombre de usuario en la sesión
        $_SESSION['user'] = $nombre;
        $_SESSION['conexion'] = date('H:i:s');
        // Crear una cookie para el usuario si es un usuario administrador
        if ($nombre == 'admin') {
            cookiesUserAdmin($nombre);
        }
        // Crear una cookie para el usuario
        cookiesUser($nombre, $password);
    }
    else{
        // Actualizar el arreglo de validación si el usuario es incorrecto
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}
// Codificar el arreglo de validación a formato JSON y mostrarlo
echo json_encode($validate);
