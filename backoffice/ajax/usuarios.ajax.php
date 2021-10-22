<?php 

require_once "../controladores/general.controlador.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

	public $validarEmail;

	/*=============================================
	=            Validar email existente          =
	=============================================*/
	public function ajaxValidarEmail(){

		$item = "email";
		$valor = $this -> validarEmail;

		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}//ajaxValidarEmail

	/*=============================================
	=       Suscripción con Paypal (Metodo)       =
	=============================================*/
	public $suscripcion;
	public $nombre;
	public $email;

	public function ajaxSuscripcion(){

		$ruta = ControladorGeneral::ctrRuta();
		$valorSuscripcion = ControladorGeneral::ctrValorSuscripcion();
		$fecha = substr(date("c"), 0, -6)."Z";; //formato de hora sin los ultimos 6 caracteres

		/*=============================================
		=            Access Token Paypal              =
		=============================================*/
				
		//codigo proporcionado por POSTMAN
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

			$respuesta1 = json_decode($response,true);//true es para captura de propiedades
			$token = $respuesta1['access_token'];

			/*=============================================
			=            Crear producto Paypal            =
			=============================================*/
			$curl2 = curl_init();

			curl_setopt_array($curl2, array(
				CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/catalogs/products',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 300,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'{
					"name": "Academy of life",
					"description": "Educación en línea",
					"type": "DIGITAL",
					"category": "EDUCATIONAL_AND_TEXTBOOKS",
					"image_url": "'.$ruta.'backoffice/vistas/img/plantilla/icono.png",
					"home_url": "'.$ruta.'"
				}',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Bearer '.$token
				),
			));

			$response = curl_exec($curl2);
			$err = curl_error($curl2);

			curl_close($curl2);

			if($err){

				echo "cURL Error #:" . $err;

			}else{

				$respuesta2 = json_decode($response,true);//true es para captura de propiedades
				$idProducto = $respuesta2['id'];

				/*=============================================
				=              Crear Plan Paypal              =
				=============================================*/
				$curl3 = curl_init();

				curl_setopt_array($curl3, array(
					CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/billing/plans',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 300,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS =>'{
						"product_id": "'.$idProducto.'",
						"name": "Suscripción mensual a Academy of life",
						"description": "Plan de pago mensual a Academy of life",
						"status": "ACTIVE",
						"billing_cycles": [
						{
							"frequency": {
								"interval_unit": "MONTH",
								"interval_count": 1
								},
								"tenure_type": "REGULAR",
								"sequence": 1,
								"total_cycles": 99,
								"pricing_scheme": {
									"fixed_price": {
										"value": "'.$valorSuscripcion.'",
										"currency_code": "USD"
									}
								}
							}
							],
							"payment_preferences": {
								"auto_bill_outstanding": true,
								"setup_fee": {
							      "value": "'.$valorSuscripcion.'",
							      "currency_code": "USD"
							    },							
								"setup_fee_failure_action": "CONTINUE",
								"payment_failure_threshold": 3
							},
							"taxes": {
								"percentage": "0",
								"inclusive": false
							}
							}',
								CURLOPT_HTTPHEADER => array(
									'Content-Type: application/json',
									'Authorization: Bearer '.$token,
									'Cookie: LANG=en_US%3BUS; ts=vreXpYrS%3D1721325319%26vteXpYrS%3D1626656342%26vt%3Dbc2a88c317aac120001e0080fffcc43d%26vr%3Dbc2a88c317aac120001e0080fffcc43c; ts_c=vr%3Dbc2a88c317aac120001e0080fffcc43c%26vt%3Dbc2a88c317aac120001e0080fffcc43d; tsrce=devdiscoverynodeweb'
								),
							));

				$response = curl_exec($curl3);
				
				$err = curl_error($curl3);

				curl_close($curl3);

				if($err){

					echo "cURL Error #:" . $err;

				}else{
					
					

					$respuesta3 = json_decode($response,true);//true es para captura de propiedades
					$idPlan = $respuesta3['id'];

					//echo $idPlan;

					/*=============================================
					=          Crear Suscripción Paypal           =
					=============================================*/
					$curl4 = curl_init();

					curl_setopt_array($curl4, array(
						CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/billing/subscriptions',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 300,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS =>'{
							"plan_id": "'.$idPlan.'",
							"start_time": "'.$fecha.'",
							"subscriber": {
								"name": {
									"given_name": "'.$this->nombre.'"
									},
									"email_address": "'.$this->email.'"
									},
									"auto_renewal": true,
									"application_context": {
										"brand_name": "Academy of life",
										"locale": "es-MX",
										"shipping_preference": "SET_PROVIDED_ADDRESS",
										"user_action": "SUBSCRIBE_NOW",
										"payment_method": {
											"payer_selected": "PAYPAL",
											"payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
											},
											"return_url": "'.$ruta.'backoffice/index.php?pagina=perfil",
											"cancel_url": "'.$ruta.'backoffice/index.php?pagina=perfil"
										}
									}',
									CURLOPT_HTTPHEADER => array(
										'Content-Type: application/json',
										'Authorization: Bearer '.$token,
										'Cookie: LANG=en_US%3BUS; ts=vreXpYrS%3D1721325319%26vteXpYrS%3D1626656342%26vt%3Dbc2a88c317aac120001e0080fffcc43d%26vr%3Dbc2a88c317aac120001e0080fffcc43c; ts_c=vr%3Dbc2a88c317aac120001e0080fffcc43c%26vt%3Dbc2a88c317aac120001e0080fffcc43d; tsrce=devdiscoverynodeweb'
									),
								));

					$response = curl_exec($curl4);
					$err = curl_error($curl4);

					curl_close($curl4);
					

					if($err){

						echo "cURL Error #:" . $err;

					}else{

						$respuesta4 = json_decode($response,true);//true es para captura de propiedades
						$urlPaypal = $respuesta4['links'][0]['href'];

						echo $urlPaypal;

					}//suscripción
					

				}//Plan			
				

			}//Producto

			
		}//access token


	}//ajaxSuscripcion

	/*=============================================
	Cancelar Suscrpción
	=============================================*/	
	public $idUsuario;

	public function ajaxCancelarSuscripcion(){

		$valor = $this->idUsuario;

		$respuesta = ControladorUsuarios::ctrCancelarSuscripcion($valor);

		echo $respuesta;

	}
	
	

}//AjaxUsuarios

if(isset($_POST['validarEmail'])){

	$valEmail = new AjaxUsuarios();
	$valEmail -> validarEmail = $_POST['validarEmail'];
	$valEmail -> ajaxValidarEmail();

}

/*=============================================
=       Suscripción con Paypal (Objeto)       =
=============================================*/
if(isset($_POST['suscripcion']) && $_POST['suscripcion'] == "ok"){

	$paypal = new AjaxUsuarios();
	$paypal -> nombre = $_POST['nombre'];
	$paypal -> email = $_POST['email'];
	$paypal -> ajaxSuscripcion();

}

/*=============================================
Cancelar Suscrpción
=============================================*/	

if(isset($_POST["idUsuario"])){

	$cancelarSuscripcion = new AjaxUsuarios();
	$cancelarSuscripcion -> idUsuario = $_POST["idUsuario"];
	$cancelarSuscripcion -> ajaxCancelarSuscripcion();

}

