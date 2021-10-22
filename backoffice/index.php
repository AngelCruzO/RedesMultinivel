<?php  

require_once "controladores/plantilla.controlador.php";
require_once "controladores/general.controlador.php";

require_once "controladores/usuarios.controlador.php";
require_once "modelos/usuarios.modelo.php";

require_once "controladores/academia.controlador.php";
require_once "modelos/academia.modelo.php";

require_once "controladores/multinivel.controlador.php";
require_once "modelos/multinivel.modelo.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();

?>