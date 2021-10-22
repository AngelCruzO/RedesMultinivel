<?php

/*===============================================
=            Historico de comisiones            =
===============================================*/
if($usuario['enlace_afiliado'] != $patrocinador){

  $pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_uninivel", "usuario_pago", $usuario['id_usuario']);

}else{

  $pagos = ControladorMultinivel::ctrMostrarPagosRed("pagos_uninivel", null, null);

}//$usuario['enlace_afiliado'] != $patrocinador

$totalComisiones = 0;

foreach ($pagos as $key => $value){
  
  if($usuario['enlace_afiliado'] != $patrocinador || $value['periodo_comision'] == $value['periodo_venta']){

    $totalComisiones += $value['periodo_comision'];

  }else{

    $totalComisiones += $value['periodo_venta']-$value['periodo_comision'];

  }//$usuario['enlace_afiliado'] != $patrocinador

}//foreach

/*======================================================
=            Cantidad de personas en la red            =
======================================================*/
if($usuario['suscripcion'] != 0){

  $red = ControladorMultinivel::ctrMostrarRed("usuarios", "red_uninivel", "patrocinador_red", $usuario['enlace_afiliado']);

  /*=============================================
  Limpinado el array de tipo Objeto de valores repetidos
  =============================================*/

  $resultado = array();

  foreach ($red as $value) {

    $resultado[$value["id_usuario"]]= $value;

  }//foreach

  $red = array_values($resultado);

}else{

  $red = array();

}//$usuario['suscripcion'] != 0

?>

<div class="row">
  <div class="col-12 col-sm-6 col-lg-3">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>$ <?php echo number_format($totalComisiones, 2, ".", ","); ?></h3>

        <p>Mis comisiones</p>
      </div>
      <div class="icon">
        <i class="fas fa-dollar-sign"></i>
      </div>
      <a href="ingresos-uninivel" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-12 col-sm-6 col-lg-3">
    <!-- small box -->
    <div class="small-box bg-purple">
      <div class="inner">
        <h3><?php echo count($red) ?></h3>

        <p>Mi red</p>
      </div>
      <div class="icon">
        <i class="fas fa-sitemap"></i>
      </div>
      <a href="uninivel" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-12 col-sm-6 col-lg-3">
    <!-- small box -->
    <div class="small-box bg-primary">
      <div class="inner">
        <h3>0</h3>

        <p>Mis tickects</p>
      </div>
      <div class="icon">
        <i class="fas fa-comments"></i>
      </div>
      <a href="soporte" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-12 col-sm-6 col-lg-3">
    <!-- small box -->
    <div class="small-box bg-dark">
      <div class="inner">

        <?php if($usuario['suscripcion'] != 0): ?>
          
          <h3 class="text-secondary">Activo</h3>

          <p>Renovación <?php echo $usuario['vencimiento']; ?></p>

      </div><!--./inner-->  

          <div class="icon">
            <i class="fas fa-user-plus"></i>
          </div><!--./icon-->
          <a href="perfil" class="small-box-footer">Cancelar suscripción <i class="fas fa-arrow-circle-right"></i></a>

      

        <?php else: ?>

          <h3 class="text-secondary">Free</h3>

          <p class="text-uppercase">Versión gratuita</p>

      </div><!--./inner--> 

          <div class="icon">
            <i class="fas fa-user-plus"></i>
          </div><!--./icon-->
          <a href="perfil" class="small-box-footer">Suscribirse ahora <i class="fas fa-arrow-circle-right"></i></a>       

        <?php endif ?>

    </div><!--./small-box-->
  </div><!--./col-->
</div>
<!-- ./row -->