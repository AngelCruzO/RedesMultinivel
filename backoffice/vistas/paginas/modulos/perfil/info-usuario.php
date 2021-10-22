<div class="col-12 col-md-4">
	<div class="card card-info card-outline">

		<div class="card-body box-profile">
			<div class="text-center">

				<?php if($usuario["foto"] == ""): ?>

					<img class="profile-user-img img-fluid img-circle" src="vistas/img/usuarios/default/default.png">

				<?php else: ?>
				
			 	<img class="profile-user-img img-fluid img-circle" src="<?php echo $usuario["foto"] ?>">

			 	<?php endif ?>

			</div>	

			<h3 class="profile-username text-center"><?php echo $usuario["nombre"] ?></h3>

			<p class="text-muted text-center"><?php echo $usuario["email"] ?></p>

			<div class="text-center">				
				<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#cambiarFoto">Cambiar foto</button>
				<button class="btn btn-purple btn-sm" data-toggle="modal" data-target="#cambiarPassword">Cambiar contraseña</button>
			</div>

		</div>

		<div class="card-footer">
			<button class="btn btn-default float-right">Eliminar cuenta</button>
		</div>

	</div>	
</div>


<!--=====================================
=         Cambiar foto perfil           =
======================================-->
<div class="modal fade" id="cambiarFoto">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<form method="post" enctype="multipart/form-data">

				<div class="modal-header">
					<h4 class="modal-title">Cambiar imagen</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>				
				</div><!--./modal-header-->

				<div class="modal-body">

					<input type="hidden" name="idUsuarioFoto" value="<?php echo $usuario["id_usuario"] ?>">
					
					<div class="form-group">
						<input type="file" class="form-control-file border" name="cambiarImagen" required>
						<input type="hidden" name="fotoActual" value="<?php echo $usuario['foto'] ?>">
					</div>

				</div><!--./modal-body-->

				<div class="modal-footer d-flex justify-content-between">

					<div>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>

					<div>
						<button type="submit" class="btn btn-primary">Enviar</button>
					</div>					
					
				</div><!--./modal-footer-->

				<?php
					$cambiarImagen = new ControladorUsuarios();
					$cambiarImagen -> ctrCambiarFotoPerfil();
				?>

			</form><!--./form-->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--=====================================
=         Cambiar contraseña         =
======================================-->
<div class="modal fade" id="cambiarPassword">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<form method="post">

				<div class="modal-header">
					<h4 class="modal-title">Cambiar Contraseña</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>				
				</div><!--./modal-header-->

				<div class="modal-body">

					<input type="hidden" name="idUsuarioPassword" value="<?php echo $usuario["id_usuario"] ?>">
					
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Nueva contraseña" name="editarPassword" required>
					</div>

				</div><!--./modal-body-->

				<div class="modal-footer d-flex justify-content-between">

					<div>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>

					<div>
						<button type="submit" class="btn btn-primary">Enviar</button>
					</div>					
					
				</div><!--./modal-footer-->

				<?php
					$cambiarPassword = new ControladorUsuarios();
					$cambiarPassword -> ctrCambiarPassword();
				?>

			</form><!--./form-->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->