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
	//add new row
	if ($numRows == 1) {
		$ID = 1;
	} else {
		$ID = $numRows;
	}
	$nombre = $_POST['nombre_cliente'];
	$email = $_POST['email_cliente'];
	$problema = $_POST['problema_cliente'];
	$fecha = $_POST['fecha_entrega_cliente'];
	$resuelto = "No";
	$tecnico = "Sin asignar";

	$moviles[] = array($ID, $nombre, $email, $problema, $fecha, $resuelto, $tecnico);
	arraytocsv($moviles, '../../csv/moviles.csv');
}

//contar cuantos rows hay dentro de un csv sin contar la primera linea
function countRowsCSV($archivo)
{
	$csv = csvtoarray($archivo);
	$numero = count($csv);
	return $numero;
}

function updateCSV()
{
	$id = $_POST['id_cliente'];
	//get the new values
	$nombre = $_POST['nombre_cliente'];
	$email = $_POST['email_cliente'];
	$problema = $_POST['problema_cliente'];
	$fecha = $_POST['fecha_entrega_cliente'];
	$resuelto = $_POST['resuelto'];
	$tecnico = $_SESSION['user'];

	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file('../../csv/moviles.csv'));
	// $csv = array_slice($csv, 1);
	// Loop through the rows of the array
	foreach ($csv as &$row) {
		// Check if the ID column matches the desired value
		if ($row[0] == $id) {
			// Update the values in the row
			$row[1] = $nombre;
			$row[2] = $email;
			$row[3] = $problema;
			$row[4] = $fecha;
			$row[5] = $resuelto;
			$row[6] = $tecnico;
			break;
		}
	}

	// Open the CSV file for writing
	$fp = fopen('../../csv/moviles.csv', 'w');

	// Write the rows of the array back to the CSV file
	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}

	// Close the file
	fclose($fp);
}
