<?php

if($usuario["enlace_afiliado"] != $patrocinador){

	$pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_matriz", "usuario_pago", $usuario["id_usuario"]);

}else{

	$pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_matriz", null, null);

}//$usuario["enlace_afiliado"] != $patrocinador

$totalComisiones = 0;
$totalVentas = 0;

foreach ($pagos as $key => $value) {

	if($usuario["enlace_afiliado"] != $patrocinador || $value["usuario_pago"] == $usuario["id_usuario"]){

		$totalComisiones += $value["periodo_comision"];

	}else{

		$totalComisiones += $value["periodo_venta"]-$value["periodo_comision"];

	}//$usuario["enlace_afiliado"] != $patrocinador

	if($usuario["enlace_afiliado"] != $patrocinador){

		$totalVentas += $value["periodo_venta"];
		
	}else{

		if($value["usuario_pago"] == $usuario["id_usuario"]){

			$totalVentas += $value["periodo_venta"];

		}

	}//$usuario["enlace_afiliado"] != $patrocinador	

}//foreach

?>

<div class="card card-primary card-outline">
	
	<div class="card-header">	

		<h3 class="pl-3 pt-3">
			
			<i class="fas fa-chart-pie mr-1"></i>

			Ganacias históricas: US$ <?php echo number_format($totalComisiones, 2, ",", "."); ?>

		</h3>

		<h6 class="pl-3">Total ventas históricas: US$ <?php echo number_format($totalVentas, 2, ",", "."); ?></h6>

	</div>

	<div class="card-body">	
	
		<div class="tab-content p-0">
			
			<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>

			<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>

		</div>

	</div>


</div>

<script>
	

var area = new Morris.Area({
element   : 'revenue-chart',
resize    : true,
data      : [

<?php

	foreach ($pagos as $key => $value) {

		if($usuario["enlace_afiliado"] != $patrocinador){

				echo "{y: '".substr($value["fecha_pago"],0,-9)."', item1: ".$value["periodo_comision"].", item2: ".$value["periodo_venta"]."},";
		
		}else{

			if($value["usuario_pago"] != $usuario["id_usuario"]){
	
				echo "{y: '".substr($value["fecha_pago"],0,-9)."', item1: ".($value["periodo_venta"]-$value["periodo_comision"]).", item2: ".$value["periodo_venta"]."},";

			}
		}//$usuario["enlace_afiliado"] != $patrocinador

	}//foreach

  ?>


],
xkey      : 'y',
ykeys     : ['item1', 'item2'],
labels    : ['Comisiones', 'Ventas'],
lineColors: ['#17a2b8', '#727cb6'],
hideHover : 'auto'

})


</script>