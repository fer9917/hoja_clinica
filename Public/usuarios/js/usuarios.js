var usuarios = {
///////////////// ******** ---- 		add		------ ************ //////////////////
//////// Carga la vista para agregar un recuerdo
	// Como parametros recibe:
		// div -> div donde se cargara el contenido
		// funcion -> guardar, editar
		// id -> ID del empleado
	
	add : function($objeto) {
		console.log('---------> $objeto add');
		console.log($objeto);

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=add',
			type : 'post',
			dataType : 'html',
		}).done(function(resp) {
			console.log('---------> done add');
			console.log(resp);

			$('#' + $objeto['div']).html(resp);
			$('.selectpicker').selectpicker('refresh');
		}).fail(function(resp) {
			console.log('----------> fail add');
			console.log(resp);

			var $mensaje = 'Error al carga la vista';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'error',
			});

			return 0;
		});
	},


///////////////// ******** ---- 		FIN add		------ ************ //////////////////

///////////////// ******** ---- 		guardar		------ ************ //////////////////
//////// Guarda la informacion en la DB
// Como parametros recibe:
	// form -> formulario con los datos a guardar

	guardar : function($objeto) {
		console.log('---------> $objeto guardar');
		console.log($objeto);
		
		var $datos = {};
		var $requeridos = [];
		var error = 0;
		var $mensaje = 'Debes llenar los siguientes campos: \n';
		
	/* Validaciones
	=============================================================== */
	
	// obtiene los inputs y los recorre
		var $inputs = $('#' + $objeto.form+ ' :input');
		$inputs.each(function() {
			var required = $(this).attr('required');
			var valor = $(this).val();
			var id = this.id;

		// Valida que el campo no este vacio si es requerido
			if (required == 'required' && valor.length <= 0) {
				error = 1;

				$requeridos.push(id);
			}
			if(id){
				$datos[this.id] = $(this).val();
			}
		});
		
	// Forma el mensaje con los campos requeridos
		if ($requeridos.length > 0) {
			$.each($requeridos, function(index, value) {
				$mensaje += '-->' + this + ' \n';
			});
		}

	// Si hay algun error, manda un mensaje
		if (error == 1) {
			$("#btn_guardar_hoja").notify($mensaje, {
				position : "top left",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'warn',
			});
			
			return 0;
		}
		
	/* FIN Validaciones
	=============================================================== */

	// Loader en el boton OK
		var $btn = $('#btn_guardar_hoja');
		$btn.button('loading');

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=guardar',
			type : 'post',
			dataType : 'json',
		}).done(function(resp) {
			console.log('----------> reponse guardar');
			console.log(resp);

			$btn.button('reset');

		// Error: Manda un mensaje con el error
			if (resp['status'] == 2) {
				var $mensaje = 'El correo y/o telefono ya existen';

				$('#btn_guardar').notify($mensaje, {
					position : "top center",
					autoHide : true,
					autoHideDelay : 4000,
					className : 'error',
				});

				return 0;
			}

		// Todo bien
			var $mensaje = 'Datos guardado';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'success',
			});
		
		// Limpia los campos
			$('#agregar_usuarios').click();
		}).fail(function(resp) {
			console.log('----------> fail guardar');
			console.log(resp);

			$btn.button('reset');

		// Error: Manda un mensaje con el error
			if (resp['status'] == 2) {
				var $mensaje = 'Error al guardar los datos';

				$('#btn_guardar_hoja').notify($mensaje, {
					position : "top left",
					autoHide : true,
					autoHideDelay : 4000,
					className : 'error',
				});

				return 0;
			}
		});
	},

///////////////// ******** ---- 		FIN guardar		------ ************ //////////////////

///////////////// ******** ---- 		listar		------ ************ //////////////////
//////// Consulta los usuarios y los agrega a la div
	// Como parametros recibe:
		// div -> div donde se cargara el contenido	

	listar : function($objeto) {
		console.log('----------> $objeto listar');
		console.log($objeto);

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=listar',
			type : 'post',
			dataType : 'html',
		}).done(function(resp) {
			console.log('----------> reponse listar');
			console.log(resp);

			$('#' + $objeto['div']).html(resp);
		}).fail(function(resp) {
			console.log('----------> fail listar');
			console.log(resp);

			var $mensaje = 'Error al obtener los usuarios';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'error',
			});
		});
	},

///////////////// ******** ---- 		FIN listar		------ ************ //////////////////

