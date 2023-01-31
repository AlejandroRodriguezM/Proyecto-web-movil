<?php
//Iniciamos la sesión
session_start();
//Incluimos las funciones necesarias
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

//Array de validación con un valor inicial predeterminado
$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

//Si hay una petición POST
if ($_POST) {
    //Guardamos los valores enviados desde el formulario
    $nombre_cliente = $_POST['nombre_cliente'];
    $email_cliente = $_POST['email_cliente'];
    $problema_cliente = $_POST['problema_cliente'];
    $fecha_cliente = $_POST['fecha_entrega_cliente'];
    $horas_estimadas = $_POST['horas_estimadas'];
    $num_factura = $_POST['num_factura'];

    //Ruta al archivo csv
    $file = '../../csv/moviles.csv';

    //Si todos los campos obligatorios están rellenos
    if (!empty($nombre_cliente) && !empty($email_cliente) && !empty($problema_cliente) && !empty($fecha_cliente) && !empty($horas_estimadas)) {

        //Se actualiza el array de validación
        $validate['success'] = true;
        $validate['mensaje'] = "Peticion de telefono enviada";
        $validate['userName'] = $nombre_cliente;
        //Se crea la petición de movil
        createMovilRequest();
    } else {
        //Si falta algún campo obligatorio, se actualiza el array de validación
        $validate['success'] = false;
        $validate['mensaje'] = "Error, no se ha podido enviar la peticion";
    }
}

//Se devuelve la respuesta en formato json
echo json_encode($validate);
