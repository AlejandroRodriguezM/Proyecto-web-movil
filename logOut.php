<?php
//destroy cookies and session
require_once 'php/funciones/funciones.php';
require_once 'php/funciones/funciones_csv.php';
session_start();
session_destroy();
destroyCookiesUser();
header('Location: login.php');
