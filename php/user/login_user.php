<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST){
    $nombre = $_POST['user'];
    $password = $_POST['password'];
    checkCSVUser();
    checkCSVdatos();
    if(comprobarUsuarioCSV($nombre,$password)){
        $validate['success'] = true;
        $validate['mensaje'] = "Usuario correcto";
        $validate['userName'] = $nombre;
        $_SESSION['user'] = $nombre;
        $_SESSION['conexion'] = date('H:i:s');
        if ($nombre == 'admin') {
            cookiesUserAdmin($nombre);
        }
        cookiesUser($nombre, $password);
    }
    else{
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}

echo json_encode($validate);


