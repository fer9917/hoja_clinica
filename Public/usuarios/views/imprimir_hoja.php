<?php
// Valida que existan usuarios en los parametros seleccionadas
	if (empty($objeto)) { ?>
		<!-- <div align="center">
			<h5><span class="label label-default">* Sin datos *</span></h5>
		</div> --><?php
		
		// return 0;
	} 
?>
<link rel="stylesheet" href="System/plugins/bootstrap/dist/css/bootstrap-theme.min.css" type="text/css" />
<link rel="stylesheet" href="System/plugins/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
<div class="row">
	<div class="col-md-8" align="center">
		<h3>Hoja de evolución  clínica</h3>
	</div>
	<div class="col-md-3" align="right" style="padding-top: 15px;">
		Yahualica de González Gallo Jalisco, Av Hidalgo 65-a, Col centro
	</div>
</div>
<table class="table" style="font-size: 10px; margin-bottom: -10px;">
	<thead>
		<tr>
			<th><h5>Datos generales</h5></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Nombre: </strong><?php echo $objeto['datos']['nombre'] ?></td>
			<td><strong>Sexo: </strong><?php echo $objeto['datos']['sexo'] ?></td>
			<td><strong>Edad: </strong><?php echo $objeto['datos']['edad'] ?></td>
			<td><strong>Peso: </strong><?php echo $objeto['datos']['peso'] ?></td>
			<td><strong>Fecha: </strong><?php echo $objeto['datos']['fecha'] ?></td>
		</tr>
		<tr>
			<td colspan="3"><strong>Servicio: </strong><?php echo $objeto['datos']['servicio'] ?></td>
			<td><strong>Num expediente: </strong><?php echo $objeto['datos']['num_expediente'] ?></td>
			<td><strong>Talla: </strong><?php echo $objeto['datos']['talla'] ?></td>
		</tr>
		<tr>
			<td colspan="5"><strong>Diagnostico: </strong><?php echo $objeto['datos']['diagnostico'] ?></td>
		</tr>
    </tbody>
</table>
<table class="table" style="font-size: 10px; margin-bottom: -10px;">
	<thead>
		<tr>
			<th><h5>Signos vitales</h5></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Frecuencia cardiaca: </strong><?php echo $objeto['datos']['frecuencia_car'] ?></td>
			<td><strong>Frecuencia respiratoria: </strong><?php echo $objeto['datos']['frecuencia_res'] ?></td>
			<td><strong>Temperatura: </strong><?php echo $objeto['datos']['temperatura'] ?></td>
			<td><strong>Tension arterial: </strong><?php echo $objeto['datos']['tension_art'] ?></td>
			<td><strong>Saturacion: </strong><?php echo $objeto['datos']['saturacion'] ?></td>
			<td><strong>Glicemia capilar: </strong><?php echo $objeto['datos']['glicemia'] ?></td>
		</tr>
    </tbody>
</table>
<table class="table" style="font-size: 10px;">
	<thead>
		<tr>
			<th><h5>Hoja clinica</h5></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><strong>Motivo de consulta: </strong></td>
		</tr>
		<tr>
			<td><?php echo $objeto['datos']['motivo_consulta'] ?></td>
		</tr>
		<tr>
			<td><strong>Subjetivo: </strong></td>
		</tr>
		<tr>
			<td><?php echo $objeto['datos']['subjetivo'] ?></td>
		</tr>
		<tr>
			<td><strong>Objetivo: </strong></td>
		</tr>
		<tr>
			<td><?php echo $objeto['datos']['objetivo'] ?></td>
		</tr>
		<tr>
			<td><strong>Analisis: </strong></td>
		</tr>
		<tr>
			<td><?php echo $objeto['datos']['analisis'] ?></td>
		</tr>
		<tr>
			<td><strong>Impresión Diagnóstica: </strong></td>
		</tr>
		<tr>
			<td><?php echo $objeto['datos']['impresion'] ?></td>
		</tr>
		<tr>
			<td><strong>Plan: </strong></td>
		</tr>
		<tr>
			<td><?php echo $objeto['datos']['plan'] ?></td>
		</tr>
    </tbody>
</table>