<?php  

$categorias = ControladorAcademia::ctrMostrarCategorias(null, null);
$item = null;
$valor = null;

foreach ($categorias as $key => $value) {
  
  if(isset($_GET['pagina']) && $_GET['pagina'] == $value['ruta_categoria']){

    //variables para separar pagina inicio de las paginas individuales
    $item = 'ruta_categoria';
    $valor = $value['ruta_categoria'];

  }

}

$academia = ControladorAcademia::ctrMostrarAcademia($item, $valor);
$listaCategorias = array();
$rutasCategorias = array();
$iconosCategorias = array();
$coloresCategorias = array();

foreach ($academia as $key => $value){
  
  array_push($listaCategorias, $value['nombre_categoria']);
  array_push($rutasCategorias, $value['ruta_categoria']);
  array_push($iconosCategorias, $value['icono_categoria']);
  array_push($coloresCategorias, $value['color_categoria']);

}

$listaCategorias = array_unique($listaCategorias);

?>

<?php foreach ($listaCategorias as $key => $value): ?>

  <!-- Cuerpo Activo -->
  <div class="card card-<?php echo $coloresCategorias[$key]; ?> card-outline">
    <div class="card-header">
      <h3 class="card-title">
        <a href="<?php echo $ruta.'backoffice/'.$rutasCategorias[$key]; ?>" class="text-muted">
          <i class="<?php echo $iconosCategorias[$key]; ?> text-<?php echo $coloresCategorias[$key]; ?>"></i>
          <?php echo $value; ?>
        </a>
      </h3>

      <div class="card-tools">
        <button type="button" class="btn btn-<?php echo $coloresCategorias[$key]; ?> btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        </div>

      </div>

      <div class="card-body">

        <div class="jd-slider slideAcademia">

          <div class="slide-inner">
            <ul class="slide-area">

              <?php foreach ($academia as $key => $valueAcademia): ?>

                <?php if($valueAcademia["nombre_categoria"] == $value): ?>

                  <li>

                    <?php if($usuario['suscripcion'] == 0): ?>

                      <?php if($valueAcademia['vista_gratuita'] == 1): ?>

                        <a href="index.php?pagina=<?php echo $rutasCategorias[$key]; ?>&video=<?php echo $valueAcademia['id_video']; ?>">
                          <figure class="px-4 activado">
                            <img src="<?php echo $valueAcademia['imagen_video']; ?>">
                          </figure>
                        </a>
                        <h6 class="text-center text-secondary" data-toggle="tooltip" title="<?php echo $valueAcademia['descripcion_video']; ?>">
                          <?php echo $valueAcademia['titulo_video']; ?>
                        </h6>

                      <?php else: ?>

                        <a href="perfil">
                          <figure class="px-4 desactivado">
                            <img src="<?php echo $valueAcademia['imagen_video']; ?>">
                          </figure>
                        </a>
                        <h6 class="text-center text-secondary" data-toggle="tooltip" title="<?php echo $valueAcademia['descripcion_video']; ?>">
                          <?php echo $valueAcademia['titulo_video']; ?>
                        </h6>

                      <?php endif ?><!--Vista gratuita-->

                    <?php else: ?>

                      <a href="index.php?pagina=<?php echo $rutasCategorias[$key]; ?>&video=<?php echo $valueAcademia['id_video']; ?>">
                          <figure class="px-4 activado">
                            <img src="<?php echo $valueAcademia['imagen_video']; ?>">
                          </figure>
                      </a>
                      <h6 class="text-center text-secondary" data-toggle="tooltip" title="<?php echo $valueAcademia['descripcion_video']; ?>">
                        <?php echo $valueAcademia['titulo_video']; ?>
                      </h6>

                    <?php endif ?><!--suscripcion == 0-->

                  </li>

                <?php endif ?><!--nombre_categoria-->

              <?php endforeach ?>
              
            </ul>
            <a class="prev" href="#">
              <i class="fas fa-angle-left text-muted"></i>
            </a>
            <a class="next" href="#">
              <i class="fas fa-angle-right text-muted"></i>
            </a>
          </div>
          <div class="controller">
            <div class="indicate-area"></div>
          </div><!--./controller-->
        </div><!--./jd-slider-->


      </div><!-- /.card-body -->

    </div>
    <!-- /.card -->

<?php endforeach  ?>