<?php
	$carpetaAdjunta = "../Public/productos/imagenes/";
	
	if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
	
		parse_str(file_get_contents("php://input"), $datosDELETE);
	
		$key = $datosDELETE['key'];
	
		unlink($carpetaAdjunta . $key);
	
		echo 0;
	}
?>
