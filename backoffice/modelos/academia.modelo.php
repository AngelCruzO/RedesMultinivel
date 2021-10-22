<?php  

require_once "conexion.php";

class ModeloAcademia{

	/*=============================================
	=              Mostrar Categorias             =
	=============================================*/
	static public function mdlMostrarCategorias($tabla, $item, $valor){
		
		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt->execute();

			return $stmt -> fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}//mdlMostrarCategorias

	/*=============================================
	=          Mostrar videos inner join          =
	=============================================*/
	static public function mdlMostrarAcademia($tabla1, $tabla2, $item, $valor){
		
		if($item != null && $valor != null){

			//inner join para dos tablas
			$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt -> fetchAll();

		}else{

			//inner join para dos tablas
			$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat");
			$stmt->execute();

			return $stmt -> fetchAll();

		}

		$stmt->close();
		$stmt = null;

		
	}//ctrMostrarAcademia


	/*=============================================
	=               Mostrar Videos                =
	=============================================*/
	static public function mdlMostrarVideos($tabla, $item, $valor){
		
		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt->execute();

			return $stmt -> fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}//mdlMostrarVideos


}//ModeloAcademia

