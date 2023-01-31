<?php
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
    $password_user = $_POST['password_user'];
    $picture_profile = $_POST['userPicture'];
    $privilegio = 'user'; // Asignar el privilegio 'user'
    // Verificar si los campos están llenos
    if (!empty($id_user) && !empty($nombre_user) && !empty($password_user)) {
        // Comprobar si el nombre de usuario ya existe
        if (comprobar_nombre($nombre_user)) {
            // Si el nombre de usuario ya existe, agregar un mensaje de error
            $validate['success'] = false;
            $validate['mensaje'] = "Nombre de usuario ya existente";
        } else {
            // Si el nombre de usuario es válido, agregar un mensaje de éxito
            $validate['success'] = true;
            $validate['mensaje'] = "Usuario creado correctamente";
            $validate['userName'] = $nombre_user;
            // Crear la carpeta para las imágenes del usuario
            create_directory_img($id_user, $nombre_user);
            // Guardar la imagen de perfil del usuario
            saveImage($id_user, $nombre_user, $picture_profile);
            // Crear un nuevo usuario
            create_new_user($id_user, $nombre_user, $password_user,$privilegio);
            // Crear los datos del usuario
            create_new_datos($id_user, $nombre_user);
            // Guardar la URL de la imagen de perfil
            insertURL($nombre_user, $id_user);
        }
    } else {
        // Si hay campos vacíos, agregar un mensaje de error
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}
// Devolver el resultado en formato JSON
echo json_encode($validate);
