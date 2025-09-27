<div class="content-wrapper" style="background-image: url('vistas/img/plantilla/food.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

  <section class="content-header" style="color: white">
    
    <h1>
      
      Tablero de Mesas
      
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="crear-venta" style="color: white !important;"><i class="fa fa-dashboard"></i> Ventas</a></li>
      
      <li class="active" style="color: white">Mesas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">
      
    <?php

    if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Vendedor" || $_SESSION["perfil"] == "Especial"){

      include "inicio/mesas-superiores.php";

    }

    ?>

    </div> 

   

  </section>
 
</div>
