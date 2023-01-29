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
    $fecha_terminado = $_POST['fecha_terminado_cliente'];
    $horas_estimadas = $_POST['horas_estimadas'];
    $horas_trabajadas = $_POST['horas_trabajadas'];
    $resuelto = $_POST['resuelto'];
    $num_factura = $_POST['num_factura'];
    $tecnico = $_POST['tecnico'];
    $file = '../../csv/moviles.csv';

    if(checkFile($file)){
        if (!empty($nombre) && !empty($email) && !empty($problema) && !empty($fecha_terminado) && !empty($resuelto)) {

            $datos_movil = array('id' => $id, 'nombre' => $nombre, 'email' => $email, 'problema' => $problema, 'fecha' => $fecha,'fecha_terminado' => $fecha_terminado,'horas_estimadas' => $horas_estimadas,'horas_trabajadas' => $horas_trabajadas, 'resuelto' => $resuelto, 'num_factura' => $num_factura, 'tecnico' => $tecnico);
    
            $validate['success'] = true;
            $validate['mensaje'] = "Peticion de arreglo solucionado";
            $validate['userName'] = $nombre;
            update_moviles($datos_movil);
        } else {
            $validate['success'] = false;
            $validate['mensaje'] = "No se ha podido solucionar el arreglo, faltan datos";
        }
    }
    else{
        $validate['success'] = false;
        $validate['mensaje'] = "ERROR. El fichero no existe o ha sido borrado. Hable con un administrador";
    }

    
}

echo json_encode($validate);
