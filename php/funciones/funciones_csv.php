<?php

include_once 'funciones.php';

const precio_hora = 10; //Constante del valor del precio por hora de trabajo

/**
 * Funcion que convierte un array a un fichero csv
 * @param mixed $array
 * @param mixed $archivo
 * @param mixed $delimitador
 * @return void
 */
function arraytocsv($array, $archivo, $delimitador = ",")
{
	$fp = fopen($archivo, 'w');
	foreach ($array as $campos) {
		fputcsv($fp, $campos, $delimitador);
	}
	fclose($fp);
}

/**
 * Funcion que convierte el contenido de un fichero csv a array
 * @param mixed $archivo
 * @param mixed $delimitador
 * @return array<array>
 */
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

/**
 * Funcion que devuelve un booleano cuyo estado varia si existe o no el usuario dentro del csv
 * @param mixed $usuario
 * @param mixed $password
 * @return bool
 */
function comprobarUsuarioCSV($usuario, $password)
{
	$csv = csvtoarray('../../csv/usuarios.csv');
	$existe = false;
	if ($csv === false) {
		throw new Exception("No se pudo leer el archivo CSV de usuarios");
	}
	foreach ($csv as $value) {
		if ($value[1] == $usuario && password_verify($password, $value[2])) {
			$existe = true;
		}
	}
	return $existe;
}

/**
 * Funcion que devuelve la contraseña de un usuario
 *
 * @param [type] $nombre
 * @param [type] $csv
 * @return string
 */
function check_pass($nombre, $csv)
{
    foreach ($csv as $row) {
        if ($row[1] == $nombre) {
            return $row[2];
        }
    }
    // Si no se encuentra el nombre, devolver un valor predeterminado o lanzar una excepción
    return null;
}

/**
 * Funcion que comprueba si existe el csv moviles, en caso de no existir, lo crea
 * @return void
 */
function checkCSV()
{
	if (!file_exists('../../csv/moviles.csv')) {
		$fp = fopen('../../csv/moviles.csv', 'w');
		fclose($fp);
		chmod('../../csv/moviles.csv', 0777);
	}
}

/**
 * Funcion que comprueba si existe el csv usuarios. Si no existe, crea uno con 1 usuario, que es el administrador de la pagina. Cuya contraseña es admin
 * @return void
 */
function checkCSVUser()
{
	if (!file_exists('../../csv/usuarios.csv')) {
		$fp = fopen('../../csv/usuarios.csv', 'w');
		$password = password_hash('admin', PASSWORD_DEFAULT);
		create_directory_img(1, 'admin');
		saveImage(1, 'admin', '');
		$usuarios[] = array("1", "admin", "$password", '', 'admin');
		arraytocsv($usuarios, '../../csv/usuarios.csv');
		fclose($fp);
		chmod('../../csv/moviles.csv', 0777);
		create_directory_img('1', 'admin');
		insertURL('admin', '1');
	}
}

/**
 * Funcion que comprueba si existe el csv datos_usuarios, en caso de no existir, lo crea
 * @return void
 */
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

/**
 * Funcion que crea una peticion de arreglo de telefono
 * @return void
 */
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

/**
 * Funcion que actualiza un slice del csv moviles
 * @param mixed $array_movil
 * @return boolean
 */
