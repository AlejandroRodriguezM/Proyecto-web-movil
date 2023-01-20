<?php

include_once 'funciones.php';
const precio_hora = 10;


function arraytocsv($array, $archivo, $delimitador = ",")
{
	$fp = fopen($archivo, 'w');
	foreach ($array as $campos) {
		fputcsv($fp, $campos, $delimitador);
	}
	fclose($fp);
}

function csvtoarray($archivo, $delimitador = ",")
{
	$fila = 1;
	$array = array();
	if (($gestor = fopen($archivo, "r")) !== FALSE) {
		while (($datos = fgetcsv($gestor, 1000, $delimitador)) !== FALSE) {
			$numero = count($datos);
			$fila++;
			for ($c = 0; $c < $numero; $c++) {
				$array[$fila][$c] = $datos[$c];
			}
		}
		fclose($gestor);
	}
	return $array;
}

function comprobarUsuarioCSV($usuario, $password)
{
	$usuarios = csvtoarray('../../csv/usuarios.csv');
	$encontrado = false;
	foreach ($usuarios as $key => $value) {
		if ($value[1] == $usuario && $value[2] == $password) {
			$encontrado = true;
		}
	}
	return $encontrado;
}

function checkCSV()
{
	if (!file_exists('../../csv/moviles.csv')) {
		$fp = fopen('../../csv/moviles.csv', 'w');
		fclose($fp);
		chmod('../../csv/moviles.csv', 0777);
	}
}

function checkCSVUser()
{
	if (!file_exists('../../csv/usuarios.csv')) {
		$fp = fopen('../../csv/moviles.csv', 'w');

		$usuarios[] = array("1", "admin", "admin");
		arraytocsv($usuarios, '../../csv/usuarios.csv');
		fclose($fp);
		chmod('../../csv/moviles.csv', 0777);
	}
}

function createMovilRequest()
{
	checkCSV();
	$moviles = csvtoarray('../../csv/moviles.csv');
	//count numRows
	$numRows = countRowsCSV('../../csv/moviles.csv');
	$ID = $numRows + 1;
	$nombre = $_POST['nombre_cliente'];
	$email = $_POST['email_cliente'];
	$problema = $_POST['problema_cliente'];
	$fecha_entrega = $_POST['fecha_entrega_cliente'];
	$horas_estimadas = $_POST['horas_estimadas'];
	$num_factura = $_POST['num_factura'];
	$precio_hora_estimado = $horas_estimadas * precio_hora;
	$resuelto = "No";
	$tecnico = "Sin asignar";

	$moviles[] = array($ID, $nombre, $email, $problema, $fecha_entrega, "", $precio_hora_estimado, "", $resuelto, $tecnico, $num_factura);
	arraytocsv($moviles, '../../csv/moviles.csv');
}

function updateCSV($array_movil)
{
	$id = $array_movil['id'];
	$nombre = $array_movil['nombre'];
	$email = $array_movil['email'];
	$problema = $array_movil['problema'];
	$fecha_entrega = $array_movil['fecha'];
	$fecha_terminado = $array_movil['fecha_terminado'];
	$precio_hora_estimado = $array_movil['horas_estimadas'];

	$horas_trabajadas = $array_movil['horas_trabajadas'];
	$precio_hora_total = (int)$horas_trabajadas * precio_hora;

	$resuelto = $array_movil['resuelto'];
	$tecnico = $_SESSION['user'];
	$numFactura = $array_movil['num_factura'];
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('../../csv/moviles.csv'));
	// Loop through the rows of the array
	updateCSVDatos($tecnico);
	foreach ($csv as $key => $row) {
		// If the ID of the current row matches the ID of the row we're looking for
		if ($row[0] == $id) {
			// Update the row
			$csv[$key] = array($id, $nombre, $email, $problema, $fecha_entrega, $fecha_terminado, $precio_hora_estimado, $precio_hora_total, $resuelto, $tecnico, $numFactura);
		}
	}
	// Write the CSV back to the file
	$fp = fopen('../../csv/moviles.csv', 'w');

	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}

	fclose($fp);
}

