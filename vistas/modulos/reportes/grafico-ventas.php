<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

  $fechaInicial = $_GET["fechaInicial"];
  $fechaFinal = $_GET["fechaFinal"];

  // OBTENER VENTAS
  $respuesta = ControladorVentas::ctrRangoFechasVentas2($fechaInicial, $fechaFinal);

  // VER SUMA TOTAL DE GASTOS POR DIA ////////////////////////////
  $gastos = ControladorGastos::ctrRangogastosf($fechaInicial, $fechaFinal);
  $totalGastos = isset($gastos['total']) ? $gastos['total'] : 0;
  //////////////////////////////////////////////////////////


// VER SUMA TOTAL ABONADO//////////////////////
$abonadot = ControladorVentas::ctrRangocreditofabonado($fechaInicial, $fechaFinal);
$totalAbonos = isset($abonadot['total']) ? $abonadot['total'] : 0;
///////////////////////////////////////////////////

}else{

$fechaInicial = null;
$fechaFinal = null;

// OBTENER VENTAS SIN RANGO DE FECHAS
$respuesta = ControladorVentas::ctrRangoFF();
// VER SUMA TOTAL DE GASTOS ////////////////////////////
$gastos = ControladorGastos::ctrMostrarSumaGastos();
$totalGastos = isset($gastos['total']) ? $gastos['total'] : 0;
//////////////////////////////////////////////////////////
// VER SUMA TOTAL DE VENTAS CREDITOS ABONADO ////////////////////////////
$abonadot  = ControladorVentas::ctrSumaTotalCreditosab();
$totalAbonos = isset($abonadot['total']) ? $abonadot['total'] : 0;
//////////////////////////////////////////////////////////
}

$arrayFechas = array();
$sumaPagosMes = array();

foreach ($respuesta as $value) {
    // Capturamos sólo el año y el mes
    $fecha = substr($value["fecha"], 0, 7);

    // Introducir las fechas en arrayFechas
    array_push($arrayFechas, $fecha);

    // Inicializamos el valor de ventas y sumas si no existe
    if (!isset($sumaPagosMes[$fecha])) {
        $sumaPagosMes[$fecha] = 0;
    }

    // Sumamos las ventas del mismo mes
    $sumaPagosMes[$fecha] += $value["total"];
}

// Resta los gastos y suma los abonos para cada mes

foreach ($sumaPagosMes as $fecha => $total) {
    // Aplica gastos y abonos solo si hay un rango de fechas
    if (isset($_GET["fechaInicial"])) {
      $sumaPagosMes[$fecha] -= $totalGastos; // Resta el total de gastos
      $sumaPagosMes[$fecha] += $totalAbonos; // Suma el total de abonos
  }
}
$noRepetirFechas = array_unique($arrayFechas);
?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Ventas</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoVentas">

		<div class="chart" id="line-chart-ventas" style="height: 250px;"></div>

  </div>

</div>

<script>
	
 var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." },";


	    }

	    echo "{y: '".$key."', ventas: ".$sumaPagosMes[$key]." }";

    }else{

       echo "{ y: '0', ventas: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['ventas'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : '$',
    gridTextSize     : 10
  });

</script>