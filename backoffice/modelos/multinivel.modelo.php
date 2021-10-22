<?php  

class ModeloMultinivel{

	/*=============================================
	=              Registro uninivel              =
	=============================================*/
	static public function mdlRegistroUninivel($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario_red, patrocinador_red, periodo_comision, periodo_venta) VALUES (:usuario_red, :patrocinador_red, :periodo_comision, :periodo_venta)");

		$stmt->bindParam(":usuario_red", $datos['usuario_red'],PDO::PARAM_STR);
		$stmt->bindParam(":patrocinador_red", $datos['patrocinador_red'],PDO::PARAM_STR);
		$stmt->bindParam(":periodo_comision", $datos['periodo_comision'],PDO::PARAM_STR);
		$stmt->bindParam(":periodo_venta", $datos['periodo_venta'],PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;

	}//mdlRegistroUninivel

	/*=============================================
	=          Mostrar red inner join             =
	=============================================*/
	static public function mdlMostrarRed($tabla1, $tabla2, $item, $valor){
		
		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.patrocinador = $tabla2.patrocinador_red WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.patrocinador = $tabla2.patrocinador_red");
			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}//mdlMostrarRed

	/*=============================================
	=             Mostrar usuario red             =
	=============================================*/
	static public function mdlMostrarUsuarioRed($tabla, $item, $valor){
		
		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}//mdlMostrarUsuarioRed


	/*=============================================
	=              Registro Binaria               =
	=============================================*/
	static public function mdlRegistroBinaria($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario_red, orden_binaria, derrame_binaria, posicion_binaria, patrocinador_red) VALUES (:usuario_red, :orden_binaria, :derrame_binaria, :posicion_binaria, :patrocinador_red)");

		$stmt -> bindParam(":usuario_red", $datos['usuario_red'], PDO::PARAM_STR);
		$stmt -> bindParam(":orden_binaria", $datos['orden_binaria'], PDO::PARAM_STR);
		$stmt -> bindParam(":derrame_binaria", $datos['derrame_binaria'], PDO::PARAM_STR);
		$stmt -> bindParam(":posicion_binaria", $datos['posicion_binaria'], PDO::PARAM_STR);
		$stmt -> bindParam(":patrocinador_red", $datos['patrocinador_red'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;

	}//mdlRegistroBinaria

	/*======================================================
	=            Actualizar comisiones y ventas            =
	======================================================*/
	static public function mdlActualizarVentasComisiones($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET periodo_comision = :periodo_comision, periodo_venta = :periodo_venta WHERE usuario_red = :usuario_red");

		$stmt -> bindParam(":periodo_comision", $datos['periodo_comision'], PDO::PARAM_STR);
		$stmt -> bindParam(":periodo_venta", $datos['periodo_venta'], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario_red", $datos['usuario_red'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;

	}//mdlActualizarVentasComisiones

	/*=============================================
	=              Registro Matriz               =
	=============================================*/
	static public function mdlRegistroMatriz($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario_red, orden_matriz, derrame_matriz, posicion_matriz, patrocinador_red) VALUES (:usuario_red, :orden_matriz, :derrame_matriz, :posicion_matriz, :patrocinador_red)");

		$stmt -> bindParam(":usuario_red", $datos['usuario_red'], PDO::PARAM_STR);
		$stmt -> bindParam(":orden_matriz", $datos['orden_matriz'], PDO::PARAM_STR);
		$stmt -> bindParam(":derrame_matriz", $datos['derrame_matriz'], PDO::PARAM_STR);
		$stmt -> bindParam(":posicion_matriz", $datos['posicion_matriz'], PDO::PARAM_STR);
		$stmt -> bindParam(":patrocinador_red", $datos['patrocinador_red'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;

	}//mdlRegistroMatriz

	/*=====================================
	=            Mostrar pagos            =
	=====================================*/	
	static public function mdlMostrarPagosRed($tabla, $item, $valor){
		
		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt->execute();

			return $stmt->fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}//mdlMostrarPagos

}//ModeloMultinivel

