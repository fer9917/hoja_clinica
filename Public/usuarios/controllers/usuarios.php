<?php
/**
 * @author Fer De La Cruz
 */

// Desactivar toda notificación de error
error_reporting(0);
ini_set("display_errors", 1);

require ("Public/usuarios/models/usuarios.php");

class usuarios extends Common {
	public $usuariosModel;

	function __construct() {
		$this -> usuariosModel = new usuariosModel();
	}

///////////////// ******** ---- 	vista_principal			------ ************ //////////////////
//////// Carga la vista

	function add($objeto) {
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_REQUEST : $objeto;

		// Carga la vista donde se agrega un recuerdo
		require ('Public/usuarios/views/add.php');
	}

///////////////// ******** ---- 	FIN	vista_principal		------ ************ //////////////////

///////////////// ******** ---- 		guardar				------ ************ //////////////////
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
	// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
	// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_REQUEST : $objeto;
		
		$objeto['fecha'] = str_replace('T', ' ', $objeto['fecha']) . ':00';
		
	// Guarda los datos en la DB
		$resp['result'] = $this -> usuariosModel -> guardar($objeto);

		$resp['status'] = (!empty($resp['result'])) ? 1 : 2;

	// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 		FIN guardar				------ ************ //////////////////

///////////////// ******** ---- 		listar					------ ************ //////////////////
//////// Consulta los usuarios y los agrega a la div
	// Como parametros recibe:
		// div -> div donde se cargara el contenido
		// id -> id del usuario
		// json -> 1 -> si tenie que devolver un json, 0 -> todo normal

	function listar($objeto) {
	// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
	// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_REQUEST : $objeto;

	// Consulta los usuarios
		$usuarios = $this -> usuariosModel -> listar($objeto);
		$usuarios = $usuarios['rows'];
	
	// Valida si se debe de regresar un json en lugar de cargar la vista
		if ($objeto['json'] == 1) {
			echo json_encode($usuarios);

			return 0;
		}
		
	// Carga la vista donde se agrega un recuerdo
		require ('Public/usuarios/views/listar.php');
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
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_REQUEST : $objeto;

		// Valida que el correo o el numero de telefono no existan
		$usuarios = $this -> usuariosModel -> listar($objeto);
		if ($usuarios['total'] > 0) {
			$resp['status'] = 2;
			echo json_encode($resp);

			return 0;
		}

		// Guarda los datos en la DB
		$resp['result'] = $this -> usuariosModel -> editar($objeto);

		$resp['status'] = (!empty($resp['result'])) ? 1 : 0;

		// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 		FIN editar		------ ************ //////////////////

///////////////// ******** ---- 		eliminar		------ ************ //////////////////
//////// Elimina el usuario de la BD
	// Como parametros recibe:
	// id -> ID del usuario

	function eliminar($objeto) {
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_POST : $objeto;

		// Guarda los datos en la DB
		$resp['result'] = $this -> usuariosModel -> eliminar($objeto);

		$resp['status'] = (!empty($resp['result'])) ? 1 : 2;

		// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 		FIN eliminar		------ ************ //////////////////

///////////////// ******** ---- 		iniciar_sesion		------ ************ //////////////////
//////// Consulta si el usuario tiene permisos para ver, si es asi carga la lista del empleados
	// Como parametros recibe:
	// mail -> mail del usuario
	// pass -> contraseña

	function iniciar_sesion($objeto) {
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_POST : $objeto;

		// Guarda los datos en la DB
		$resp['result'] = $this -> usuariosModel -> iniciar_sesion($objeto);

		if ($resp['result']['total'] > 0) {
			$resp['status'] = 1;
		} else {
			$resp['status'] = 2;
		}

		// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 		FIN iniciar_sesion		------ ************ //////////////////

///////////////// ******** ---- 				salir			------ ************ //////////////////
//////// Cierra la session y redirecciona al login
	// Como parametros recibe:

	function salir($objeto) {
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_POST : $objeto;

		// Limpia la sesion
		session_start();
		$resp['status'] = (session_destroy()) ? 1 : 2;

		// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 			FIN salir			------ ************ //////////////////

///////////////// ******** ---- 			cambiar_pass		------ ************ //////////////////
//////// Cambia la contraseña del usuario
	// Como parametros recibe:
	// id -> ID del usuario
	// pass -> contraseña
	// pass2 -> Confirmacion de contraseña

	function cambiar_pass($objeto) {
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_REQUEST : $objeto;

		// Guarda los datos en la DB
		$resp['result'] = $this -> usuariosModel -> cambiar_pass($objeto);
		$resp['status'] = (!empty($resp['result'])) ? 1 : 0;

		// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 		FIN cambiar_pass		------ ************ //////////////////

///////////////// ******** ---- 			activar				------ ************ //////////////////
//////// Cambia el status al usuario en la BD a activado
	// Como parametros recibe:
	// id -> ID del usuario

	function activar($objeto) {
		// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
		// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_POST : $objeto;

		// Guarda los datos en la DB
		$resp['result'] = $this -> usuariosModel -> activar($objeto);

		$resp['status'] = (!empty($resp['result'])) ? 1 : 2;

		// Regresa al ajax el mensaje
		echo json_encode($resp);
	}

///////////////// ******** ---- 			FIN activar				------ ************ //////////////////

///////////////// ******** ---- 			imprimir_hoja			------ ************ //////////////////
//////// Imprime la hoja de con los datos de la consulta
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
		
	function imprimir_hoja($objeto) {
	// Si el objeto viene vacio(llamado desde el index) se le asigna el $_REQUEST que manda el Index
	// Si no conserva su valor normal
		$objeto = (empty($objeto)) ? $_REQUEST : $objeto;
		
		$objeto['sexo'] = ($objeto['sexo'] == 1) ? 'Hombre' : 'Mujer' ;
		
	// Carga la vista donde se agrega un recuerdo
		require ('Public/usuarios/views/imprimir_hoja.php');
	}

///////////////// ******** ---- 		FIN	imprimir_hoja			------ ************ //////////////////

}
?>