///////////////// ******** ---- 		editar		------ ************ //////////////////
//////// Actualiza la informacion del usuario en la DB
	// Como parametros recibe:
		// form -> formulario con los datos a guardar
		// id -> ID del usuario.
		// id_excluido -> ID a excluir en la consulta(permite que no se repita el mail ni el tel en la edicion)

	editar : function($objeto) {
	// Captura los datos de la tabla de usuarios si no vienen directo de la funcion
		$objeto['nombre'] = (!$objeto['nombre']) ? $('#nombre_' + $objeto['id']).val() : $objeto['nombre'];
		$objeto['mail'] = (!$objeto['mail']) ? $('#mail_' + $objeto['id']).val() : $objeto['mail'];
		$objeto['tel'] = (!$objeto['tel']) ? $('#tel_' + $objeto['id']).val() : $objeto['tel'];

		console.log('---------> $objeto editar');
		console.log($objeto);

		var $errores = '';
		var $requerido = 0;

	// ** Validaciones
		$.each($objeto, function(index, val) {
			if (index == 'nombre') {
				if (val == null || val.length == 0 || /^\s+$/.test(val)) {
					$errores += '\n - Introduce un nombre';
				}
			}

			if (index == 'mail') {
				if (val == null || val.length == 0 || /^\s+$/.test(val)) {
					$requerido++;
				} else {
					if (!(/[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(val))) {
						$errores += '\n - Correo no valido';
					}
				}
			}
			
			if (index == 'tel') {
				if (val == null || val.length == 0 || /^\s+$/.test(val)) {
					$requerido++;
				} else {
					if (val.length != 10 || !(/^\d{10}$/.test(val))) {
						$errores += '\n - Telefono no valido';
					}
				}
			}
		});

	// Valida que exista el telefono o el correo
		if ($requerido > 1) {
			$.notify('Necesitas introducir un correo o un telefono', {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'warn',
			});

			return 0;
		}

	// Manda el mensaje de error
		if ($errores != '') {
			$.notify($errores, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'warn',
			});

			return 0;
		}
	// ** Fin validaciones
	
		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=editar',
			type : 'post',
			dataType : 'json',
		}).done(function(resp) {
			console.log('----------> reponse editar');
			console.log(resp);

		// Error: Manda un mensaje con el error
			if (resp['status'] == 2) {
				var $mensaje = 'El correo y/o telefono ya existen';

				$.notify($mensaje, {
					position : "top center",
					autoHide : true,
					autoHideDelay : 4000,
					className : 'error',
				});

				return 0;
			}

		// Todo bien :D
			var $mensaje = 'Datos guardados';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'success',
			});
		}).fail(function(resp) {
			console.log('----------> fail editar');
			console.log(resp);

			// Error: Manda un mensaje con el error
			if (resp['status'] == 2) {
				var $mensaje = 'Error al guardar los datos';

				$.notify($mensaje, {
					position : "top center",
					autoHide : true,
					autoHideDelay : 4000,
					className : 'error',
				});

				return 0;
			}
		});
	},

///////////////// ******** ---- 		FIN editar		------ ************ //////////////////

///////////////// ******** ---- 		eliminar		------ ************ //////////////////
//////// Elimina el usuario de la BD
	// Como parametros recibe:
		// id -> ID del usuario

	eliminar : function($objeto) {
		console.log('----------> $objeto eliminar');
		console.log($objeto);

	// Confirma la eliminacion
		if (confirm('¿Seguro que quieres eliminar?')) {
			$.ajax({
				data : $objeto,
				url : 'ajax.php?c=usuarios&f=eliminar',
				type : 'post',
				dataType : 'json',
			}).done(function(resp) {
				console.log('----------> done eliminar');
				console.log(resp);
				
			// Todo bien
				var $mensaje = 'Usuario eliminado';
				$.notify($mensaje, {
					position : "top center",
					autoHide : true,
					autoHideDelay : 4000,
					className : 'success',
				});
				
			// Lista los usuarios
				$('#listar_usuarios').click(); 
			}).fail(function(resp) {
				console.log('----------> fail eliminar');
				console.log(resp);
	
				var $mensaje = 'Error al eliminar el usuario';
				$.notify($mensaje, {
					position : "top center",
					autoHide : true,
					autoHideDelay : 4000,
					className : 'error',
				});
	
				return 0;
			});
		}
	},

	///////////////// ******** ---- 		FIN eliminar		------ ************ //////////////////

	///////////////// ******** ---- 		iniciar_sesion		------ ************ //////////////////
	//////// Consulta si el usuario tiene permisos para ver, si es asi carga la lista del empleados
	// Como parametros recibe:
	// mail -> mail del usuario
	// pass -> contraseña

	iniciar_sesion : function($objeto) {
		console.log('----------> $objeto iniciar_sesion');
		console.log($objeto);

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=iniciar_sesion',
			type : 'post',
			dataType : 'json',
			success : function(resp) {
				console.log('----------> reponse iniciar_sesion');
				console.log(resp);

				// Error: Manda un mensaje con el error
				if (!resp) {
					var $mensaje = 'Error al iniciar sesion';
					$('#' + $objeto['div']).notify($mensaje, {
						position : "top center",
						autoHide : true,
						autoHideDelay : 4000,
						className : 'error',
					});

					return 0;
				}

				// Sin permisos
				if (resp['status'] == 2) {
					var $mensaje = 'No tienes permisos';
					$('#btn_entrar').notify($mensaje, {
						position : "left",
						autoHide : true,
						autoHideDelay : 4000,
						className : 'error',
					});

					return 0;
				}

				// Todo bien :D
				if (resp['status'] == 1) {
					// Cierra la ventana modal
					$('#btn_cerrar_pass').click();

					// Lista los usuarios
					usuarios.listar({
						div : 'container'
					});
				}
			}
		});
	},

	///////////////// ******** ---- 		FIN iniciar_sesion		------ ************ //////////////////

