<?php

/**
 * Funcion que crea cookies para el usuario
 * @param mixed $user
 * @param mixed $password
 * @return void
 */
function cookiesUser($user, $password)
{
	setcookie('loginUser', $user, time() + 3600, '/');
	setcookie('passwordUser', $password, time() + 3600, '/');
}

/**
 * Funcion que crea cookies para el administrador
 * @param mixed $user
 * @return void
 */
function cookiesUserAdmin($user)
{
	setcookie('adminUser', $user, time() + 3600, '/');
}

/**
 * Funcion que destruye las cookies
 * @return void
 */
function destroyCookiesUser()
{
	setcookie('loginUser', '', time() - 3600, '/');
	setcookie('passwordUser', '', time() - 3600, '/');
	setcookie('adminUser', '', time() - 3600, '/');
	echo '<script type="text/JavaScript"> 
	localStorage.clear();
 </script>';
}

/**
 * Funcion que comprueba si existe tanto cookie como session de un usuario
 * @return void
 */
function checkCookiesUser()
{
	if (!isset($_SESSION['user']) || !isset($_COOKIE['loginUser'])) {
		echo '<script type="text/JavaScript"> 
		localStorage.clear();
     </script>';
		die("Error. You are not logged <a href='logOut.php'>Log in</a>");
	}
}

/**
 * Function that is used to check that reserved words cannot be saved
 *
 * @return array
 */
function reservedWords()
{
	$palabras = array(
		"select", "insert", "update", "delete", "drop", "alter", "create", "table", "from", "where",
		"and", "or", "not", "like", "in", "between", "is", "null", "asc", "desc", "into", "values", "set", "show",
		"database", "databases", "use", "grant", "revoke", "index", "primary", "key", "foreign", "references", "on",
		"order", "by", "group", "having", "limit", "union", "all", "distinct", "case", "when", "then", "else", "end",
		"count", "sum", "avg", "min", "max", "top", "union", "all", "distinct", "case", "when", "then", "else", "end",
		"count", "sum", "avg", "min", "max", "top", "truncate", "procedure", "function", "declare", "exec", "xp_cmdshell",
		"sp_", "sysobjects", "syscolumns", "sysusers", "sysindexes", "sysconstraints", "syscomments", "sysdepends",
		"sysfiles", "sysgroups", "sysprocesses", "sysprotects", "sysservers", "sysstatistics", "sysviews", "syssegments",
		"sysalternates", "sysconfigures", "sysdepends", "sysfilegroups", "sysfiles1", "sysfiles2", "sysforeignkeys",
		"sysfulltextcatalogs", "sysfulltextnotify", "sysindexes", "sysindexkeys", "sysmembers", "sysobjects", "syspermissions",
		"sysproperties", "sysreferences", "syssegments", "syssubsystems", "systypes", "sysusers", "sysxmlindexes", "sysxmlnodes",
		"sysxmlschemas", "sysxmltypes", "syscolumns", "syscomments", "sysdepends", "sysfiles", "sysfiles1", "sysfiles2",
		"sysfulltextcatalogs", "sysfulltextnotify", "sysindexes", "sysindexkeys", "sysmembers", "sysobjects", "syspermissions",
		"sysproperties", "sysreferences", "syssegments", "syssubsystems", "systypes", "sysxmlindexes", "sysxmlnodes", "sysxmlschemas",
		"sysxmltypes", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell",
		"xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite",
		"xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree",
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell",
		"xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite",
		"xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree",
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell",
		"xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite",
		"xp_fileexist", "xp_dirtree", "xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree",
		"xp_filelist", "xp_cmdshell", "xp_regread", "xp_regwrite", "xp_fileexist", "xp_dirtree", "xp_filelist" . "puto", "gilipollas",
		"cabron", "cabrona", "cabronazo", "idiota", "pringado", "tonto", "tonta"
	);
	return $palabras;
}

/**
 * Funcion que genera un numero de factura aleatorio
 * @return string
 */
function createInvocieNumer()
{
	$number = rand(100000, 999999);
	$letter = chr(rand(65, 90));
	$number = $letter . $number;
	return $number;
}

/**
 * funcion que devuelve la direccion de la imagen de perfil de la persona loogueada
 * @param mixed $archivo
 * @param mixed $login
 * @return mixed
 */
function pictureProfile($archivo, $login)
{
	$profilePicture = imagen_usuario($archivo, $login);
	return $profilePicture;
}

/**
 * Funcion que guarda la nueva imagen de perfil
 * @param mixed $idUser
 * @param mixed $nombre
 * @param mixed $image
 * @return void
 */
function saveImage($idUser, $nombre, $image)
{
	if (empty($image)) {
		$pathDefault = '../../assets/pictureProfile/default/default.jpg';
		$type = pathinfo($pathDefault, PATHINFO_EXTENSION);
		$data = file_get_contents($pathDefault);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);
	}
	$file_path = '../../assets/pictureProfile/' . $idUser . "_" . $nombre;
	$blob = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
	$file = fopen($file_path . "/profile.jpg", "w");
	fwrite($file, $blob);
	fclose($file);
}

/**
 * Funcion que crea el directorio de la imagen de perfil
 * @param mixed $id
 * @param mixed $nombre
 * @return void
 */
function create_directory_img($id, $nombre)
{
	$dir = '../../assets/pictureProfile/' . $id . '_' . $nombre;
	if (!file_exists($dir)) {
		mkdir($dir, 0777, true);
	}
}

/**
 * Funcion que elimina el directorio de la imagen de perfil
 * @param mixed $id
 * @param mixed $nombre
 * @return void
 */
function delete_directory($id, $nombre)
{
	$file_path = '../../assets/pictureProfile/' . $id . "_" . $nombre;
	if (file_exists($file_path)) {
		$files = glob($file_path . '/*');
		foreach ($files as $file) {
			if (is_file($file))
				unlink($file);
		}
		rmdir($file_path);
	}
}
