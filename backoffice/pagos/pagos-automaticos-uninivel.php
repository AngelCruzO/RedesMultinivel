<?php
/*==============================
=            Vistas            =
==============================*/
date_default_timezone_set('America/Mexico_City');

$usuarios = ControladorPagos::ctrMostrarUsuarios(null, null);

$fechaActual = date('Y-m-d');

foreach ($usuarios as $key => $value) {
	
	$fechaDiaDespues = strtotime('+1day', strtotime($value['vencimiento']));
	$fechaDiaDespues = date('Y-m-d', $fechaDiaDespues);
	
	if($fechaDiaDespues == $fechaActual){

		pagarUsuario($value['id_usuario'], $value['enlace_afiliado'], $value['paypal'], $value['vencimiento'], $fechaActual, $value['id_suscripcion'], $value['patrocinador']);

	}//$fechaDiaDespues == $fechaActual

}//foreach

/*==========================================================
=            Pagar a cada usuarios por separado            =
==========================================================*/
function pagarUsuario($id_usuario, $enlace_afiliado, $paypal, $vencimiento, $fechaActual, $id_suscripcion, $patrocinador){

	$red = ControladorPagos::ctrMostrarUsuarioRed("red_uninivel", "patrocinador_red", $enlace_afiliado);
	
	$periodo_comision = 0;
	$periodo_venta = 0;

	foreach ($red as $key => $value){
		
		$periodo_comision += $value['periodo_comision'];
		$periodo_venta += $value['periodo_venta'];

	}//foreach

	if($enlace_afiliado != "academy-of-life" && $periodo_comision != 0){

		/*====================================
		=            Access token            =
		====================================*/			
		$curl1 = curl_init();

		curl_setopt_array($curl1, array(
			CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/oauth2/token',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 300,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic QVdxS1ZUb0N1VWVtZVRzNjE2N01IdGl4SDVEN3dhaEtmUGpYQjl0U1RBUU41ZzdYZmN2ZmFZczRnbjE0d2Q1dHJSc3pBTmlzam9mbzFQbmU6RUR1aUhKUnRuX3lqU1U2MGpaeDV2Y1lRNk5oeU9BMmwzU3JrMmNVUjdpcHVTMmhtdXpiM1E3Qmk0c3JxLVdzdXZWR0NodWNvUGszT1U3VHI=',
				'Content-Type: application/x-www-form-urlencoded'
			),
		));

		$response = curl_exec($curl1);
		$err = curl_error($curl1);

		curl_close($curl1);

		if($err){

			echo "cURL Error #:" . $err;

		}else{

			/*=====================================
			=            Pago a paypal            =
			=====================================*/							
			$respuesta1 = json_decode($response,true);//true es para captura de propiedades
			$token = $respuesta1['access_token'];
			
			$curl2 = curl_init();

			$aleatorio = rand(0, 10000);

			curl_setopt_array($curl2, array(
			  CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/payments/payouts',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 300,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS =>'{
			  "sender_batch_header": {
			    "sender_batch_id": "Payouts_'.$aleatorio.'_'.$enlace_afiliado.'_'.$fechaActual.'",
			    "email_subject": "Tu tienes un pago de Academy of life!",
			    "email_message": "Tu haz recibido un pago de Academy of life! Gracias por usar nuestros servicios!"
			  },
			  "items": [
			    {
			      "recipient_type": "EMAIL",
			      "amount": {
			        "value": "'.$periodo_comision.'",
			        "currency": "USD"
			      },
			      "note": "POSPYO001",
			      "sender_item_id": "Payouts_'.$aleatorio.'_'.$enlace_afiliado.'_'.$fechaActual.'",
			      "receiver": "'.$paypal.'",
			      "alternate_notification_method": {
			        "phone": {
			          "country_code": "52",
			          "national_number": "5523924992"
			        }
			      },
			      "notification_language": "es-ES"
			    }
			  ]
			}',
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Authorization: Bearer '.$token,
			    'Cookie: ts=vreXpYrS%3D1721325319%26vteXpYrS%3D1626656342%26vt%3Dbc2a88c317aac120001e0080fffcc43d%26vr%3Dbc2a88c317aac120001e0080fffcc43c; ts_c=vr%3Dbc2a88c317aac120001e0080fffcc43c%26vt%3Dbc2a88c317aac120001e0080fffcc43d'
			  ),
			));

			$response = curl_exec($curl2);
			$err = curl_error($curl2);

			curl_close($curl2);

			if($err){

				echo "cURL Error #:" . $err;

			}else{

				$respuesta2 = json_decode($response,true);//true es para captura de propiedades
				$idPayout = $respuesta2['batch_header']['payout_batch_id'];
				
				$tabla = "pagos_uninivel";

				$fechaInicial = strtotime('-1 month', strtotime($vencimiento));
				$fechaInicial = date('Y-m-d', $fechaInicial);

				$datos = array("id_pago_paypal" => $idPayout,
							   "usuario_pago" => $id_usuario,
							   "periodo" => $fechaInicial." a ".$vencimiento,
							   "periodo_comision" => $periodo_comision,
							   "periodo_venta" => $periodo_venta);

				$pagos = ControladorPagos::ctrIngresarPagos($tabla, $datos);

				if($pagos == "ok"){

					/*=============================================
					=              Status Suscripcion             =
					=============================================*/
					$curl3 = curl_init();

					curl_setopt_array($curl3, array(
						CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/billing/subscriptions/'.$id_suscripcion,
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 300,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'GET',
						CURLOPT_HTTPHEADER => array(
							'Content-Type: application/json',
							'Authorization: Bearer '.$token,
							'Cookie: ts=vreXpYrS%3D1721325319%26vteXpYrS%3D1626656342%26vt%3Dbc2a88c317aac120001e0080fffcc43d%26vr%3Dbc2a88c317aac120001e0080fffcc43c; ts_c=vr%3Dbc2a88c317aac120001e0080fffcc43c%26vt%3Dbc2a88c317aac120001e0080fffcc43d; tsrce=devdiscoverynodeweb'
						),
					));

					$response = curl_exec($curl3);
					$err = curl_error($curl3);

					curl_close($curl3);

					if($err){

						echo "cURL Error #:" . $err;

					}else{
						
						$respuesta3 = json_decode($response,true);//true es para captura de propiedades
						$estado = $respuesta3['status'];
						
						if($estado == "ACTIVE"){

							$fechaVencimiento = substr($respuesta3['billing_info']['next_billing_time'], 0, -10);
							$ciclosPagados = $respuesta3['billing_info']['cycle_executions'][0]['cycles_completed'];


							/*====================================================
							=            Actualizar tabla de usuarios            =
							====================================================*/
							$traerPatrocinador = ControladorPagos::ctrMostrarUsuarios("enlace_afiliado", $patrocinador)	;			
							if($traerPatrocinador['suscripcion'] == 0){

								$patrocinadorRed = "academy-of-life";
								$porcentaje = 1;

							}else{

								$patrocinadorRed = $traerPatrocinador['enlace_afiliado'];

								if($patrocinadorRed == "academy-of-life"){
									$porcentaje = 1;
								}else{
									$porcentaje = 0.4;
								}//$patrocinadorRed == "academy-of-life"

							}//$traerPatrocinador['suscripcion'] == 0

							$datosSuscripcion = array("id_usuario" => $id_usuario,
													  "patrocinador" => $patrocinadorRed,
													  "ciclo_pago" => $ciclosPagados,
													  "vencimiento" => $fechaVencimiento);

							$actualizarSuscripcion = ControladorPagos::ctrActualizarSuscripcion($datosSuscripcion);
							echo '<pre>Actualizar suscripcion: '; print_r($actualizarSuscripcion); echo '</pre>';

							/*==========================================
							=            Borrar patrocinios            =
							==========================================*/						
							$borrarPatrocinios = ControladorPagos::ctrBorrarPatrociniosRedUninivel($enlace_afiliado);
							echo '<pre>Borrar patrocinios: '; print_r($borrarPatrocinios); echo '</pre>';

							/*============================================
							=            Actualizar tabla red            =
							============================================*/
							$datosRed = array("usuario_red" => $id_usuario,
											  "patrocinador_red" => $patrocinadorRed,
											  "periodo_comision" => 10*$porcentaje,
											  "periodo_venta" => 10);

							$actualizarRed = ControladorPagos::ctrActualizarRedUninivel($datosRed);
							echo '<pre>Actualizar usuario red: '; print_r($actualizarRed); echo '</pre>';
						
						}else{

							/*==============================================
							=            Actualizar suscripcion            =
							==============================================*/
							$datosSuscripcion = array("id_usuario" => $id_usuario,
													  "suscripcion" => 0,
													  "id_suscripcion" => null,
													  "vencimiento" => null,
													  "ciclo_pago" => null,
													  "firma" => null,
													  "fecha_contrato" => null);

							$cancelarSuscripcion = ControladorPagos::ctrCancelarSuscripcion($datosSuscripcion);
							echo '<pre>Cancelar suscripcion: '; print_r($cancelarSuscripcion); echo '</pre>';

							$eliminarUsuarioRed = ControladorPagos::ctrEliminarUsuarioRed($id_usuario);
							echo '<pre>Eliminar Usuario rd: '; print_r($eliminarUsuarioRed); echo '</pre>';							
							
						}//$estado == "ACTIVE"

					}//$err

				}//$pagos == "ok"

			}//pago

		}//access token

	}//$enlace_afiliado != "cademy-of-life"

	if($enlace_afiliado == "academy-of-life"){

		/*======================================================
		=            Ingresar pago al administrador            =
		======================================================*/
		$tabla = "pagos_uninivel";

		$fechaInicial = strtotime('-1 day', strtotime($vencimiento));
		$fechaInicial = date('Y-m-d', $fechaInicial);

		$datos = array("id_pago_paypal" => null,
					   "usuario_pago" => $id_usuario,
					   "periodo" => $fechaInicial." a ".$vencimiento,
					   "periodo_comision" => $periodo_comision,
					   "periodo_venta" => $periodo_venta);

		$pagos = ControladorPagos::ctrIngresarPagos($tabla, $datos);

		/*==========================================
		=            Borrar patrocinios            =
		==========================================*/						
		$borrarPatrocinios = ControladorPagos::ctrBorrarPatrociniosRedUninivel($enlace_afiliado);
		echo '<pre>Eliminar patrocinios'; print_r($borrarPatrocinios); echo '</pre>';

		/*==============================================
		=            Actualizar suscripcion            =
		==============================================*/
		$fechaNuevaVencimiento = strtotime('+1 day', strtotime($vencimiento));
		$fechaNuevaVencimiento = date('Y-m-d', $fechaNuevaVencimiento);


		$datosSuscripcion = array("id_usuario" => $id_usuario,
								  "patrocinador" => null,
								  "ciclo_pago" => null,
								  "vencimiento" => $fechaNuevaVencimiento);

		$actualizarSuscripcion = ControladorPagos::ctrActualizarSuscripcion($datosSuscripcion);	
		echo '<pre>Actualizar usuario red: '; print_r($actualizarSuscripcion); echo '</pre>';
		

	}//$enlace_afiliado == "academy-of-life"

}//pagarUsuario