function update_moviles($array_movil) {
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

	fclose($fp);

	if ($resuelto == "Si") {
		$result = updateCSVDatos($tecnico);
		if ($result) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

/**
 * Funcion que actualiza el csv datos_usuarios
 * @param mixed $nombre
 * @return boolean
 */
function updateCSVDatos($nombre)
{
	$num_horas = numero_horas_trabajadas($nombre);
	$num_moviles = numero_moviles_arreglados($nombre);
	$success = true;
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
	if ($fp) {
		foreach ($csv as $row) {
			if (!fputcsv($fp, $row)) {
				$success = false;
			}
		}
		fclose($fp);
	} else {
		$success = false;
	}
	return $success;
}

/**
 * Funcion que devuelve un booleano true si existe el fichero
 * @param mixed $nombre
 * @return boolean
 */
function checkFile($file)
{
	$exist = True;
	if (!file_exists($file)) {
		$exist = False;
	}
	return $exist;
}

/**
 * Funcion que elimina un slce de un fichero csv
 * @param mixed $file
 * @return void
 */
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

/**
 * Funcion que devuelve el numero de filas de un csv
 * @param mixed $archivo
 * @return int
 */
function countRowsCSV($archivo)
{
	$csv = csvtoarray($archivo);
	$numero = count($csv);
	return $numero;
}

/**
 * Funcion que devuelve el numero de filas de un csv de un tecnico en concreto
 * @param mixed $archivo
 * @return int
 */
function countRowsUser($tecnico)
{
	$csv = csvtoarray('./csv/moviles.csv');
	$numero = 0;
	foreach ($csv as $row) {
		if ($row[9] == $tecnico) {
			$numero++;
		}
	}
	return $numero;
}

/**
 * Funcion que devuelve el numero de filas de un csv resueltos
 * @param mixed $archivo
 * @return int
 */
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

/**
 * Funcion que devuelve el numero de filas de un csv averiados
 * @param mixed $archivo
 * @return int
 */
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

/**
 * Funcion que devuelve el numero de horas trabajadas de un trabajador en concreto
 * @param mixed $nombre
 * @return int
 */
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

/**
 * Funcion que devuelve el numero de moviles arreglados arreglados de un trabajador en concreto
 * @param mixed $nombre
 * @return int
 */
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

/**
 * Devuelve un array con los datos de un trabajador en concreto
 * @param mixed $id
 * @param mixed $file
 * @return array
 */
function estadisticas_trabajador($id, $file)
{
	$csv = array_map('str_getcsv', file($file));
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			return $row;
		}
	}
	return null;
}

/**
 * Devuelve un array con los datos de todos los trabajadores
 * @param mixed $file
 * @return array
 */
function estadisticas_trabajadores($file)
{
	// Read the CSV file into an array
	$csv = array_map('str_getcsv', file($file));

	//Return all the data
	return $csv;
}

/**
 * Devuelve el total de horas trabajadas por todos los trabajadores
 * @param mixed $file
 * @return int
 */
function total_horas($file)
{
	$csv = csvtoarray($file);
	$horas_trabajadas = 0;
	foreach ($csv as $row) {
		$horas_trabajadas += (int)$row[2];
	}
	return $horas_trabajadas;
}

/**
 * Devuelve el total de moviles arreglados por todos los trabajadores
 * @param mixed $file
 * @return int
 */
function total_moviles($file)
{
	$csv = csvtoarray($file);
	$moviles_arreglados = 0;
	foreach ($csv as $row) {
		$moviles_arreglados += (int)$row[3];
	}
	return $moviles_arreglados;
}

/**
 * Devuelve el total de moviles arreglados por un trabajador en concreto
 * @param mixed $nombre
 * @param mixed $file
 * @return int
 */
function total_moviles_usuario($nombre, $file)
{
	$csv = csvtoarray($file);
	$moviles_arreglados = 0;
	foreach ($csv as $row) {
		if ($row[1] == $nombre) {
			$moviles_arreglados += (int)$row[3];
		}
	}
	return $moviles_arreglados;
}

/**
 * Devuelve el total de horas trabajadas por un trabajador en concreto en porcentaje
 * @param mixed $nombre
 * @param mixed $file
 * @return int
 */
function porcentaje_horas($id, $file)
{
	$horas_trabajadas = estadisticas_trabajador($id, $file)[2];
	$total_horas = total_horas($file);
	if ($total_horas > 0) {
		$porcentaje = ($horas_trabajadas / $total_horas) * 100;
		//redondear con 2 digitos
		$porcentaje = round($porcentaje, 2);
	}
	else{
		$porcentaje = 0;
	}
	return $porcentaje;
}

/**
 * Devuelve el total de moviles arreglados por un trabajador en concreto en porcentaje
 * @param mixed $nombre
 * @param mixed $file
 * @return int
 */
