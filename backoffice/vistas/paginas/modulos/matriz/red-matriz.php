<?php 

include "vistas/paginas/modulos/preload.php";

$regresar = false;

if(isset($_GET['id'])){

	$valor = $_GET['id'];
	$usuario = ControladorUsuarios::ctrMostrarUsuarios("id_usuario", $valor);
	$regresar = true;

}else{

	$valor = $usuario['id_usuario'];

}//$_GET['id']

$red = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz","usuario_red", $valor);

$ordenMatriz = $red[0]["orden_matriz"];//[0] para evitar la repeticion de fetchAll

?>

<input type="hidden" value="<?php echo $usuario["id_usuario"]; ?>" id="id_usuario">

<div class="card card-primary card-outline preloadRed" >

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

		 	<div class="habilitarGananciasMatriz" verGanancias="ok"></div>

			<button type="button" class="btn btn-info btn-sm text-white float-right verGanancias">
				<i class="fas fa-sitemap"></i>
			</button>

			<div class="tablaGanancias">
			 	
			 	<table class="table table-striped table-bordered table-light text-center">
			 		
			 		<thead class="bg-info">
			 			<tr>
			 				<th><i class="fas fa-table"></i></th>
			 				<th>Comisiones</th>
			 				<th>Ventas</th>
			 			</tr><!--./tr-->
			 		</thead><!--./thead-->

			 		<tbody>

			 			<tr>
			 				<td>Nivel 1</td>
			 				<td>$<span class="comisionNivel1">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 				<td>$<span class="ventaNivel1">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 			</tr><!--./tr-->

			 			<tr>
			 				<td>Nivel 2</td>
			 				<td>$<span class="comisionNivel2">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 				<td>$<span class="ventaNivel2">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 			</tr><!--./tr-->

			 			<tr>
			 				<td>Nivel 3</td>
			 				<td>$<span class="comisionNivel3">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 				<td>$<span class="ventaNivel3">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 			</tr><!--./tr-->

			 			<tr>
			 				<td>Nivel 4</td>
			 				<td>$<span class="comisionNivel4">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 				<td>$<span class="ventaNivel4">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 			</tr><!--./tr-->

			 			<tr>
			 				<td><b>Total</b></td>
			 				<td>$<span class="totalComisionMatriz">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 				<td>$<span class="totalVentaMatriz">
			 					<img src="vistas/img/plantilla/status.gif" style="width: 30px; height: 30px;">
			 				</span></td>
			 			</tr><!--./tr-->

			 		</tbody><!--./tbody-->

			 	</table><!--./table-->

			</div><!--./tablaGanancias-->

		<?php endif ?>

	</div><!--./card-header-->

	<div class="card-body">
		
		<div id="summary" class="tree_main" patrocinador="<?php echo $usuario['enlace_afiliado']; ?>">

			<?php  

			generarArbol($ordenMatriz, $usuario['id_usuario'], $usuario["nombre"], $usuario['foto'], $usuario['enlace_afiliado']);

			function generarArbol($ordenMatriz, $usuarioRed, $nombre, $foto, $patrocinador){

				$ladoA = "";
				$ladoB = "";
				$ladoC = "";
				$ladoD = "";

				if($foto == ""){

					$foto = "vistas/img/usuarios/default/default.png";

				}

				/*=============================================
				=  Traer lado A, B, C Y D linea descendiente  =
				=============================================*/
				$respuesta = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $ordenMatriz);

				echo '<ul id="tree_view" style="display: none;">

						<li>

							<img class="tree_icon rounden-circle" data-nite-src="'.$foto.'">
							<p class="demo_name_style">'.$nombre.'</p>';

							foreach ($respuesta as $key => $value) {
								
								if($value['posicion_matriz'] == "A"){

									$ladoA = generarLineasDescendientes($value['orden_matriz'], $ladoA, null, null, null, $patrocinador, null);

								}//ladoA

								if($value['posicion_matriz'] == "B"){

									$ladoB = generarLineasDescendientes($value['orden_matriz'], null, $ladoB, null, null, $patrocinador, null);

								}//ladoB

								if($value['posicion_matriz'] == "C"){

									$ladoC = generarLineasDescendientes($value['orden_matriz'], null, null, $ladoC, null, $patrocinador, null);

								}//ladoC

								if($value['posicion_matriz'] == "D"){

									$ladoD = generarLineasDescendientes($value['orden_matriz'], null, null, null, $ladoD, $patrocinador, null);

								}//ladoD

							}//foreach

							echo generarLineasDescendientes($ordenMatriz, $ladoA, $ladoB, $ladoC, $ladoD, $patrocinador, "lineaDescendiente");

						echo '</li>

				</ul>';
				

			}//generarArbol

			function generarLineasDescendientes($ordenMatriz, $ladoA, $ladoB, $ladoC, $ladoD, $patrocinador, $clase){

				$respuesta = ControladorMultinivel::ctrMostrarUsuarioRed("red_matriz", "derrame_matriz", $ordenMatriz);
				
				$derrame = 0;
				$sinLineaDescendiente = null;
				$arbol = '<ul>';

				/*=============================================
				=        Cuando no hay descendiente           =
				=============================================*/
				if(count($respuesta) == 0){

					$arbol .= '<li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li>
							   <li>
							   		<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li>
							   <li>
							   		<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li>
							   <li>
							   		<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
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
					if($value['posicion_matriz'] == "A" && $derrame == 1){

						$arbol .= '<li>
								   <a href="index.php?pagina=matriz&id='.$afiliado['id_usuario'].'">
									<img class="tree_icon rounded-circle '.$clase.'Izq" data-nite-src="'.$foto.'" patrocinador="'.$afiliado["patrocinador"].'">';
									

						if($afiliado['patrocinador'] == $patrocinador){

							$arbol .= '<p class="demo_name_style">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}else{

							$arbol .= '<p class="demo_name_style bg-info">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}//$afiliado['patrocinador']

						$arbol .= $ladoA.'</li>';

					}//2da linea A

					/*=============================================
					=      Segunda linea descenciente lado B      =
					=============================================*/
					if($value['posicion_matriz'] == "B" && $derrame == 2){

						$arbol .= '<li>
						           <a href="index.php?pagina=matriz&id='.$afiliado['id_usuario'].'">
									<img class="tree_icon rounded-circle '.$clase.'Der" data-nite-src="'.$foto.'" patrocinador="'.$afiliado["patrocinador"].'">';

						if($afiliado['patrocinador'] == $patrocinador){

							$arbol .= '<p class="demo_name_style">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}else{

							$arbol .= '<p class="demo_name_style bg-info">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}//$afiliado['patrocinador']

						$arbol .= $ladoB.'</li>';

					}//2da linea B

					/*=============================================
					=      Segunda linea descenciente lado C      =
					=============================================*/
					if($value['posicion_matriz'] == "C" && $derrame == 3){

						$arbol .= '<li>
						           <a href="index.php?pagina=matriz&id='.$afiliado['id_usuario'].'">
									<img class="tree_icon rounded-circle '.$clase.'Der" data-nite-src="'.$foto.'" patrocinador="'.$afiliado["patrocinador"].'">';

						if($afiliado['patrocinador'] == $patrocinador){

							$arbol .= '<p class="demo_name_style">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}else{

							$arbol .= '<p class="demo_name_style bg-info">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}//$afiliado['patrocinador']

						$arbol .= $ladoC.'</li>';

					}//2da linea C

					/*=============================================
					=      Segunda linea descenciente lado D      =
					=============================================*/
					if($value['posicion_matriz'] == "D" && $derrame == 4){

						$arbol .= '<li>
						           <a href="index.php?pagina=matriz&id='.$afiliado['id_usuario'].'">
									<img class="tree_icon rounded-circle '.$clase.'Der" data-nite-src="'.$foto.'" patrocinador="'.$afiliado["patrocinador"].'">';

						if($afiliado['patrocinador'] == $patrocinador){

							$arbol .= '<p class="demo_name_style">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}else{

							$arbol .= '<p class="demo_name_style bg-info">'.$afiliado["nombre"].'</p>
							<img data-nite-src="vistas/img/plantilla/down.png" class="tree_down_icon">
							</a>';

						}//$afiliado['patrocinador']

						$arbol .= $ladoD.'</li>';

					}//2da linea D

					$sinLineaDescendiente = $value['posicion_matriz'];

				}//foreach		

				/*=============================================
				=               Cuando faltan 3               =
				=============================================*/
				if($derrame == 1 && $sinLineaDescendiente == "A"){

					$arbol .= '<li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li> 
							   <li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li> 
							   <li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li>';

				}

				/*=============================================
				=               Cuando faltan 2               =
				=============================================*/
				if($derrame == 2 && $sinLineaDescendiente == "B"){

					$arbol .= '<li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li> 
							   <li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li>';
				}

				/*=============================================
				=               Cuando faltan 1               =
				=============================================*/
				if($derrame == 3 && $sinLineaDescendiente == "C"){

					$arbol .= '<li>
									<img class="tree_icon rounded-circle" data-nite-src="vistas/img/usuarios/default/default.png">
							   </li>';
				}

				$arbol .= '</ul>';

				return $arbol;
				
			}//generarLineasDescencientes

			?>	

			<div id="tree" class="orgChart"></div>

		</div><!--./tree_main-->

	</div><!--./card-body-->

</div><!--./card-->

