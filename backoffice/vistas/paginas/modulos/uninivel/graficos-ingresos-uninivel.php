<?php  

if($usuario["enlace_afiliado"] != $patrocinador){

	$pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_uninivel", "usuario_pago", $usuario['id_usuario']);

}else{

	$pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_uninivel", null, null);

}//$usuario["enlace_afiliado"] != $patrocinador

$totalComisiones = 0;
$totalVentas = 0;

foreach ($pagos as $key => $value){
	
	if($usuario['enlace_afiliado'] != $patrocinador || $value['periodo_comision'] == $value['periodo_venta']){

		$totalComisiones += $value['periodo_comision'];

	}else{

		$totalComisiones += $value['periodo_venta']-$value['periodo_comision'];

	}//periodo comision

	$totalVentas += $value['periodo_venta'];

}//foreach

?>

<div class="card card-primary card-outline">

	<div class="card-header">

		<h3 class="pl-3 pt-3">
			<i class="fas fa-chart-pie mr-1"></i>
			Ganancias históricas: US$ <?php echo number_format($totalComisiones, 2, ".", ","); ?>
		</h3>

		<h6 class="pl-3">Total ventas históricas: US$ <?php echo number_format($totalVentas, 2, ".", ","); ?></h6>

	</div><!--./card-header-->

	<div class="card-body">

		<div class="tab-content p-0">

			<div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>

			<div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>

		</div><!--./tab-content-->

	</div><!--./card-body-->

</div><!--./card-->

<script>
	
	var area = new Morris.Area({

		element: 'revenue-chart',
		resize: true,
		data: [

		<?php

		foreach ($pagos as $key => $value){
			
			if($usuario['enlace_afiliado'] != $patrocinador || $value['periodo_comision'] == $value['periodo_venta']){

				echo "{y: '".substr($value['fecha_pago'],0,-9)."', item1: ".$value['periodo_comision'].", item2: ".$value['periodo_venta']."},";

			}else{

				echo "{y: '".substr($value['fecha_pago'],0,-9)."', item1: ".$value['periodo_venta']-$value['periodo_comision'].", item2: ".$value['periodo_venta']."},";

			}//datos grafico

		}//foreach

		?>

		],
		xkey: 'y',
		ykeys: ['item1', 'item2'],
		labels: ['Comsiones', 'Ventas'],
		lineColors: ['#17a2b8', '#727cb6'],
		hideHover: 'auto'

	})

</script>