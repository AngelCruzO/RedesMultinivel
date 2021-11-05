<div class="content-wrapper" style="min-height: 1058.31px;">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Soporte</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
            <li class="breadcrumb-item active">Soporte</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="container-fluid">

      <div class="content">
        <div class="row">

          <div class="col-md-3">
            <?php 

              include 'modulos/soporte/botones.php';

            ?>
          </div><!--.col-->

          <div class="col-md-9">
            <?php 

              if(isset($_GET['soporte'])){

                 include 'modulos/soporte/'.$_GET['soporte'].'.php';

              }else{

                include 'modulos/soporte/nuevo-ticket.php';

              }//isset($_GET['soporte'])             

            ?>
          </div><!--./col-->

        </div><!--./row-->
      </div><!--./content-->

    </div><!--./container-fluid-->

  </section>
  <!-- /.content -->

</div>