/*=====================================
=            Controladores            =
=====================================*/
class ControladorPagos{

	/*========================================
	=            Mostrar usuarios            =
	========================================*/	
	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloPagos::mdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarUsuarios

	/*=============================================
	=             Mostrar usuario red             =
	=============================================*/
	static public function ctrMostrarUsuarioRed($tabla, $item, $valor){
		
		$respuesta = ModeloPagos::mdlMostrarUsuarioRed($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarUsuarioRed

	/*==========================================
	=            Registro pagos red            =
	==========================================*/
	static public function ctrIngresarPagos($tabla, $datos){
		
		$respuesta = ModeloPagos::mdlIngresarPagos($tabla, $datos);

		return $respuesta;

	}//ctrIngresarPagos

	/*==========================================
	=         Actualizar suscripcion           =
	==========================================*/
	static public function ctrActualizarSuscripcion($datos){
		
		$tabla = "usuarios";

		$respuesta = ModeloPagos::mdlActualizarSuscripcion($tabla, $datos);

		return $respuesta;

	}//ctrActualizarSuscripcion

	/*==========================================
	=         Borrar patrocinios red           =
	==========================================*/
	static public function ctrBorrarPatrociniosRedUninivel($datos){
		
		$tabla = "red_uninivel";

		$respuesta = ModeloPagos::mdlBorrarPatrociniosRedUninivel($tabla, $datos);

		return $respuesta;

	}//ctrBorrarPatrociniosRedUninivel

	/*==========================================
	=              Actualizar red              =
	==========================================*/
	static public function ctrActualizarRedUninivel($datos){
		
		$tabla = "red_uninivel";

		$respuesta = ModeloPagos::mdlActualizarRedUninivel($tabla, $datos);

		return $respuesta;

	}//ctrActualizarRedUninivel

	/*==========================================
	=           Cancelar suscripcion           =
	==========================================*/
	static public function ctrCancelarSuscripcion($datos){
		
		$tabla = "usuarios";

		$respuesta = ModeloPagos::mdlCancelarSuscripcion($tabla, $datos);

		return $respuesta;

	}//ctrCancelarSuscripcion

	/*==========================================
	=            Eliminar usuario              =
	==========================================*/
	static public function ctrEliminarUsuarioRed($datos){
		
		$tabla = "red_uninivel";

		$respuesta = ModeloPagos::mdlEliminarUsuarioRed($tabla, $datos);

		return $respuesta;

	}//ctrEliminarUsuarioRed
	
}//ControladorPagos


/*===============================
=            Modelos            =
===============================*/
class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=ventas-suscripcion","root","");

		$link->exec("set names utf8");

		return $link;

	}//conectar

}//Conexion

