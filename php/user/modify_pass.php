
<?php
/**
 * API que sirve para modificar la contraseña de un usuario
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
    $csv = csvtoarray('../../csv/usuarios.csv');
    //Asignación de valores a las variables
    $nombre = $_POST['nombre_user'];
    $password = $_POST['password_user'];

    $pass = check_pass($nombre,$csv);

    //Comprobación de nombre de usuario
    if ($password == $nombre) { //El nombre está en uso y es diferente al antiguo
        $validate['success'] = false;
        $validate['mensaje'] = "No puedes usar la misma contraseña";
    } else{
        $validate['success'] = true;
        $validate['mensaje'] = "Has cambiado correctamente la contraseña";
        $validate['userName'] = $nombre;
        //Llamado a funciones de modificación
        change_pass($nombre, $password);
    }
}

//Codificación del array de respuesta a formato JSON
echo json_encode($validate);
