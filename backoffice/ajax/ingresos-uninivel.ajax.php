<?php

require_once "../controladores/general.controlador.php";

require_once "../controladores/multinivel.controlador.php";
require_once "../modelos/multinivel.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaIngresos{

	/*=============================================
	ACTIVAR TABLA INGRESOS
	=============================================*/ 

	public function mostrarTabla(){

		$patrocinador = ControladorGeneral::ctrPatrocinador();

		if($_GET["enlace_afiliado"] != $patrocinador){

			$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_uninivel", "patrocinador_red", $_GET['enlace_afiliado']);

			$pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_uninivel", "usuario_pago", $_GET['id_usuario']);

		}else{

			$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_uninivel", null, null);

			$pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_uninivel", null, null);

		}//$_GET["enlace_afiliado"] != $patrocinador
		
		if(count($pagos) == 0){

			echo '{"data": [ ]}';

			return;

		}//count($pagos) == 0

		$periodo_comision = 0;
		$periodo_venta = 0;

		$datosJson = '{

		"data": [ ';

		if(count($red) != 0){

			foreach ($red as $key => $value) {

				if($_GET["enlace_afiliado"] != $patrocinador || $value["patrocinador_red"] == $patrocinador){

					$periodo_comision += $value["periodo_comision"];


				}else{

					$periodo_comision += $value["periodo_venta"]-$value["periodo_comision"];
				}//pagos

				$periodo_venta += $value["periodo_venta"]; 

			}//foreach 

			$usuario = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $_GET["id_usuario"]);

			if($_GET["enlace_afiliado"] != $patrocinador){

				$fechaPago = $usuario["vencimiento"];
			
			}else{

				$fechaPago = date('Y-m-d');
			}//$_GET["enlace_afiliado"] != $patrocinador

			/*=============================================
			NOTAS
			=============================================*/	

			$notas = "<h5><a href='uninivel' class='btn btn-purple btn-sm'>Actualizar</a></h5>";			
			$datosJson	 .= '[
						
					"1",
					"En proceso...",
					"En proceso...",
					"En proceso...",
					"'.substr($usuario["fecha"],0,-9).' a '.$usuario["vencimiento"].'",
					"$ '.number_format($periodo_comision, 2, ",", ".").'",
					"$ '.number_format($periodo_venta, 2, ",", ".").'",
					"'.$fechaPago.'",
					"'.$notas.'"

			],';

		}//foreach

		foreach ($pagos as $key => $value) {

			$periodo_comision = 0;
			$periodo_venta = 0;

			if($_GET["enlace_afiliado"] != $patrocinador || $value["periodo_comision"] == $value["periodo_venta"]){

				$periodo_comision += $value["periodo_comision"];

			}else{

				$periodo_comision += $value["periodo_venta"]-$value["periodo_comision"];
			}//pagos
				
  			$periodo_venta += $value["periodo_venta"];  

  			$usuario = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $value["usuario_pago"]);
	
			/*=============================================
			NOTAS
			=============================================*/

			if($_GET["enlace_afiliado"] != $patrocinador){			

				$notas = "<h5><span class='badge badge-success'>Pagada</span></h5>";

			}else{

				$notas = "<h5><span class='badge badge-success'>Pagada $".number_format($value["periodo_comision"])."</span></h5>";
			}//$_GET["enlace_afiliado"] != $patrocinador	

			$datosJson	 .= '[
						
					"'.($key+2).'",
					"'.$value["id_pago_paypal"].'",
					"'.$usuario["nombre"].'",
					"'.$usuario["paypal"].'",
					"'.$value["periodo"].'",
					"$ '.number_format($periodo_comision, 2, ",", ".").'",
					"$ '.number_format($periodo_venta, 2, ",", ".").'",
					"'.substr($value["fecha_pago"],0,-9).'",
					"'.$notas.'"

			],';
		}//foreach

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

	}//mostrarTabla


}//TablaIngresos

/*=============================================
ACTIVAR TABLA UNINIVEL
=============================================*/ 

$activar = new TablaIngresos();
$activar -> mostrarTabla();