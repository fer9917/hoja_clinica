<button class="btn btn-primary" onclick="$('#agregar_usuarios').click();">
	<i class="fa fa-plus"></i> Nuevo
</button>
<br /><br />
<?php
// Valida que existan usuarios en los parametros seleccionadas
	if (empty($usuarios)) { ?>
		<div align="center">
			<h3><span class="label label-default">* No tienes usuarios *</span></h3>
		</div><?php
		
		return 0;
	} 
?>
<table class="table table-bordered table-striped">
	<tr>
		<td><strong><i class="fa fa-user"></i></strong></td>
		<td><strong><i class="fa fa-envelope-o"></i></strong></td>
		<td><strong><i class="fa fa-phone"></i></strong></td>
		<td><strong><i class="fa fa-unlock"></i></strong></td>
		<td align="center"><strong><i class="fa fa-list"></i></strong></td>
		<td align="center" nowrap="1"><strong><i class="fa fa-check"></i> / <i class="fa fa-trash"></i></strong></td>
	</tr><?php
	foreach ($usuarios as $key => $value) { ?>
		<tr id="tr_<?php echo $value['id'] ?>">
			<td>
				<input 
					class="form-control"
					style="width: 150px"
					type="text" value="<?php echo $value['nombre'] ?>" 
					onchange="usuarios.editar({id:<?php echo $value['id'] ?>, id_excluido:<?php echo $value['id'] ?>})" 
					id="nombre_<?php echo $value['id'] ?>" />
			</td>
			<td>
				<input 
					class="form-control"
					style="width: 220px"
					type="mail" value="<?php echo $value['mail'] ?>" 
					onchange="usuarios.editar({id:<?php echo $value['id'] ?>, id_excluido:<?php echo $value['id'] ?>})" 
					id="mail_<?php echo $value['id'] ?>" />
			</td>
			<td>
				<input 
					class="form-control"
					style="width: 120px"
					type="number" value="<?php echo $value['tel'] ?>" 
					onchange="usuarios.editar({id:<?php echo $value['id'] ?>, id_excluido:<?php echo $value['id'] ?>})"
					id="tel_<?php echo $value['id'] ?>" />
			</td>
			<td>
				<button 
					class="btn btn-default"
					data-toggle="modal" 
					data-target="#modal_cambiar_pass" 
					onclick='$("#id_cambiar_pass").val(<?php echo $value['id'] ?>)'>
					<i class="fa fa-unlock"></i>
				</button>
			</td>
			<td align="center">
				<button type="button" class="btn btn-primary" onclick='usuarios.editar_permisos({id:<?php echo $value['id'] ?>})'>
					<i class="fa fa-list"></i>
				</button>
			</td>
			<td align="center" style="width: 100px"><?php
				if ($value['status'] == 1) { ?>
					<button type="button" class="btn btn-danger" onclick="usuarios.eliminar({id:<?php echo $value['id'] ?>})">
						<i class="fa fa-trash"></i>
					</button><?php
					
				} else { ?>
					<button type="button" class="btn btn-success" onclick="usuarios.activar({id:<?php echo $value['id'] ?>})">
						<i class="fa fa-check"></i>
					</button><?php
				} ?>
			</td>
		</tr><?php
	} ?>
</table>
<!-- Modal cambiar contraseña-->
<div class="modal fade" id="modal_cambiar_pass" tabindex="-1" role="dialog" aria-labelledby="titulo_cambiar_pass">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button id="btn_cerrar_cambiar_pass" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="titulo_cambiar_pass">Cambiar contraseña</h4>
			</div>
			<div class="modal-body">
				<input readonly="1" id="id_cambiar_pass" type="text" class="form-control" style="visibility:hidden" />
				<blockquote style="font-size: 14px">
			    	<p>
			      		Esta funcion <strong>Cambia la contraseña</strong> del usuario. Introduce la nueva contraseña
			      		en el primer recuadro y repitela en el segundo para confirmarla, despues preciona 
			      		<strong>cambiar</strong>.
			    	</p>
			    </blockquote>
				<div class="row">
					<div class="col-md-6">
						<div class="input-group input-group-lg">
							<span class="input-group-addon"> <i class="fa fa-lock"></i> </span>
							<input 
								autocomplete="off"
								id="pass_nuevo" 
								type="password" 
								class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="input-group input-group-lg">
							<span class="input-group-addon">
								<i class="fa fa-check"></i> <i class="fa fa-lock"></i> 
							</span>
							<input 
								autocomplete="off"
								id="pass_nuevo2" 
								type="password" 
								class="form-control" />
						</div>
					</div>
				</div>
			</div>
		<!-- Botones -->
			<div class="modal-footer">
				<button 
					id="btn_cambiar_pass" 
					type="button"
					class="btn btn-primary"  
					onclick="usuarios.cambiar_pass({id:$('#id_cambiar_pass').val(), pass:$('#pass_nuevo').val(), pass2:$('#pass_nuevo2').val()})">
					<i class="fa fa-check"></i> Cambiar
				</button>
			</div>
		</div>
	</div>
</div>
<!-- FIN Modal pass-->