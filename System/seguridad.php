<?php
/**
 * @author Fer De La Cruz
 */
 
// ** Valida que se inicie sesion
	session_start();
	if (!$_SESSION['usuario']['id'] || !$_SESSION['usuario']['nombre']) {
		header('Location: app/sesion/login.php');
	}
?>