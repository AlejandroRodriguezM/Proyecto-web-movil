<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST) {
    $id = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $file = '../../csv/moviles.csv';
    if (checkFile($file)) {
        deleteSliceCSV($id, $file); 
        $validate['success'] = true;
        $validate['mensaje'] = "Ha borrado correctamente los datos";
    } else {
        $validate['success'] = false;
        $validate['mensaje'] = "ERROR. El fichero no existe o ha sido borrado. Hable con un administrador";
    }
}

echo json_encode($validate);
