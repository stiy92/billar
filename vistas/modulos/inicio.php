<div class="content-wrapper" style="background-image: url('vistas/img/plantilla/inicio.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

  <section class="content-header" style="color: white">
    
    <h1>
      
      Tablero
      
      <small style="color: white">Panel de Control</small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio" style="color: white"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active" style="color: white">Tablero</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">
      
    <?php

    if($_SESSION["perfil"] =="Administrador"){

      include "inicio/cajas-superiores.php";

    }

    ?>

    </div> 

     <div class="row">
       
        <div class="col-lg-12">

          <?php

          if($_SESSION["perfil"] =="Administrador"){
          
           include "inicio/grafico-ventas.php";

          }

          ?>

        </div>

        <div class="col-lg-6">

          <?php

          if($_SESSION["perfil"] =="Administrador"){
          
           include "inicio/productos-mas-vendidos.php";

         }

          ?>

        </div>

         <div class="col-lg-6">

          <?php

          if($_SESSION["perfil"] =="Administrador"){
          
           include "inicio/productos-recientes.php";

         }

          ?>

        </div>

         <div class="col-lg-12">
           
          <?php

          if($_SESSION["perfil"] =="Especial" || $_SESSION["perfil"] =="Vendedor"){

             echo '<div class="box box-success">

             <div class="box-header">

             <h1>Bienvenid@ ' .$_SESSION["nombre"].'</h1>

             </div>

             </div>';

          }

          ?>

         </div>

     </div>

  </section>
 
</div>
