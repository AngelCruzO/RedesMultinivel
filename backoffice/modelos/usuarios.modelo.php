<?php 

require_once "conexion.php";


class ModeloUsuarios{

	/*=============================================
	=           Registro de usuarios            =
	=============================================*/
	static public function mdlRegistroUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(perfil, nombre, email, password, suscripcion, verificacion, email_encriptado, patrocinador) VALUES(:perfil, :nombre, :email, :password, :suscripcion, :verificacion, :email_encriptado, :patrocinador)");

		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":suscripcion", $datos["suscripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":verificacion", $datos["verificacion"], PDO::PARAM_STR);
		$stmt->bindParam(":email_encriptado", $datos["email_encriptado"], PDO::PARAM_STR);
		$stmt->bindParam(":patrocinador", $datos["patrocinador"], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			return print_r(Conexion::conectar()->errorInfo());
		}

		//opcional
		$stmt->close();
		$stmt->null;

	}//mdlRegistroUsuario

	/*=============================================
	=              MostrarUsuarios                =
	=============================================*/
	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null && $valor != null){

			$stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar() -> prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		

		$stmt -> close();
		$stmt -> null;

	}//mdlMostrarUsuarios

	/*=============================================
	=            Actualizar Usuario               =
	=============================================*/
	static public function mdlActualizarUsuario($tabla, $id, $item, $valor){

		$stmt = Conexion::conectar() -> prepare("UPDATE $tabla SET $item = :$item WHERE id_usuario = :id_usuario");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario", $id, PDO::PARAM_STR);

		if($stmt -> execute()){
			return 'ok';
		}else{
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt -> close();
		$stmt -> null;

	}//mdlActualizarUsuario

	/*=============================================
	=            Iniciar suscripcion            =
	=============================================*/
	static public function mdlIniciarSuscripcion($tabla,$datos){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET suscripcion = :suscripcion, id_suscripcion = :id_suscripcion, ciclo_pago = :ciclo_pago, vencimiento = :vencimiento,  enlace_afiliado = :enlace_afiliado, patrocinador = :patrocinador, paypal = :paypal, pais = :pais, codigo_pais = :codigo_pais, telefono_movil = :telefono_movil, firma = :firma, fecha_contrato = :fecha_contrato  WHERE id_usuario = :id_usuario");

		$stmt -> bindParam(":suscripcion", $datos["suscripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_suscripcion", $datos["id_suscripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":ciclo_pago", $datos["ciclo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":vencimiento", $datos["vencimiento"], PDO::PARAM_STR);
		$stmt -> bindParam(":enlace_afiliado", $datos["enlace_afiliado"], PDO::PARAM_STR);
		$stmt -> bindParam(":patrocinador", $datos["patrocinador"], PDO::PARAM_STR);
		$stmt -> bindParam(":paypal", $datos["paypal"], PDO::PARAM_STR);
		$stmt -> bindParam(":pais", $datos["pais"], PDO::PARAM_STR);
		$stmt -> bindParam(":codigo_pais", $datos["codigo_pais"], PDO::PARAM_STR);
		$stmt -> bindParam(":telefono_movil", $datos["telefono_movil"], PDO::PARAM_STR);
		$stmt -> bindParam(":firma", $datos["firma"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_contrato", $datos["fecha_contrato"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if($stmt -> execute()){
			return 'ok';
		}else{
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt -> close();
		$stmt -> null;		

	}//mdlIniciarSuscripcion
	

	/*=============================================
	=           Cancelar suscripcion            =
	=============================================*/
	static public function mdlCancelarSuscripcion($tabla,$datos){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET  suscripcion = :suscripcion, ciclo_pago = :ciclo_pago, firma = :firma, fecha_contrato = :fecha_contrato WHERE id_usuario = :id_usuario");

		$stmt -> bindParam(":suscripcion", $datos["suscripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":ciclo_pago", $datos["ciclo_pago"], PDO::PARAM_STR);
		$stmt -> bindParam(":firma", $datos["firma"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha_contrato", $datos["fecha_contrato"], PDO::PARAM_STR);
		$stmt -> bindParam(":id_usuario", $datos["id_usuario"], PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";

		}else{

			return print_r(Conexion::conectar()->errorInfo());		

		}

		$stmt-> close();
		$stmt = null;		

	}//mdlCancelarSuscripcion

}//ModeloUsuario

