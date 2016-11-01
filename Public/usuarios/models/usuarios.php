<?php
/**
 * @author Fer De La Cruz
 */
class usuariosModel extends Connection {
///////////////// ******** ---- 			guardar				------ ************ //////////////////
//////// Guarda la informacion en la DB
	// Como parametros puede recibir:
		// analisis -> string
		// diagnostico -> string
		// edad -> int
		// fecha -> dateTimeLocal
		// frecuencia_car -> int
		// frecuencia_res -> int
		// glicemia -> int
		// id -> int
		// impresion -> string
		// motivo_consulta -> string
		// nombre -> string
		// num_expediente -> int
		// objetivo -> string
		// peso -> decimal
		// plan -> string
		// servicio -> string
		// sexo -> 1 -> hombre, 2 -> mujer
		// subjetivo -> string
		// suturacion -> int
		// temperatura -> int
		// tension -> int

	function guardar($objeto) {
	// Funcion anti Hack
		foreach ($objeto as $key => $value) {
			$datos[$key] = $this -> escapar($value);
		}
	
	// Valida que exista el paciente
		if (empty($datos['id'])) {
			$sql = "INSERT INTO
						pacientes(nombre, sexo)
					VALUES
						('".$datos['nombre']."', '".$datos['sexo']."')";
			$datos['id'] = $this -> insert_id($sql);
		}
		
		$sql = "INSERT INTO
					hojas
					(id_paciente, edad, diagnostico, servicio, num_expediente, fecha, peso, talla, frecuencia_car, 
					frecuencia_res, temperatura, tension_art, saturacion, glicemia, motivo_consulta, subjetivo, objetivo, analisis, 
					impresion, plan)
				VALUES
					('".$datos['id']."', '".$datos['edad']."', '".$datos['diagnostico']."', '".$datos['servicio']."', 
					'".$datos['num_expediente']."', '".$datos['fecha']."', '".$datos['peso']."', '".$datos['talla']."', 
					'".$datos['frecuencia_car']."', '".$datos['frecuencia_res']."', '".$datos['temperatura']."', 
					'".$datos['tension_art']."', '".$datos['saturacion']."', '".$datos['glicemia']."', '".$datos['motivo_consulta']."', 
					'".$datos['subjetivo']."', '".$datos['objetivo']."', '".$datos['analisis']."', '".$datos['impresion']."', 
					'".$datos['plan']."')";
		// return $sql;
		$result = $this -> query($sql);

		return $result;
	}

///////////////// ******** ---- 			FIN guardar				------ ************ //////////////////

///////////////// ******** ---- 			listar					------ ************ //////////////////
//////// Consulta los usuarios y los agrega a la div
	// Como parametros recibe:
		// div -> div donde se cargara el contenido
		// id -> id del usuario
		// json -> 1 -> si tenie que devolver un json, 0 -> todo normal

	function listar($objeto) {
	// Filtra por ID si existe
		$condicion .= (!empty($objeto['id']) && empty($objeto['id_excluido'])) ? ' AND p.id = '.$objeto['id'] : '';
	// Excluye el ID del usuario(esto nos sirve al momento de editar)
		$condicion .= (!empty($objeto['id_excluido'])) ? ' AND p.id != '.$objeto['id'] : '';
		
	// Excluye el ID del usuario(esto nos sirve al momento de editar)
		$condicion .= (!empty($objeto['palabras'])) ? ' AND p.id != '.$objeto['id'] : '';

		$sql = "SELECT
					CONCAT('[', p.id, '] ', p.nombre) AS nombre_paciente, p.id, p.nombre, p.sexo, h.edad, 
					h.diagnostico, h.servicio, h.num_expediente, h.peso, h.talla, h.frecuencia_car, h.frecuencia_res, 
					h.temperatura, h.tension_art, h.saturacion, h.glicemia, h.motivo_consulta, h.subjetivo, h.objetivo, 
					h.analisis, h.impresion, h.plan
				FROM
					pacientes p
				LEFT JOIN
						hojas h
					ON
						h.id_paciente = p.id
				WHERE
					1=1".
				$condicion."
				GROUP BY
					p.id
				ORDER BY
					p.nombre ASC";
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