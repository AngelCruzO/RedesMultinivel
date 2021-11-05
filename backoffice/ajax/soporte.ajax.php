<?php

require_once "../controladores/soporte.controlador.php";
require_once "../modelos/soporte.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class SoporteAjax{

	/*========================================
	=            Tickets papelera            =
	========================================*/
	public $ticketsPapelera;
	public $idUsuario;
	public $tipoTickets;

	public function ctrTicketsPapelera(){

		$arrayTicketsPapelera = explode(",", $this->ticketsPapelera);

		for ($i=0; $i < count($arrayTicketsPapelera); $i++) { 
			
			$ticket = ControladorSoporte::ctrMostrarTickets("id_soporte", $arrayTicketsPapelera[$i]);

			if($ticket[0]['papelera'] != null){

				$papelera = json_decode($ticket[0]['papelera']);

				if($this->tipoTickets == "papelera"){

					array_push($papelera, $this->idUsuario);

					ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "papelera", json_encode($papelera));

					$respuesta = ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "tipo", "papelera");

				}else{

					for ($f=0; $f < count($papelera); $f++) { 
						
						if($papelera[$f] == $this->idUsuario){

							array_splice($papelera, $f, 1);

						}

					}//for

					ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "papelera", json_encode($papelera));

					if(count($papelera) == 0){

						$respuesta = ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "tipo", "enviado");

						echo "recuperado";

						return;

					}else{

						$respuesta = ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "tipo", "papelera");

					}//count($papelera) == 0

				}//$this->tipoTickets == "papelera"

			}else{

				$papelera = array();

				array_push($papelera, $this->idUsuario);

				ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "papelera", json_encode($papelera));

				$respuesta = ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "tipo", "papelera");

			}//$ticket[0]['papelera'] != null

			$respuesta = ControladorSoporte::ctrActualizarTicket($arrayTicketsPapelera[$i], "tipo", "papelera");

		}//for

		echo $respuesta;

	}//ctrTicketsPapelera

}//SoporteAjax

if(isset($_POST['ticketsPapelera'])){

	$eliminar = new SoporteAjax();
	$eliminar -> ticketsPapelera = $_POST['ticketsPapelera'];
	$eliminar -> idUsuario = $_POST['idUsuario'];
	$eliminar -> tipoTickets = $_POST['tipoTickets'];
	$eliminar->ctrTicketsPapelera();

}