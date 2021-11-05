/*================================
=            CKEDITOR            =
================================*/
ClassicEditor
.create(document.querySelector("#editor"),{

	toolbar: ['heading','|','bold','italic','link','bulletedList','numberedList','|','undo','redo']

})
.then(function(editor){

	$(".ck-content").css({"height":"200px"})

})
.catch(function(error){
	
	console.log("error", error);

})

/*==================================================
=            Subiendo archivos adjuntos            =
==================================================*/
$(".subirAdjuntos").change(function(){

	var archivos = this.files;

	for(var i=0;i<archivos.length;i++){

		/*====================================================
		=            validar formatos de archivos            =
		====================================================*/
		if(archivos[i]["type"] != "image/jpeg" &&
		   archivos[i]["type"] != "image/png" &&
		   archivos[i]["type"] != "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" &&
		   archivos[i]["type"] != "application/vnd.ms-excel" &&
		   archivos[i]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
		   archivos[i]["type"] != "application/msword" &&
		   archivos[i]["type"] != "application/pdf"){

			$(".subirAdjuntos").val("");

			swal({
				title: "Error al subir los Archivos",
				text: "¡El formato del los archivos no es correcto, debe ser: JPG, PNG, EXCEL, WORD O PDF!",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});

			return;

		}else if(archivos[i]["size"] > 32000000){

			$(".subirAdjuntos").val("");

			swal({
				title: "Error al subir los Archivos",
				text: "¡Los archivos no deben pesar más de 32MB",
				type: "error",
				confirmButtonText: "¡Cerrar!"
			});

			return;

		}else{

			multiplesArchivos(archivos[i]);			

		}//formatos

	}//for

})

var archivosTemporales = [];

function multiplesArchivos(archivo){
	
	var datosArchivo = new FileReader;
	datosArchivo.readAsDataURL(archivo);

	$(datosArchivo).on("load", function(event){

		var rutaArchivo = event.target.result;

		if(archivo["type"] == "image/jpeg" || archivo["type"] == "image/png"){

			$(".mailbox-attachments").append(`

				<li temporal="`+rutaArchivo+`">
	              <span class="mailbox-attachment-icon has-img"><img src="`+rutaArchivo+`" alt="Attachment"></span><br>

	              <div class="mailbox-attachment-info">
	                <a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"></i> `+archivo['name']+`</a>
	                    <span class="mailbox-attachment-size clearfix mt-1">
	                      <span>`+archivo['size']+` Bytes</span>
	                      <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal=""><i class="fas fa-times"></i></a>	                    
	                    </span>
	              </div>
	            </li>

			`);

		}//imagenes

		if(archivo["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || archivo["type"] == "application/vnd.ms-excel"){

			$(".mailbox-attachments").append(`

				<li temporal="`+rutaArchivo+`">
					<span class="mailbox-attachment-icon"><i class="far fa-file-excel"></i></span><br>

					<div class="mailbox-attachment-info">
						<a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"> `+archivo['name']+`</i></a>
						<span class="mailbox-attachment-size clearfix mt-1">
					       <span>`+archivo['size']+`Bytes</span>
					       <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal=""><i class="fas fa-times"></i></a>
						</span>
					</div>
				</li>

			`);

		}//excel

		if(archivo["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || archivo["type"] == "application/msword"){

			$(".mailbox-attachments").append(`

				<li temporal="`+rutaArchivo+`">
					<span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span><br>

					<div class="mailbox-attachment-info">
						<a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"> `+archivo['name']+`</i></a>
						<span class="mailbox-attachment-size clearfix mt-1">
					       <span>`+archivo['size']+`Bytes</span>
					       <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal=""><i class="fas fa-times"></i></a>
						</span>
					</div>
				</li>

			`);

		}//word

		if(archivo["type"] == "application/pdf"){

			$(".mailbox-attachments").append(`

				<li temporal="`+rutaArchivo+`">
					<span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span><br>

					<div class="mailbox-attachment-info">
						<a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"> `+archivo['name']+`</i></a>
						<span class="mailbox-attachment-size clearfix mt-1">
					       <span>`+archivo['size']+`Bytes</span>
					       <button type="button" class="btn btn-default btn-sm float-right quitarAdjunto" temporal=""><i class="fas fa-times"></i></button>					  
						</span>
					</div>
				</li>

			`);

		}//word

		if(archivosTemporales.length != 0){

			archivosTemporales = JSON.parse($(".archivosTemporales").val());

		}

		archivosTemporales.push(rutaArchivo);

		$(".archivosTemporales").val(JSON.stringify(archivosTemporales));//conversion de un string a JSON

	})

}//multiplesArchivos

/*==============================================
=            Quitar archivo adjunto            =
==============================================*/
$(document).on("click", ".quitarAdjunto", function(){	

	var listaTemporales = JSON.parse($(".archivosTemporales").val());//conversion de JSON a array
	var quitarAdjunto = $(".quitarAdjunto");

	for(var i=0;i<listaTemporales.length;i++){

		$(quitarAdjunto[i]).attr("temporal", listaTemporales[i]);

		var quitarArchivo = $(this).attr("temporal");

		if(quitarArchivo == listaTemporales[i]){

			listaTemporales.splice(i, 1);

			$(".archivosTemporales").val(JSON.stringify(listaTemporales));//conversion de un string a JSON

			$(this).parent().parent().parent().remove();

		}//quitarArchivo == listaTemporales[i]

	}//for

})

/*=========================================
=            Datatable tickets            =
=========================================*/
var id_usuario = $(".idUsuario").val();
var tipoTicket = $(".tipoTicket").val();

// $.ajax({

// 	"url": "ajax/soporte-tabla.ajax.php?id_usuario="+id_usuario+"&tipo="+tipoTicket,
// 	success: function(respuesta){
// 		console.log("respuesta", respuesta);		
// 	}

// })

$(".tablaTickets").DataTable({

	"ajax": "ajax/soporte-tabla.ajax.php?id_usuario="+id_usuario+"&tipo="+tipoTicket,
	"deferRender": true,
	"retrieve": true,
	"processing": true,
	"language": {

        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }

    }

});

/*=========================================
=            Enviar a papelera            =
=========================================*/
$(".btnPapelera").click(function(){
	
	var ticketsPapelera = $(this).attr("idTickets");
	var idUsuario = $(this).attr("idUsuario");
	var tipoTickets = $(this).attr("tipoTickets");

	var datos = new FormData();
	datos.append("ticketsPapelera", ticketsPapelera);
	datos.append("idUsuario", idUsuario);
	datos.append("tipoTickets", tipoTickets);

	$.ajax({

		url: "ajax/soporte.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta) {

			if(respuesta == "ok"){

	    		swal({
							type:"success",
						  	title: "¡TICKET ENVIADO CORRECTAMENTE A LA PAPELERA!",
						  	text: "¡Puede recuperar el ticket si lo desea en la sección de papelera!",
						  	showConfirmButton: true,
							confirmButtonText: "Cerrar"
						  
					}).then(function(result){

							if(result.value){   
							    window.location = "soporte";
							  } 
							  
					});

	    	}//respuesta == "ok"

	    	if(respuesta == "recuperado"){

	    		swal({
							type:"success",
						  	title: "¡TICKET RECUPERADO!",
						  	text: "¡Revisa en las otras bandejas el ticket recuperado!",
						  	showConfirmButton: true,
							confirmButtonText: "Cerrar"
						  
					}).then(function(result){

							if(result.value){   
							    window.location = "soporte";
							  } 
							  
					});

	    	}//respuesta == "recuperado"

		}//respuesta success

	})//ajax

})//click

