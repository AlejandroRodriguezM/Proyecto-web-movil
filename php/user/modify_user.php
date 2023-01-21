<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST){
    $id = $_POST['id_user'];
    $nombre = $_POST['nombre_user'];
    $password = $_POST['password_user'];

    if(!check_nombre($nombre)){
        $validate['success'] = true;
        $validate['mensaje'] = "Usuario modificado correctamente";
        $validate['userName'] = $nombre;
        modify_user($id,$nombre,$password);
        modify_datos($id,$nombre);
    }
    else{
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}

echo json_encode($validate);