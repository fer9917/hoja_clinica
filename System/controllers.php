<?php
/**
 * @author Fer De La Cruz
 */
 
// Carga el controlador que se manda llamar desde la url. El archivo php y el controlador deben llamarse igual.

@$controller_file = strtolower($_GET['c']);

require('common.php');
require("DB/conector.php"); // funciones mySQL

$ruta = '';

session_start();
// Valida el inicio de session
if (!$_SESSION['usuario']['id'] || !$_SESSION['usuario']['nombre']) {
	header('Location: app/sesion/login.php');
}else{
	$ruta = 'Public/';
}

$url = $ruta.$controller_file.'/controllers/'.$controller_file.'.php';

if (isset($_GET['c']) && file_exists($url)) {
	require_once $ruta.$controller_file.'/controllers/'.$controller_file.'.php';
	$controller = new $_GET['c']();
}else{
	$mensaje = 'Controlador no encontrado: '.$controller_file;
	print_r($mensaje);
	return $mensaje;
}

?>