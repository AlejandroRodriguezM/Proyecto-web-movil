<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST) {
    $id_user = $_POST['id_user'];
    $nombre_user = $_POST['nombre_user'];
    $password_user = $_POST['password_user'];

    if (!empty($id_user) && !empty($nombre_user) && !empty($password_user)) {
        if (comprobar_nombre($nombre_user)) {
            $validate['success'] = false;
            $validate['mensaje'] = "Nombre de usuario ya existente";
        } else {
            $validate['success'] = true;
            $validate['mensaje'] = "Peticion de usuario enviada";
            $validate['userName'] = $nombre_user;
            create_new_user($id_user, $nombre_user, $password_user);
            create_new_datos($id_user, $nombre_user);
        }
    } else {
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}

echo json_encode($validate);