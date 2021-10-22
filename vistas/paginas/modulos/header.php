<!--=====================================
HEADER
======================================-->

<header>

	<div class="container-fluid">
		
		<div class="container p-0">

			<div class="row">

				<!-- LOGO -->
			
				<div class="col-7 col-sm-5 col-md-4 col-lg-2 col-xl-3 my-3 d-flex mt-lg-3 logotipo">

					<i class="fas fa-bars d-block d-lg-none text-white pt-2 pr-2"></i>
					
					<a href="<?php echo $ruta; ?>inicio">
						<img data-nite-src="img/logo.png" class="img-fluid pt-1">
					</a>

				</div>

				<!-- BOTONERA -->

				<div class="d-none d-lg-block col-lg-8 col-xl-6 p-0 pt-lg-2 mt-lg-1 pt-xl-4 botonera">
					
					<ul class="nav justify-content-lg-left justify-content-xl-end">
						
						<li class="nav-item">
							<a class="nav-link text-white" href="#cursos">Cursos</a>
						</li>

						<li class="nav-item">
							<a class="nav-link text-white" href="#nosotros">Nosotros</a>
						</li>

						<li class="nav-item">
							<a class="nav-link text-white" href="#testimonios">Testimonios</a>
						</li>

						<li class="nav-item">
							<a class="nav-link text-white" href="#planes">Planes</a>
						</li>

						<li class="nav-item">
							<a class="nav-link text-white" href="#faq">FAQ</a>
						</li>

						<li class="nav-item">
							<a class="nav-link text-white" href="#">Blog</a>
						</li>

						<li class="nav-item">
							<a class="nav-link text-white" href="#contactenos">Contáctenos</a>
						</li>

					</ul>

				</div>	

				<!-- IDIOMA E INGRESO -->

				<div class="col-5 col-sm-7 col-md-8 col-lg-2 col-xl-3 p-0 pt-4 pt-lg-2 mt-lg-1 pt-xl-4">

					<!-- IDIOMA -->
					
					<div class="ml-xl-4 float-left mt-lg-1 d-none d-lg-block">

						<div class="dropdown">

							<button type="button" class="btn btn-light btn-sm dropdown-toggle pr-3" data-toggle="dropdown">
								<form action="<?php echo $ruta; ?>" method="post">
									<input type="hidden" name="idioma" value="es">
									<input type="submit" value="ES" style="border: 0;background: transparent;padding: 0;margin: 0;float: left;cursor: pointer;">
								</form>
							</button>

							<div class="dropdown-menu">

								<a class="dropdown-item">

									<form action="<?php echo $ruta; ?>" method="post">
										<input type="hidden" name="idioma" value="en">
										<input type="submit" value="EN" style="border: 0;background: transparent;padding: 0;margin: 0;cursor: pointer;">
									</form>

								</a>

							</div>

						</div>

					</div>

					<!-- INGRESO -->

					<div class="mr-2 mr-lg-0 float-right pt-1 ingresos">
						
						<button class="btn btn-info btn-sm d-flex">
							
							<a href="<?php echo $ruta; ?>ingreso" class="text-white">Ingresar</a>

							<span class="text-white mx-2">|</span>

							<a href="<?php echo $ruta; ?>registro" class="text-white">Crear Cuenta</a>

						</button>

					</div>

				</div>	

			</div>

		</div>

	</div>

</header>