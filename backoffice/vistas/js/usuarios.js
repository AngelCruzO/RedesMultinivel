/*=============================================
=            Listado de paises                =
=============================================*/
$.ajax({

	url:"vistas/js/plugins/paises.json",
	type: "GET",
	success: function(respuesta){
		
		respuesta.forEach(seleccionarPais);

		function seleccionarPais(item, index){			
			var pais =  item.name;
			var codPais =  item.code;
			var dial = item.dial_code;

			$("#inputPais").append(
				`<option value="`+pais+`,`+codPais+`,`+dial+`">`+pais+`</option>`
			)

		}//seleccionarPais
	}//success

});

/*=============================================
=                SELECT2                      =
=============================================*/
$('.select2').select2();

/*=============================================
=        Agregar dial code del pais           =
=============================================*/
$("#inputPais").change(function(){
	/*split convierte un valor en array*/
	$(".dialCode").html($(this).val().split(",")[2])

});

/*=============================================
=               Input Mask                    =
=============================================*/
$('[data-mask]').inputmask();

/*=============================================
=               Firma virtual                 =
=============================================*/
$("#signatureparent").jSignature({
	color: "#333",
	lineWidth: 1,
	width: 320,
	height: 100
});

$(".repetirFirma").click(function(){
	$("#signatureparent").jSignature("reset");
});

/*=============================================
=           Funcion generar Cookies           =
=============================================*/
function crearCookie(nombre, valor, diasExpiracion){

	var hoy = new Date();
	hoy.setTime(hoy.getTime() + (diasExpiracion*24*60*60*1000));//formato expiracion

	var fechaExpiracion = "expires=" +hoy.toUTCString();
	document.cookie = nombre + "=" +valor+"; "+fechaExpiracion;

}

/*=============================================
=      Validar formulario suscripcion         =
=============================================*/
$(".suscribirse").click(function(){

	$(".alert").remove();

	var nombre = $("#inputName").val();
	var email = $("#inputEmail").val();
	var patrocinador = $("#inputPatrocinador").val();
	var enlace_afiliado = $("#inputAfiliado").val();
	var pais = $("#inputPais").val().split(",")[0];
	var codigo_pais = $("#inputPais").val().split(",")[1];
	var telefono_movil = $("#inputPais").val().split(",")[2]+" "+$("#inputMovil").val();
	var red = $("#tipoRed").val();
	var aceptarTerminos = $("#aceptarTerminos:checked").val();

	if($("#signatureparent").jSignature("isModified")){

		var firma = $("#signatureparent").jSignature("getData", "image/svg+xml");

	}

	//Validar datos
	if( nombre == "" ||
		email == "" ||
		patrocinador == "" ||
		enlace_afiliado == "" ||
		pais == "" ||
		codigo_pais == "" ||
		telefono_movil == "" ||
		red == "" ||
		aceptarTerminos != "on" ||
		!$("#signatureparent").jSignature('isModified')){

			$(".suscribirse").before(`
				<div class="alert alert-danger">Faltan datos, no ha aceptado o no ha firmado los términos y condiciones</div>
			`);

		return;


	}else{

		crearCookie("enlace_afiliado", enlace_afiliado, 1);
		crearCookie("patrocinador", patrocinador, 1);
		crearCookie("pais", pais, 1);
		crearCookie("codigo_pais", codigo_pais, 1);
		crearCookie("telefono_movil", telefono_movil, 1);
		crearCookie("red", red, 1);
		crearCookie("firma", firma[1], 1);


		//funcionamiento para la Api de Paypal
		var datos = new FormData();
		datos.append("suscripcion","ok");
		datos.append("nombre", nombre);
		datos.append("email", email);

		$.ajax({

			url: "ajax/usuarios.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			//dataType: "json",
			beforeSend: function(){

				//preload
				$(".suscribirse").after(` 

					<img src="vistas/img/plantilla/status.gif" class="ml-3" style="width:30px; height30px;">
					<span class="alert alert-warning ml-3">Procesando la suscripción, no cerrar esá página</span>

				`)
			},
			success: function(respuesta){

				//console.log("respuesta", respuesta);

				window.location = respuesta;

			}//respuesta

		});

	}
	

})

