<!-- //en este apartado se pone los usuarios que no pueden ingresar aqui direcionandolos a inicio o pagina no encontrada -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
$fechaInicial = isset($_GET["fechaInicial"]) ? $_GET["fechaInicial"] : '';
$fechaFinal = isset($_GET["fechaFinal"]) ? $_GET["fechaFinal"] : '';
$productoBuscado = isset($_GET["producto"]) ? $_GET["producto"] : '';
?>
<div class="content-wrapper" style="background-image: url('vistas/img/plantilla/second.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

                 <section class="content-header" style="color: white"> 
    
                   <h1>
      
                     Buscar ventas por producto
    
                   </h1>

                   <ol class="breadcrumb">
      
                     <li><a href="inicio" style="color: white"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
                     <li class="active" style="color: white">Ventas por producto</li>
    
                   </ol>

                 </section>

          <section class="content">

             <div class="box">
                         <!-- primer header con los botones agregar y formulario -->
                        <div class="box-header with-border">
  
                        <a href="crear-venta">

                          <button class="btn btn-primary">
            
                            Agregar venta

                          </button>

                        </a>

                        <a href="ventas-credito">

                          <button class="btn btn-success">
            
                            Ver creditos

                          </button>

                        </a>

                      <!-- formulario inicial to look for product -->
                        <div class="box-body">

                              <form method="get" action="index.php">
                              <input type="hidden" name="ruta" value="ventas-por-producto">

                            <div class="row">

                           <div class="col-md-3">
                             <label style="color: black;">Fecha Inicial</label>
                             <input type="date" name="fechaInicial" class="form-control" value="<?php echo $fechaInicial; ?>" required>
                           </div>

                            <div class="col-md-3">
                              <label style="color: black;">Fecha Final</label>
                              <input type="date" name="fechaFinal" class="form-control" value="<?php echo $fechaFinal; ?>" required>
                            </div>

                            <div class="col-md-4">
                               <label style="color: black;">Nombre del Producto</label>
                               <input type="text" name="producto" class="form-control" placeholder="Buscar producto..." value="<?php echo $productoBuscado; ?>" required>
                            </div>

                            <div class="col-md-2" style="margin-top: 25px;">
                              <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                            </div>

                            </div>
                              </form>
                         </div>
                          </div>

                <div class="box-body">

                  <?php
                         $alerta = '';

                         if (isset($_GET["fechaInicial"], $_GET["fechaFinal"], $_GET["producto"]) && $_GET["producto"] !== "") {

                
                           $fechaInicial = $_GET["fechaInicial"];
                           $fechaFinal = $_GET["fechaFinal"];
                           $productoBuscado = htmlspecialchars(trim($_GET["producto"]));

                           try {

                            

                           $ventas = ControladorVentas::ctrRangoFechasVentas($fechaInicial, $fechaFinal);

                           if (empty($ventas)) {
                            $alerta= '<script>
                            
                                    Swal.fire({
                                      icon: "warning",
                                      title: "Sin ventas",
                                      text: "No se encontraron ventas en el rango de fechas seleccionado."
                                    });
                                    
                                  </script>';
                        } else {
                           $encontrados = [];

                           foreach ($ventas as $venta) {

                             $productos = json_decode($venta["productos"], true);

                             foreach ($productos as $producto) {
                               if (stripos($producto["descripcion"], $productoBuscado) !== false) {
                                 $encontrados[] = [
                                   "descripcion" => $producto["descripcion"],
                                   "cantidad" => $producto["cantidad"],
                                   "total" => $producto["precio"] * $producto["cantidad"],
                                   "factura" => $venta["codigo"],
                                   "fecha" => $venta["fecha"]
                                 ];
                               }
                             }
                           }

                           if (!empty($encontrados)) {

                            $totalVentas = 0; // Inicializa el total

                                   foreach ($encontrados as $item) {
                                     $totalVentas += $item["total"];
                                       }
        
                                  echo  '<table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
                                               <thead>
         
                                                <tr>
           
                                                  <th style="width:10px">#</th>
                                                  <th>Producto</th>
                                                  <th>Cantidad</th>
                                                  <th>Total</th>
                                                  <th>Factura</th>
                                                  <th>Fecha</th> 
                                                </tr> 

                                               </thead>

                                                <tbody>';
                                                 
                                                foreach ($encontrados as $key => $item) {
                                                  echo '<tr>
                                                          <td>'.($key+1).'</td>
                                                          <td>'.$item["descripcion"].'</td>
                                                          <td>'.$item["cantidad"].'</td>
                                                          <td>$ '.number_format($item["total"], 2).'</td>
                                                          <td>'.$item["factura"].'</td>
                                                          <td>'.$item["fecha"].'</td>
                                                        </tr>';
                                                }
               
                                                  echo '</tbody> </table>' ;

                                                  echo '<div class="alert alert-success" style="font-size: 18px;">
                                                    <strong>Total de Ventas Encontradas: $ '.number_format($totalVentas, 2).'</strong>
                                                     </div>';
                                                } else {
                                                  $alerta= '<script>
                                                        Swal.fire({
                                                          icon: "info",
                                                          title: "Sin coincidencias",
                                                          text: "No se encontró información del producto buscado."
                                                        });
                                                      </script>';
                                                }

                                              }

                                            } catch (Exception $e) {
                                              $alerta= '<script>
                                              
                                                      Swal.fire({
                                                        icon: "error",
                                                        title: "Error",
                                                        text: "'.$e->getMessage().'"
                                                      });
                                            
                                                    </script>';
                                          }
                                      
                                      }
                                      
                        ?>
                        <?php
                        if (!empty($alerta)) {
                          echo $alerta;
                                }
                               ?>
                </div>

                </div>

           </section>

</div>





