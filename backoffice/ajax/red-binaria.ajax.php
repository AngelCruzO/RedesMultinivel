<?php 

require_once "../controladores/multinivel.controlador.php";
require_once "../modelos/multinivel.modelo.php";

class AjaxBinaria{

	public $periodoComision;
	public $periodoVenta;
	public $idUsuario;

	/*=============================================
	=   Actualizar comisiones y ventas en la BD   =
	=============================================*/
	public function ajaxActualizarBinaria(){

		$datos = array("usuario_red" => $this->idUsuario,
					   "periodo_comision" => $this->periodoComision,
					   "periodo_venta" => $this->periodoVenta);

		$respuesta = ControladorMultinivel::ctrActualizarBinaria($datos);

		echo $respuesta;

	}//ajaxActualizarBinaria

}//AjaxBinaria

/*=============================================
=   Actualizar comisiones y ventas en la BD   =
=============================================*/
if(isset($_POST["periodoComision"])){

	$actualizar = new AjaxBinaria();
	$actualizar -> periodoComision = $_POST["periodoComision"];
	$actualizar -> periodoVenta = $_POST["periodoVenta"];
	$actualizar -> idUsuario = $_POST["idUsuario"];
	$actualizar -> ajaxActualizarBinaria();

}

