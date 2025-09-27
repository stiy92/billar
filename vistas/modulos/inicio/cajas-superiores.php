<?php

$item = null;
$valor = null;
$orden = "id";
$fechaInicial = null;
$fechaFinal = null;

// VER SUMA TOTAL DE VENTAS POR DIA//////////////////////
$ventass = ControladorVentas::ctrRangoventasf($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////

// VER SUMA TOTAL DE GASTOS POR DIA ////////////////////////////
$gastos = ControladorGastos::ctrRangogastosf($fechaInicial, $fechaFinal);
//////////////////////////////////////////////////////////

// VER SUMA TOTAL CREDITO POR DIA//////////////////////
$ventascre = ControladorVentas::ctrRangocreditof($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////

// VER SUMA TOTAL NEQUI POR DIA//////////////////////
$ventasneq = ControladorVentas::ctrRangonequif($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////

// VER SUMA TOTAL ABONADO//////////////////////
$abonadot = ControladorVentas::ctrRangocreditofabonado($fechaInicial, $fechaFinal);
///////////////////////////////////////////////////
//// VALOR FINAL/////////////////////////////////
$valor =$ventass["total"] + $ventasneq["total"] + $abonadot["total"] - $gastos["total"];
////////////////////////////////////////////////////////

// // VER SUMA TOTAL DE VENTAS CREDITOS ////////////////////////////
// $creditot = ControladorVentas::ctrSumaTotalCreditos();
// //////////////////////////////////////////////////////////

// $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
// $totalCategorias = count($categorias);

// $clientes = ControladorClientes::ctrMostrarClientes($item, $valor);
// $totalClientes = count($clientes);

// $productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);
// $totalProductos = count($productos);

?>


<!-- VENTAS EFECTIVOS POR DIA-->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventass["total"]); ?></h3>

      <p>Ventas efectivo hoy</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- GASTOS POR DIA -->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-red">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($gastos["total"]); ?></h3>

      <p>Gastos efectivo hoy</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>


<!-- VENTAS CREDITOS -->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventascre["total"]); ?></h3>

      <p>Ventas credito hoy</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- VENTAS NEQUI -->
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-purple">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($ventasneq["total"]); ?></h3>

      <p>Ventas Nequi hoy</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>
<!-- VALOR REAL -->
<div class="col-lg-6 col-xs-6">

  <div class="small-box bg-blue">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($valor); ?></h3>

      <p>Valor</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>
<!-- VALOR ABONADO -->
<div class="col-lg-6 col-xs-6">

  <div class="small-box bg-success">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($abonadot["total"]); ?></h3>

      <p>Abonos de credito</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<!-- CATEGORIAS -->
<!-- <div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalCategorias); ?></h3>

      <p>Categorías</p>
    
    </div>
    
    <div class="icon">
    
      <i class="ion ion-clipboard"></i>
    
    </div>
    
    <a href="categorias" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div> -->

<!-- CLIENTES -->
<!-- <div class="col-lg-3 col-xs-6">

  <div class="small-box bg-yellow">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalClientes); ?></h3>

      <p>Clientes</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-person-add"></i>
    
    </div>
    
    <a href="clientes" class="small-box-footer">

      Más info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div> -->

<!-- VENTAS CREDITOS TOTAL
<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-yellow">
    
    <div class="inner">
      
      <h3>$<?php echo number_format($creditot["total"],2); ?></h3>

      <p>creditos total</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="ventas" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div> -->

<!-- PRODUCTOS TOTAL -->
<!-- <div class="col-lg-3 col-xs-6">

  <div class="small-box bg-red">
  
    <div class="inner">
    
      <h3><?php echo number_format($totalProductos); ?></h3>

      <p>Productos</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-ios-cart"></i>
    
    </div>
    
    <a href="productos" class="small-box-footer">
      
      Más info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div> -->