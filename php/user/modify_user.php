<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST){
    $id = $_POST['id_user'];
    $nombre = $_POST['nombre_user'];
    $password = $_POST['password_user'];
    $picture_profile = $_POST['userPicture'];
    $antiguo_nombre = nombre_usuario($id);

    if(check_nombre($nombre) && $nombre != $antiguo_nombre){

        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
    elseif($nombre == $antiguo_nombre){
        $validate['success'] = true;
        $validate['mensaje'] = "Usuario modificado correctamente";
        $validate['userName'] = $nombre;
        saveImage($id, $nombre, $picture_profile);
        modify_user($id,$nombre,$password);
        modify_datos($id,$nombre);
        saveImage($id, $nombre, $picture_profile);
    }
    elseif(!check_nombre($nombre) && $nombre != $antiguo_nombre){
        $validate['success'] = true;
        $validate['mensaje'] = "Usuario modificado correctamente";
        $validate['userName'] = $nombre;
        actualizar_tecnico($antiguo_nombre, $nombre);
        delete_directory($id, $antiguo_nombre);
        create_directory_img($id, $nombre);
        saveImage($id, $nombre, $picture_profile);
        modify_user($id,$nombre,$password);
        modify_datos($id,$nombre);
        insertURL($nombre, $id);
        
    }
    else{
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}

echo json_encode($validate);