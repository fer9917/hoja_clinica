<?php
/**
 * @author Fer De La Cruz
 */
class usuariosModel extends Connection {
///////////////// ******** ---- 		guardar		------ ************ //////////////////
//////// Guarda la informacion en la DB
	// Como parametros recibe:
		// url -> Direccion de la imagen
		// titulo -> el titulo de la imagen
		// descripcion -> descripcion de la imagen

	function guardar($objeto) {
	// Funcion anti Hack
		foreach ($objeto as $key => $value) {
			$datos[$key] = $this -> escapar($value);
		}

		$datos['pass'] = $this -> encriptar($datos['pass']);

		$sql = "	SELECT
						mail
					FROM
						usuarios
					WHERE
						mail = '".$datos['mail']."'
					OR
						tel = '".$datos['tel']."'";
		$result = $this -> queryArray($sql);

		if ($result['total'] > 0) {
			$result = 0;
		} else {
			$sql = "	INSERT INTO
							usuarios
							(nombre, mail, pass, tel, tipo)
						VALUES
							('".$datos['nombre']."', '".$datos['mail']."', '".$datos['pass']."', '".$datos['tel']."', ".$datos['tipo'].")";
			// return $sql;
			$result = $this -> query($sql);
		}

		return $result;
	}

///////////////// ******** ---- 		FIN guardar		------ ************ //////////////////

///////////////// ******** ---- 		listar		------ ************ //////////////////
//////// Consulta los usuarios y los agrega a la div
	// Como parametros recibe:
	// div -> div donde se cargara el contenido
	// id -> id del usuario

	function listar($objeto) {
		// Filtra por ID si existe
		$condicion .= (!empty($objeto['id']) && empty($objeto['id_excluido'])) ? ' AND id = '.$objeto['id'] : '';
		// Excluye el ID del usuario(esto nos sirve al momento de editar)
		$condicion .= (!empty($objeto['id_excluido'])) ? ' AND id != '.$objeto['id'] : '';
		// Filtra por el tipo si existe, si no, no muestra los super usuarios(-1)
		$condicion .= (!empty($objeto['tipo'])) ? ' AND tipo = '.$objeto['tipo'] : ' AND tipo != -1';
		// Filtra por mail y/o telefono
		$condicion .= (!empty($objeto['mail']) || !empty($objeto['tel'])) ? ' AND (mail = \''.$objeto['id'].'\' OR tel = \''.$objeto['tel'].'\')' : '';

		$sql = "
				SELECT
					*
				FROM
					usuarios
				WHERE
					1=1".$condicion;
		$result = $this -> queryArray($sql);

		return $result;
	}

///////////////// ******** ---- 	FIN	listar		------ ************ //////////////////

///////////////// ******** ---- 		editar		------ ************ //////////////////
//////// Actualiza  la informacion  del usuario en la DB
	// Como parametros recibe:
	// mail -> mail del usuario
	// pass -> pass del usuario
	// tel -> numero de telefono
	// campa -> campañia
	// cumple -> cumpleaños

	function editar($objeto) {
		// Funcion anti Hack
		foreach ($objeto as $key => $value) {
			$datos[$key] = $this -> escapar($value);
		}

		$sql = "	UPDATE
						usuarios
					SET
						mail = '".$datos['mail']."',
						tel = '".$datos['tel']."',
						nombre = '".$datos['nombre']."'
					WHERE
						id = '".$datos['id']."'";
		// return $sql;
		$result = $this -> query($sql);

		return $result;
	}

///////////////// ******** ---- 		FIN editar		------ ************ //////////////////

///////////////// ******** ---- 		eliminar		------ ************ //////////////////
//////// Elimina el usuario de la BD
	// Como parametros recibe:
	// id -> ID del usuario

	function eliminar($objeto) {
		$sql = "	UPDATE
						usuarios
					SET
						status = 2
					WHERE
						id = '".$objeto['id']."'";
		// return $sql;
		$result = $this -> query($sql);

		return $result;
	}

///////////////// ******** ---- 		FIN eliminar		------ ************ //////////////////

///////////////// ******** ---- 		iniciar_sesion		------ ************ //////////////////
//////// Consulta si el usuario tiene permisos para ver, si es asi carga la lista del empleados
	// Como parametros recibe:
	// mail -> mail del usuario
	// pass -> contraseña

	function iniciar_sesion($objeto) {
		// Funcion anti Hack
		foreach ($objeto as $key => $value) {
			$datos[$key] = $this -> escapar($value);
		}

		$sql = "
				SELECT
					*
				FROM
					t_admin
				WHERE
					mail='".$datos['mail']."'
				AND
					pass='".$datos['pass']."'";
		// return $sql;
		$result = $this -> queryArray($sql);

		return $result;
	}

///////////////// ******** ---- 	FIN	iniciar_sesion		------ ************ //////////////////

///////////////// ******** ---- 			cambiar_pass		------ ************ //////////////////
//////// Cambia la contraseña del usuario
	// Como parametros recibe:
	// id -> ID del usuario
	// pass -> contraseña
	// pass2 -> Confirmacion de contraseña

	function cambiar_pass($objeto) {
		// Funcion anti Hack
		foreach ($objeto as $key => $value) {
			$datos[$key] = $this -> escapar($value);
		}

		$datos['pass'] = $this -> encriptar($datos['pass']);

		$sql = "	UPDATE
						usuarios
					SET
						pass = '".$datos['pass']."'
					WHERE
						id = '".$datos['id']."'";
		// return $sql;
		$result = $this -> query($sql);

		return $result;
	}

///////////////// ******** ---- 		FIN cambiar_pass		------ ************ //////////////////

///////////////// ******** ---- 			activar				------ ************ //////////////////
//////// Cambia el status al usuario en la BD a activado
	// Como parametros recibe:
	// id -> ID del usuario

	function activar($objeto) {
		$sql = "	UPDATE
						usuarios
					SET
						status = 1
					WHERE
						id = '".$objeto['id']."'";
		// return $sql;
		$result = $this -> query($sql);

		return $result;
	}

///////////////// ******** ---- 		FIN activar				------ ************ //////////////////

}
?>