<?php 

class ModeloSoporte{

	/*====================================
	=            Crear ticket            =
	====================================*/
	static public function mdlCrearTicket($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (remitente, receptor, asunto, mensaje, adjuntos, tipo) VALUES (:remitente, :receptor, :asunto, :mensaje, :adjuntos, :tipo)");

		$stmt->bindParam(":remitente",$datos['remitente'], PDO::PARAM_STR);
		$stmt->bindParam(":receptor",$datos['receptor'], PDO::PARAM_STR);
		$stmt->bindParam(":asunto",$datos['asunto'], PDO::PARAM_STR);
		$stmt->bindParam(":mensaje",$datos['mensaje'], PDO::PARAM_STR);
		$stmt->bindParam(":adjuntos",$datos['adjuntos'], PDO::PARAM_STR);
		$stmt->bindParam(":tipo",$datos['tipo'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO::errorInfo():\n";
			print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;		

	}//mdlCrearTicket

	/*=======================================
	=            Mostrar tickets            =
	=======================================*/
	static public function mdlMostrarTickets($tabla, $item, $valor){

		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt->execute();

			return $stmt->fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt->execute();

			return $stmt -> fetchAll();

		}

		$stmt->close();
		$stmt = null;

	}//mdlMostrarTickets

	/*=========================================
	=            Actualizar ticket            =
	=========================================*/
	
	
	
	static public function mdlActualizarTicket($tabla, $id, $item, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item = :$item WHERE id_soporte = :id_soporte");

		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt->bindParam(":id_soporte", $id, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO::errorInfo():\n";
			print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;	

	}//mdlActualizarTicket
	

}//ModeloSoporte