class ModeloPagos{

	/*========================================
	=            Mostrar usuarios            =
	========================================*/
	static public function mdlMostrarUsuarios($tabla, $item, $valor){

		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt->execute();

			return $stmt->fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();

		}

	}//mdlMostrarUsuarios
	
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

	/*==========================================
	=            Registro pagos red            =
	==========================================*/
	static public function mdlIngresarPagos($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (id_pago_paypal, usuario_pago, periodo, periodo_comision, periodo_venta) VALUES (:id_pago_paypal, :usuario_pago, :periodo, :periodo_comision, :periodo_venta)");

		$stmt->bindParam(":id_pago_paypal",$datos['id_pago_paypal'], PDO::PARAM_STR);
		$stmt->bindParam(":usuario_pago",$datos['usuario_pago'], PDO::PARAM_STR);
		$stmt->bindParam(":periodo",$datos['periodo'], PDO::PARAM_STR);
		$stmt->bindParam(":periodo_comision",$datos['periodo_comision'], PDO::PARAM_STR);
		$stmt->bindParam(":periodo_venta",$datos['periodo_venta'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt=null;		

	}//mdlIngresarPagos

	/*==========================================
	=         Actualizar suscripcion           =
	==========================================*/
	static public function mdlActualizarSuscripcion($tabla, $datos){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET ciclo_pago = :ciclo_pago, vencimiento = :vencimiento, patrocinador = :patrocinador WHERE id_usuario = :id_usuario");

		$stmt->bindParam(":ciclo_pago",$datos['ciclo_pago'], PDO::PARAM_STR);
		$stmt->bindParam(":vencimiento",$datos['vencimiento'], PDO::PARAM_STR);
		$stmt->bindParam(":patrocinador",$datos['patrocinador'], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario",$datos['id_usuario'], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt=null;		

	}//mdlActualizarSuscripcion

	/*==============================================
	=            Borrar patrocinios Red            =
	==============================================*/
	static public function mdlborrarPatrociniosRedUninivel($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET patrocinador_red = null WHERE patrocinador_red = :patrocinador_red");

		$stmt->bindParam(":patrocinador_red",$datos, PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt=null;

	}//mdlBorrarPatrociniosRedUninivel

	/*==============================================
	=            Borrar patrocinios Red            =
	==============================================*/
	static public function mdlActualizarRedUninivel($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET patrocinador_red = :patrocinador_red, periodo_comision = :periodo_comision, periodo_venta = :periodo_venta WHERE usuario_red = :usuario_red");

		$stmt->bindParam(":patrocinador_red",$datos['patrocinador_red'], PDO::PARAM_STR);
		$stmt->bindParam(":periodo_comision",$datos['periodo_comision'], PDO::PARAM_STR);
		$stmt->bindParam(":periodo_venta",$datos['periodo_venta'], PDO::PARAM_STR);
		$stmt->bindParam(":usuario_red",$datos['usuario_red'], PDO::PARAM_STR);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt=null;

	}//mdlActualizarRedUninivel

	/*==============================================
	=             Cancelar suscripcion             =
	==============================================*/
	static public function mdlCancelarSuscripcion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET suscripcion = :suscripcion, id_suscripcion = :id_suscripcion, vencimiento = :vencimiento, ciclo_pago = :ciclo_pago, firma = :firma, fecha_contrato = :fecha_contrato WHERE id_usuario = :id_usuario");

		$stmt->bindParam(":suscripcion",$datos['suscripcion'], PDO::PARAM_STR);
		$stmt->bindParam(":id_suscripcion",$datos['id_suscripcion'], PDO::PARAM_STR);
		$stmt->bindParam(":vencimiento",$datos['vencimiento'], PDO::PARAM_STR);
		$stmt->bindParam(":ciclo_pago",$datos['ciclo_pago'], PDO::PARAM_STR);
		$stmt->bindParam(":firma",$datos['firma'], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_contrato",$datos['fecha_contrato'], PDO::PARAM_STR);
		$stmt->bindParam(":id_usuario",$datos['id_usuario'], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt=null;

	}//mdlCancelarSuscripcion

	/*==============================================
	=               Eliminar usuario               =
	==============================================*/
	static public function mdlEliminarUsuarioRed($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE usuario_red = :usuario_red");

		$stmt->bindParam(":usuario_red", $datos, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		}else{
			echo "\nPDO:errorInfo():\n";
			return print_r(Conexion::conectar()->errorInfo());
		}
		
		$stmt->close();
		$stmt=null;

	}//mdlEliminarUsuarioRed
	
}//ModeloPagos
