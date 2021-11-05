<?php 

class ControladorSoporte{

	/*====================================
	=            Nuevo ticket            =
	====================================*/
	public function ctrCrearTicket(){

		if (isset($_POST['mensaje'])){

			$url = ControladorGeneral::ctrRuta();

			if(preg_match('/^[0-9]+$/', $_POST['remitente']) && 
			   preg_match('/^[\/\=\\&\\;\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÓ ]+$/', $_POST['asunto']) &&
			   preg_match('/^[\/\=\\&\\;\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÓ ]+$/', $_POST['mensaje'])){

				$adjuntosArray = array();

				if($_POST['adjuntos'] != ""){


					/*===============================================================
					=            Crear directorio para archivos adjuntos            =
					===============================================================*/
					$directorio = "vistas/img/tickets/".$_POST['remitente'];

					if(!(file_exists($directorio))){

						mkdir($directorio, 0755);

					}

					$adjuntos = json_decode($_POST['adjuntos'], true);

					foreach ($adjuntos as $key => $value) {
						
						$separarAdjunto = explode(";", $value);

						$separarBase64 = explode(",", $separarAdjunto[1]);

						if($separarAdjunto[0] == 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' || $separarAdjunto[0] == 'data:application/vnd.ms-excel'){

							$aleatorio = mt_rand(100, 999);
							$ruta = $directorio."/".$aleatorio.".xlsx";

							$archivo = base64_decode($separarBase64[1]);

							file_put_contents($ruta, $archivo);

							array_push($adjuntosArray, $ruta);

						}/*excel*/else if($separarAdjunto[0] == 'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $separarAdjunto[0] == 'data:application/msword'){

							$aleatorio = mt_rand(100, 999);
							$ruta = $directorio."/".$aleatorio.".docx";

							$archivo = base64_decode($separarBase64[1]);

							file_put_contents($ruta, $archivo);

							array_push($adjuntosArray, $ruta);

						}/*word*/else if($separarAdjunto[0] == 'data:application/pdf'){

							$aleatorio = mt_rand(100, 999);
							$ruta = $directorio."/".$aleatorio.".pdf";

							$archivo = base64_decode($separarBase64[1]);

							file_put_contents($ruta, $archivo);

							array_push($adjuntosArray, $ruta);

						}/*pdf*/else if($separarAdjunto[0] == 'data:image/jpeg'){

							$aleatorio = mt_rand(100, 999);
							$ruta = $directorio."/".$aleatorio.".jpg";

							$archivo = base64_decode($separarBase64[1]);

							file_put_contents($ruta, $archivo);

							array_push($adjuntosArray, $ruta);

						}/*jpeg*/else if($separarAdjunto[0] == 'data:image/png'){

							$aleatorio = mt_rand(100, 999);
							$ruta = $directorio."/".$aleatorio.".png";

							$archivo = base64_decode($separarBase64[1]);

							file_put_contents($ruta, $archivo);

							array_push($adjuntosArray, $ruta);

						}/*png*/else{

							echo '<script>

								swal({

									type: "error",
									title: "¡CORREGIR!",
									text: "¡No se permiten formatos diferentes a JPG, PNG, EXCEL, WORD o PDF",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"

								}).then(function(result){

									if(result.value){
										window.location = "'.$url.'backoffice/soporte";
									}

								});

							</script>';

						}//validacion de formatos

					}//foreach					

				}//Adjuntos

					/*===============================================
					=            Enviamos info al modelo            =
					===============================================*/
					$tabla = "soporte";

					if(is_array($_POST['receptor'])){

						/*==========================================================
						=            Enviar ticket a todos los usuarios            =
						==========================================================*/
						if($_POST['receptor'][0] == 0){

							$listaUsuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);

							foreach ($listaUsuarios as $key => $value) {
								
								if($key != 0){

									$datos = array("remitente" => $_POST['remitente'],
												   "receptor" => $value['id_usuario'],
												   "asunto" => $_POST['asunto'],
												   "mensaje" => $_POST['mensaje'],
												   "adjuntos" => json_encode($adjuntosArray),
												   "tipo" => "enviado");

									$respuesta = ModeloSoporte::mdlCrearTicket($tabla, $datos);

								}

							}//foreach

						}else{

							foreach ($_POST['receptor'] as $key => $value) {

								$datos = array("remitente" => $_POST['remitente'],
												   "receptor" => $_POST['receptor'][$key],
												   "asunto" => $_POST['asunto'],
												   "mensaje" => $_POST['mensaje'],
												   "adjuntos" => json_encode($adjuntosArray),
												   "tipo" => "enviado");

								$respuesta = ModeloSoporte::mdlCrearTicket($tabla, $datos);

							}//foreach

						}//numero de envios
												

					}else{

						$datos = array("remitente" => $_POST['remitente'],
								   "receptor" => $_POST['receptor'],
								   "asunto" => $_POST['asunto'],
								   "mensaje" => $_POST['mensaje'],
								   "adjuntos" => json_encode($adjuntosArray),
								   "tipo" => "enviado");

						$respuesta = ModeloSoporte::mdlCrearTicket($tabla, $datos);

					}//is_array($_POST['receptor'])	

					if($respuesta == "ok"){

						echo '<script>

							swal({

								type: "success",
								title: "¡SU TICKET HA SIDO CORRECTAMENTE ENVIADO!",
								text: "¡Muy pronto nos comunicaremos con usted!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"

							}).then(function(result){

								if(result.value){
									window.location = "'.$url.'backoffice/soporte";
								}

							});

						</script>';

					}//ok

			}else{

				echo '<script>

					swal({

						type: "error",
						title: "¡CORREGIR!",
						text: "¡No se permiten caracteres especiales en ninguno de los campos!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"

					}).then(function(result){

						if(result.value){
							window.location = "'.$url.'backoffice/soporte";
						}

					});

				</script>';

			}//validacion de datos

		}//isset($_POST['mensaje'])

	}//ctrCrearTicket

	/*=======================================
	=            Mostrar tickets            =
	=======================================*/
	static public function ctrMostrarTickets($item, $valor){

		$tabla = "soporte";

		$respuesta = ModeloSoporte::mdlMostrarTickets($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarTickets

	/*==========================================
	=            Actualizar tickets            =
	==========================================*/
	static public function ctrActualizarTicket($id, $item, $valor){

		$tabla = "soporte";

		$respuesta = ModeloSoporte::mdlActualizarTicket($tabla, $id, $item, $valor);

		return $respuesta;

	}//ctrActualizarTicket	

}//ControladorSoporte
