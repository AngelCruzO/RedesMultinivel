<?php 
require_once "controladores/plantilla.controlador.php";
require_once "controladores/ruta.controlador.php";

require_once "backoffice/controladores/usuarios.controlador.php";
require_once "backoffice/modelos/usuarios.modelo.php";

require_once "backoffice/extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();

?>