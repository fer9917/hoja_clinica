<?php
/**
 * @author Fer De La Cruz
 */
session_start();
if ($_SERVER['SERVER_NAME'] == 'localhost') {
	$servidor = 'localhost';
	$usuariobd = 'root';
	$clavebd = 'root';
	$bd = 'hoja_clinica';
} else {
	$servidor = 'mysql.hostinger.mx';
	$usuariobd = 'u767839180_jaraz';
	$clavebd = 'foreverfree';
	$bd = 'u767839180_veder';
}

?>