<?php  

class ControladorAcademia{

	/*=============================================
	=              Mostrar Categorias             =
	=============================================*/
	static public function ctrMostrarCategorias($item, $valor){

		$tabla = 'categorias';

		$respuesta = ModeloAcademia::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarCategorias

	/*=============================================
	=           Mostrar videos inner join         =
	=============================================*/
	static public function ctrMostrarAcademia($item, $valor){

		$tabla1 = 'categorias';
		$tabla2 = 'videos';
		
		$respuesta = ModeloAcademia::mdlMostrarAcademia($tabla1, $tabla2, $item, $valor);

		return $respuesta;

	}//ctrMostrarAcademia

	/*=============================================
	=               Mostrar videos                =
	=============================================*/
	static public function ctrMostrarVideos($item, $valor){
		
		$tabla = "videos";

		$respuesta = ModeloAcademia::mdlMostrarVideos($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarVideos
	
	

}//ControladorAcademia

