
<?php
/**
 * API que sirve para actualizar el estado de un movil a reparar
 */
// Inicio de sesión
session_start();

// Se incluyen los archivos de funciones
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

// Se crea un arreglo de validación con un valor inicial falso
$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

// Si se envían datos por POST
if ($_POST) {
    // Se reciben los datos del formulario
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
    // Nombre del archivo csv
    $file = '../../csv/moviles.csv';

    // Si el archivo existe
    if (checkFile($file)) {
        // Si los campos obligatorios están llenos
        if (!empty($nombre) && !empty($email) && !empty($problema) && !empty($fecha_terminado) && !empty($resuelto)) {
            // Se crea un arreglo con los datos del móvil
            $datos_movil = array('id' => $id, 'nombre' => $nombre, 'email' => $email, 'problema' => $problema, 'fecha' => $fecha, 'fecha_terminado' => $fecha_terminado, 'horas_estimadas' => $horas_estimadas, 'horas_trabajadas' => $horas_trabajadas, 'resuelto' => $resuelto, 'num_factura' => $num_factura, 'tecnico' => $tecnico);

            // Se actualiza el archivo csv
            update_moviles($datos_movil);

            // Se actualiza el mensaje de validación
            $validate['success'] = true;
            $validate['mensaje'] = "Peticion de arreglo solucionado";
            $validate['userName'] = $nombre;
        } else {
            // Si faltan datos, se muestra un mensaje de error
            $validate['success'] = false;
            $validate['mensaje'] = "ERROR. El fichero no existe o ha sido borrado. Hable con un administrador";
        }
    }
}

// Se devuelve la respuesta en formato json
echo json_encode($validate);