function porcentaje_moviles($id, $file)
{
	$moviles_arreglados = estadisticas_trabajador($id, $file)[3];
	$total_moviles = total_moviles($file);
	if ($total_moviles > 0) {
		$porcentaje = ($moviles_arreglados / $total_moviles) * 100;
		$porcentaje = round($porcentaje, 2);
	} else {
		$porcentaje = 'No ha arreglado móviles aún';
	}
	return $porcentaje;
}

/**
 * devuelve el total de id en el csv y le suma 1. Se usa para asignar ID a nuevos trabajadores
 * @return int
 */
function num_id()
{
	$csv = csvtoarray('./csv/usuarios.csv');
	$numero = count($csv);
	return $numero + 1;
}

/**
 * Funcion para crear nuevos usuarios. Tambien hace llamada al resto de funciones referente a la creacion del usuario
 * @param mixed $id
 * @param mixed $nombre
 * @param mixed $password
 * @param mixed $privilegio
 * @return bool
 */
function create_new_user($id, $nombre, $privilegio, $picture_profile)
{
	$csv = csvtoarray('../../csv/usuarios.csv');
	$password_hash = password_hash($nombre, PASSWORD_DEFAULT);
	$csv[] = array($id, $nombre, $password_hash, '', $privilegio);
	$fp = fopen('../../csv/usuarios.csv', 'w');
	if ($fp === false) {
		return false;
	}
	foreach ($csv as $row) {
		if (fputcsv($fp, $row) === false) {
			fclose($fp);
			return false;
		}
	}
	fclose($fp);
	// Crear la carpeta para las imágenes del usuario
	create_directory_img($id, $nombre);
	// Guardar la imagen de perfil del usuario
	saveImage($id, $nombre, $picture_profile);
	// Crear los datos del usuario
	create_new_datos($id, $nombre);
	// Guardar la URL de la imagen de perfil
	insertURL($nombre, $id);
	return true;
}

/**
 * Funcion para modificar usuarios
 * @param mixed $id
 * @param mixed $nombre
 * @param mixed $password
 * @param mixed $privilegio
 * @return void
 */
function modify_user($id, $nombre, $password)
{
	$csv = csvtoarray('../../csv/usuarios.csv');
	$fp = fopen('../../csv/usuarios.csv', 'w');
	foreach ($csv as $i => $row) {
		if ($row[0] == $id) {
			$csv[$i][1] = $nombre;
			$csv[$i][2] = $password;
		}
		fputcsv($fp, $csv[$i]);
	}
	fclose($fp);
}

/**
 * Funcion para modificar datos de usuarios
 * @param mixed $id
 * @param mixed $nombre
 * @param mixed $password
 * @param mixed $privilegio
 * @return void
 */
function modify_datos($id, $nombre)
{
	$csv = array_map('str_getcsv', file('../../csv/datos_usuarios.csv'));
	$fp = fopen('../../csv/datos_usuarios.csv', 'w');
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			$row[1] = $nombre;
		}
		fputcsv($fp, $row);
	}
	fclose($fp);
}

/**
 * Funcion para modificar imagen de usuarios
 * @param mixed $id
 * @param mixed $nombre
 * @param mixed $password
 * @param mixed $privilegio
 * @return void
 */
function modify_imagen($id, $imagen)
{
	$csv = array_map('str_getcsv', file('../../csv/usuarios.csv'));
	$fp = fopen('../../csv/usuarios.csv', 'w');
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			$row[3] = $imagen;
		}
		fputcsv($fp, $row);
	}
	fclose($fp);
}

/**
 * Funcion para crear nuevos datos de usuarios
 * @param mixed $id
 * @param mixed $nombre
 * @param mixed $password
 * @param mixed $privilegio
 * @return void
 */
function create_new_datos($id, $nombre)
{
	chmod('../../csv/datos_usuarios.csv', 0777);
	$csv = csvtoarray('../../csv/datos_usuarios.csv');
	$csv[] = array($id, $nombre, 0, 0);
	$fp = fopen('../../csv/datos_usuarios.csv', 'w');
	foreach ($csv as $row) {
		fputcsv($fp, $row);
	}
	fclose($fp);
}

