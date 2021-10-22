<?php

session_start(); 

//almacenar clase
$ruta = ControladorRuta::ctrRuta();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Academy of life</title>

	<base href="vistas/">

	<link rel="icon" href="img/icono.png">

	<!--=====================================
	VÍNCULOS CSS
	======================================-->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<!-- Fuente Open Sans -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed|Roboto:100|Grand+Hotel" rel="stylesheet">

	<!-- Hoja Estilo Personalizada -->
	<link rel="stylesheet" href="css/style.css">

	<!--=====================================
	VÍNCULOS JAVASCRIPT
	======================================-->

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

	<!-- https://easings.net/es# -->
	<script src="js/plugins/jquery.easing.js"></script>

	<!-- https://markgoodyear.com/labs/scrollup/ -->
	<script src="js/plugins/scrollUP.js"></script>

	<!-- https://www.jqueryscript.net/loading/Handle-Loading-Progress-jQuery-Nite-Preloader.html -->
	<script src="js/plugins/jquery.nite.preloader.js"></script>

	<script src="js/plugins/sweetalert2.all.js"></script>

</head>

<body>

<?php

if(isset($_GET['pagina'])){

	/*=============================================
	=        Validar correo electrónico           =
	=============================================*/
	$item = "email_encriptado";
	$valor = $_GET['pagina'];

	$validarCorreo = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

	if(is_array($validarCorreo) && $validarCorreo["email_encriptado"] == $_GET["pagina"]){

		$id = $validarCorreo["id_usuario"];
		$item = "verificacion";
		$valor = 1;

		$respuesta = ControladorUsuarios::ctrActualizarUsuario($id, $item, $valor);

		if($respuesta == "ok"){

			echo '<script>

				swal({
					type: "success",
					title: "¡CORRECTO!",
					text: "¡Su cuenta ha sido verificada, ya puede ingresar al sistema!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then(function(result){

					if(result.value){
						window.location = "'.$ruta.'ingreso";
					}

				});

			</script>';

			return;

		}

	}

	/*=============================================
	=             Enlace de afiliado              =
	=============================================*/
	$validarEnlace = ControladorUsuarios::ctrMostrarUsuarios("enlace_afiliado", $_GET['pagina']);

	if(is_array($validarEnlace) && $validarEnlace['enlace_afiliado'] == $_GET['pagina'] && $validarEnlace['suscripcion'] == 1){

		//cookie por 7 dias
		setcookie("patrocinador", $validarEnlace["enlace_afiliado"], time() + 604800, "/");

		include "paginas/inicio.php";

	}else if($_GET['pagina'] == "inicio"){//Lista blanca de paginas

		include "paginas/".$_GET['pagina'].".php";

	}else if($_GET['pagina'] == "ingreso"){
		if(isset($_POST['idioma'])){
			if($_POST['idioma'] == 'es'){
				include "paginas/ingreso.php";
			}else{
				include "paginas/ingreso_en.php";
			}

		}else{
			include "paginas/ingreso.php";
		}
		
	}else if($_GET['pagina'] == "registro"){

		if(isset($_POST['idioma'])){
			if($_POST['idioma'] == 'es'){
				include "paginas/registro.php";
			}else{
				include "paginas/registro_en.php";
			}

		}else{
			include "paginas/registro.php";
		}
		
	}else{
		include "paginas/inicio.php";	
	}

}else{
	include "paginas/inicio.php";
}


?>

<?php if(!isset($_COOKIE['ver_cookies'])): ?>

<div class="jumbotron bg-white w-100 text-center py-4 shadow-lg cookies">
	
	<p>Este sitio web utiliza cookies para garantizar que obtenga la mejor experiencia al navegar nuestro sitio.
	<a href="<?php echo $ruta; ?>politicas-de-privacidad.pdf" target="_blank">Leer más</a>
	</p>

	<button class="btn btn-info btn-sm px-5">OK</button>

</div>

<?php endif ?>

<input type="hidden" value="<?php echo $ruta; ?>" id="ruta">
<script src="js/script.js"></script>

</body>

</html>
