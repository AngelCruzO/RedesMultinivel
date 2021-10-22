<div class="ladoUsuarios">
	
	<div class="container-fluid">
	
	<div class="row">
		
		<div class="col-12 col-lg-4 formulario">

			<figure class="p-2 p-sm-5 p-lg-4 p-xl-5 text-center">
			
				<a href="<?php echo $ruta; ?>inicio"><img src="img/logo-positivo.png" class="img-fluid"></a>
				
					<div class="d-flex justify-content-between">
					
						<h4>Ingreso al sistema</h4>

						<div class="dropdown text-right">

							<button type="button" class="btn btn-light btn-sm dropdown-toggle border" data-toggle="dropdown">
								<form action="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" method="post">
									<input type="hidden" name="idioma" value="es">
									<input type="submit" value="ES" style="border: 0;background: transparent;padding: 0;margin: 0;float: left;cursor: pointer;">
								</form>
							</button>

							<div class="dropdown-menu">

								<a class="dropdown-item">
									<form action="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" method="post">
										<input type="hidden" name="idioma" value="en">
										<input type="submit" value="EN" style="border: 0;background: transparent;padding: 0;margin: 0;cursor: pointer;">
									</form>
								</a>

							</div>

						</div>

					</div>

					<form class="mt-5" method="post" >

						<p class="text-center py-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi sunt officia unde officiis</p>

						<input type="email" class="form-control my-3 py-3" placeholder="Correo Electrónico" name="ingresoEmail" required>

						<input type="password" class="form-control my-3 py-3" placeholder="Contraseña" name="ingresoPassword" required>

						<?php
							$ingreso = new ControladorUsuarios();
							$ingreso -> ctrIngresoUsuario();
						?>

						<input type="submit" class="form-control my-3 py-3 btn btn-info" value="Ingresar">

						<p class="text-center pt-1">¿Aún no tienes una cuenta? | <a href="<?php echo $ruta; ?>registro">Regístrate</a></p>

						<p class="text-center pt-1"><a href="#modalRecuperarPassword" data-toggle="modal" data-dismiss="modal">¿Olvidó su contraseña?</a></p>


					</form>

			</figure>

		</div>

		<div class="col-12 col-lg-8 fotoIngreso text-center">		

			<a href="<?php echo $ruta; ?>inicio"><button class="d-none d-lg-block text-center btn btn-default btn-lg my-3 text-white btnRegresar">Regresar</button></a>

			<a href="<?php echo $ruta; ?>inicio"><button class="d-block d-lg-none text-center btn btn-default btn-lg btn-block my-3 text-white btnRegresarMovil">Regresar</button></a>

			<ul class="p-0 m-0 py-4 d-flex justify-content-center redesSociales">

				<li>
					<a href="#" target="_blank"><i class="fab fa-facebook-f lead text-white mx-4"></i></a>
				</li>

				<li>
					<a href="#" target="_blank"><i class="fab fa-instagram lead text-white mx-4"></i></a>
				</li>	

				
				<li>
					<a href="#" target="_blank"><i class="fab fa-linkedin lead text-white mx-4"></i></a>
				</li>

				<li>
					<a href="#" target="_blank"><i class="fab fa-twitter lead text-white mx-4"></i></a>
				</li>

				<li>
					<a href="#" target="_blank"><i class="fab fa-youtube lead text-white mx-4"></i></a>
				</li>

			</ul>

		</div>

	</div>

</div>
</div>

<div class="modal fade formulario" id="modalRecuperarPassword">
	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title">Recuperar contraseña</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>				
			</div>

			<div class="modal-body">

				<form method="post">

					<p class="text-muted">Escriba su correo electrónico con el que estás registrado y allí le enviaremos una nueva contraseña</p>

					<div class="input-group mb-3">
						<div class="input-group-prepend">

							<span class="input-group-text">
								<i class="far fa-envelope"></i>								
							</span>
							
						</div><!--./input-group-prepend-->

						<input type="email" class="form-control" placeholder="Email" name="emailRecuperarPassword">
					</div><!--./mb-3-->

					<input type="submit" class="btn btn-dark btn-block" value="Enviar">

					<?php 
						$recuperarPassword = new ControladorUsuarios();
						$recuperarPassword -> ctrRecuperarPassword();
					?>

				</form>

			</div><!--./modal-body-->
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->