/*=============================================
=               Tabla Usuarios                =
=============================================*/
// $.ajax({

// 	url: "ajax/tabla-usuarios.ajax.php",
// 	success: function(respuesta){
// 		console.log("respuesta", respuesta);
// 	}

// });


$(".tablaUsuarios").DataTable({
	"ajax": "ajax/tabla-usuarios.ajax.php",
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


/*==============================================
=           Copiar en el CLIPBOARD             =
==============================================*/
$(".copiarLink").click(function(){
	
	var temporal = $("<input>");

	$("body").append(temporal);

	temporal.val($("#linkAfiliado").val()).select();

	document.execCommand("copy");

	temporal.remove();

	$(this).parent().parent().after(` 

		<div class="text-muted copiado">Enlace copiado en el portapapeles</div>

	`);

	setTimeout(function(){

		$(".copiado").remove();

	},2000);

});

/*=============================================
=            Cancelar suscripcion             =
=============================================*/
$(".cancelarSuscripcion").click(function(){
	
	var ruta = $("#ruta").val();
	var idSuscripcion = $(this).attr("idSuscripcion");
	var idUsuario = $(this).attr("idUsuario");

	swal({
		title: "¿Está seguro de cancelar la suscripción?",
		text: "¡Si no lo está puede cancelar la acción, recuerde que perderá todo el trabajo que ha hecho con la red pero recibirá el pago de su último mes!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Si, cancelar suscripción!'
	}).then(function(result){

		if(result.value){

			var token = null;
			
			/*=============================================
			=                Access Token                 =
			=============================================*/
			var settings12 = {
				"url": "https://api-m.sandbox.paypal.com/v1/oauth2/token",
				"method": "POST",
				"timeout": 0,
				"headers": {
					"Authorization": "Basic QVdxS1ZUb0N1VWVtZVRzNjE2N01IdGl4SDVEN3dhaEtmUGpYQjl0U1RBUU41ZzdYZmN2ZmFZczRnbjE0d2Q1dHJSc3pBTmlzam9mbzFQbmU6RUR1aUhKUnRuX3lqU1U2MGpaeDV2Y1lRNk5oeU9BMmwzU3JrMmNVUjdpcHVTMmhtdXpiM1E3Qmk0c3JxLVdzdXZWR0NodWNvUGszT1U3VHI=",
					"Content-Type": "application/x-www-form-urlencoded"
				},
				"data": {
					"grant_type": "client_credentials"
				}
			};

			$.ajax(settings12).done(function (response) {
				token = "Bearer "+response["access_token"];

				/*=============================================
				=            Cancelar suscripción             =
				=============================================*/
				var settings2 = {
					"url": "https://api-m.sandbox.paypal.com/v1/billing/subscriptions/"+idSuscripcion+"/cancel",
					"method": "POST",
					"timeout": 0,
					"headers": {
						"Content-Type": "application/json",
						"Authorization": token
						},
					"data": JSON.stringify({
						"reason": "Not satisfied with the service"
					}),
				};

				$.ajax(settings2).done(function (response) {
					
					//if(response = "undefined"){

						var datos = new FormData();
						datos.append("idUsuario", idUsuario);

						$.ajax({

							url: "ajax/usuarios.ajax.php",
							method: "POST",
							data: datos,
							cache: false,
							contentType: false,
							processData: false,
							success: function(respuesta) {
								
								if(respuesta == "ok"){

									swal({
										type:"success",
									  	title: "¡Su suscripción ha sido cancelada con éxito!",
									  	text: "¡Continua disfrutando de nuestro contenido gratuito!",
									  	showConfirmButton: true,
										confirmButtonText: "Cerrar"
									  
									}).then(function(result){

											
											if(result.value){   
											    window.location = "perfil";
											    
											} 
									});
													
								}

								
							}//respuesta

						});//ajax

					//}//undefined

				});//Cancelar
				
			});//token

		}//result.Value

	});//result

});

/*=============================================
=               Pinterest Grid                =
=============================================*/
$('.grid').pinterest_grid({
	no_columns: 3,
	padding_x: 10,
	padding_y: 10,
	margin_bottom: 50,
	single_column_breakpoint: 700
});