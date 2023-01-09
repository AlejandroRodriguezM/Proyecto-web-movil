<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST) {
    $nombre_cliente = $_POST['nombre_cliente'];
    $email_cliente = $_POST['email_cliente'];
    $problema_cliente = $_POST['problema_cliente'];
    $fecha_cliente = $_POST['fecha_entrega_cliente'];

    $file = '../../csv/moviles.csv';

    if (!empty($nombre_cliente) && !empty($email_cliente) && !empty($problema_cliente) && !empty($fecha_cliente)) {

        $validate['success'] = true;
        $validate['mensaje'] = "Peticion de telefono enviada";
        $validate['userName'] = $nombre_cliente;
        createMovilRequest();
    } else {
        $validate['success'] = false;
        $validate['mensaje'] = "Usuario incorrecto";
    }
}

echo json_encode($validate);
