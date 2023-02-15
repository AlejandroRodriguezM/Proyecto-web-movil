
<?php
/**
 * API que sirve para modificar un usuario en concreto
 */
//Inicio de sesión
session_start();

//Inclusión de archivos con funciones necesarias
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

//Array para almacenar los datos de respuesta
$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

//Verificación de la existencia de datos enviados por POST
if ($_POST) {
    //Asignación de valores a las variables
    $id = $_POST['id_user'];
    $nombre = $_POST['nombre_user'];
    $password = $_POST['password_user'];
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $picture_profile = $_POST['userPicture'];
    $antiguo_nombre = nombre_usuario($id); //Obtiene el nombre antiguo del usuario

    //Comprobación de nombre de usuario
    if (comprobar_nombre($nombre) && $nombre != $antiguo_nombre) { //El nombre está en uso y es diferente al antiguo
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    } elseif ($nombre == $antiguo_nombre) { //El nombre es igual al antiguo
        if (password_verify($nombre, $password_hash)) {
            $validate['success'] = false;
            $validate['mensaje'] = "No puedes usar la misma contraseña 12112";
        } else {
            $validate['success'] = true;
            $validate['mensaje'] = "Usuario modificado correctamente";
            $validate['userName'] = $nombre;
            //Llamado a funciones de modificación
            saveImage($id, $nombre, $picture_profile);
            modify_user($id, $nombre, $password_hash);
            modify_datos($id, $nombre);
            saveImage($id, $nombre, $picture_profile);
        }
    } elseif (!comprobar_nombre($nombre) && $nombre != $antiguo_nombre) { //El nombre no está en uso y es diferente al antiguo
        if (password_verify($nombre, $password_hash)) { //El nombre está en uso y es diferente al antiguo
            $validate['success'] = false;
            $validate['mensaje'] = "No puedes usar la misma contraseña";
        } else {
            $validate['success'] = true;
            $validate['mensaje'] = "Usuario modificado correctamente";
            $validate['userName'] = $nombre;
            //Llamado a funciones de modificación
            actualizar_tecnico($antiguo_nombre, $nombre);
            delete_directory($id, $antiguo_nombre);
            create_directory_img($id, $nombre);
            saveImage($id, $nombre, $picture_profile);
            modify_user($id, $nombre, $password_hash);
            modify_datos($id, $nombre);
            insertURL($nombre, $id);
        }
    } else {
        //El nombre es incorrecto
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}

//Codificación del array de respuesta a formato JSON
echo json_encode($validate);
