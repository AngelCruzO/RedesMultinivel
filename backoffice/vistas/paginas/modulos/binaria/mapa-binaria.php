<?php 

$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_binaria", "usuario_red", $usuario['id_usuario']);

if(count($red) > 1){

completarReferidos($red[0]['orden_binaria']);

//variables de sesion para colocar datos
$_SESSION['pais'] = null;
$_SESSION['cod'] = null;

function completarReferidos($ordenBinaria){

	$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_binaria", "derrame_binaria", $ordenBinaria);

	foreach ($red as $key => $value) {

		listadoUsuarios($value['usuario_red']);
		
		completarReferidos($value['orden_binaria']);

	}//foreach

}//completarReferidos

function listadoUsuarios($idUsuario){
	
	$pais = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $idUsuario);

	$_SESSION['pais'] .= $pais['pais'].",";
	$_SESSION['cod'] .= $pais['codigo_pais'].",";

	//convertir string a array
	$_SESSION['totalPaises'] = explode(",", $_SESSION['pais']);
	$_SESSION['codPais'] = explode(",", $_SESSION['cod']);

}//listadoUsuarios

array_pop($_SESSION['totalPaises']);
array_pop($_SESSION['codPais']);

$listaPaises = $_SESSION['totalPaises'];
$listaCodPaises = $_SESSION['codPais'];
	
$cantidadPaises = count($listaPaises);

/*=============================================
=               Contar paises                 =
=============================================*/
function contarValoresArray($array){
	
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

$cantidadUsuariosCodigo = contarValoresArray($listaCodPaises);
$cantidadUsuarios = contarValoresArray($listaPaises);

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

}else{

	return;

}


?>

<div class="card card-info card-outline">
	
	<div class="card-header">
		<h5 class="m-0 float-left">Territorios</h5>
	</div><!--./card-header-->

	<div class="card-body">
		<div id="world-map" style="height: 250px; width: 100%;"></div>
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
	
	$('#world-map').vectorMap({
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

</script>