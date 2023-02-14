
<?php
/**
 * API que sirve para editar una linea especifica de un csv
 */
session_start();
include_once '../funciones/funciones.php';
include_once '../funciones/funciones_csv.php';

$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

// Verifica si se han enviado datos a través del método POST
if ($_POST) {
    // Almacena los datos en variables
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

    // Verifica si el archivo CSV existe
    if(checkFile($file)){
        // Verifica que se hayan ingresado los datos requeridos
        if (!empty($nombre) && !empty($email) && !empty($problema) && !empty($fecha_terminado) && !empty($resuelto)) {

            // Crea un arreglo con los datos del móvil
            $datos_movil = array('id' => $id, 'nombre' => $nombre, 'email' => $email, 'problema' => $problema, 'fecha' => $fecha,'fecha_terminado' => $fecha_terminado,'horas_estimadas' => $horas_estimadas,'horas_trabajadas' => $horas_trabajadas, 'resuelto' => $resuelto, 'num_factura' => $num_factura, 'tecnico' => $tecnico);
    
            // Actualiza los datos del móvil en el archivo CSV
            update_moviles($datos_movil);
            
            // Agrega un mensaje de éxito
            $validate['success'] = true;
            $validate['mensaje'] = "Petición de arreglo solucionada";
            $validate['userName'] = $nombre;
        } else {
            // Agrega un mensaje de error si faltan datos
            $validate['success'] = false;
            $validate['mensaje'] = "No se ha podido solucionar el arreglo, faltan datos";
        }
    }
    else{
        // Agrega un mensaje de error si el archivo no existe
        $validate['success'] = false;
        $validate['mensaje'] = "ERROR. El fichero no existe o ha sido borrado. Hable con un administrador";
    }
}

// Devuelve la respuesta en formato JSON
echo json_encode($validate);