function updateCSVDatos($nombre)
{
	$num_horas = numero_horas_trabajadas($nombre);
	$num_moviles = numero_moviles_arreglados($nombre);
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('../../csv/datos_usuarios.csv'));
	// Loop through the rows of the array
	foreach ($csv as $key => $row) {
		// If the ID of the current row matches the ID of the row we're looking for
		if ($row[1] == $nombre) {
			// Update the row
			$csv[$key] = array($row[0], $nombre, $num_horas, $num_moviles);
		}
	}
	// Write the CSV back to the file
	$fp = fopen('../../csv/datos_usuarios.csv', 'w');

	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}

	fclose($fp);
}

function checkFile($file)
{

	$exist = True;
	if (!file_exists($file)) {
		$exist = False;
	}
	return $exist;
}

function deleteSliceCSV($id, $file)
{
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file($file));
	// Initialize a new array to store the updated rows
	$updated_csv = array();
	// Loop through the rows of the array
	foreach ($csv as $row) {
		// If the ID of the current row does not match the ID of the row we're looking for, add it to the updated array
		if ($row[0] != $id) {
			$updated_csv[] = $row;
		}
	}
	// Open the CSV file for writing
	$fp = fopen($file, 'w');
	// Loop through the rows of the updated array
	foreach ($updated_csv as $row) {
		// Write the values of the row to the CSV file
		fputcsv($fp, $row);
	}
	// Close the file
	fclose($fp);
}
function countRowsCSV($archivo)
{
	$csv = csvtoarray($archivo);
	$numero = count($csv);
	return $numero;
}

function countRowsCSVResueltos($archivo)
{
	$csv = csvtoarray($archivo);
	$numero_resueltos = 0;
	foreach ($csv as $row) {
		if ($row[8] == "Si") {
			$numero_resueltos++;
		}
	}
	return $numero_resueltos;
}

function countRowsCSVAveriados($archivo)
{
	$csv = csvtoarray($archivo);
	$numero_averiados = 0;
	foreach ($csv as $row) {
		if ($row[8] == "No") {
			$numero_averiados++;
		}
	}
	return $numero_averiados;
}

function numero_horas_trabajadas($nombre)
{
	$csv = csvtoarray('../../csv/moviles.csv');
	$horas_trabajadas = 0;
	foreach ($csv as $row) {
		if ($row[9] == $nombre) {
			$horas_trabajadas += (int)$row[7] / precio_hora;
		}
	}
	return $horas_trabajadas;
}

function numero_moviles_arreglados($nombre)
{
	$csv = csvtoarray('../../csv/moviles.csv');
	$moviles_arreglados = 0;
	foreach ($csv as $row) {
		if ($row[9] == $nombre) {
			$moviles_arreglados++;
		}
	}
	return $moviles_arreglados;
}

function estadisticas_trabajador($id)
{
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('./csv/datos_usuarios.csv'));

	// Iterate through the array to find the worker with the matching ID
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			// Return the data for the matching worker
			return $row;
		}
	}
}

function descargar_fichero_trabajador($id)
{
    // Get worker data
    $data = estadisticas_trabajador($id);
    if (is_string($data)) {
        return $data;
    }

    // Create a new temporary CSV file
    $tempName = tempnam(sys_get_temp_dir(), 'csv');
    $file = fopen($tempName, 'w');

    // Add the relevant data to a new array
    $relevantData = array($data[1], $data[2], $data[3]);

    // Add the relevant data to the CSV file
    fputcsv($file, array("Nombre","Horas trabajadas","Moviles arreglados"));
    fputcsv($file, $relevantData);

    // Close the file
    fclose($file);
    clearstatcache();

    // Rename the temporary file
    $fileName = $data[0] . '_' . $data[1] . '.csv';
    rename($tempName, $fileName);

    // Set the appropriate headers to trigger a download in the browser
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $fileName . '";');

    // Read the file and output its contents
    readfile($fileName);
    unlink($fileName); // delete the created file after download
}


