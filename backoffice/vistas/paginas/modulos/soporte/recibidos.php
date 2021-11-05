<div class="card card-primary card-outline">

	<!-- HEADER TICKETS RECIBIDOS -->
	<div class="card-header pb-3">

		<h3 class="card-title">Tickets Recibidos</h3>

		<div class="card-tools">

			<div class="mailbox-controls pb-4">

				<button type="button" class="btn btn-default btn-sm checkbox-toggle">
					<i class="far fa-square"></i>
				</button>

				<div class="btn-group">
					<a href="#">
						<button type="button" class="btn btn-default btn-sm btnPapelera" data-toggle="tooltip" title="Enviar a papelera" idTickets idUsuario="<?php echo $usuario['id_usuario']; ?>" tipoTickets="papelera">
							<i class="fas fa-trash"></i>
						</button>
					</a>
				</div>

				<a href="<?php echo $ruta ?>backoffice/index.php?pagina=soporte&soporte=recibidos" class="btn btn-default btn-sm">
					<i class="fas fa-sync-alt"></i>
				</a>

			</div><!--./mailbox-controls-->

		</div><!--./card-tools-->

	</div><!--./card-header-->

	<!-- BODY TICKETS RECIBIDOS -->
	<div class="card-body p-3 mailbox-messages">

		<input type="hidden" class="tipoTicket" value="recibidos">
		<input type="hidden" class="idUsuario" value="<?php echo $usuario['id_usuario'] ?>">

		<table class="table table-bordered table-striped dt-responsive tablaTickets" width="100%">

			<thead>
				<tr>
					<th>Seleccionar</th>
					<th>Remite</th>
					<th>Asunto</th>
					<th>Adjuntos</th>
					<th>Fecha y hora</th>
				</tr>	
			</thead><!--./thead-->

			<tbody>
				<!-- <tr>
					<td><input type="checkbox"><i class="far fa-square"></i></td>
				    <td>Lorenzo Gomez</td>
				    <td>Lorem Ipsum</td>
				    <td><i class="fas fa-paperclip"></i></td>
				    <td>2020-01-22 23:59:00</td>
				</tr>	 -->			
			</tbody><!--./tbody-->

		</table><!--./table-->

	</div><!--./card-body-->

</div><!--./card-->