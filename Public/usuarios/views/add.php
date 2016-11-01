<?php
	date_default_timezone_set('America/Mexico_City');
	$datos['fecha'] = (!empty($datos['fecha'])) ? $datos['fecha'] : date('Y-m-d').'T'.date('H:i') ;
?>
<style>
	.twitter-typeahead { width: 100%; } 
</style>
<form class="form" id="form_agregar_hoja">
	<div class="panel-group" id="accordion_datos_generales" role="tablist" aria-multiselectable="true">
		<div class="panel panel-primary">
			<div hrefer class="panel-heading" id="heading_datos_generales" role="tab" style="cursor: pointer" data-toggle="collapse" data-parent="#accordion_datos_generales" href="#tab_datos_generales" aria-controls="collapse_datos_generales" aria-expanded="true">
				<h4 class="panel-title"><strong><i class="fa fa-user"></i> Datos generales</strong></h4>
			</div>
			<div id="tab_datos_generales" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_datos_generales">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-1">
							<div class="form-group">
								<label><strong>ID</strong></label>
								<input 
									type="number" 
									id="id"
									ondblclick="usuarios.desbloquear({id: 'id'})"
									min="0" 
									readonly="1" 
									class="form-control">
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label><strong>Nombre</strong></label><br />
								<input 
									required="1" 
									type="text" 
									class="form-control typeahead" 
									id="nombre"
									placeholder="Juan Perez">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Sexo</label>
								<br />
								<select id="sexo" class="selectpicker" data-width="100%">
									<option selected value="1">Hombre</option>
									<option value="2">Mujer</option>
								</select>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Edad</label>
								<input type="number" min="0" class="form-control" id="edad" placeholder="23">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>Peso</label>
								<input type="number" min="0" class="form-control" id="peso" placeholder="70">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label><strong>Servicio</strong></label>
								<input type="text" class="form-control" id="servicio" placeholder="Consulta">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Num expediente</strong></label>
								<input type="number" min="0" class="form-control" id="num_expediente" placeholder="1234">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Talla</strong></label>
								<input type="number" min="0" class="form-control" id="talla" placeholder="173">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><strong>Fecha</strong></label>
								<input type="datetime-local" class="form-control" id="fecha" value="<?php echo $datos['fecha'] ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><strong>Diagnostico</strong></label>
								<input required="1" type="text" class="form-control" id="diagnostico" placeholder="gripe">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-group" id="accordion_signos_vitales" role="tablist" aria-multiselectable="true">
		<div class="panel panel-info">
			<div hrefer class="panel-heading" id="heading_signos_vitales" role="tab" style="cursor: pointer" data-toggle="collapse" data-parent="#accordion_signos_vitales" href="#tab_signos_vitales" aria-controls="collapse_signos_vitales" aria-expanded="true">
				<h4 class="panel-title"><strong><i class="fa fa-heartbeat"></i> Signos vitales</strong></h4>
			</div>
			<div id="tab_signos_vitales" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_signos_vitales">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Frecuencia cardiaca</strong></label>
								<input type="number" min="0" class="form-control" id="frecuencia_car" placeholder="121">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Frecuencia respiratoria</strong></label>
								<input type="number" min="0" class="form-control" id="frecuencia_res" placeholder="23">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Temperatura</strong></label>
								<input type="number" min="0" class="form-control" id="temperatura" placeholder="32">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Tension arterial</strong></label>
								<input type="number" min="0" class="form-control" id="tension_art" placeholder="1234">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Saturacion</strong></label>
								<input type="number" min="0" class="form-control" id="saturacion" placeholder="32">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label><strong>Glicemia capilar</strong></label>
								<input type="number" min="0" class="form-control" id="glicemia" placeholder="32">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-group" id="accordion_hoja_clinica" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div hrefer class="panel-heading" id="heading_hoja_clinica" role="tab" style="cursor: pointer" data-toggle="collapse" data-parent="#accordion_hoja_clinica" href="#tab_hoja_clinica" aria-controls="collapse_hoja_clinica" aria-expanded="true">
				<h4 class="panel-title"><strong><i class="fa fa-pencil-square-o"></i> Hoja clinica</strong></h4>
			</div>
			<div id="tab_hoja_clinica" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_signos_vitales">
				<div class="panel-body">
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								<label><strong>Motivo de consulta</strong></label>
								<textarea required="1" id="motivo_consulta" class="form-control" rows="3"></textarea>
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group">
								<label><strong>Subjetivo</strong></label>
								<textarea id="subjetivo" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><strong>Objetivo</strong></label>
								<textarea id="objetivo" class="form-control" rows="8">A la exploración física, paciente en buenas condiciones generales. Consciente, tranquila, cooperadora en presencia de la madre. Piel y tegumentos con buen estado de hidratación y buena coloración. Normocéfalo, conductos auditivos permeables, membranas timpánicas aperladas,  pupilas isocóricas normorreflécticas, narinas permeables, cavidad oral bien hidratada. Faringe sin alteraciones. Cuello central, cilíndrico, móvil sin adenopatías palpables. Tórax simétrico, dinámico, murmullo vesicular audible, campos pulmonares bien ventilados sin estertores ni sibilancias. Precordio rítmico, concordante con el pulso sin presencia de soplos ni más fenómenos agregados. Abdomen globoso a expensas de panículo adiposo, blando, normoperistáltico, depresible, no doloroso a palpación, extremidades íntegras, no edematizadas, pulsos periféricos presentes, llenado capilar inmediato, revisión de pies sin alteraciones, presencia de múltiples masas móviles, no adheridas ni dolorosas en ambas extremidades superiores. Neurológicamente integra para la edad
								</textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label><strong>Analisis</strong></label>
								<textarea id="analisis" class="form-control" rows="8"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Impresión Diagnóstica</strong></label>
								<textarea required="1" id="impresion" class="form-control" rows="3"></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Plan</strong></label>
								<textarea id="plan" class="form-control" rows="3"></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<button
	id="btn_guardar_hoja"
	data-loading-text="<i class='fa fa-refresh fa-spin'></i>"
	class="btn btn-success btn-lg"
	onclick="usuarios.guardar({form:'form_agregar_hoja'})">
	<i class="fa fa-check"></i> Guardar
</button>