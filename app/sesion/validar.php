<?php
/**
 * @author Fer De La Cruz
 */
	session_destroy();
	ini_set('session.cookie_httponly',1);
	set_time_limit(3600);
	
	include ('conector.php');

// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
// Si no conserva su valor normal
	$objeto = (empty($objeto)) ? $_REQUEST : $objeto;
		
// Instanciamos la conexion a la DB
	$objet_conexion = new Connection();
	
// Funcion anti Hack
	foreach ($objeto as $key => $value) {
		$datos[$key] = $objet_conexion->escapar($value);
	}
	
	$datos['pass'] = $objet_conexion->encriptar($datos['pass']);
	
// Consulta los datos del usuario
	if (!empty($datos['usuario']) && !empty($datos['pass'])) {
		$sql = "	SELECT
						id, nombre, tipo, status
					FROM
						usuarios_hoja
					WHERE
						mail = '".$datos['usuario']."'
					OR
						tel = '".$datos['usuario']."'
					AND
						pass = '".$datos['pass']."'";
		$result = $objet_conexion->queryArray($sql);
		
		if ($result['total'] > 0) {
		// Valida que no este eliminado
			if ($result['rows'][0]['status'] == 2) {
				echo "<script>
						alert('Tu usuario ha sido eliminado. Para recuperarlo ponte en contacto con el administrador');
						window.location.href = 'login.php';
						</script>";
				// header('Location: login.php');
				return 0;
			}
		
		// Todo bien :D, crea la variable de session y entra al index
			session_start();
			$_SESSION['usuario'] = $result['rows'][0];
			
			header('Location: ../../index.php');
			// echo "	<script>
						// window.location.href = '../../index.php';
					// </script>";
		}else{
			echo "	<script>
						alert('Datos incorrectos');
						window.location.href = 'login.php';
					</script>";
			
			// header('Location: login.php');
			return 0;
		}
	}
?>