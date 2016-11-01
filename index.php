<?php
// Desactivar toda notificación de error
error_reporting(0);
ini_set("display_errors", 1);

include 'System/seguridad.php';

date_default_timezone_set('America/Mexico_City');
?>
<html>
	<head>
		<title>Hoja clinica</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="app/imagenes/favicon.png" />
	</head>
<!--/////////////// ***** ------			 CSS 			------ ***** ///////////////-->

<!-- bootstrap -->
	<link rel="stylesheet" href="System/plugins/bootstrap/dist/css/bootstrap-theme.min.css" type="text/css" />
	<link rel="stylesheet" href="System/plugins/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
<!-- fileinput -->
	<link href="System/plugins/bootstrap-fileinput-master/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<!-- font-awesome -->
	<link rel="stylesheet" href="System/plugins/font-awesome/css/font-awesome.min.css" type="text/css" />
<!-- jquery-ui -->
	<link rel="stylesheet" href="System/plugins/jquery-ui/jquery-ui.min.css" type="text/css" />
<!-- bootstrap-select -->
	<link rel="stylesheet" href="System/plugins/bootstrap-select-1.9.3/dist/css/bootstrap-select.min.css">
<!-- dataTables  -->
    <link rel="stylesheet" href="System/plugins/dataTable/css/datatablesboot.min.css">
<!-- typeahead -->
    <link rel="stylesheet" href="System/plugins/typeahead/typeahead.css">

<!--/////////////// ***** ------			 FIN CSS 			------ ***** ///////////////-->

<!--/////////////// ***** ------			 JS 			------ ***** ///////////////-->

<!-- JQuery-->
	<script src="System/plugins/jquery.min.js"></script>
<!-- JQuery-ui -->
	<script src="System/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- fileinput -->
	<script src="System/plugins/bootstrap-fileinput-master/js/fileinput.min.js"></script>
<!-- bootstrap -->
	<script src="System/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- bootstrap-select  -->
	<script src="System/plugins/bootstrap-select-1.9.3/dist/js/bootstrap-select.min.js"></script>
<!-- notify -->
	<script src="System/plugins/notify.js"></script>
<!-- dataTables  -->
	<script src="System/plugins/dataTable/js/datatables.min.js"></script>
	<script src="System/plugins/dataTable/js/dataTables.bootstrap.min.js"></script>
<!-- typeahead -->
	<script src="System/plugins/typeahead/typeahead.js"></script>

<!-- Systema -->
	<script src="Public/usuarios/js/usuarios.js"></script>

<!--/////////////// ***** ------			 	FIN JS 			------ ***** ///////////////-->
	<body>
		<div id="menu">
			<ul class="nav nav-tabs responsive" id="tabs">
				<li><a id="agregar_usuarios" href="#div_usuarios" onclick="usuarios.add({div: 'div_usuarios'})">Agregar</a></li>
				<li><a id="listar_usuarios" href="#div_usuarios" onclick="usuarios.listar({div: 'div_usuarios'})">Editar</a></li>
			</ul>
		</div>
		<div class="container" style="padding: 1%">
			<div class="row">
				<div class="col-md-12">
					<div class="tab-content responsive">
						<div class="tab-pane" id="div_usuarios">
							<!-- En esta div se carga el contenido de los usuarios -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script>
	$('#tabs a').click(function(e) {
		e.preventDefault()
		$(this).tab('show')
	})

// Carga la vista de agregar usuario
	$('#agregar_usuarios').click(); 
</script>