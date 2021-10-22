<?php 

$red = ControladorMultinivel::ctrMostrarRed("usuarios", "red_uninivel", "patrocinador_red", $usuario['enlace_afiliado']);

$activados = 0;
$desactivados = 0;

if(count($red) != 0){

	foreach ($red as $key => $value) {
		
		if($value["suscripcion"] != 0){

			++$activados;

		}else{

			++$desactivados;

		}//$value["suscripcion"]

	}//foreach

}else{

	$activados = 0;
	$desactivados = 0;

}

?>

<input type="hidden" value="<?php echo $usuario["enlace_afiliado"] ?>" id="enlace_afiliado">
<input type="hidden" value="<?php echo $usuario["id_usuario"] ?>" id="id_usuario">

<div class="col-12 col-lg-7">
	
	<div class="card card-primary card-outline">

		<div class="card-header">
			<h5 class="m-0 float-left">Mi red: <?php echo $activados ?> activos - <?php echo $desactivados ?> desactivados</h5>

			<?php if($usuario['enlace_afiliado'] != $patrocinador): ?>

				<h5 class="float-right">Patrocinador: <span class="badge-secondary"><?php echo $usuario['patrocinador'] ?></span></h5>

			<?php endif ?>
		</div><!--./card-header-->

		<div class="card-body">

			<table class="table table-bordered table-striped dt-responsive tablaUninivel" width="100%">

				<thead>
					<th style="width: 10px;">#</th>
					<th>Foto</th>
					<th>Nombres</th>
					<th>País</th>
					<th>Vencimiento</th>
					<th>Suscripción</th>
				</thead>

				<tbody>

					<!---<td>1</td>
					<td><img src="vistas/img/usuarios/default/default.png" class="img-fluid" width="30px"></td>
					<td>Jaime Carillo</td>
					<td>Colombia</td>
					<td>2019-07-06</td>
					<td><h5><span class="badge badge-success">Activada</span></h5></td>-->

				</tbody><!--./tbody-->

			</table><!--./table-->



		</div><!--./card-body-->

	</div><!--./card-->

</div><!--./col-->