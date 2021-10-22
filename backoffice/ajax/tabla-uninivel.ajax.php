<?php

require_once "../controladores/multinivel.controlador.php";
require_once "../modelos/multinivel.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaUninivel{

	public function mostrarTabla(){

		if(isset($_GET["enlace_afiliado"])){

			$red = ControladorMultinivel::ctrMostrarRed("usuarios", "red_uninivel", "patrocinador_red",	$_GET["enlace_afiliado"]);

			/*=============================================
			Limpinado el array de tipo Objeto de valores repetidos
			=============================================*/

			$resultado = array();

			foreach ($red as $value) {
				
				$resultado[$value["id_usuario"]]= $value;
				
			}//foreach

			$red = array_values($resultado);

			if(count($red)== 0){

	 			$datosJson = '{"data": []}';

				echo $datosJson;

				return;

 			}

 			$datosJson = '{

		 	"data": [ ';

			foreach ($red as $key => $value) {


				/*=============================================
				FOTO
				=============================================*/	

				if($value["foto"] != ""){

					$foto = "<img src='".$value["foto"]."' class='img-fluid rounded-circle' width='30px'>";

				}else{

					$foto = "<img src='vistas/img/usuarios/default/default.png' class='img-fluid' width='30px'>";
				}

				/*=============================================
				SUSCRIPCIÓN
				=============================================*/	

				if($value["suscripcion"] != 0){	

					$suscripcion = "<h5><span class='badge badge-success'>Activado</span></h5>";

				}else{

					$suscripcion = "<h5><span class='badge badge-danger'>Desactivado</span></h5>";
				}


				$datosJson	 .= '[
						
					"'.($key+1).'",
					"'.$foto.'",
					"'.$value["nombre"].'",
					"'.$value["pais"].'",
					"'.$value["vencimiento"].'",
					"'.$suscripcion.'"

				],';		

			}//foreach

			$datosJson = substr($datosJson, 0, -1);

			$datosJson.=  ']

			}';

			echo $datosJson;

		}//$_GET["enlace_afiliado"]

	}//mostrarTabla

}//TablaUninivel

/*=============================================
ACTIVAR TABLA UNINIVEL
=============================================*/ 

$activar = new TablaUninivel();
$activar -> mostrarTabla();
