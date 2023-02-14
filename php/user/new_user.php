
<?php
/**
 * API que sirve para crear un nuevo usuario
 */
// Iniciar la sesión
session_start();

// Incluir las funciones
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

// Crear un array para almacenar el resultado
$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

// Verificar si se han enviado datos por POST
if ($_POST) {
    // Recoger los datos del formulario
    $id_user = $_POST['id_user'];
    $nombre_user = $_POST['nombre_user'];
    $picture_profile = $_POST['userPicture'];
    $privilegio = $nombre_user; // Asignar el privilegio 'user'
    // Verificar si los campos están llenos
    if (!empty($id_user) && !empty($nombre_user)) {
        // Comprobar si el nombre de usuario ya existe
        if (comprobar_nombre($nombre_user)) {
            $validate['success'] = false;
            $validate['mensaje'] = "Nombre de usuario ya existente";
        } elseif(create_new_user($id_user, $nombre_user, $privilegio,$picture_profile)) {
            $validate['success'] = true;
            $validate['mensaje'] = "Usuario creado correctamente";
            $validate['userName'] = $nombre_user;

        }
    } else {
        // Si hay campos vacíos, agregar un mensaje de error
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}
// Devolver el resultado en formato JSON
echo json_encode($validate);
