<!-- //en este apartado se pone los usuarios que no pueden ingresar aqui direcionandolos a inicio o pagina no encontrada -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if($_SESSION["perfil"] == "Especial" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}
$clienteBuscado = isset($_GET["cliente"]) ? $_GET["cliente"] : '';
?>

<div class="content-wrapper" style="background-image: url('vistas/img/plantilla/second.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

                  <section class="content-header" style="color: black"> 
                      <h1>Buscar Deudas de Clientes</h1>
                      <ol class="breadcrumb">
                        <li><a href="inicio" style="color: black"><i class="fa fa-dashboard"></i> Inicio</a></li>
                        <li class="active" style="color: black">Deudas de Clientes</li>
                      </ol>
                    </section>

          <section class="content">
           <div class="box">
                         <!-- primer header con los botones agregar y formulario -->
                        <div class="box-header with-border">
  
                        <a href="crear-venta"><button class="btn btn-primary">Agregar venta</button></a>

                        <a href="ventas-credito"><button class="btn btn-success">Ver creditos</button></a>
                        </div>

                      <div class="box-body">
                        <!-- Formulario de búsqueda -->
                        <form method="get" action="index.php">
                          <input type="hidden" name="ruta" value="creditos-por-cliente">
                          <div class="row">
                            <div class="col-md-4">
                              <label style="color: black;">Nombre del Cliente</label>
                              <input type="text" name="cliente" class="form-control" placeholder="Buscar Cliente..." value="<?php echo htmlspecialchars($clienteBuscado); ?>" required>
                            </div>
                            <div class="col-md-2" style="margin-top: 25px;">
                              <button type="submit" class="btn btn-primary btn-block">Buscar</button>
                            </div>
                          </div>
                        </form>
                      </div>
                          
                       <div class="box-body">
                         <?php
                         if (!empty($clienteBuscado)) {
                           try {
                             $ventas = ControladorVentas::ctrVentasCreditos();
                             $encontrados = [];

                             foreach ($ventas as $venta) {
                               $cliente = ControladorClientes::ctrMostrarClientes("id", $venta["id_cliente"]);
                               $nombreCliente = $cliente["nombre"] ?? '';

                               if (stripos($nombreCliente, $clienteBuscado) !== false) {
                                 $encontrados[] = [
                                   "id_cliente" => $cliente["id"],
                                   "cliente" => $nombreCliente,
                                   "total" => $venta["total"],
                                   "abonado" => $venta["monto_abonado"],
                                   "deuda" => $venta["saldo_pendiente"],
                                   "factura" => $venta["codigo"],
                                   "fecha" => $venta["fecha"],
                                   "observaciones" => $venta["observaciones"]
                                 ];
                               }
                             }
                
                             if (!empty($encontrados)) {
                              $idCliente = $encontrados[0]["id_cliente"];
                              $totalFacturas = array_sum(array_column($encontrados, 'total'));
                              $totalAbonado = array_sum(array_column($encontrados, 'abonado'));
                              $totalDebe = $totalFacturas - $totalAbonado;
                              
                              echo '<table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                      <thead>
                                        <tr>
                                          <th>#</th><th>Cliente</th><th>Total Factura</th><th>Abonado</th><th>Deuda</th><th>Factura</th><th>Fecha</th><th>observaciones</th>
                                        </tr>
                                      </thead><tbody>';
              
                             foreach ($encontrados as $key => $item) {
                               echo '<tr>
                                       <td>'.($key+1).'</td>
                                       <td>'.$item["cliente"].'</td>
                                       <td>$ '.number_format($item["total"], 2).'</td>
                                       <td>$ '.number_format($item["abonado"], 2).'</td>
                                       <td>$ '.number_format($item["deuda"], 2).'</td>
                                       <td>'.$item["factura"].'</td>
                                       <td>'.$item["fecha"].'</td>
                                       <td>'.$item["observaciones"].'</td>
                                     </tr>';
                             }
                             
                             echo '</tbody></table>';
                             echo '
                               <div class="alert" style="background-color: #f44336; color: white; font-size: 18px;">
                                 <strong>Total Facturado: $ '.number_format($totalFacturas, 2).'</strong>
                               </div>
                               <div class="alert" style="background-color: #4CAF50; color: white; font-size: 18px;">
                                                <strong>Total Abonado: $ '.number_format($totalAbonado, 2).'</strong>
                               </div>
                                              <div class="alert" style="background-color: #2196F3; color: white; font-size: 18px; display: flex; justify-content: space-between; align-items: center;">
                                 <strong>Total Adeudado: $ '.number_format($totalDebe, 2).'</strong>
                                 <button class="btn btn-warning btnpagarcreditototal" data-id-cliente="'.$idCliente.'">Pagar todas las facturas</button>
                               </div>';
                           } else {
                             echo '<script>
                               Swal.fire({
                                 icon: "info",
                                 title: "Sin coincidencias",
                                 text: "No se encontró información del cliente buscado."
                               });
                             </script>';
                           }
                           
                           } catch (Exception $e) {
                              echo '<script>
                                Swal.fire({
                                  icon: "error",
                                  title: "Error",
                                  text: "'.$e->getMessage().'"
                                });
                              </script>';
                            }
                          }
                          ?>
                          </div>

                          </div>
                        </section>
                      </div>

                      <!-- ALERTA SweetAlert para confirmar pago -->
                     <script>
                     document.addEventListener("DOMContentLoaded", function() {
                       const btnPagar = document.querySelector(".btnpagarcreditototal");

                       if (btnPagar) {
                         btnPagar.addEventListener("click", function() {
                           const idCliente = this.getAttribute("data-id-cliente");

                           Swal.fire({
                             title: "¿Deseas pagar todas las facturas de este cliente?",
                             text: "Se marcarán como pagadas todas las facturas a crédito.",
                             icon: "warning",
                             showCancelButton: true,
                             confirmButtonColor: "#3085d6",
                             cancelButtonColor: "#d33",
                             cancelButtonText: "Cancelar",
                             confirmButtonText: "Sí, pagar todas"
                           }).then((result) => {
                             if (result.isConfirmed) {
                               const inputCliente = document.querySelector('input[name="cliente"]');
                               if (inputCliente) inputCliente.value = "";
          
                                  window.location.href = "index.php?ruta=creditos-por-cliente&idPagarTodoCliente=" + idCliente;
                                }
                              });
                            });
                          }
                        });
                     </script>

                               <?php
                               // Ejecutar pago si llega por GET
                               if (isset($_GET["idPagarTodoCliente"])) {
                                 $pagarTodo = new ControladorVentas();
                                 $pagarTodo->ctrPagarTodoCliente();
                               }
                               
                                  ?>
                           

                                                 
                                                






