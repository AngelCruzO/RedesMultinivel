<?php 

$regresar = false;

if(isset($_GET['id'])){

	$valor = $_GET['id'];
	$usuario = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $valor);
	$regresar = true;

}else{

	$valor = $usuario['id_usuario'];

}//$_GET['id']

$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_binaria","usuario_red", $valor);

$ordenBinaria = $red[0]["orden_binaria"];//[0] para evitar la repeticion de fetchAll

?>

<input type="hidden" value="<?php echo $usuario["id_usuario"]; ?>" id="id_usuario">

<div class="card card-primary card-outline preloadRed">

	<div class="card-header">

		<?php if($red[0]['patrocinador_red'] != ""): ?>

			<h5 class="float-left">Patrocinador:
				<span class="badge badge-secondary"><?php echo $red[0]["patrocinador_red"]; ?></span>
			</h5>

		<?php endif ?>

		<!--=====================================
 		 =            Tabla ganancias           =
		 ======================================-->
		 <?php if($regresar): ?>

		 	<a href="javascript:history.back()" class="btn btn-default btn-sm text-secondary float-right"><i class="fas fa-chevron-left"></i> Regresar</a>

		 <?php else: ?>
		 	<div class="habilitarGananciasBinarias" verGanancias="ok"></div>

			<button type="button" class="btn btn-info btn-sm text-white float-right verGanancias">
				<i class="fas fa-sitemap"></i>
			</button>

			<div class="tablaGanancias">
			 	
			 	<table class="table table-striped table-bordered table-light text-center">
			 		
			 		<thead class="bg-info">
			 			<tr>
			 				<th><i class="fas fa-table"></i></th>
			 				<th>Izquierdo</th>
			 				<th>Derecho</th>
			 			</tr><!--./tr-->
			 		</thead><!--./thead-->

			 		<tbody>

			 			<tr>
			 				<td>Directos</td>
			 				<td><span class="directoIzq">0</span></td>
			 				<td><span class="directoDer">0</span></td>
			 			</tr><!--./tr-->

			 			<tr>
			 				<td>Derrame</td>
			 				<td><span class="derrameIzq">0</span></td>
			 				<td><span class="derrameDer">0</span></td>
			 			</tr><!--./tr-->

			 			<tr>
			 				<td><b>Puntos</b></td>
			 				<td><b><span class="totalLadoIzq">0</span> Puntos</b></td>
			 				<td><b><span class="totalLadoDer">0</span> Puntos</b></td>
			 			</tr><!--./tr-->

			 		</tbody><!--./tbody-->

			 	</table><!--./table-->

			</div><!--./tablaGanancias-->

		<?php endif ?>

	</div><!--./card-header-->

	<div class="card-body">
		
		<div id="summary" class="tree_main" patrocinador="<?php echo $usuario['enlace_afiliado']; ?>">

			<?php  

			generarArbol($ordenBinaria, $usuario['id_usuario'], $usuario["nombre"], $usuario['foto'], $usuario['enlace_afiliado']);

			function generarArbol($ordenBinaria, $usuarioRed, $nombre, $foto, $patrocinador){

				$ladoA = "";
				$ladoB = "";

				if($foto == ""){

					$foto = "vistas/img/usuarios/default/default.png";

				}

				/*=============================================
				= Traer lado A y lado B 1ra linea descendiente=
				=============================================*/
				$respuesta = ControladorMultinivel::ctrMostrarUsuarioRed("red_binaria", "derrame_binaria", $ordenBinaria);

				echo '<ul id="tree_view" style="display: none;">

						<li>

							<img class="tree_icon rounden-circle" src="'.$foto.'">
							<p class="demo_name_style">'.$nombre.'</p>';

							foreach ($respuesta as $key => $value) {
								
								if($value['posicion_binaria'] == "A"){

									$ladoA = generarLineasDescendientes($value['orden_binaria'], $ladoA, null, $patrocinador, null);

								}//ladoA

								if($value['posicion_binaria'] == "B"){

									$ladoB = generarLineasDescendientes($value['orden_binaria'], null, $ladoB, $patrocinador, null);

								}//ladoB

							}//foreach

							echo generarLineasDescendientes($ordenBinaria, $ladoA, $ladoB, $patrocinador, "lineaDescendiente");

						echo '</li>

				</ul>';
				

			}//generarArbol

			function generarLineasDescendientes($ordenBinaria, $ladoA, $ladoB, $patrocinador, $clase){

				$respuesta = ControladorMultinivel::ctrMostrarUsuarioRed("red_binaria", "derrame_binaria", $ordenBinaria);
				
				$derrame = 0;
				$sinLineaDescendiente = null;
				$arbol = '<ul>';

				/*=============================================
				=        Cuando no hay descendiente           =
				=============================================*/
				if(count($respuesta) == 0){

					$arbol .= '<li>
									<img class="tree_icon rounded-circle" src="vistas/img/usuarios/default/default.png">
							   </li>
							   <li>
							   		<img class="tree_icon rounded-circle" src="vistas/img/usuarios/default/default.png">
							   </li>
							</ul>';

					return $arbol;

				}//!$respuesta

				/*=============================================
				=       Cuando si hay linea descenciente      =
				=============================================*/
				foreach ($respuesta as $key => $value) {
					
					//Traemos datos
					$afiliado = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $value["usuario_red"]);

					//Validamos foto
					if($afiliado['foto'] == ""){

						$foto = "vistas/img/usuarios/default/default.png";

					}else{

						$foto = $afiliado['foto'];

					}//$afiliado['foto']

					//Aumentamos derrame
					$derrame++;

					/*=============================================
					=      Segunda linea descenciente lado A      =
					=============================================*/
					if($value['posicion_binaria'] == "A" && $derrame == 1){

						$arbol .= '<li>
								   <a href="index.php?pagina=binaria&id='.$afiliado['id_usuario'].'">
									<img class="tree_icon rounded-circle '.$clase.'Izq" src="'.$foto.'" patrocinador="'.$afiliado["patrocinador"].'">';
									

						if($afiliado['patrocinador'] == $patrocinador){

							$arbol .= '<p class="demo_name_style">'.$afiliado["nombre"].'</p></a>';

						}else{

							$arbol .= '<p class="demo_name_style bg-info">'.$afiliado["nombre"].'</p></a>';

						}//$afiliado['patrocinador']

						$arbol .= $ladoA.generarLineasDescendientes($value['orden_binaria'], $ladoA, null, $patrocinador, $clase).'</li>';

					}//2da linea A

					/*=============================================
					=      Segunda linea descenciente lado B      =
					=============================================*/
					if($value['posicion_binaria'] == "B" && $derrame == 2){

						$arbol .= '<li>
						           <a href="index.php?pagina=binaria&id='.$afiliado['id_usuario'].'">
									<img class="tree_icon rounded-circle '.$clase.'Der" src="'.$foto.'" patrocinador="'.$afiliado["patrocinador"].'">';

						if($afiliado['patrocinador'] == $patrocinador){

							$arbol .= '<p class="demo_name_style">'.$afiliado["nombre"].'</p></a>';

						}else{

							$arbol .= '<p class="demo_name_style bg-info">'.$afiliado["nombre"].'</p></a>';

						}//$afiliado['patrocinador']

						$arbol .= $ladoB.generarLineasDescendientes($value['orden_binaria'], null, $ladoB, $patrocinador, $clase).'</li>';

					}//2da linea B

					$sinLineaDescendiente = $value['posicion_binaria'];

				}//foreach

				/* Verificar despues si es necesaria la parte de abajo */			

				/*=============================================
				=            Cuando falta lado B              =
				=============================================*/
				if($derrame == 1 && $sinLineaDescendiente == "A"){

					$arbol .= '<li>
									<img class="tree_icon rounded-circle" src="vistas/img/usuarios/default/default.png">
							   </li>';

				}//sin linea A

				$arbol .= '</ul>';

				return $arbol;
				
			}//generarLineasDescencientes

			?>
			
			<!--<ul id="tree_view" style="display: none;">
				
				<li>

					<img src="vistas/img/usuarios/6/117.jpg" class="tree_icon rounded-circle">
					<p class="demo_name_style">Alexander Parra</p>

					<ul>
						
						<li>
							<img class="tree_icon rounded-circle lineaDescendienteIzq" src="vistas/img/usuarios/6/117.jpg">
							<p class="demo_name_style">Alexander Parra</p>

							<ul>
								
								<li>
									<img class="tree_icon rounded-circle lineaDescendienteIzq" src="vistas/img/usuarios/6/117.jpg">
									<p class="demo_name_style">Alexander Parra</p>
								</li>/li

								<li>
									<img class="tree_icon rounded-circle lineaDescendienteDer" src="vistas/img/usuarios/6/117.jpg">
									<p class="demo_name_style">Alexander Parra</p>
								</li>/li

							</ul>./ul							

						</li>/li

						<li>
							<img class="tree_icon rounded-circle lineaDescendienteDer" src="vistas/img/usuarios/6/117.jpg">
							<p class="demo_name_style">Alexander Parra</p>

							<ul>
								
								<li>
									<img class="tree_icon rounded-circle lineaDescendienteIzq" src="vistas/img/usuarios/6/117.jpg">
									<p class="demo_name_style">Alexander Parra</p>
								</li>/li

								<li>
									<img class="tree_icon rounded-circle lineaDescendienteDer" src="vistas/img/usuarios/6/117.jpg">
									<p class="demo_name_style">Alexander Parra</p>
								</li>li

							</ul>ul

						</li>li

					</ul>ul

				</li>li

			</ul>/ul-->

			<div id="tree" class="orgChart"></div>

		</div><!--./tree_main-->

	</div><!--./card-body-->

</div><!--./card-->

