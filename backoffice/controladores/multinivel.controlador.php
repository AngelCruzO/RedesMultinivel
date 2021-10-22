<?php  

class ControladorMultinivel{

	/*=============================================
	=              Registro uninivel              =
	=============================================*/
	static public function ctrRegistroUninivel($datos){
		
		$tabla = "red_uninivel";

		$respuesta = ModeloMultinivel::mdlRegistroUninivel($tabla, $datos);

		return $respuesta;

	}//ctrRegistroUninivel


	/*=============================================
	=           Mostrar red inner join            =
	=============================================*/
	static public function ctrMostrarRed($tabla1, $tabla2, $item, $valor){
		
		$respuesta = ModeloMultinivel::mdlMostrarRed($tabla1, $tabla2, $item, $valor);

		return $respuesta;

	}//ctrMostrarRed

	/*=============================================
	=             Mostrar usuario red             =
	=============================================*/
	static public function ctrMostrarUsuarioRed($tabla, $item, $valor){
		
		$respuesta = ModeloMultinivel::mdlMostrarUsuarioRed($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarUsuarioRed

	/*=============================================
	=              Registro binaria               =
	=============================================*/
	static public function ctrRegistroBinaria($datos){
		
		/*Variables*/
		$ordenBinaria = null;
		$derrameBinaria = null;

		$red = ModeloMultinivel::mdlMostrarUsuarioRed("red_binaria", null, null);

		/*Asignar orden de la red*/
		foreach ($red as $key => $value) {
			
			$ordenBinaria = $value['orden_binaria'] + 1;
			
		}//foreach

		/*Traer patrocinador y asignar posicion*/

		$patrocinador = ControladorUsuarios::ctrMostrarUsuarios("enlace_afiliado", $datos["patrocinador_red"]);

		$idPatrocinador = $patrocinador['id_usuario'];

		$derrame = ModeloMultinivel::mdlMostrarUsuarioRed("red_binaria", "usuario_red", $idPatrocinador);

		foreach ($derrame as $key => $value) {
			
			$derrameBinaria = $value['orden_binaria'];

		}

		/*Posiscion en la red*/
		$respuesta = ControladorMultinivel::derrameBinaria($derrameBinaria, $datos['patrocinador_red']);

		/*Generar posicion correspondiente*/
		if($respuesta['posicionLetra'] == "" || $respuesta['posicionLetra'] == "B"){

			$posicionLetra = "A";

		}//letraA

		if($respuesta['posicionLetra'] == "A"){

			$posicionLetra = "B";

		}//letraB

		/*=============================================
		=        Guardamos usuario en la red          =
		=============================================*/
		$datosBinaria = array("usuario_red" => $datos['usuario_red'],
							  "orden_binaria" => $ordenBinaria,
							  "derrame_binaria" => $respuesta['derrameBinaria'],
							  "posicion_binaria" => $posicionLetra,
							  "patrocinador_red" => $datos['patrocinador_red']);

		$tabla = "red_binaria";

		$respuesta = ModeloMultinivel::mdlRegistroBinaria($tabla, $datosBinaria);

		return $respuesta;		

	}//ctrRegistroBinaria

	/*=============================================
	=              Derrame binaria                =
	=============================================*/
	static public function derrameBinaria($derrameBinaria, $patrocinador){
		
		$lineaDescendiente = ModeloMultinivel::mdlMostrarUsuarioRed("red_binaria", "derrame_binaria", $derrameBinaria);

		/*Cuando no hay linea*/
		if(!$lineaDescendiente){

			$datos = array("posicionLetra" => "",
					   "derrameBinaria" => $derrameBinaria);
			return $datos;

		}else if(count($lineaDescendiente) == 1){/*Cuando solo hay una linea*/

			$datos = array("posicionLetra" => "A",
					   "derrameBinaria" => $derrameBinaria);

			return $datos;

		}else{

			/*Cuando el derrame es directamente de la empresa*/
			$patrocinador = ControladorGeneral::ctrPatrocinador();

			if($patrocinadorRed == $patrocinador){

				$datos = ControladorMultinivel::derrameBinaria($derrameBinaria+1, $patrocinador);

				return $datos;

			}else{

				$datos = ControladorMultinivel::derrameBinariaPatrocinador($lineaDescendiente[0]['orden_binaria']);

				return $datos;

			}//patrocinador

		}//lineasDescendientes
		
	}//derrameBinaria

	/*=============================================
	=        Derrame binaria patrocinador         =
	=============================================*/
	static public function derrameBinariaPatrocinador($derrameBinaria){
		
		$lineaDescendiente = ModeloMultinivel::mdlMostrarUsuarioRed("red_binaria", "derrame_binaria", $derrameBinaria);

		/*Cuando no hay linea*/
		if(!$lineaDescendiente){

			$datos = array("posicionLetra" => "",
					   "derrameBinaria" => $derrameBinaria);
			return $datos;

		}else if(count($lineaDescendiente) == 1){/*Cuando solo hay una linea*/

			$datos = array("posicionLetra" => "A",
					   "derrameBinaria" => $derrameBinaria);

			return $datos;

		}else{

			$datos = ControladorMultinivel::derrameBinariaPatrocinador($lineaDescendiente[0]['orden_binaria']);

			return $datos;			

		}//lineasDescendientes

	}//derrameBinariaPatrocinador

	/*=============================================
	=             Actualizar Binaria              =
	=============================================*/
	static public function ctrActualizarBinaria($datos){
		
		$tabla = "red_binaria";

		$respuesta = ModeloMultinivel::mdlActualizarVentasComisiones($tabla, $datos);

		return $respuesta;

	}//ctrActualizarBinaria

	/*=============================================
	=               Registro matriz               =
	=============================================*/
	static public function ctrRegistroMatriz($datos){
		
		/*Variables*/
		$ordenMatriz = null;
		$derrameMatriz = null;

		$red = ModeloMultinivel::mdlMostrarUsuarioRed("red_matriz", null, null);

		/*Asignar orden de la red*/
		foreach ($red as $key => $value) {
			
			$ordenMatriz = $value['orden_matriz'] + 1;
			
		}//foreach

		/*Traer patrocinador y asignar posicion*/

		$patrocinador = ControladorUsuarios::ctrMostrarUsuarios("enlace_afiliado", $datos["patrocinador_red"]);

		$idPatrocinador = $patrocinador['id_usuario'];

		$derrame = ModeloMultinivel::mdlMostrarUsuarioRed("red_matriz", "usuario_red", $idPatrocinador);

		foreach ($derrame as $key => $value) {
			
			$derrameMatriz= $value['orden_matriz'];

		}

		/*Posiscion en la red*/
		$respuesta = ControladorMultinivel::derrameMatriz($derrameMatriz, $datos['patrocinador_red']);

		/*Generar posicion correspondiente*/
		if($respuesta['posicionLetra'] == "" || $respuesta['posicionLetra'] == "D"){

			$posicionLetra = "A";

		}//letraA

		if($respuesta['posicionLetra'] == "A"){

			$posicionLetra = "B";

		}//letraB

		if($respuesta['posicionLetra'] == "B"){

			$posicionLetra = "C";

		}//letraC

		if($respuesta['posicionLetra'] == "C"){

			$posicionLetra = "D";

		}//letraD

		/*=============================================
		=        Guardamos usuario en la red          =
		=============================================*/
		$datosMatriz = array("usuario_red" => $datos['usuario_red'],
							  "orden_matriz" => $ordenMatriz,
							  "derrame_matriz" => $respuesta['derrameMatriz'],
							  "posicion_matriz" => $posicionLetra,
							  "patrocinador_red" => $datos['patrocinador_red']);

		$tabla = "red_matriz";

		$respuesta = ModeloMultinivel::mdlRegistroMatriz($tabla, $datosMatriz);

		return $respuesta;		

	}//ctrRegistroMatriz

	/*=============================================
	=              Derrame matriz                =
	=============================================*/
	static public function derrameMatriz($derrameMatriz, $patrocinador){
		
		$lineaDescendiente = ModeloMultinivel::mdlMostrarUsuarioRed("red_matriz", "derrame_matriz", $derrameMatriz);

		/*Cuando no hay linea*/
		if(!$lineaDescendiente){

			$datos = array("posicionLetra" => "",
					       "derrameMatriz" => $derrameMatriz);
			return $datos;

		}else if(count($lineaDescendiente) == 1){/*Cuando solo hay una linea*/

			$datos = array("posicionLetra" => "A",
					       "derrameMatriz" => $derrameMatriz);

			return $datos;

		}else if(count($lineaDescendiente) == 2){/*Cuando solo hay dos lineas*/

			$datos = array("posicionLetra" => "B",
					       "derrameMatriz" => $derrameMatriz);

			return $datos;

		}else if(count($lineaDescendiente) == 3){/*Cuando solo hay 3 lineas*/

			$datos = array("posicionLetra" => "C",
					       "derrameMatriz" => $derrameMatriz);

			return $datos;

		}else{

			/*Cuando el derrame es directamente de la empresa*/
			$patrocinador = ControladorGeneral::ctrPatrocinador();

			if($patrocinadorRed == $patrocinador){

				$datos = ControladorMultinivel::derrameMatriz($derrameMatriz+1, $patrocinador);

				return $datos;

			}else{

				$datos = ControladorMultinivel::derrameMatrizPatrocinador($lineaDescendiente[0]['orden_matriz']);

				return $datos;

			}//patrocinador

		}//lineasDescendientes
		
	}//derrameMatriz

	/*=============================================
	=        Derrame matriz patrocinador         =
	=============================================*/
	static public function derrameMatrizPatrocinador($derrameMatriz){
		
		$lineaDescendiente = ModeloMultinivel::mdlMostrarUsuarioRed("red_matriz", "derrame_matriz", $derrameMatriz);

		/*Cuando no hay linea*/
		if(!$lineaDescendiente){

			$datos = array("posicionLetra" => "",
					       "derrameMatriz" => $derrameMatriz);
			return $datos;

		}else if(count($lineaDescendiente) == 1){/*Cuando solo hay una linea*/

			$datos = array("posicionLetra" => "A",
					       "derrameMatriz" => $derrameMatriz);

			return $datos;

		}else if(count($lineaDescendiente) == 2){/*Cuando solo hay dos lineas*/

			$datos = array("posicionLetra" => "B",
					       "derrameMatriz" => $derrameMatriz);

			return $datos;

		}else if(count($lineaDescendiente) == 3){/*Cuando solo hay 3 lineas*/

			$datos = array("posicionLetra" => "C",
					       "derrameMatriz" => $derrameMatriz);

			return $datos;

		}else{

			$datos = ControladorMultinivel::derrameMatrizPatrocinador($derrameMatriz+1);

			return $datos;			

		}//lineasDescendientes

	}//derrameMatrizPatrocinador

	/*=============================================
	=             Actualizar Matriz               =
	=============================================*/
	static public function ctrActualizarMatriz($datos){
		
		$tabla = "red_matriz";

		$respuesta = ModeloMultinivel::mdlActualizarVentasComisiones($tabla, $datos);

		return $respuesta;

	}//ctrActualizarMatriz

	/*=====================================
	=            Mostrar Pagos            =
	=====================================*/
	static public function ctrMostrarPagosRed($tabla, $item, $valor){
		
		$respuesta = ModeloMultinivel::mdlMostrarPagosRed($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarPagosRed
	
}//ControladorMultinivel

