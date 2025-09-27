<!-- //en este apartado se pone los usuarios que no pueden ingresar aqui direcionandolos a inicio o pagina no encontrada -->
<?php

// if($_SESSION["perfil"] == "Especial"){

//   echo '<script>

//     window.location = "inicio";

//   </script>';

//   return;

// }

// $xml = ControladorVentas::ctrDescargarXML();

// if($xml){

//   rename($_GET["xml"].".xml", "xml/".$_GET["xml"].".xml");

//   echo '<a class="btn btn-block btn-success abrirXML" archivo="xml/'.$_GET["xml"].'.xml" href="ventas">Se ha creado correctamente el archivo XML <span class="fa fa-times pull-right"></span></a>';

// }

?>
<div class="content-wrapper">

  <section class="content-header"> 
    
    <h1>
      
      Administrar ventas credito
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar ventas credito</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-venta">

          <button class="btn btn-primary">
            
            Agregar venta

          </button>

        </a>
        <a href="ventas">

          <button class="btn btn-success">
            
            Ver ventas

          </button>

        </a>

         <!-- <button type="button" class="btn btn-default pull-right" id="daterange-btn">
           
            <span>
              <i class="fa fa-calendar"></i> 

              <?php

                if(isset($_GET["fechaInicial"])){

                  echo $_GET["fechaInicial"]." - ".$_GET["fechaFinal"];
                
                }else{
                 
                  echo 'Rango de fecha';

                }

              ?>
            </span>

            <i class="fa fa-caret-down"></i>

         </button> -->

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Factura</th>
           <th>Cliente</th>
           <th>Vendedor</th>
           <th>Forma</th>
           <th>Neto</th> 
           <th>Total</th> 
           <th>Fecha</th>
           <th>Debe</th>
           <th>Abono</th>
           <th>-%</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

          $respuesta = ControladorVentas::ctrVentasCreditos();

          foreach ($respuesta as $key => $value) {
           
           echo '<tr>

                  <td>'.($key+1).'</td>

                  <td>'.$value["codigo"].'</td>';

                  $itemCliente = "id";
                  $valorCliente = $value["id_cliente"];

                  $respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

                  echo '<td>'.$respuestaCliente["nombre"].'</td>';

                  $itemUsuario = "id";
                  $valorUsuario = $value["id_vendedor"];

                  $respuestaUsuario = ControladorUsuarios::ctrMostrarUsuarios($itemUsuario, $valorUsuario);

                  echo '<td>'.$respuestaUsuario["nombre"].'</td>

                  <td>'.$value["metodo_pago"].'</td>

                  <td>$ '.number_format($value["neto"]).'</td> 

                  <td>$ '.number_format($value["total"]).'</td>

                  <td>'.$value["fecha"].'</td>
                  <td>$ '.number_format($value["saldo_pendiente"]).'</td>
                  <td>$ '.number_format($value["monto_abonado"]).'</td>
                  <td>$ '.number_format($value["descuento"]).'</td>

                  <td>

                    <div class="btn-group">



                      <button class="btn btn-success btnImprimirTicket" codigoVenta="'.$value["codigo"].'">

                        <i class="fa fa-ticket">T</i>

                      </button>
                        
                      <button class="btn btn-info btnImprimirFactura" codigoVenta="'.$value["codigo"].'">

                        <i class="fa fa-print"></i>P

                      </button>';

                      if($_SESSION["perfil"] == "Administrador"){

                      echo '
                      <button class="btn btn-warning btnEditarVenta" idVenta="'.$value["id"].'"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnEliminarVenta" idVenta="'.$value["id"].'"><i class="fa fa-times"></i></button>
                      <button class="btn btn-info btnabonarcredito" data-toggle="modal" data-target="#modalAbonar" idVenta="'.$value["id"].'"><i class="fa fa-credit-card"></i></button>
                      <button class="btn btn-primary btnpagarcredito" idVenta="'.$value["id"].'"><i class="fa fa-usd"></i></button>';
                    }

                    echo '</div>  

                  </td>

                </tr>';
            }

        ?>
               
        </tbody>

       </table>

       <?php

               if (isset($_GET["idEliminarVenta"])) {
                 $eliminarVenta = new ControladorVentas();
                 $eliminarVenta->ctrEliminarVenta();
               }

     
                if (isset($_GET["idPagarVenta"])) {
                 $pagarVenta = new ControladorVentas();
                 $pagarVenta->ctrPagarVenta();
                }
      ?>
       

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL ABONAR
======================================-->

<div id="modalAbonar" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Abonar</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">


                <!--=====================================
                ENTRADA DEL SALDO PENDIENTE
                ======================================-->
                <div class="modal-header">
                     <h3 class="modal-title">Saldo pendiente</h3>
                             </div>
                             
                <div class="form-group">
                
                  <div class="input-group">
                    
                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                    <input type="number" class="form-control" id="saldop" readonly>


                  </div>

                </div> 

                   <!-- ENTRADA PARA VALOR -->

                  <div class="form-group row">

                    <div class="col-xs-6">

                      <div class="input-group">
  
                     <span class="input-group-addon"><i class="fa fa-arrow-up"></i></span> 

                      <input type="number" class="form-control input-lg" id="nuevoValor" name="nuevoValor" step="any" min="0" placeholder="Valor a abonar" required>
                      <input type="hidden" id="idVenta" name="idVenta">
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

          <button type="submit" class="btn btn-primary">Guardar ingreso</button>

        </div>

      </form>

        <?php

          $abonarventa = new ControladorVentas();
          $abonarventa -> ctrAbonarVenta();

        ?>  

    </div>

  </div>

</div>


<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoCliente" placeholder="Ingresar nombre" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL DOCUMENTO ID -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-key"></i></span> 

                <input type="number" min="0" class="form-control input-lg" name="nuevoDocumentoId" placeholder="Ingresar documento" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL EMAIL -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span> 

                <input type="email" class="form-control input-lg" name="nuevoEmail" placeholder="Ingresar email" required>

              </div>

            </div>

            <!-- ENTRADA PARA EL TELÉFONO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-phone"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoTelefono" placeholder="Ingresar teléfono" data-inputmask="'mask':'(999) 999-9999'" data-mask required>

              </div>

            </div>

            <!-- ENTRADA PARA LA DIRECCIÓN -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaDireccion" placeholder="Ingresar dirección" required>

              </div>

            </div>

             <!-- ENTRADA PARA LA FECHA DE NACIMIENTO -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevaFechaNacimiento" placeholder="Ingresar fecha nacimiento" data-inputmask="'alias': 'yyyy/mm/dd'" data-mask required>

              </div>

            </div>
  
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cliente</button>

        </div>

      </form>

      <?php

        $crearCliente = new ControladorClientes();
        $crearCliente -> ctrCrearCliente();

      ?>

    </div>

  </div>

</div>





