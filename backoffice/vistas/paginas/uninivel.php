<?php 

if($usuario['suscripcion'] == 0){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper" style="min-height: 1058.31px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Red Uninivel</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Red Uninivel</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">
      
      <?php  

      include "modulos/uninivel/analitica-uninivel.php";

      ?>

      <div class="row">
        
        <?php

        include "modulos/uninivel/tabla-uninivel.php";
        include "modulos/uninivel/mapa-uninivel.php";

        ?>

      </div><!--./row-->
      

    </div>

  </section>
  <!-- /.content -->

</div><!--./content-wrapper-->