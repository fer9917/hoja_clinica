<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Entrar</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" type="image/png" href="../imagenes/favicon.png" />
<!--/////////////// ***** ------			 CSS 			------ ***** ///////////////-->

		<link href="../../System/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<style type="text/css">
            .vertical-offset-100 {
                padding-top: 100px;
            }
		</style>
		
<!--/////////////// ***** ------			 CSS 			------ ***** ///////////////-->

<!--/////////////// ***** ------			 JS 			------ ***** ///////////////-->

		<script src="../../System/plugins/jquery.min.js"></script>
		<script src="../../System/plugins/bootstrap/dist/js/bootstrap.min.js"></script>

<!--/////////////// ***** ------			 JS 			------ ***** ///////////////-->
	</head>
	<body background="../imagenes/fondo.png">
		<div class="container">
			<div class="row vertical-offset-100">
				<div class="col-md-4 col-md-offset-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2 class="panel-title">Login</h2>
						</div>
						<div class="panel-body">
							<form accept-charset="UTF-8" action="validar.php">
								<fieldset>
									<div class="form-group">
										<input class="form-control input-lg" placeholder="mail o telefono" name="usuario" type="text">
									</div>
									<div class="form-group">
										<input class="form-control input-lg" placeholder="Pass" name="pass" type="password" value="">
									</div>
									<input class="btn btn-lg btn-success btn-block" type="submit" value="Ok">
								</fieldset>
							</form>
						</div>
						<div class="panel-footer">
							<a href="#">Recuperar contraseña</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>