/*==============================
=            iCheck            =
==============================*/
$(".tablaTickets").on("draw.dt", function(){

	$(".mailbox-messages input[type='checkbox']").iCheck({

		checkboxClass: "icheckbox_flat-blue",
		radioClass: "iradio_flat-blue"

	});

	/*=========================================
	=            Enviar a papelera            =
	=========================================*/
	var ticketCheckbox = $(".ticketCheckbox");
	var idTickets = [];

	for (var i = 0; i < ticketCheckbox.length; i++) {

		/*===========================================
		=            Seleccionar tickets            =
		===========================================*/		
		$(ticketCheckbox[i]).on("ifChecked", function(event){
			
			idTickets.push($(this).attr("idTicket"));

			if($(".btnPapelera").attr("idTickets") != ""){

				ticketsPapelera = $(".btnPapelera").attr("idTickets").split(",");

				ticketsPapelera.push($(this).attr("idTicket"));

				$(".btnPapelera").attr("idTickets", idTickets.toString());

			}else{

				$(".btnPapelera").attr("idTickets", idTickets.toString());

			}

		})

		/*=============================================
    	Quitar el Check para enviar a la papelera
    	=============================================*/

    	$(ticketCheckbox[i]).on("ifUnchecked", function(event){

    		var quitarTicketsPapelera = $(".btnPapelera").attr("idTickets").split(",");

    		for(var f = 0; f < quitarTicketsPapelera.length; f++){

    			if(quitarTicketsPapelera[f] == $(this).attr("idTicket")){

    				quitarTicketsPapelera.splice(f, 1);

    				idTickets.splice(f, 1);

    				$(".btnPapelera").attr("idTickets", quitarTicketsPapelera.toString());

    			}

    		}//for

    	})		

	}//for

})

$(".checkbox-toggle").click(function(){

	var clicks = $(this).data('clicks');

	if(clicks){
		$(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
		$(".far", this).removeClass("fa-check-square").addClass("fa-square");
	}else{
		$(".mailbox-messages input[type='checkbox']").iCheck("check");
		$(".far", this).removeClass("fa-square").addClass("fa-check-square");
	}

	$(this).data("clicks", !clicks);

})