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

function check_nombre($nombre){
	$usuarios = csvtoarray('../../csv/usuarios.csv');
	$encontrado = false;
	foreach ($usuarios as $key => $value) {
		if ($value[1] == $nombre) {
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
		$fp = fopen('../../csv/usuarios.csv', 'w');

		$usuarios[] = array("1", "admin", "admin");
		arraytocsv($usuarios, '../../csv/usuarios.csv');
		fclose($fp);
		chmod('../../csv/moviles.csv', 0777);
	}
}

function checkCSVdatos()
{
	if (!file_exists('../../csv/datos_usuarios.csv')) {
		$fp = fopen('../../csv/datos_usuarios.csv', 'w');

		$usuarios[] = array("1", "admin", 0, 0);
		arraytocsv($usuarios, '../../csv/datos_usuarios.csv');
		fclose($fp);
		chmod('../../csv/datos_usuarios.csv', 0777);
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
	$tecnico = $array_movil['tecnico'];
	$numFactura = $array_movil['num_factura'];
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('../../csv/moviles.csv'));
	// Loop through the rows of the array


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
	if ($resuelto == "Si") {
		updateCSVDatos($tecnico);
	}
	fclose($fp);
}

function updateCSVAdmin($array_movil)
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
	$tecnico = $array_movil['tecnico'];
	$numFactura = $array_movil['num_factura'];
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('../../csv/moviles.csv'));
	// Loop through the rows of the array


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
	if ($resuelto == "Si") {
		updateCSVDatos($tecnico);
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

function countRowsUser($tecnico){
	$csv = csvtoarray('./csv/moviles.csv');
	$numero = 0;
	foreach ($csv as $row) {
		if ($row[9] == $tecnico) {
			$numero++;
		}
	}
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

function estadisticas_trabajador($id, $file)
{
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file($file));

	// Iterate through the array to find the worker with the matching ID
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			// Return the data for the matching worker
			return $row;
		}
	}
}

function estadisticas_trabajadores($file)
{
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file($file));
	
	//Return all the data
	return $csv;
}

function total_horas($file)
{
	$csv = csvtoarray($file);
	$horas_trabajadas = 0;
	foreach ($csv as $row) {
		$horas_trabajadas += (int)$row[2];
	}
	return $horas_trabajadas;
}

function total_moviles($file)
{
	$csv = csvtoarray($file);
	$moviles_arreglados = 0;
	foreach ($csv as $row) {
		$moviles_arreglados += (int)$row[3];
	}
	return $moviles_arreglados;
}

function porcentaje_horas($id, $file)
{
	$horas_trabajadas = estadisticas_trabajador($id, $file)[2];
	$total_horas = total_horas($file);
	if($total_horas > 0){
		$porcentaje = ($horas_trabajadas / $total_horas) * 100;
		//redondear con 2 digitos
		$porcentaje = round($porcentaje, 2);
	}
	else{
		$porcentaje = 'No ha trabajado aún';
	}
	return $porcentaje;
}

function porcentaje_moviles($id, $file)
{
	$moviles_arreglados = estadisticas_trabajador($id, $file)[3];
	$total_moviles = total_moviles($file);
	if($total_moviles > 0){
	$porcentaje = ($moviles_arreglados / $total_moviles) * 100;
	$porcentaje = round($porcentaje, 2);
	}
	else{
		$porcentaje = 'No ha arreglado móviles aún';
	}
	return $porcentaje;
}

function num_id(){
	$csv = csvtoarray('./csv/usuarios.csv');
	$numero = count($csv);
	return $numero + 1;
}

function create_new_user($id,$nombre,$password){
	$csv = csvtoarray('../../csv/usuarios.csv');
	$csv[] = array($id,$nombre,$password);
	$fp = fopen('../../csv/usuarios.csv', 'w');
	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}
	fclose($fp);
}

function modify_user($id,$nombre,$password){
    $csv = csvtoarray('../../csv/usuarios.csv');
    $fp = fopen('../../csv/usuarios.csv', 'w');
    foreach ($csv as $i => $row) {
        if($row[0] == $id){
            $csv[$i][1] = $nombre;
            $csv[$i][2] = $password;
        }
        fputcsv($fp, $csv[$i]);
    }
    fclose($fp);
}

function modify_datos($id,$nombre){
    $csv = array_map('str_getcsv', file('../../csv/datos_usuarios.csv'));
    $fp = fopen('../../csv/datos_usuarios.csv', 'w');
    foreach ($csv as $row) {
        if($row[0] == $id){ 
            $row[1] = $nombre;
        }
        fputcsv($fp, $row);
    }
    fclose($fp);
}

function create_new_datos($id,$nombre){
	chmod('../../csv/datos_usuarios.csv', 0777);
	$csv = csvtoarray('../../csv/datos_usuarios.csv');
	$csv[] = array($id,$nombre,0,0);
	$fp = fopen('../../csv/datos_usuarios.csv', 'w');
	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}
	fclose($fp);
}

function num_users(){
	$csv = csvtoarray('./csv/usuarios.csv');
	$numero = count($csv);
	return $numero;
}

function comprobar_nombre($nombre){
	$csv = csvtoarray('../../csv/usuarios.csv');
	$existe = false;
	foreach ($csv as $row) {
		if($row[1] == $nombre){
			$existe = true;
		}
	}
	return $existe;
}
