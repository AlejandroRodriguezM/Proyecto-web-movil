<?php
//destroy cookies and session
require_once 'php/funciones/funciones.php';
require_once 'php/funciones/funciones_csv.php';
destroyCookiesUser();
header('Location: login.php');
?>