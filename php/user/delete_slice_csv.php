<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST) {
    $id = $_POST['id_cliente'];
    die(var_dump($id));
    $file = '../../csv/moviles.csv';
    deleteSliceCSV($id,$file);
    $validate['success'] = true;
    $validate['mensaje'] = "Ha borrado correctamente los datos";

}

echo json_encode($validate);