///////////////// ******** ---- 				salir			------ ************ //////////////////
//////// Cierra la session y redirecciona al login
	// Como parametros recibe:

	salir : function($objeto) {
		console.log('----------> $objeto salir');
		console.log($objeto);

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=salir',
			type : 'post',
			dataType : 'json',
		}).done(function(resp) {
			console.log('----------> reponse salir');
			console.log(resp);

			window.location.href = 'app/sesion/login.php';
		}).fail(function(resp) {
			console.log('----------> fail salir');
			console.log(resp);

			var $mensaje = 'Error al salir';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'error',
			});

			return 0;
		});
	},
	
///////////////// ******** ---- 		FIN salir		------ ************ //////////////////

///////////////// ******** ---- 		cambiar_pass		------ ************ //////////////////
//////// Cambia la contraseña del usuario
// Como parametros recibe:
	// id -> ID del usuario
	// pass -> contraseña	
	// pass2 -> Confirmacion de contraseña
	
	cambiar_pass : function($objeto) {
		console.log('---------> $objeto cambiar_pass');
		console.log($objeto);

		var $errores = '';
		var $coinciden = '';

	// ** Validaciones
		$.each($objeto, function(index, val) {
		// Valida pass
			if (index == 'pass') {
				if (val == null || val.length == 0 || /^\s+$/.test(val)) {
					$errores += '\n - Introduce una contraseña';
				} else {
					$coinciden = val;
				}
			}

		// Valida pass
			if (index == 'pass2') {
				if (val == null || val.length == 0 || /^\s+$/.test(val)) {
					$errores += '\n - Confirma la contraseña';
				} else {
					if ($coinciden != val) {
						$errores += '\n - Las contraseñas no coinciden';
					}
				}
			}
		});

	// Manda el mensaje de error
		if ($errores != '') {
			$.notify($errores, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'warn',
			});

			return 0;
		}
	// ** Fin validaciones

	// Loader en el boton OK
		var $btn = $('#btn_cambiar_pass');
		$btn.button('loading');

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=cambiar_pass',
			type : 'post',
			dataType : 'json',
		}).done(function(resp) {
			console.log('----------> done cambiar_pass');
			console.log(resp);

			$btn.button('reset');

		// Todo bien
			var $mensaje = 'Datos guardados';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'success',
			});
			
			$('#btn_cerrar_cambiar_pass').click();
		}).fail(function(resp) {
			console.log('----------> fail cambiar_pass');
			console.log(resp);

			$btn.button('reset');
			
			var $mensaje = 'Error al guardar los datos';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'error',
			});

			return 0;
		});
	},

///////////////// ******** ---- 		FIN cambiar_pass		------ ************ //////////////////

///////////////// ******** ---- 			activar				------ ************ //////////////////
//////// Activa en usuario eliminado
	// Como parametros recibe:
		// id -> ID del usuario
	
	activar : function($objeto) {
		console.log('----------> $objeto activar');
		console.log($objeto);

		$.ajax({
			data : $objeto,
			url : 'ajax.php?c=usuarios&f=activar',
			type : 'post',
			dataType : 'json',
		}).done(function(resp) {
			console.log('----------> reponse activar');
			console.log(resp);

		// Todo bien
			var $mensaje = 'Usuario activado';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'success',
			});

		// Lista los usuarios
			$('#listar_usuarios').click(); 
		}).fail(function(resp) {
			console.log('----------> fail activar');
			console.log(resp);

			var $mensaje = 'Error al activar el uusuario';
			$.notify($mensaje, {
				position : "top center",
				autoHide : true,
				autoHideDelay : 4000,
				className : 'error',
			});

			return 0;
		});
	},

///////////////// ******** ---- 			FIN activar		------ ************ //////////////////

}; 