/**
 * Devuelve el numero de usuarios
 * @return int
 */
function num_users()
{
	$csv = csvtoarray('./csv/usuarios.csv');
	$numero = count($csv);
	return $numero;
}

/**
 * Funcion que comprueba si existe un usuario en el csv usuarios
 * @param mixed $nombre
 * @return bool
 */
function comprobar_nombre($nombre)
{
	$csv = csvtoarray('../../csv/usuarios.csv');
	$existe = false;
	foreach ($csv as $row) {
		if ($row[1] == $nombre) {
			$existe = true;
		}
	}
	return $existe;
}

/**
 * devuelve la imagen de un usuario concreto
 * @param mixed $archivo
 * @param mixed $login
 * @return mixed
 */
function imagen_usuario($archivo, $login)
{
	$csv = csvtoarray($archivo);
	foreach ($csv as $row) {
		if ($row[1] == $login) {
			return $row[3];
		}
	}
}

/**
 * funcion que inserta la direccion de la imagen de perfil de un usuario
 * @param mixed $nombre
 * @param mixed $idUser
 * @return void
 */
function insertURL($nombre, $idUser)
{
	$file_path = 'assets/pictureProfile/' . $idUser . "_" . $nombre . "/profile.jpg";
	$csv = csvtoarray('../../csv/usuarios.csv');
	$fp = fopen('../../csv/usuarios.csv', 'w');
	foreach ($csv as $i => $row) {
		if ($row[0] == $idUser) {
			$csv[$i][3] = $file_path;
		}
		fputcsv($fp, $csv[$i]);
	}
}

/**
 * funcion que devuelve el nombre de un usuario
 * @param mixed $id
 * @return mixed
 */
function nombre_usuario($id)
{
	$csv = csvtoarray('../../csv/usuarios.csv');
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			return $row[1];
		}
	}
}

/**
 * Funcion que se utiliza para cambiar la contraseña de un usuario
 *
 * @param [type] $nombre
 * @param [type] $password
 * @return void
 */
function change_pass($nombre, $password)
{
	$csv = csvtoarray('../../csv/usuarios.csv');
	$fp = fopen('../../csv/usuarios.csv', 'w');
	foreach ($csv as $i => $row) {
		if ($row[1] == $nombre) {
			$csv[$i][2] = password_hash($password, PASSWORD_DEFAULT);
		}
		fputcsv($fp, $csv[$i]);
	}
}

/**
 * funcion que devuelve el privilegio de un usuario
 * @param mixed $id
 * @return mixed
 */
function privilegio_usuario($nombre)
{
	$csv = csvtoarray('./csv/usuarios.csv');
	foreach ($csv as $row) {
		if ($row[1] == $nombre) {
			return $row[4];
		}
	}
}

/**
 * Funcion que actualiza los datos del tecnico del fichero moviles
 * @param mixed $antiguo_nombre
 * @param mixed $nuevo_nombre
 * @return void
 */
function actualizar_tecnico($antiguo_nombre, $nuevo_nombre)
{
	$csv = csvtoarray('../../csv/moviles.csv');
	$fp = fopen('../../csv/moviles.csv', 'w');
	foreach ($csv as $i => $row) {
		if ($row[9] == $antiguo_nombre) {
			$csv[$i][9] = $nuevo_nombre;
		}
		fputcsv($fp, $csv[$i]);
	}
}

/**
 * Funcion que devuelve el ID de un trabajador
 */
function id_user($nombre){
	$csv = csvtoarray('csv/usuarios.csv');
	foreach ($csv as $row) {
		if ($row[1] == $nombre) {
			return $row[0];
		}
	}
}

/**
 * funcion que devuelve el nombre de un usuario
 * @param mixed $id
 * @return mixed
 */
function nombre_tecnico($id)
{
	$csv = csvtoarray('csv/usuarios.csv');
	foreach ($csv as $row) {
		if ($row[0] == $id) {
			return $row[1];
		}
	}
}
