<?php

if($_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper" style="background-image: url('vistas/img/plantilla/inicio.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

  <section class="content-header" style="color: white">
    
    <h1>
      
      Administrar gastos
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio" style="color: white"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active" style="color: white">Administrar gastos</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregargastos">
          
          Agregar gasto

        </button>
      
      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Vendedor</th>
           <th>Valor</th>
           <th>Descripción</th>
           <th>Fecha</th>
           <th>Acciones</th>
           
         </tr> 

        </thead>  
        
       <tbody>

       <?php
       $item = null;
       $valor = null;
 
       $gastos = ControladorGastos::ctrMostrarGastos($item, $valor);

       foreach ($gastos as $key => $value) {
        // obtener el nombre del vendedor 

        $itemUsuario = "id";
        $valorUsuario = $value["vendedor"];

        $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);
        
        echo '<tr>

               <td>'.($key+1).'</td>

               <td>'.$respuestaUsuario["nombre"].'</td>

               <td>'.$value["valor"].'</td>

               <td>'.$value["descripcion"].'</td>

               <td>'.$value["fecha"].'</td>

               <td>

                    <div class="btn-group">
                        
                     ';

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '
                      <button class="btn btn-warning btnEditarGasto" data-toggle="modal" data-target="#modalEditarGasto" idGasto="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                      ';
                    // Boton para eliminar gasto
                    // <button class="btn btn-danger btnEliminarGasto" idGasto="'.$value["id"].'"><i class="fa fa-times"></i></button>

                    }

                    echo '</div>
                  </td>
             </tr>';
         }
       ?>
        </tbody>

        </table>
        
       <input type="hidden" value="<?php echo $_SESSION['perfil']; ?>" id="perfilOculto">

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR GASTO
======================================-->

<div id="modalAgregargastos" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar gastos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


                <!--=====================================
                ENTRADA DEL VENDEDOR
                ======================================-->
            
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>

                    <input type="hidden" name="idVendedor" value="<?php echo $_SESSION["id"]; ?>">

                  </div>

                </div> 

                   <!-- ENTRADA PARA VALOR -->

                  <div class="form-group row">

                    <div class="col-xs-6">

                      <div class="input-group">
  
                     <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                      <input type="number" class="form-control input-lg" id="nuevoGasto" name="nuevoGasto" step="any" min="0" placeholder="Valor del gasto" required>

                    </div>

                  </div>

            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group ">
             <div class="col-xs-12" style="padding-top: 20px;">
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <textarea class="form-control input-lg" name="nuevaDescripcion" placeholder="Ingresar descripción" required ></textarea>
                </div>
              </div>

            </div>

                </div>

            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar gasto</button>

        </div>

      </form>

        <?php

          $crearGasto = new ControladorGastos();
          $crearGasto -> ctrCrearGasto();

        ?>  

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR GASTO
======================================-->

<div id="modalEditarGasto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar gasto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


            <!-- ENTRADA PARA EL VALOR -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-code"></i></span> 

                <input type="number" class="form-control input-lg" id="editarValor" name="editarValor" required>
                
                <input type="hidden" id="idGasto" name="idGasto" required >
                             
                </div>
            </div>


            <!-- ENTRADA PARA LA DESCRIPCIÓN -->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span> 

                <input type="text" class="form-control input-lg" id="editarDescripcion" name="editarDescripcion" required >

              </div>

            </div>

            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

        <?php

          $editarGasto = new ControladorGastos();
          $editarGasto -> ctrEditarGasto();

        ?>      

    </div>

  </div>

</div>

<?php

  $eliminarGasto = new ControladorGastos();
  $eliminarGasto -> ctrEliminarGasto();

?>      


<!-- //Validacion de caracteres paa el ingreso de datos de un gasto  -->

<script>
    function validarEntrada(input) {
      // Expresión regular que acepta solo números y letras
      var regex = /^[a-zA-Z0-9]*$/;
      // Verifica si el valor ingresado coincide con la expresión regular
      if (!regex.test(input.value)) {
        // Si no coincide, elimina el último carácter ingresado
        input.value = input.value.slice(0, -1);
      }
    }
  </script>
