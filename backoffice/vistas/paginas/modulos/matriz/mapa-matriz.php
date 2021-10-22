<?php 

$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "usuario_red", $usuario['id_usuario']);

completarReferidosMatriz($red[0]['orden_matriz']);

//variables de sesion para colocar datos
$_SESSION['paisMatriz'] = null;
$_SESSION['codMatriz'] = null;

function completarReferidosMatriz($ordenMatriz){

	$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $ordenMatriz);

	foreach ($red as $key => $value) {

		listadoUsuariosMatriz($value['usuario_red']);
		
		completarReferidosMatriz($value['orden_matriz']);

	}//foreach

}//completarReferidos

function listadoUsuariosMatriz($idUsuario){
	
	$pais = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $idUsuario);

	$_SESSION['paisMatriz'] .= $pais['pais'].",";
	$_SESSION['codMatriz'] .= $pais['codigo_pais'].",";

	//convertir string a array
	$_SESSION['totalPaisesMatriz'] = explode(",", $_SESSION['paisMatriz']);
	$_SESSION['codPaisMatriz'] = explode(",", $_SESSION['codMatriz']);

}//listadoUsuarios

array_pop($_SESSION['totalPaisesMatriz']);
array_pop($_SESSION['codPaisMatriz']);

$listaPaises = $_SESSION['totalPaisesMatriz'];
$listaCodPaises = $_SESSION['codPaisMatriz'];
	
$cantidadPaises = count($listaPaises);

/*=============================================
=               Contar paises                 =
=============================================*/
function contarValoresArrayMatriz($array){
	
	$contar = array();

	foreach ($array as $value) {
		
		if(isset($contar[$value])){

			$contar[$value] += 1;

		}else{

			$contar[$value] = 1;

		}//$contar[$value]

	}//foreach

	return $contar;

}//contarValoresArray

$cantidadUsuariosCodigo = contarValoresArrayMatriz($listaCodPaises);
$cantidadUsuarios = contarValoresArrayMatriz($listaPaises);

/*=============================================
=              Limitar foreach                =
=============================================*/
function limit($array, $limite){
	foreach ($array as $key => $value){
		
		if(!$limite--) break;

		yield $key => $value;

	}//foreach

}//limit

/*=============================================
=         Ordenar de mayor a menor            =
=============================================*/
arsort($cantidadUsuarios);

?>

<div class="card card-info card-outline">
	
	<div class="card-header">
		<h5 class="m-0 float-left">Territorios</h5>
	</div><!--./card-header-->

	<div class="card-body">
		<div id="world-mapMatriz" style="height: 250px; width: 100%;"></div>
	</div><!--./card-body-->

	<div class="card-footer bg-white">
		
		<div class="d-flex">

			<?php foreach (limit($cantidadUsuarios, 4) as $key => $value): ?>
				<div class="text-center flex-fill">

					<input type="text" class="knob" data-readonly="true" value="<?php echo number_format($value*100/$cantidadPaises) ?>" data-width="60" data-height="60" data-fgColor="#007BFF">

					<div class="text-secondary"><?php echo $key ?></div>

				</div><!--text-center-->
			<?php endforeach ?>
			
		</div><!--./d-flex-->

	</div><!--./card-footer-->

</div><!--./card-->

<script>

	$('.knob').knob();

	var visitorsData={
		<?php

		foreach ($cantidadUsuariosCodigo as $key => $value) {
			echo "'".$key."':".$value.",";
		}

		?>
	}//visitorsData
	
	$('#world-mapMatriz').vectorMap({
	 	map              : 'world_mill_en',
	 	backgroundColor  : '#007BFF',
	 	regionStyle      : {
	 		initial: {
	 			fill            : 'rgba(255, 255, 255, 0.7)',
	 			'fill-opacity'  : 1,
	 			stroke          : 'rgba(0,0,0,.2)',
	 			'stroke-width'  : 1,
	 			'stroke-opacity': 1
	 		}
	 	},
	 	series           : {
	 		regions: [{
	 			values           : visitorsData,
	 			scale            : ['#ffffff', '#0154ad'],
	 			normalizeFunction: 'polynomial'
	 		}]
	 	},
	 	onRegionLabelShow: function (e, el, code) {
	      if (typeof visitorsData[code] != 'undefined')
	        el.html(el.html() + ': ' + visitorsData[code] + ' afiliados')
	    }
	})	

</script><!--./script-->