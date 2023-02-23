
<?php
/**
 * API que permite eliminar una linea de un csv.
 */
session_start(); // Inicia la sesión
include_once '../funciones/funciones.php'; // Incluye el archivo con funciones útiles
include_once '../funciones/funciones_csv.php'; // Incluye el archivo con funciones específicas para trabajar con CSV

// Array que almacenará la respuesta a la solicitud del cliente
$validate['success'] = array('success' => false, 'mensaje' => "", "userName" => "");

// Si se han enviado datos a través del método POST
if ($_POST) {
    // Recoge el ID del cliente y su nombre
    $id = $_POST['id_cliente'];
    // Archivo CSV donde se almacenan los datos
    $file = '../../csv/moviles.csv';
    // Comprueba si el archivo existe
    if (checkFile($file)) {
        // Borra una fila del archivo CSV que coincida con el ID del cliente
        deleteSliceCSV($id, $file);
        // La operación ha sido un éxito
        $validate['success'] = true;
        $validate['mensaje'] = "Ha borrado correctamente los datos";
    } else {
        // El archivo no existe o ha sido borrado
        $validate['success'] = false;
        $validate['mensaje'] = "ERROR. El fichero no existe o ha sido borrado. Hable con un administrador";
    }
}

// Devuelve la respuesta en formato JSON
echo json_encode($validate);
