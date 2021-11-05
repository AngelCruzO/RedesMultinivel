<?php

session_start();

$ruta = ControladorGeneral::ctrRuta();
$valorSuscripcion = ControladorGeneral::ctrValorSuscripcion();
$patrocinador = ControladorGeneral::ctrPatrocinador();

if(!isset($_SESSION['validarSesion'])){

  echo '<script>
    window.location = "'.$ruta.'ingreso";
  </script>';

  return;

}

$item = "id_usuario";
$valor = $_SESSION['id'];

$usuario = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Backoffice | Ventas por suscripción</title>

  <link rel="icon" href="vistas/img/plantilla/icono.png">

  <meta name="viewport" content="width=device-width, initial-scale=1">

 <!--=====================================
  Vínculos CSS
  ======================================-->

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Theme style -->
  <link rel="stylesheet" href="vistas/css/plugins/adminlte.min.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="vistas/css/plugins/OverlayScrollbars.min.css">

  <!-- jdSlider -->
  <link rel="stylesheet" href="vistas/css/plugins/jdSlider.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="vistas/css/plugins/select2.min.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="vistas/css/plugins/dataTables.bootstrap4.min.css"> 
  <link rel="stylesheet" href="vistas/css/plugins/responsive.bootstrap.min.css">

  <!-- JQVMap -->
  <link rel="stylesheet" href="vistas/css/plugins/jquery-jvectormap-1.2.2.css">

  <!-- jOrgChart -->
  <link rel="stylesheet" href="vistas/css/plugins/jquery.jOrgChart.css">

  <!-- Morris -->
  <link rel="stylesheet" href="vistas/css/plugins/morris.css">

  <!-- iCheck -->
  <link rel="stylesheet" href="vistas/css/plugins/iCheck-flat-blue.css">

  <!--Estilos personalizados-->
  <link rel="stylesheet" href="vistas/css/style.css"> <!--Va al final para poder editar algun estilo de los plugins-->

  <!--=====================================
  Vínculos JS
  ======================================-->

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

  <!-- AdminLTE App -->
  <script src="vistas/js/plugins/adminlte.min.js"></script>

  <!-- overlayScrollbars -->
  <script src="vistas/js/plugins/jquery.overlayScrollbars.min.js"></script>

  <!-- jdSlider -->
  <script src="vistas/js/plugins/jdSlider.js"></script>

  <!-- Select2 -->
  <script src="vistas/js/plugins/select2.full.min.js"></script>

  <!-- inputmask -->
  <script src="vistas/js/plugins/jquery.inputmask.js"></script>

  <!-- jSignature-->
  <script src="vistas/js/plugins/jSignature.js"></script>
  <script src="vistas/js/plugins/jSignature.CompressorSVG.js"></script>

  <!-- Sweet Alert 2 -->
  <script src="vistas/js/plugins/sweetalert2.all.js"></script>

  <!-- dataTables -->
  <script src="vistas/js/plugins/jquery.dataTables.min.js"></script>
  <script src="vistas/js/plugins/dataTables.bootstrap4.min.js"></script>
  <script src="vistas/js/plugins/dataTables.responsive.min.js"></script>
  <script src="vistas/js/plugins/responsive.bootstrap.min.js"></script>

  <!--HLS-->
  <script src="vistas/js/plugins/hls.min.js"></script>

  <!-- Pinterest Grid -->
  <script src="vistas/js/plugins/pinterest_grid.js"></script>

  <!-- JQVMap -->
  <script src="vistas/js/plugins/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="vistas/js/plugins/jquery-jvectormap-world-mill-en.js"></script>

  <!-- Knob -->
  <script src="vistas/js/plugins/jquery.knob.js"></script>

  <!-- jOrgChart -->
  <script src="vistas/js/plugins/jquery.jOrgChart.js"></script>

  <!-- jQuery Number -->
  <script src="vistas/js/plugins/jquerynumber.min.js"></script>

  <!-- Preload-->
  <script src="vistas/js/plugins/jquery.nite.preloader.js"></script>

  <!-- Morris -->
  <script src="vistas/js/plugins/morris.min.js"></script>
  <script src="vistas/js/plugins/raphael-min.js"></script>

  <!-- CKEditor -->
  <script src="vistas/js/plugins/ckeditor.js"></script>

  <!-- iCheck https://github.com/fronteed/iCheck-->
  <script src="vistas/js/plugins/icheck.min.js"></script>

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
	
	<div class="wrapper">

		<?php
	
		include "paginas/modulos/header.php";

		include "paginas/modulos/menu.php";

		/*=============================================
		=            Paginas del sitio                =
		=============================================*/

    if(isset($_GET['pagina'])){

      $categorias = ControladorAcademia::ctrMostrarCategorias(null,null);
      $paginaAcademia = null;

      foreach ($categorias as $key => $value) {

        if($_GET['pagina'] == $value['ruta_categoria']){

          $paginaAcademia = $value['ruta_categoria'];

        }

      }

      /* Lista blanca de paginas */      
      if($_GET['pagina'] == 'inicio' || 
         $_GET['pagina'] == 'perfil' ||
         $_GET['pagina'] == 'usuarios' ||
         $_GET['pagina'] == 'uninivel' ||
         $_GET['pagina'] == 'binaria' ||
         $_GET['pagina'] == 'matriz' ||
         $_GET['pagina'] == 'ingresos-uninivel' ||
         $_GET['pagina'] == 'ingresos-binaria' ||
         $_GET['pagina'] == 'ingresos-matriz' ||
         $_GET['pagina'] == 'plan-compensacion' || 
         $_GET['pagina'] == 'soporte' ||
         $_GET['pagina'] == 'salir'){
        include "paginas/".$_GET['pagina'].".php";
      }elseif($_GET['pagina'] == $paginaAcademia){
        include "paginas/academia.php";
      }else{
        include "paginas/error404.php";
      }

    }else{
      include "paginas/inicio.php";
    }

		include "paginas/modulos/footer.php";

		?>
		
	</div>

<input type="hidden" value="<?php echo $valorSuscripcion; ?>" id="valorSuscripcion">

<script src="vistas/js/inicio.js"></script>
<script src="vistas/js/usuarios.js"></script>
<script src="vistas/js/multinivel.js"></script>
<script src="vistas/js/ingresos.js"></script>
<script src="vistas/js/soporte.js"></script>
</body>
</html>
