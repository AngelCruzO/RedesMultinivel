<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ControladorUsuarios{

	/*=============================================
	=            Resgistro de usuarios            =
	=============================================*/
	public function ctrRegistroUsuario(){

		$ruta = ControladorRuta::ctrRuta();

		if(isset($_POST['registroNombre'])){
			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',$_POST['registroNombre']) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST['registroEmail']) &&
			   preg_match('/^[a-zA-Z0-9]+$/',$_POST['registroPassword'])){

			   	$encriptarEmail = md5($_POST['registroEmail']);

			   	$tabla = 'usuarios';
			    $datos = array("perfil" => "usuario",
							   "nombre" => $_POST['registroNombre'],
							   "email" => $_POST['registroEmail'],
							   "password" => $_POST['registroPassword'],
							   "suscripcion" => 0,
							   "verificacion" => 0,
							   "email_encriptado" => $encriptarEmail,
							   "patrocinador" => $_POST['patrocinador']);

				$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

				if($respuesta == 'ok'){


					/*=============================================
					=   Verificacion correo electronico           =
					=============================================*/
					date_default_timezone_set("America/Mexico_City");

					$mail = new PHPMailer;

					$mail->Charset = "UTF-8";
					$mail->isMail();
					$mail->setFrom("info@academyoflife.com", "Academy of life");
					$mail->addReplyTo("info@academyoflife.com", "Academy of life");
					$mail->Subject = "Por favor verifique su dirección de correo electrónico";
					$mail->addAddress($_POST['registroEmail']);
					$mail->msgHTML('<div style="width: 100%; background: #eee; position: relative; font-family: sans-serif; padding-bottom: 40px;">

						<center>
						<!--La imagen debe estar subida en internet-->
						<img style="padding: 20px; width: 10%;" src="https://i.pinimg.com/originals/99/b0/e5/99b0e593f9237abf16df5cb1b1a87735.png">
						</center>

						<div style="position: relative; margin: auto; width: 600px; background: white; padding: 20px;">
							<center>
								<img style="padding: 20px; width: 15%;" src="https://img.icons8.com/bubbles/452/email--v1.png">

								<h3 style="font-weight: 100; color: #999;">VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO</h3>

								<hr style="border: 1px solid #ccc; width: 80%;">

								<h4 style="font-weight: 100; color: #999; padding: 0 20px;">Para empezar a usar su cuenta, debe confirmar su dirección de correo electrónico</h4>

								<a href="'.$ruta.$encriptarEmail.'" target="_blank" style="text-decoration: none;">

									<div style="line-height: 60px; background: #0aa; width: 60%; color: white;">Verifique su dirección de correo electrónico</div>
								</a>

								<br>

								<hr style="border: 1px solid #ccc; width: 80%;">

								<h5 style="font-weight: 100; color: #999;">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y eliminarlo.</h5>
							</center>

						</div><!--./div2-->

						</div>');

					$envio = $mail->Send();

					if(!$envio){
						echo '<script>

							swal({
								type: "error",
								title: "¡ERROR!",
								text: "¡Ha ocurrido un problema enviando verificacion de correo electrónico a '.$_POST['registroEmail'].' '.$mail->ErrorInfo.', por favor inténtelo nuevamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then(function(result){

								if(result.value){
									history.back();
								}

							});

						</script>';
				
					}else{
						echo '<script>

							swal({
								type: "success",
								title: "¡SU CUENTA HA SIDO CREADA CORRECTAMENTE!",
								text: "¡Por favor revise su bandeja de entrada o la carpeta SPAM de su correo electrónico para verificar su cuenta!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then(function(result){

								if(result.value){
									window.location = "'.$ruta.'ingreso";
								}

							});

						</script>';
					}
													

					
				}
				

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
								history.back();
							}

						});

				</script>';
				
			}
		}

	}//Termina ctrRegistroUsuarios

	/*=============================================
	=             Mostrar Usuarios                =
	=============================================*/
	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}//ctrMostrarUsuarios

	/*=============================================
	=            Actualizar usuario               =
	=============================================*/
	static public function ctrActualizarUsuario($id, $item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item, $valor);

		return $respuesta;

	}//ctrActualizarUsuario


	/*=============================================
	=            Ingreso usuario                  =
	=============================================*/
	public function ctrIngresoUsuario(){

		if(isset($_POST['ingresoEmail'])){

			if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST['ingresoEmail']) && preg_match('/^[a-zA-Z0-9]+$/',$_POST['ingresoPassword'])){

				$tabla = 'usuarios';
				$item = "email";
				$valor = $_POST['ingresoEmail'];

				$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

				if($respuesta["email"] == $_POST['ingresoEmail'] && $respuesta["password"] == $_POST['ingresoPassword']){

					if($respuesta["verificacion"] == 0){

						echo '<script>

							swal({
								type: "error",
								title: "¡EROR!",
								text: "¡El correo electrónico no ha sido verificado, por favor revise la bandeja de entrada o la carpeta de SPAM de cu correo electrónico para verificar la cuenta, o contáctese con nuestro soporte a info@academyoflife.com!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then(function(result){

								if(result.value){
									history.back();
								}

							});

						</script>';
						return;

					}else{

						$_SESSION['validarSesion'] = "ok";
						$_SESSION['id'] = $respuesta["id_usuario"];

						$ruta = ControladorRuta::ctrRuta();

						echo '<script>
							window.location = "'.$ruta.'backoffice";
						</script>';

					}


				}else{

					echo '<script>

						swal({
							type: "error",
							title: "¡CORREGIR!",
							text: "¡El email o contraseña no coinciden!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){

							if(result.value){
								history.back();
							}

						});

					</script>';
					return;

				}

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
								history.back();
							}

						});

				</script>';

			}

		}

	}//ctrIngresoUsuario
	
	/*=============================================
	=            Cambiar foto perfil              =
	=============================================*/
	public function ctrCambiarFotoPerfil(){

		if(isset($_POST['idUsuarioFoto'])){

			$ruta = $_POST['fotoActual'];

			if(isset($_FILES['cambiarImagen']['tmp_name']) && !empty($_FILES['cambiarImagen']['tmp_name'])){

				/*=============================================
				=           Dimensiones de tamaño             =
				=============================================*/
				list($ancho, $alto) = getimagesize($_FILES['cambiarImagen']['tmp_name']);
				$nuevoAncho = 500;
				$nuevoAlto = 500;

				/*=============================================
				=     Direccion donde guardar imagenes        =
				=============================================*/
				$directorio = "vistas/img/usuarios/".$_POST['idUsuarioFoto'];

				//verificacion de carpetas e imagenes
				if($ruta != ""){

					unlink($ruta);

				}else{

					if(!file_exists($directorio)){
						//creacion de carpetas
						mkdir($directorio, 0755);
					}

				}

				/*=============================================
				=       Validando extension de archivo        =
				=============================================*/
				if($_FILES['cambiarImagen']['type'] == "image/jpeg"){

					//creacion de archivos nuevos tipo imagen

					$aleatorio = mt_rand(100,999);
					$ruta = $directorio."/".$aleatorio.".jpg";
					$origen = imagecreatefromjpeg($_FILES["cambiarImagen"]["tmp_name"]);
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

				}elseif($_FILES['cambiarImagen']['type'] == "image/png"){

					$aleatorio = mt_rand(100,999);
					$ruta = $directorio."/".$aleatorio.".png";
					$origen = imagecreatefrompng($_FILES["cambiarImagen"]["tmp_name"]);
					$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

					imagealphablending($destino, FALSE);
					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

				}else{

					echo '<script>

						swal({
							type: "error",
							title: "¡CORREGIR!",
							text: "¡No se permiten formatos diferentes a JPG y/o PNG!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then(function(result){

							if(result.value){
								history.back();
							}

						});

					</script>';

					return;

				}//extensiones
				
			}//$_FILES['cambiarImagen']



			$tabla = "usuarios";
			$id = $_POST['idUsuarioFoto'];
			$item = "foto";
			$valor = $ruta;

			$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item, $valor);

			if($respuesta == "ok"){

				echo '<script>

					swal({
						type: "success",
						title: "¡CORRECTO!",
						text: "¡La foto de perfil ha sido actualizada!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){

						if(result.value){
							history.back();
						}

					});

				</script>';

			}//$respuesta

		}//$_POST['idUsuarioFoto']

	}//ctrCambiarFotoPerfil
	
	/*=============================================
	=              Cambiar contraseña             =
	=============================================*/
	public function ctrCambiarPassword(){

		if(isset($_POST['idUsuarioPassword'])){

			if($_POST['editarPassword'] != $_POST['confirmarPassword']){
				echo '<script>

					swal({
						type: "error",
						title: "¡CORREGIR!",
						text: "¡Las contraseñas no coinciden, favor de verificar!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){

						if(result.value){
							history.back();
						}

					});

				</script>';
				return;
				
			}else{

			$tabla = "usuarios";
			$id = $_POST['idUsuarioPassword'];
			$item = "password";
			$valor = $_POST['editarPassword'];

			$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item, $valor);

			if($respuesta == "ok"){

				echo '<script>

					swal({
						type: "success",
						title: "¡CORRECTO!",
						text: "¡La contraseña ha sido actualizada!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar"
					}).then(function(result){

						if(result.value){
							history.back();
						}

					});

				</script>';

			}//$respuesta
		}

		}//$_POST['idUsuarioPassword']

	}//ctrCambiarPassword
	

}//Termina ControladorUsuarios

