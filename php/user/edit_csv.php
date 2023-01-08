<?php
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");
// Get the form data
$id = $_POST['id_cliente'];
$nombre = $_POST['nombre_cliente'];
$email = $_POST['email_cliente'];
$problema = $_POST['problema_cliente'];
$fecha = $_POST['fecha_entrega_cliente'];
$resuelto = $_POST['resuelto'];

updateCSV();

$validate['success'] = true;
$validate['mensaje'] = "Usuario correcto";

// Return a response indicating that the update was successful
echo json_encode($validate);
