<?php

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
		if ($value[0] == $usuario && $value[1] == $password) {
			$encontrado = true;
		}
	}
	return $encontrado;
}

function checkCSV()
{
	//comprobar si existe ../../csv/moviles.csv si no crear
	if (!file_exists('../../csv/moviles.csv')) {
		$fp = fopen('../../csv/moviles.csv', 'w');
		//add this
		$campos = array('ID', 'Nombre', 'Email', 'Problema', 'Fecha', 'Estado', 'Solucion');
		fputcsv($fp, $campos, ',');
		fclose($fp);
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
	$fecha = $_POST['fecha_entrega_cliente'];
	$resuelto = "No";
	$tecnico = "Sin asignar";

	$moviles[] = array($ID, $nombre, $email, $problema, $fecha, $resuelto, $tecnico);
	arraytocsv($moviles, '../../csv/moviles.csv');
}

function countRowsCSV($archivo)
{
	$csv = csvtoarray($archivo);
	$numero = count($csv);
	return $numero;
}

function updateCSV($array_movil)
{
	$id = $array_movil['id'];
	$nombre = $array_movil['nombre'];
	$email = $array_movil['email'];
	$problema = $array_movil['problema'];
	$fecha = $array_movil['fecha'];
	$resuelto = $array_movil['resuelto'];
	$tecnico = $_SESSION['user'];
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('../../csv/moviles.csv'));
	// Loop through the rows of the array
	foreach ($csv as $key => $row) {
		// If the ID of the current row matches the ID of the row we're looking for
		if ($row[0] == $id) {
			// Update the row
			$csv[$key] = array($id, $nombre, $email, $problema, $fecha, $resuelto, $tecnico);
		}
	}

	// Write the CSV back to the file
	$fp = fopen('../../csv/moviles.csv', 'w');

	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}

	fclose($fp);

}
