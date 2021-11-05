<?php

$totalPapelera = 0;

$ticketRecibidos = ControladorSoporte::ctrMostrarTickets("receptor", $usuario['id_usuario']);

$totalRecibidos = 0;

foreach ($ticketRecibidos as $key => $value) {

	if($value['tipo'] == "papelera"){

		$papelera = json_decode($value['papelera'], true);

		if(count($papelera) == 1){

			if($papelera[0] == $usuario['id_usuario']){

				--$totalRecibidos;
				++$totalPapelera;

			}//$papelera[0] == $usuario['id_usuario'])

		}//count($papelera) == 1

		if(count($papelera) == 2){

			if($papelera[0] == $usuario['id_usuario'] || $papelera[1] == $usuario['id_usuario']){

				--$totalRecibidos;
				++$totalPapelera;

			}//$papelera[0] == $usuario['id_usuario']

		}//count($papelera) == 2

	}//$value['tipo'] == "papelera"
	
	++$totalRecibidos;

}//foreach

$ticketEnviados = ControladorSoporte::ctrMostrarTickets("remitente", $usuario['id_usuario']);

$totalEnviados = 0;

foreach ($ticketEnviados as $key => $value) {

	if($value['tipo'] == "papelera"){

		$papelera = json_decode($value['papelera'], true);

		if(count($papelera) == 1){

			if($papelera[0] == $usuario['id_usuario']){

				--$totalEnviados;
				++$totalPapelera;

			}

		}

		if(count($papelera) == 2){

			if($papelera[0] == $usuario['id_usuario'] || $papelera[1] == $usuario['id_usuario']){

				--$totalEnviados;
				++$totalPapelera;

			}

		}

	}
	
	++$totalEnviados;

}//foreach

?>

<a href="<?php echo $ruta; ?>backoffice/soporte" class="btn btn-primary btn-block mb-3">Crear Ticket</a>

<div class="card">

	<div class="card-header">
		<h3 class="card-title">Tickets</h3>

		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-widget="collapse">
				<i class="fa fa-minus"></i>
			</button>
		</div><!--./card-tools-->
	</div><!--./card-header-->

	<div class="card-body p-0">
		<ul class="nav nav-pills flex-column">

			<li class="nav-item">
				<a href="index.php?pagina=soporte&soporte=recibidos" class="nav-link">
					<i class="fas fa-inbox"></i> Recibidos
					<span class="badge bg-primary float-right"><?php echo $totalRecibidos; ?></span>
				</a>
			</li>

			<li class="nav-item">
				<a href="index.php?pagina=soporte&soporte=enviados" class="nav-link">
					<i class="fas fa-envelope"></i> Enviados
					<span class="badge bg-info float-right"><?php echo $totalEnviados; ?></span>
				</a>
			</li>

			<li class="nav-item">
				<a href="index.php?pagina=soporte&soporte=papelera" class="nav-link">
					<i class="fas fa-trash"></i> Papelera
					<span class="badge bg-danger float-right"><?php echo $totalPapelera; ?></span>
				</a>
			</li>

		</ul><!--./ul-->
	</div><!--./card-body-->
	
</div><!--./card-->