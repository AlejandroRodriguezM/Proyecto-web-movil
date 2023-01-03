<?php

function arraytocsv($array,$archivo,$delimitador = ","){
	$fp = fopen($archivo, 'w');
	foreach ($array as $campos) {
		fputcsv($fp, $campos, $delimitador);
	}
	fclose($fp);
}

function csvtoarray($archivo,$delimitador = ","){
	$fila = 1;
	$array = array();
	if (($gestor = fopen($archivo, "r")) !== FALSE) {
		while (($datos = fgetcsv($gestor, 1000, $delimitador)) !== FALSE) {
			$numero = count($datos);
			$fila++;
			for ($c=0; $c < $numero; $c++) {
				$array[$fila][$c] = $datos[$c];
			}
		}
		fclose($gestor);
	}
	return $array;
}

function comprobarUsuarioCSV($usuario,$password){
	$usuarios = csvtoarray('../../csv/usuarios.csv');
	$encontrado = false;
	foreach ($usuarios as $key => $value) {
		if($value[0] == $usuario && $value[1] == $password){
			$encontrado = true;
		}
	}
	return $encontrado;
}

