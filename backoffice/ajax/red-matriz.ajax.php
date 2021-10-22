<?php 

require_once "../controladores/multinivel.controlador.php";
require_once "../modelos/multinivel.modelo.php";

require_once "../controladores/general.controlador.php";

//Solucion al error de Conexion
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxMatriz{

	/*=============================================
	=           Comisiones matriz 4x4             =
	=============================================*/
	public $idUsuario;

	public function ajaxComisionesMatriz(){

		$valorSuscripcion = ControladorGeneral::ctrValorSuscripcion();

		$comisionNivel1 = 0;
		$ventaNivel1 = 0;

		$comisionNivel2 = 0;
		$ventaNivel2 = 0;

		$comisionNivel3 = 0;
		$ventaNivel3 = 0;

		$comisionNivel4 = 0;
		$ventaNivel4 = 0;
		
		$respuesta = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "usuario_red", $this->idUsuario);

		/*==============================================================
		=            Recorrido 1ra linea comisiones nivel 1            =
		==============================================================*/
		$linea1 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $respuesta[0]["orden_matriz"]);
		
		if(count($linea1) == 4){

			$comisionNivel1 = $valorSuscripcion;
			$ventaNivel1 = $valorSuscripcion*4;

		}else{

			$comisionNivel1 = 0;
			$ventaNivel1 = count($linea1)*$valorSuscripcion;

		}//count($linea1) == 4

		/*=============================================================================
		=            Recorrido por 2da y 3ra linea para comisiones nivel 2            =
		=============================================================================*/
		$arrayNivel2 = array();
		$arrayNivel3 = array();
		$arrayNivel4 = array();

		foreach ($linea1 as $key => $value1){
			
			$linea2 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value1["orden_matriz"]);
			
			foreach ($linea2 as $key => $value2){
				
				$linea3 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value2["orden_matriz"]);
				
				array_push($arrayNivel2, count($linea3));

				foreach ($linea3 as $key => $value3){
					
					$linea4 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value3["orden_matriz"]);

					foreach ($linea4 as $key => $value4){

						$linea5 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value4["orden_matriz"]);

						foreach ($linea5 as $key => $value5) {
							
							$linea6 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value5["orden_matriz"]);

							array_push($arrayNivel3, count($linea6));

							foreach ($linea6 as $key => $value6){
								
								$linea7 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value6["orden_matriz"]);

								foreach ($linea7 as $key => $value7){

									$linea8 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value7["orden_matriz"]);

									foreach ($linea8 as $key => $value8) {
										
										$linea9 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value8["orden_matriz"]);

										foreach ($linea9 as $key => $value9) {
											
											$linea10 = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $value9["orden_matriz"]);

											array_push($arrayNivel4, count($linea10));

										}//$linea9

									}//$linea8

								}//$linea7

							}//$linea6

						}//$linea5
						
					}//$linea4

				}//$linea3

			}//$linea2

		}//$linea1	


		/*==========================================
		=            Comisiones nivel 2            =
		==========================================*/
		$cantidadNivel2 = 0;

		for ($i=0; $i < count($arrayNivel2); $i++){ 
			
			$cantidadNivel2 += $arrayNivel2[$i];			

		}//for($arrayNivel2)
		
		$bloque = floor($cantidadNivel2/4);

		if($cantidadNivel2 <= 32){

			$comisionNivel2 = 0;
			$ventaNivel2 = $bloque*$valorSuscripcion*3;

		}else{

			$ventaNivel2 = $bloque*$valorSuscripcion*3;
			$comisionNivel2 = $ventaNivel2-$valorSuscripcion*24;

		}//$cantidadNivel2 <= 32

		/*==========================================
		=            Comisiones nivel 3            =
		==========================================*/
		$cantidadNivel3 = 0;

		for ($i=0; $i < count($arrayNivel3); $i++) { 
			
			$cantidadNivel3 += $arrayNivel3[$i];

		}//for($arrayNivel3)
		
		$bloque = floor($cantidadNivel3/64);

		if($cantidadNivel3 <= 1024){

			$comisionNivel3 = 0;
			$ventaNivel3 = $bloque*$valorSuscripcion*24;

		}else{

			$ventaNivel3 = $bloque*$valorSuscripcion*24;
			$comisionNivel3 = $ventaNivel3-$valorSuscripcion*384;

		}//$cantidadNivel3 <= 64

		/*==========================================
		=            Comisiones nivel 4            =
		==========================================*/
		$cantidadNivel4 = 0;

		for ($i=0; $i < count($arrayNivel4); $i++) { 
			
			$cantidadNivel3 += $arrayNivel4[$i];

		}//for($arrayNivel3)
		
		$bloque = floor($cantidadNivel4/4096);

		$ventaNivel4 = $bloque*$valorSuscripcion*384;
		$comisionNivel4 = $bloque*$valorSuscripcion*384;

		$datos = array("comisionNivel1" => $comisionNivel1,
					   "ventaNivel1" => $ventaNivel1,
					   "comisionNivel2" => $comisionNivel2,
					   "ventaNivel2" => $ventaNivel2,
					   "comisionNivel3" => $comisionNivel3,
					   "ventaNivel3" => $ventaNivel3,
					   "comisionNivel4" => $comisionNivel4,
					   "ventaNivel4" => $ventaNivel4,
					   "totalComisionMatriz" => $comisionNivel1+$comisionNivel2+$comisionNivel3+$comisionNivel4,
					   "totalVentasMatriz" => $ventaNivel1+$ventaNivel2+$ventaNivel3+$ventaNivel4);

		echo json_encode($datos);	
 
	}//ajaxComisionesMatriz

	/*=======================================================
	=            Actualizar comisiones y ventas             =
	=======================================================*/
	public $periodoComision;
	public $periodoVenta;
	public $usuarioRed;

	public function ajaxActualizarMatriz(){
		
		$datos = array("usuario_red" => $this->usuarioRed,
					   "periodo_comision" => $this->periodoComision,
					   "periodo_venta" => $this->periodoVenta);

		$respuesta = ControladorMultinivel::ctrActualizarMatriz($datos);

		echo $respuesta;
 
	}//ajaxActualizarMatriz

}//AjaxMatriz

/*=============================================
=           Comisiones matriz 4x4             =
=============================================*/
if(isset($_POST['idUsuario'])){

	$comisiones = new AjaxMatriz();
	$comisiones -> idUsuario = $_POST['idUsuario'];
	$comisiones -> ajaxComisionesMatriz();

}

/*======================================================
=            Actualizar comisiones y ventas            =
======================================================*/
if(isset($_POST['periodoComision'])){

	$actualizar = new AjaxMatriz();
	$actualizar -> periodoComision = $_POST['periodoComision'];
	$actualizar -> periodoVenta = $_POST['periodoVenta'];
	$actualizar -> usuarioRed = $_POST['usuarioRed'];
	$actualizar -> ajaxActualizarMatriz();

}


