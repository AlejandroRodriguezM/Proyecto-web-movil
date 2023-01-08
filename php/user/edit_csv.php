<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

if ($_POST) {
    $id = $_POST['id_cliente'];
    $nombre = $_POST['nombre_cliente'];
    $email = $_POST['email_cliente'];
    $problema = $_POST['problema_cliente'];
    $fecha = $_POST['fecha_entrega_cliente'];
    $resuelto = $_POST['resuelto'];

    if (!empty($nombre) && !empty($email) && !empty($problema) && !empty($fecha) && !empty($resuelto)) {

        $datos_movil = array('id' => $id, 'nombre' => $nombre, 'email' => $email, 'problema' => $problema, 'fecha' => $fecha, 'resuelto' => $resuelto);

        $validate['success'] = true;
        $validate['mensaje'] = "Peticion de arreglo solucionado";
        $validate['userName'] = $nombre;
        updateCsv($datos_movil);
    } else {
        $validate['success'] = false;
        $validate['mensaje'] = "No se ha podido solucionar el arreglo, faltan datos";
    }
}

echo json_encode($validate);
