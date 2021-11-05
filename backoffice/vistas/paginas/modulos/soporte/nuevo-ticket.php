<?php 

$listaUsuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);

?>

<div class="card card-primary card-outline">

	<div class="card-header">
		<h3 class="card-title">Crear un nuevo Ticket</h3>
	</div><!--./card-title-->

	<form method="post" enctype="multipart/form-data">

		<div class="card-body">

			<!--Para quien va dirigido-->			
			<div class="input-group mb-3">

				<?php if($usuario['perfil'] != "admin"): ?>

					<div class="input-froup-prepend">
						<span class="input-group-text">Para:</span>
					</div>

					<?php if(isset($_GET['para'])): ?>

						<input type="text" class="form-control" value="<?php echo $_GET['para'] ?>" readonly required>

						<input type="hidden" class="form-control" value="<?php echo $_GET['id_para'] ?>" name="receptor">

					<?php else: ?>

						<input type="text" class="form-control" value="Academy of life" readonly required>

						<input type="hidden" class="form-control" value="1" name="receptor">

					<?php endif ?><!--administrador-->

				<?php else: ?>

					<div class="input-froup-prepend">
						<span class="input-group-text">Para:</span>
					</div>

					<?php if(isset($_GET['para'])): ?>

						<input type="text" class="form-control" value="<?php echo $_GET['para'] ?>" readonly required>

						<input type="hidden" class="form-control" value="<?php echo $_GET['id_para'] ?>" name="receptor">

					<?php else: ?>

						<div style="width: 90%;">
							<select name="receptor[]" class="form-control select2" multiple="multiple" data-placeholder="Selecciona un usuario">
								<option value="0">Todos los usuarios</option>

								<?php foreach ($listaUsuarios as $key => $value): ?>

									<?php if($key != 0): ?>

										<option value="<?php echo $value['id_usuario']; ?>"><?php echo $value['nombre'] ?></option>

									<?php endif ?>

								<?php endforeach ?>

							</select>
						</div>

					<?php endif ?>

				<?php endif ?><!-- $usuario['perfil'] != "admin"-->

				<input type="hidden" class="form-control" value="<?php echo $usuario['id_usuario']; ?>" name="remitente">

			</div>

			<!--Asunto del ticket-->
			<div class="input-group mb-3">
				
				<div class="input-group-prepend">
					<span class="input-group-text">Asunto:</span>
				</div>

				<?php if(isset($_GET['asunto'])): ?>

					<input type="text" class="form-control" value="<?php echo $_GET['asunto'] ?>" name="asunto" required>

				<?php else: ?>

					<input type="text" class="form-control" name="asunto" required>

				<?php endif ?>

			</div>
			
			<!--Mensaje del ticket-->
			<div class="form-group">

				<textarea name="mensaje" id="editor" style="width: 100%;"></textarea>

				<!--Adnjuntos del ticket-->
				<div class="form-group my-2">
					<div class="btn btn-default btn-file">
						<i class="fas fa-paperclip"></i> Adjuntar
						<input type="file" class="subirAdjuntos" multiple>
						<input type="hidden" name="adjuntos" class="archivosTemporales">
					</div> 

					<p class="help-block small">Archivos con peso Máximo de 32MB</p>

				</div>

			</div>

		</div><!--./card-body-->

		<div class="card-footer">
			
			<ul class="mailbox-attachments d-flex align-items-stretch clearfix">
				<!--<li>
					<span class="mailbox-attachment-icon has-img"><img src="http://academyoflife.com/backoffice/vistas/img/01-imagen.png" alt=""></span><br>

					<div class="mailbox-attachment-info">
						<a href="#" class="mailbox-attachment-name"><i class="fas fa-camera"> photo2.png</i></a>
						<span class="mailbox-attachment-size clearfix mt-1">
					       <span>1.9 MB</span>
						   <a href="#" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
						</span>
					</div>
				</li>-->
			</ul>

			<div class="float-right">
				<button type="submit" class="btn btn-primary">
					<i class="fas fa-envelope"></i> Enviar
				</button>
			</div>

			<a href="soporte" class="btn btn-default">
				<i class="fas fa-times"></i> Descartar
			</a>

		</div><!--./card-footer-->

		<?php 

		$crearTicket = new ControladorSoporte();
		$crearTicket->ctrCrearTicket();

		?>

	</form><!--./form-->

</div><!--./card-->